<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = json_decode(file_get_contents("php://input"));

if (isset($data->request_id) && isset($data->handWordPrice)) {
    require_once('connect-DB.php');
    $handWordPrice = $data->handWordPrice;
    $checkInvoice = $database->prepare("SELECT * FROM invoices WHERE service_request_id = :request_id");
    $checkInvoice->bindParam(":request_id", $data->request_id);
    $checkInvoice->execute();
    $checkInvoice = $checkInvoice->fetch();
    if ($checkInvoice) {
        print_r(json_encode(['success' => false, 'message' => 'Invoice already generated']));
        exit();
    } else {
        $request_id = $data->request_id;
        $partsAdded = $database->prepare("SELECT item_id, quantity_used FROM inventory_usage WHERE service_request_id = :request_id");
        $partsAdded->bindParam(":request_id", $request_id);
        $partsAdded->execute();
        $total = $handWordPrice;
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
            print_r(json_encode(['success' => true, 'message' => 'Invoice generated successfully']));
        } else {
            print_r(json_encode(['success' => false, 'message' => 'Error generating invoice: ' . $invoice->errorInfo()]));
        }
    }
}