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
<link rel="icon" href="../src/pics/garagekom.png" />
<?php require_once('../head.html') ?>
<title>GARAGEKOM | Admin</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php
            if ($_SESSION['user']->role == "admin") {
                require_once('side-bar.html');
            } elseif ($_SESSION['user']->role == "mechanic") {
                require_once('mechanic/side-bar.html');
            } ?>
            <?php require_once('connect-DB.php') ?>
            <div class="container-fluid">
                <div class="row">
                    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
                        <h2>Invoices Management</h2>

                        <div class="table-responsive">
                            <table class="table table-striped table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Request ID</th>
                                        <th>Owner Name</th>
                                        <th>Total</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $invoices = $database->prepare("SELECT * FROM invoices");
                                    $invoices->execute();
                                    $invoices = $invoices->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($invoices as $invoice) {
                                        echo "<tr>";
                                        echo "<td>" . $invoice["invoice_id"] . "</td>";
                                        echo "<td>" . $invoice["service_request_id"] . "</td>";
                                        $ownerID = $database->prepare('SELECT client_id FROM service_requests WHERE request_id = :service_request_id');
                                        $ownerID->bindParam(':service_request_id', $invoice["service_request_id"]);
                                        $ownerID->execute();
                                        $ownerID = $ownerID->fetch(PDO::FETCH_ASSOC);
                                        $owner = $database->prepare('SELECT client_name FROM clients WHERE client_id = :client_id');
                                        $owner->bindParam(':client_id', $ownerID["client_id"]);
                                        $owner->execute();
                                        $owner = $owner->fetch(PDO::FETCH_ASSOC);
                                        echo "<td>" . $owner["client_name"] . "</td>";
                                        echo "<td>" . $invoice["total_amount"] . "</td>";
                                        echo "<td>" . $invoice["invoice_date"] . "</td>";
                                        echo "<td>
                                        <button class='btn btn-success btn-sm' onclick='printInvoice(" . $invoice["service_request_id"]  . ")'>Print</button>
                                        </td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </main>
                </div>
            </div>
            <script>
                function printInvoice(request_id) {
                    window.location.href = "invoicePrint.php?request_id=" + request_id;
                }
            </script>
</body>

</html>