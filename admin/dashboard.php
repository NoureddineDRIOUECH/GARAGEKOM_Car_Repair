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
            <!-- Sidebar -->
            <?php
            if ($_SESSION['user']->role == "admin") {

                require_once('side-bar.html');
            } elseif ($_SESSION['user']->role == "mechanic") {
                require_once('mechanic/side-bar.html');
            } ?>
            <?php require_once('connect-DB.php') ?>
            <?php
            if (isset($_POST['update_status'])) {
                $updateStatus = $database->prepare("UPDATE service_requests SET status = :request_status WHERE request_id = :request_id");
                $updateStatus->bindParam(':request_status', $_POST['status']);
                $updateStatus->bindParam(':request_id', $_POST['request_id']);
                $updateStatus->execute();
                echo "<script>window.location.href = 'dashboard.php';</script>";
            }
            ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
                <h2>Dashboard
                </h2>

                <!-- Example Widgets -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Service Requests</h5>
                                <p class="card-text"><?php
                                                        echo  $database->query("SELECT COUNT(*) FROM service_requests")->fetchColumn();
                                                        ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Inventory Count</h5>
                                <p class="card-text"><?php
                                                        echo $database->query("SELECT COUNT(*) FROM inventory")->fetchColumn();
                                                        ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Pending Requests</h5>
                                <p class="card-text"><?php
                                                        echo $database->query("SELECT COUNT(*) FROM service_requests WHERE status = 'pending'")->fetchColumn();
                                                        ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Client Count</h5>
                                <p class="card-text"><?php
                                                        echo $database->query("SELECT COUNT(*) FROM clients")->fetchColumn();
                                                        ?></p>
                            </div>
                        </div>
                    </div>

                </div>

            </main>
        </div>
















        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
            <h2 class="mb-4">Pending Request</h2>
            <div class="table-responsive">
                <table class="table table-striped table-sm table-hover">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Client Name</th>
                            <th>Car Registration</th>
                            <!-- <th>Service Type</th> -->
                            <th>Request</th>
                            <!-- <th>Parts Added</th> -->
                            <th>Mechanic</th>
                            <th>Problem</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $requests = $database->prepare("SELECT * FROM service_requests WHERE status = 'Pending' ORDER BY request_date DESC");
                        $requests->execute();
                        $requests = $requests->fetchAll(PDO::FETCH_ASSOC);
                        if ($requests) {
                            foreach ($requests as $request) {
                                echo "<tr>";
                                echo "<td>" . $request['request_id'] . "</td>";
                                $clientName = $database->prepare("SELECT client_name FROM service_requests INNER JOIN clients ON service_requests.client_id = clients.client_id WHERE request_id = :request_id");
                                $clientName->bindParam(':request_id', $request['request_id']);
                                $clientName->execute();
                                $clientName = $clientName->fetch();
                                echo "<td>" . $clientName['client_name'] . "</td>";
                                $carReg = $database->prepare("SELECT car_registration FROM service_requests INNER JOIN cars ON service_requests.car_id = cars.car_id WHERE request_id = :request_id");
                                $carReg->bindParam(':request_id', $request['request_id']);
                                $carReg->execute();
                                $carReg = $carReg->fetch();
                                echo "<td>" . $carReg['car_registration'] . "</td>";
                                // $serviceType = $database->prepare("SELECT service_type FROM service_requests INNER JOIN services ON service_requests.service_id = services.service_id WHERE request_id = :request_id");
                                // $serviceType->bindParam(':request_id', $request['request_id']);
                                // $serviceType->execute();
                                // $serviceType = $serviceType->fetch();
                                // echo "<td>" . $serviceType['service_type'] . "</td>";
                                $requestWanted = $database->prepare("SELECT service_name FROM service_requests INNER JOIN services ON service_requests.service_id = services.service_id WHERE request_id = :request_id");
                                $requestWanted->bindParam(':request_id', $request['request_id']);
                                $requestWanted->execute();
                                $requestWanted = $requestWanted->fetch();
                                echo "<td>" . $requestWanted['service_name'] . "</td>";
                                $partsAdded = $database->prepare("SELECT item_id, quantity_used FROM inventory_usage WHERE service_request_id = :request_id");
                                $partsAdded->bindParam(':request_id', $request['request_id']);
                                $partsAdded->execute();
                                $addedPartsCount = $partsAdded->rowCount(); // Count of added parts

                                // echo "<td>";
                                // if ($addedPartsCount > 0) {
                                //     while ($part = $partsAdded->fetch(PDO::FETCH_ASSOC)) {
                                //         $itemNameQuery = $database->prepare("SELECT item_name FROM inventory WHERE item_id = :item_id");
                                //         $itemNameQuery->bindParam(':item_id', $part['item_id']);
                                //         $itemNameQuery->execute();
                                //         $itemName = $itemNameQuery->fetchColumn();
                                //         echo "<span class='text-warning-emphasis'>" . $itemName . "</span> x <span class='text-warning-emphasis'>" . $part['quantity_used'] . "</span><br>";
                                //     }
                                // } else {
                                //     echo "<span class='text-secondary-emphasis'>No Parts In this request</span>";
                                // }
                                // echo "</td>";
                                $employee = $database->prepare("SELECT employee_name FROM service_requests INNER JOIN employees ON service_requests.employee_id = employees.employee_id WHERE request_id = :request_id");
                                $employee->bindParam(':request_id', $request['request_id']);
                                $employee->execute();
                                $employee = $employee->fetch();
                                echo "<td>" . $employee['employee_name'] . "</td>";
                                // check if problem description is null or empty and show "n/a" if it is
                                // a function to check if the content is just a space
                                if (empty(trim($request['problem_description']))) {
                                    echo "<td><span class='text-secondary-emphasis'>N/A</span></td>";
                                } else {
                                    echo "<td>" . $request['problem_description'] . "</td>";
                                }
                                echo "<td>";
                                echo "<button type='button' class='btn btn-outline-primary btn-sm' data-bs-toggle='modal' data-bs-target='#update' data-bs-id='" . $request['request_id'] . "' >Update status</button>";

                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<td class='text-center text-bg-primary' colspan = 8>No pending requests</td>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
        <div class="modal fade" id="update" tabindex="-1" aria-labelledby="update" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="update">Update status</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" class="m-auto">
                        <div class="form-check">
                            <input class="form-check-input" value="In progress" type="radio" name="status" id="inProgress">
                            <label class="form-check-label text-warning" for="inProgress">
                                In progress
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" value="Completed" type="radio" name="status" id="done">
                            <label class="form-check-label text-success" for="done">
                                Completed
                            </label>
                            <input type="hidden" name="request_id" id="update_request_id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="update_status" class="btn btn-success">Update
                                status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#update').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var requestId = button.data('bs-id'); // Extract info from data-bs-id attribute
                var modal = $(this);
                modal.find('#update_request_id').val(requestId);
            });
        })
    </script>
    <script src="code.js"></script>
</body>

</html>