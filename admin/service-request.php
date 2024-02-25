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
<style>
#toastS {
    display: none;
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #4caf50;
    color: white;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
}
</style>
<script>
function generateInvoice(request_id) {
    fetch("generateInvoice.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                request_id: request_id,
            }),

        }).then((response) => response.json())
        .then((data) => {
            if (data.success) {
                function showToast(message) {
                    var toast = document.getElementById("toastS");
                    toast.innerHTML = message;
                    toast.style.display = "block";
                    setTimeout(function() {
                        toast.style.display = "none";
                    }, 3000);
                }
                showToast("Inovoice generated successfuly!");
            } else {
                showToast("Error generating Inovoice!");
            }
        })
        .then(() => {
            window.location.reload();
        })
        .catch((error) => {
            showBootstrapToast("Error generating invoice.", "bg-danger");
            console.error("Error generating invoice:", error);
        });
}
</script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div id="toastS"></div>
            <?php
            if ($_SESSION['user']->role == "admin") {

                require_once('side-bar.html');
            } elseif ($_SESSION['user']->role == "mechanic") {
                require_once('mechanic/side-bar.html');
            } ?>
            <?php require_once('connect-DB.php') ?>
            <?php
            if (isset($_POST['update_status'])) {
                $value = $_POST['status'];
                $request_id = $_POST['request_id'];
                if ($value == "Completed") {
                    echo "<script>generateInvoice(" . $request_id . ")</script>";
                }
                if ($value == "In progress") {
                    $clientName = $database->prepare("SELECT client_name, client_email FROM service_requests INNER JOIN clients ON service_requests.client_id = clients.client_id WHERE request_id = :request_id");
                    $clientName->bindParam(':request_id', $request_id);
                    $clientName->execute();
                    $clientName = $clientName->fetch();

                    $subject = "Service Request Updated";
                    $message = "
                    <!DOCTYPE html>
            <html>
            <head>
              <title>GARAGEKOM | Service Request Update</title>
              <style>
                body {
                  font-family: Arial, sans-serif;
                  margin: 0;
                  padding: 0;
                }
            
                .container {
                  width: 600px;
                  margin: 20px auto;
                  border-radius: 5px;
                  background-color: #f5f5f5;
                  padding: 20px;
                }
            
                h2 {
                  background-color: #0d6efd;
                  color: #fff;
                  padding: 15px;
                  border-radius: 5px;
                  font-size: 20px;
                  margin-bottom: 15px;
                }
            
                p {
                  font-size: 16px;
                  line-height: 1.5;
                  margin-bottom: 10px;
                }
            
                a {
                  color: #0d6efd;
                  text-decoration: none;
                }
              </style>
            </head>
            
            <body>
              <div class='container'>
                <h2>GARAGEKOM | Service Request Updated</h2>
                <p>Dear " . $clientName['client_name'] . ",</p>
                <p>We are writing to inform you that your service request with ID " . $request_id . " has been updated to 'In progress.' Our dedicated team is currently working on it, and we will keep you informed of the progress.</p>
                <p>We appreciate your patience and understanding. If you have any questions or concerns, please do not hesitate to contact us by replying to this email or calling us at <a href='tel:+212660133665'>06-60-13-36-65</a>.</p>
                <p>Sincerely,</p>
                <p>The GARAGEKOM Team</p>
              </div>
            </body>
            </html>
                    ";
                    require_once "../mail.php";
                    $mail->addAddress($clientName['client_email']);

                    $mail->Subject = $subject;
                    $mail->Body = $message;
                    $mail->setFrom("oyuncoyt@gmail.com", "Garagekom");
                    $mail->send();
                }

                $updateStatus = $database->prepare("UPDATE service_requests SET status = :request_status WHERE request_id = :request_id");
                $updateStatus->bindParam(':request_status', $value);
                $updateStatus->bindParam(':request_id', $request_id);
                $updateStatus->execute();
                echo "<script>window.location.href = 'service-request.php';</script>";


                $updateStatus = $database->prepare("UPDATE service_requests SET status = :request_status WHERE request_id = :request_id");
                $updateStatus->bindParam(':request_status', $value);
                $updateStatus->bindParam(':request_id', $request_id);
                $updateStatus->execute();
                echo "<script>window.location.href = 'service-request.php';</script>";
            }
            if (isset($_POST['add_part'])) {
                $checkQte = $database->prepare("SELECT item_quantity FROM inventory WHERE item_id = :part_id");
                $checkQte->bindParam(':part_id', $_POST['name']);
                $checkQte->execute();
                $checkQte = $checkQte->fetch();
                if ($checkQte['item_quantity'] < $_POST['qte']) {
                    echo "<script>window.location.href = 'service-request.php';</script>";
                    exit();
                } else {
                    // check if part already added so we add just qte
                    $checkPart = $database->prepare("SELECT * FROM inventory_usage WHERE service_request_id = :request_id AND item_id = :part_id");
                    $checkPart->bindParam(':request_id', $_POST['request_id']);
                    $checkPart->bindParam(':part_id', $_POST['name']);
                    $checkPart->execute();
                    $checkPart = $checkPart->fetch();
                    if ($checkPart) {
                        $updateQte = $database->prepare("UPDATE inventory_usage SET quantity_used = quantity_used + :qte WHERE service_request_id = :request_id AND item_id = :part_id");
                        $updateQte->bindParam(':qte', $_POST['qte']);
                        $updateQte->bindParam(':request_id', $_POST['request_id']);
                        $updateQte->bindParam(':part_id', $_POST['name']);
                        $updateQte->execute();
                        echo "<script>window.location.href = 'service-request.php';</script>";
                    } else {
                        $addPart = $database->prepare("INSERT INTO inventory_usage (service_request_id, item_id, quantity_used) VALUES (:request_id, :part_id, :qte)");
                        $addPart->bindParam(':request_id', $_POST['request_id']);
                        $addPart->bindParam(':part_id', $_POST['name']);
                        $addPart->bindParam(':qte', $_POST['qte']);
                        $addPart->execute();
                        // delete qte 
                        $updateQte = $database->prepare("UPDATE inventory SET item_quantity = item_quantity - :qte WHERE item_id = :part_id");
                        $updateQte->bindParam(':qte', $_POST['qte']);
                        $updateQte->bindParam(':part_id', $_POST['name']);
                        $updateQte->execute();
                    }
                }
            }
            ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
                <h2 class="mb-4">Service Request Management</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Request ID</th>
                                <th>Client Name</th>
                                <th>Car Registration</th>
                                <!-- <th>Service Type</th> -->
                                <th>Request</th>
                                <th>Parts Added</th>
                                <th>Mechanic</th>
                                <th>Status</th>
                                <th>Problem</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $requests = $database->prepare("SELECT * FROM service_requests
ORDER BY 
    CASE 
        WHEN status = 'Pending' THEN 1
        WHEN status = 'In progress' THEN 2
        WHEN status = 'Completed' THEN 3
        ELSE 4
    END,
    request_date DESC");
                            $requests->execute();
                            $requests = $requests->fetchAll(PDO::FETCH_ASSOC);
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

                                echo "<td>";
                                if ($addedPartsCount > 0) {
                                    while ($part = $partsAdded->fetch(PDO::FETCH_ASSOC)) {
                                        $itemNameQuery = $database->prepare("SELECT item_name FROM inventory WHERE item_id = :item_id");
                                        $itemNameQuery->bindParam(':item_id', $part['item_id']);
                                        $itemNameQuery->execute();
                                        $itemName = $itemNameQuery->fetchColumn();
                                        echo "<span class='text-warning-emphasis'>" . $itemName . "</span> x <span class='text-warning-emphasis'>" . $part['quantity_used'] . "</span><br>";
                                    }
                                } else {
                                    echo "<span class='text-secondary-emphasis'>No Parts In this request</span>";
                                }
                                echo "</td>";
                                $employee = $database->prepare("SELECT employee_name FROM service_requests INNER JOIN employees ON service_requests.employee_id = employees.employee_id WHERE request_id = :request_id");
                                $employee->bindParam(':request_id', $request['request_id']);
                                $employee->execute();
                                $employee = $employee->fetch();
                                echo "<td>" . $employee['employee_name'] . "</td>";
                                echo "<td>" . $request['status'] . "</td>";
                                echo "<td>" . $request['problem_description'] . "</td>";
                                echo "<td>";
                                if ($request['status'] != "Completed") {
                                    echo "<button type='button' class='btn btn-outline-primary btn-sm' data-bs-toggle='modal' data-bs-target='#update' data-bs-id='" . $request['request_id'] . "' >Update status</button>";
                                }
                                if ($request['status'] == "In progress") {
                                    echo "<button type='button' class='btn btn-outline-warning btn-sm' data-bs-toggle='modal' data-bs-target='#addPart' data-bs-id='" . $request['request_id'] . "' >Add part</button>";
                                }
                                if (($request['status'] == "Completed")) {
                                    // check if the request have a invoice 
                                    // $checkInvoice = $database->prepare("SELECT * FROM invoices WHERE service_request_id = :request_id");
                                    // $checkInvoice->bindParam(':request_id', $request['request_id']);
                                    // $checkInvoice->execute();
                                    // if ($checkInvoice->rowCount() == 0) {
                                    //     // echo "<button type='button' data-bs-toggle='modal' data-bs-target='#generateInvoice' data-bs-id='" . $request['request_id'] . "'  class='btn btn-outline-info btn-sm'>Generate invoice</button>";
                                    // } else {
                                    echo "<button type='button' class='btn btn-outline-success btn-sm' onclick='printInvoice(" . $request['request_id'] . ")'>Print invoice</button>";
                                    // }
                                }
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>

            <!-- <div class="modal fade" id="generateInvoice" tabindex="-1" aria-labelledby="generateInvoice" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="generateInvoice">Generate Invoice</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form method="post" id="generateInvoiceForm">
                                <label for="price_hand_work" class="form-label">Hand Work Price </label>
                                <input type="number" min="0" name="price_hand_work" id="price_hand_work" class="form-control" required>
                                <input type="hidden" name="request_id" id="update_request_id">


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="generate" class="btn btn-success">Generate
                                invoice</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="modal fade" id="update" tabindex="-1" aria-labelledby="update" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="update">Update status</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" class="m-auto">
                            <div class="form-check">
                                <input class="form-check-input" value="In progress" type="radio" name="status"
                                    id="inProgress">
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
        <div class="modal fade" id="addPart" tabindex="-1" aria-labelledby="addPart" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addPart">Add part</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form method="post">
                            <label for="name" class="form-label">Item name</label>
                            <select name="name" id="name" class="form-select" required>
                                <?php
                                // show item name and brand and model and price
                                $items = $database->prepare("SELECT item_id, item_price,item_car_name,item_brand, item_model, item_name FROM inventory");
                                $items->execute();
                                $items = $items->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($items as $item) {
                                    echo "<option value='" . $item['item_id'] . "'>" . $item['item_name'] . " | " . $item['item_brand'] . " | " . $item['item_car_name'] . " | " . $item['item_model'] . " | " . $item['item_price'] . " MAD</option>";
                                }
                                ?>
                            </select>
                            <label for="qte" class="form-label">
                                Quantity
                            </label>
                            <input type="number" name="qte" min="1" id="qte" class="form-control" required>
                            <input type="hidden" name="request_id" id="update_request_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="add_part" class="btn btn-success">Add
                            part</button>
                        </form>
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
            // $('#generateInvoice').on('show.bs.modal', function(event) {
            //     var button = $(event.relatedTarget); // Button that triggered the modal
            //     var requestId = button.data('bs-id'); // Extract info from data-bs-id attribute
            //     var modal = $(this);
            //     modal.find('#update_request_id').val(requestId);
            // })
            // $('#generateInvoiceForm').on('submit', function(e) {
            //     e.preventDefault(); // Prevent the default form submission

            //     var request_id = $('#update_request_id').val();

            //     // Call the generateInvoice function
            //     generateInvoice(request_id);
            // });
            $('#addPart').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var requestId = button.data('bs-id'); // Extract info from data-bs-id attribute
                var modal = $(this);
                modal.find('#update_request_id').val(requestId);
            });
        })

        function printInvoice(request_id) {
            window.location.href = "invoicePrint.php?request_id=" + request_id;
        }
        </script>

</body>

</html>