<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = json_decode(file_get_contents("php://input"));

if (isset($data->request_id)) {
    require_once('connect-DB.php');
    $checkInvoice = $database->prepare("SELECT * FROM invoices WHERE service_request_id = :request_id");
    $checkInvoice->bindParam(":request_id", $data->request_id);
    $checkInvoice->execute();
    $checkInvoice = $checkInvoice->fetch();
    if ($checkInvoice) {
        print_r(json_encode(['success' => false, 'message' => 'Invoice already generated']));
        exit();
    } else {
        $request_id = $data->request_id;
        $request = $database->prepare("SELECT client_id, service_id, car_id FROM service_requests WHERE request_id = :request_id");
        $request->bindParam(":request_id", $request_id);
        $request->execute();
        $request = $request->fetch();
        $service = $database->prepare("SELECT service_name, service_price FROM services WHERE service_id = :service_id");
        $service->bindParam(":service_id", $request['service_id']);
        $service->execute();
        $service = $service->fetch();
        $total = $service['service_price'];
        $partsAdded = $database->prepare("SELECT item_id, quantity_used FROM inventory_usage WHERE service_request_id = :request_id");
        $partsAdded->bindParam(":request_id", $request_id);
        $partsAdded->execute();
        while ($part = $partsAdded->fetch()) {
            $item = $database->prepare("SELECT item_price FROM inventory WHERE item_id = :item_id");
            $item->bindParam(":item_id", $part['item_id']);
            $item->execute();
            $item = $item->fetch();
            $total += $part['quantity_used'] * $item['item_price'];
        }
        $invoice = $database->prepare("INSERT INTO invoices (service_request_id,invoice_date, total_amount) VALUES (:request_id, NOW(),:total)");
        $invoice->bindParam(":request_id", $request_id);
        $invoice->bindParam(":total", $total);
        if ($invoice->execute()) {
            $invoice = $database->prepare("SELECT invoice_date, total_amount FROM invoices WHERE service_request_id = :request_id");
            $invoice->bindParam(":request_id", $request_id);
            $invoice->execute();
            $invoice = $invoice->fetch();
            $client = $database->prepare("SELECT client_name, client_email, client_phone FROM clients WHERE client_id = :client_id");
            $client->bindParam(":client_id", $request['client_id']);
            $client->execute();
            $client = $client->fetch();
            $car = $database->prepare("SELECT car_registration FROM cars WHERE car_id = :car_id");
            $car->bindParam(":car_id", $request['car_id']);
            $car->execute();
            $car = $car->fetchColumn();
            require_once "../mail.php";

            $mail->addAddress($client['client_email']);
            $mail->Subject = "Service Request";
            ob_start();
            include "invoice_template.php";
            $mailBody = ob_get_clean();

            $mail->Body = $mailBody;
            $mail->setFrom("oyuncoyt@gmail.com", "Garagekom");
            if ($mail->send()) {
                print_r(json_encode(['success' => true, 'message' => 'Invoice generated successfully']));
            } else {
                print_r(json_encode(['success' => false, 'message' => 'Error sending email: ' . $mail->ErrorInfo]));
            }
        } else {
            print_r(json_encode(['success' => false, 'message' => 'Error generating invoice: ' . implode(", ", $invoice->errorInfo())]));
        }
    }
}
