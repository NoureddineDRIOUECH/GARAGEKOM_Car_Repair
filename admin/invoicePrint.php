<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

// Ensure that only admins and mechanic have access to the dashboard
if ($_SESSION['user']->role !== "admin" && $_SESSION['user']->role !== "mechanic") {
  header("Location: login.php");
  exit();
}
?>
<html lang="en" data-bs-theme="light">
<link rel="icon" href="../src/pics/garagekom.png" />
<?php require_once('../head.html') ?>

<?php require_once('connect-DB.php') ?>
<title>Invoice - GARAGEKOM</title>
<style>
body {
    font-family: "Arial", sans-serif;
}

.container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.container>div {
    margin-bottom: 20px;
}

table {
    width: 100%;
    margin-top: 20px;
}

th,
td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #f5f5f5;
}

.text-end {
    text-align: right;
}

img {
    max-width: 100%;
    height: auto;
}

hr {
    border-top: 1px solid #ddd;
}

@media print {
    .btn {
        display: none !important;
    }
}
</style>
</head>

<body>
    <div class="container-lg mt-5 ml-5 mr-5">
        <div class="d-flex flex-wrap justify-content-between">
            <div class="text-start">
                <h2 class="text-primary">Invoice</h2>
                <?php
        $request_id = $_GET['request_id'];
        $request = $database->prepare("SELECT client_id, service_id, car_id FROM service_requests WHERE request_id = :request_id");
        $request->bindParam(":request_id", $request_id);
        $request->execute();
        $request = $request->fetch();
        ?>

                <?php
        $invoice = $database->prepare("SELECT invoice_date, total_amount FROM invoices WHERE service_request_id = :request_id");
        $invoice->bindParam(":request_id", $request_id);
        $invoice->execute();
        $invoice = $invoice->fetch();
        ?>
                <p>Invoice Number: <?php echo $request_id; ?></p>
                <p>Date: <?php echo $invoice['invoice_date']; ?></p>
            </div>
            <div class="col-md-4 text-end">
                <img src="../src/pics/garagekom.png" alt="GARAGEKOM Logo" width="100" />
            </div>
        </div>

        <hr />
        <?php
    $client = $database->prepare("SELECT client_name, client_email, client_phone FROM clients WHERE client_id = :client_id");
    $client->bindParam(":client_id", $request['client_id']);
    $client->execute();
    $client = $client->fetch();
    ?>

        <!-- Client Information -->
        <div class="d-flex flex-wrap justify-content-between mt-4">
            <div class="col-md-6">
                <h4 class="text-primary">Client Information</h4>
                <p>Client Name: <?php echo $client['client_name']; ?></p>
                <p>Email: <?php echo $client['client_email']; ?></p>
                <p>Phone: <?php echo $client['client_phone']; ?></p>
                <?php
        $car = $database->prepare("SELECT car_registration FROM cars WHERE car_id = :car_id");
        $car->bindParam(":car_id", $request['car_id']);
        $car->execute();
        $car = $car->fetchColumn();
        ?>
                <p>Car Registration: <?php echo $car ?> </p>
                <?php
        $service = $database->prepare("SELECT service_name FROM services WHERE service_id = :service_id");
        $service->bindParam(":service_id", $request['service_id']);
        $service->execute();
        $service = $service->fetch();
        ?>
                <p>Service: <?php echo $service['service_name']; ?></p>
            </div>
            <div class="col-md-6 text-end">
                <h4 class="text-primary">Garage Information</h4>
                <p>GARAGEKOM</p>
                <p>+212 660 1318 89</p>
                <p>Hay Moulay Rachid Massira 3, Casablanca Maroc</p>
            </div>
        </div>

        <!-- Invoice Items -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h4 class="text-primary">Invoice Items</h4>
                <table class="table table-striped table-sm table-hover">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
            $partsAdded = $database->prepare("SELECT item_id, quantity_used FROM inventory_usage WHERE service_request_id = :request_id");
            $partsAdded->bindParam(':request_id', $request_id);
            $partsAdded->execute();
            $addedPartsCount = $partsAdded->rowCount(); // Count of added parts

            if ($addedPartsCount > 0) {
              $totalItemPrice = 0; // Initialize total item price

              while ($part = $partsAdded->fetch(PDO::FETCH_ASSOC)) {
                $itemNameQuery = $database->prepare("SELECT item_name, item_price FROM inventory WHERE item_id = :item_id");
                $itemNameQuery->bindParam(':item_id', $part['item_id']);
                $itemNameQuery->execute();
                $items = $itemNameQuery->fetch();
                echo "<tr>";
                echo "<td><span class='text-warning-emphasis'>" . $items['item_name'] . "</span></td>";
                echo "<td><span class='text-warning-emphasis'>" . $part['quantity_used'] . "</span></td>";
                echo "<td><span class='text-warning-emphasis'>" . $items['item_price'] . " MAD</span></td>";
                echo "<td><span class='text-warning-emphasis'>" . $items['item_price'] * $part['quantity_used'] . " MAD</span></td>";
                echo "</tr>";

                $totalItemPrice += $items['item_price'] * $part['quantity_used']; // Update total item price
              }
            } else {
              echo "<tr><td colspan='4'><span class='text-secondary-emphasis'>No Parts In this request</span></td></tr>";
            }
            ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Total Amount and Handwork Amount -->
        <div class="d-flex flex-wrap justify-content-between mt-4">
            <div class="col-md-6">

                <p><strong>Service Price:</strong></p>
                <p><strong>Total Amount:</strong></p>
            </div>
            <div class="col-md-6 text-end">
                <p class='text-primary'><strong><?php echo $invoice['total_amount'] - $totalItemPrice ?> MAD</strong>
                <p class="text-primary"><strong><?php echo $invoice['total_amount'] ?> MAD</strong></p>
                </p>
            </div>

            <button class="btn btn-primary m-auto" onclick="window.print()">Imprimer la Facture</button>
        </div>

    </div>
</body>

</html>