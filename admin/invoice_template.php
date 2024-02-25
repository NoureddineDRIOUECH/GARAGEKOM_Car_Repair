<!DOCTYPE html>
<html lang='en' data-bs-theme='light'>

<?php require_once('../head.html') ?>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>GARAGEKOM Service Request Confirmation</title>
    <style>
    body {
        font-family: 'Arial', sans-serif;
    }

    a {
        text-decoration: none;
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
    </style>
</head>

<body>
    <div class='container-lg mt-5 ml-5 mr-5'>
        <div class='d-flex flex-wrap justify-content-between'>
            <div class='text-start'>
                <h2 class='text-primary'>Invoice</h2>
                <p>Invoice Number: <?php echo $request_id; ?></p>
                <p>Date: <?php echo $invoice['invoice_date']; ?></p>
            </div>
            <div class='col-md-4'>
            </div>
        </div>

        <hr />

        <!-- Client Information -->
        <div class='d-flex flex-wrap justify-content-between mt-4'>
            <div class='col-md-6'>
                <h4 class='text-primary'>Client Information</h4>
                <p>Client Name: <?php echo $client['client_name']; ?></p>
                <p>Email: <?php echo $client['client_email']; ?></p>
                <p>Phone: <?php echo $client['client_phone']; ?></p>

                <p>Car Registration: <?php echo $car ?> </p>
                <p>Service: <?php echo $service['service_name']; ?></p>
            </div>
            <div class='col-md-6'>
                <h4 class='text-primary'>Garage Information</h4>
                <p>GARAGEKOM</p>
                <p>+212 660 1318 89</p>
                <p>Hay Moulay Rachid Massira 3, Casablanca Maroc</p>
            </div>
        </div>

        <!-- Invoice Items -->
        <div class='row mt-4'>
            <div class='col-md-12'>
                <h4 class='text-primary'>Invoice Items</h4>
                <table class='table table-striped table-sm table-hover'>
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
                        $partsAdded = $database->prepare('SELECT item_id, quantity_used FROM inventory_usage WHERE service_request_id = :request_id');
                        $partsAdded->bindParam(':request_id', $request_id);
                        $partsAdded->execute();
                        $addedPartsCount = $partsAdded->rowCount(); // Count of added parts

                        if ($addedPartsCount > 0) {
                            $totalItemPrice = 0; // Initialize total item price

                            while ($part = $partsAdded->fetch(PDO::FETCH_ASSOC)) {
                                $itemNameQuery = $database->prepare('SELECT item_name, item_price FROM inventory WHERE item_id = :item_id');
                                $itemNameQuery->bindParam(':item_id', $part['item_id']);
                                $itemNameQuery->execute();
                                $items = $itemNameQuery->fetch();
                                echo '<tr>';
                                echo '<td><span class="text-warning-emphasis">' . $items['item_name'] . '</span></td>';
                                echo '<td><span class="text-warning-emphasis">' . $part['quantity_used'] . '</span></td>';
                                echo '<td><span class="text-warning-emphasis">' . $items['item_price'] . ' MAD</span></td>';
                                echo '<td><span class="text-warning-emphasis">' . $items['item_price'] * $part['quantity_used'] . ' MAD</span></td>';
                                echo '</tr>';

                                $totalItemPrice += $items['item_price'] * $part['quantity_used']; // Update total item price
                            }
                        } else {
                            echo '<tr><td colspan="4"><span class="text-secondary-emphasis">No Parts In this request</span></td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Total Amount and Handwork Amount -->
        <div class='d-flex flex-wrap justify-content-between mt-4'>
            <div class='col-md-6'>
                <p><strong>Service Price:</strong></p>
                <p><strong>Total Amount:</strong></p>
            </div>
            <div class='col-md-6 text-end'>
                <p class='text-primary'><strong><?php echo $invoice['total_amount'] - $totalItemPrice ?> MAD</strong>
                </p>
                <p class='text-primary'><strong><?php echo $invoice['total_amount'] ?> MAD</strong></p>
            </div>
        </div>

        <!-- Pick Up Instructions -->
        <div class='d-flex flex-wrap justify-content-between mt-4'>
            <div class='col-md-6'>
                <h4 class='text-primary'>Pick Up Instructions</h4>
                <p>Your car is now ready for pick up. Please come to our garage during business hours to retrieve your
                    car.</p>
                <p>If you have any questions or concerns, please contact us at <a href="tel:+212 660 1318 89">+212 660
                        1318 89</a> or <a href="mailto:noureddine@garagekom.com">noureddine@garagekom.com</a></p>
            </div>
        </div>

    </div>
</body>

</html>