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
            <?php
            if (isset($_POST["add_client"])) {
                $addClient = $database->prepare("INSERT INTO clients (client_name, client_email, client_phone, client_address , client_added_date) VALUES (:fullName, :email, :phoneNumber, :address , NOW())");
                $addClient->bindParam(':fullName', $_POST["name"]);
                $addClient->bindParam(':phoneNumber', $_POST["phone"]);
                $addClient->bindParam(':email', $_POST["email"]);
                $addClient->bindParam(':address', $_POST["address"]);
                $addClient->execute();

                $clientId = $database->lastInsertId();
                $addCar = $database->prepare("INSERT INTO cars (car_registration, client_id, car_name , car_brand, car_model) VALUES (:carRegistration, :clientId, :carName , :carBrand, :carModel)");
                $addCar->bindParam(':carRegistration', $_POST["registration"]);
                $addCar->bindParam(':clientId', $clientId);
                $addCar->bindParam(':carName', $_POST["carName"]);
                $addCar->bindParam(':carBrand', $_POST["brand"]);
                $addCar->bindParam(':carModel', $_POST["model"]);
                $addCar->execute();
                echo "<script>window.location.href = 'client.php';</script>";
            }
            if (isset($_POST["delete_client"])) {
                $id = $_POST["client_id"];

                // // Step 1: Delete from inventory_usage
                // $deleteInventoryUsage = $database->prepare("DELETE FROM inventory_usage WHERE service_request_id IN (SELECT request_id FROM service_requests WHERE client_id = :client_id)");
                // $deleteInventoryUsage->bindParam(':client_id', $id);
                // $deleteInventoryUsage->execute();

                // // Step 2: Delete from invoices
                // $deleteInvoices = $database->prepare("DELETE FROM invoices WHERE service_request_id IN (SELECT request_id FROM service_requests WHERE client_id = :client_id)");
                // $deleteInvoices->bindParam(':client_id', $id);
                // $deleteInvoices->execute();

                // // Step 3: Delete from service_requests
                // $deleteServiceRequests = $database->prepare("DELETE FROM service_requests WHERE client_id = :client_id");
                // $deleteServiceRequests->bindParam(':client_id', $id);
                // $deleteServiceRequests->execute();

                // Step 4: Delete from cars
                $deleteCars = $database->prepare("DELETE FROM cars WHERE client_id = :client_id");
                $deleteCars->bindParam(':client_id', $id);
                $deleteCars->execute();

                // Step 5: Delete from clients
                $deleteClient = $database->prepare("DELETE FROM clients WHERE client_id = :client_id");
                $deleteClient->bindParam(':client_id', $id);
                $deleteClient->execute();
                echo "<script>window.location.href = 'client.php';</script>";
            }
            if (isset($_POST['edit_client'])) {
                $id = $_POST["client_id"];
                $name = $_POST["name"];
                $email = $_POST["email"];
                $phone = $_POST["phone"];
                $address = $_POST["address"];
                $registration = $_POST["registration"];
                $carName = $_POST["carName"];
                $brand = $_POST["brand"];
                $model = $_POST["model"];
                $editClient = $database->prepare("UPDATE clients SET client_name = :name, client_email = :email, client_phone = :phone, client_address = :address WHERE client_id = :client_id");
                $editCar = $database->prepare("UPDATE cars SET car_registration = :registration, car_name = :carName, car_brand = :brand, car_model = :model WHERE client_id = :client_id");
                $editClient->bindParam(':name', $name);
                $editClient->bindParam(':email', $email);
                $editClient->bindParam(':phone', $phone);
                $editClient->bindParam(':address', $address);
                $editClient->bindParam(':client_id', $id);
                $editClient->execute();
                $editCar->bindParam(':registration', $registration);
                $editCar->bindParam(':carName', $carName);
                $editCar->bindParam(':brand', $brand);
                $editCar->bindParam(':model', $model);
                $editCar->bindParam(':client_id', $id);
                $editCar->execute();
                echo "<script>window.location.href = 'client.php';</script>";
            }
            ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
                <h2>Client Management</h2>

                <div class="mb-4">
                    <button type="submit" class="btn btn-warning mt-3" data-bs-toggle="modal" data-bs-target="#addClient">Add Client</button>
                </div>

                <div class="table-responsive">
                    <h3>Client List</h3>
                    <table class="table table-striped table-sm table-hover ">
                        <thead class="table-primaryrrt">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Address</th>
                                <th>Car Registration</th>
                                <th>Date Added</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $clients = $database->prepare("SELECT * FROM clients");
                            $clients->execute();
                            $clients = $clients->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($clients as $client) {
                                echo "<tr>";
                                echo "<td>" . $client["client_id"] . "</td>";
                                echo "<td>" . $client["client_name"] . "</td>";
                                echo "<td>" . $client["client_email"] . "</td>";
                                echo "<td>" . $client["client_phone"] . "</td>";
                                echo "<td>" . $client["client_address"] . "</td>";
                                $carRegistration = $database->prepare("SELECT car_registration FROM cars WHERE client_id = :client_id");
                                $carRegistration->bindParam(':client_id', $client["client_id"]);
                                $carRegistration->execute();
                                $carRegistration = $carRegistration->fetch();
                                echo "<td>" . $carRegistration["car_registration"] . "</td>";
                                echo "<td>" . $client["client_added_date"] . "</td>";
                                echo "<td>";
                                echo '<button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#aditClient" data-bs-id="' . $client["client_id"] . '">Edit</button>';
                                //   echo   '<button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteClient" data-bs-id="' . $client["client_id"] . '">Delete</button>';
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>


            <div class="modal fade" id="aditClient" tabindex="-1" aria-labelledby="aditClient" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="aditClient">Edit Client</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                <label for="name" class="form-label">Full name</label>
                                <input type="text" name="name" id="name" class="form-control mb-3" required>

                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control mb-3" required>

                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" name="phone" id="phone" class="form-control mb-3" required>

                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" id="address" class="form-control mb-3" required>

                                <label for="registration" class="form-label">Car Registration</label>
                                <input type="text" name="registration" id="registration" class="form-control mb-3" required>

                                <label for="brand" class="form-label">Car Brand</label>
                                <input type="text" name="brand" id="brand" class="form-control mb-3" required>

                                <label for="carName" class="form-label">Car Name</label>
                                <input type="text" name="carName" id="carName" class="form-control mb-3" required>

                                <input type="hidden" name="client_id" id="edit_client_id">
                                <label for="model" class="form-label">Model</label>
                                <input type="number" min="1900" max="<?php echo date("Y"); ?>" name="model" id="model" class="form-control mb-3" required>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="edit_client" class="btn btn-primary">Save changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>







            <div class="modal fade" id="deleteClient" tabindex="-1" aria-labelledby="deleteClient" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="deleteClient">Delete Client</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure ?</p>
                            <p>You wanna delete this client</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <form method="post">
                                <input type="hidden" name="client_id" id="delete_client_id">
                                <button type="submit" class="btn btn-danger" name="delete_client">Delete Client</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="addClient" tabindex="-1" aria-labelledby="addClient" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="addClient">Add new Client</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                <label for="name" class="form-label">Full name</label>
                                <input type="text" name="name" id="name" class="form-control mb-3" required>

                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control mb-3" required>

                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" name="phone" id="phone" class="form-control mb-3" required>

                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" id="address" class="form-control mb-3" required>

                                <label for="registration" class="form-label">Car Registration</label>
                                <input type="text" name="registration" id="registration" class="form-control mb-3" required>

                                <label for="brand" class="form-label">Car Brand</label>
                                <input type="text" name="brand" id="brand" class="form-control mb-3" required>

                                <label for="carName" class="form-label">Car Name</label>
                                <input type="text" name="carName" id="carName" class="form-control mb-3" required>


                                <label for="model" class="form-label">Model</label>
                                <input type="number" min="1900" max="<?php echo date("Y"); ?>" name="model" id="model" class="form-control mb-3" required>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="add_client" class="btn btn-primary">Add client</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
            <script>
                // Edit Client Modal
                $('#aditClient').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var clientId = button.data('bs-id'); // Extract info from data-bs-id attribute
                    var modal = $(this);
                    modal.find('#edit_client_id').val(clientId);
                });

                // Delete Client Modal
                $('#deleteClient').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var clientId = button.data('bs-id'); // Extract info from data-bs-id attribute
                    var modal = $(this);
                    modal.find('#delete_client_id').val(clientId);
                });
            </script>
</body>

</html>