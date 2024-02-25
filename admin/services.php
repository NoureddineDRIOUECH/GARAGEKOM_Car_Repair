<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Ensure that only admins and mechanic have access to the dashboard
if ($_SESSION['user']->role !== "admin") {
    header("Location: login.php");
    exit();
}
?>
<link rel="icon" href="../src/pics/garagekom.png" />
<?php require_once('../head.html') ?>
<title>GARAGEKOM | Admin</title>
</head>

<body>
    <?php require_once("connect-DB.php") ?>
    <?php
    if (isset($_POST["add_service"])) {
        $name = $_POST["name"];
        $type = $_POST["type"];
        $price = $_POST["price"];
        $description = $_POST["description"];
        $addService = $database->prepare("INSERT INTO services (service_name, service_type, service_description,service_price) VALUES (:service_name, :service_type, :service_description, :service_price)");
        $addService->bindParam(':service_name', $name);
        $addService->bindParam(':service_type', $type);
        $addService->bindParam(':service_description', $description);
        $addService->bindParam(':service_price', $price);
        $addService->execute();
        echo "<script>window.location.href = 'services.php';</script>";
    }
    if (isset($_POST["delete_service"])) {
        $id = $_POST["service_id"];

        // Get the service_request_ids associated with the service
        $service_request_ids_query = $database->prepare("SELECT request_id FROM service_requests WHERE service_id = :service_id");
        $service_request_ids_query->bindParam(':service_id', $id);
        $service_request_ids_query->execute();
        $service_request_ids = $service_request_ids_query->fetchAll(PDO::FETCH_COLUMN);

        // Check if there are any service requests
        if ($service_request_ids) {
            // Loop through each service request and delete associated inventory_usage

            foreach ($service_request_ids as $service_request_id) {
                $deleteInventoryUsage = $database->prepare("DELETE FROM inventory_usage WHERE service_request_id = :inventory_service_request_id");
                $deleteInventoryUsage->bindParam(':inventory_service_request_id', $service_request_id);
                $deleteInventoryUsage->execute();
            }

            // Loop through each service request and delete them
            foreach ($service_request_ids as $service_request_id) {
                $deleteServiceRequest = $database->prepare("DELETE FROM service_requests WHERE request_id = :service_request_id");
                $deleteServiceRequest->bindParam(':service_request_id', $service_request_id);
                $deleteServiceRequest->execute();
            }
        }

        // Delete the service itself
        $deleteService = $database->prepare("DELETE FROM services WHERE service_id = :service_id");
        $deleteService->bindParam(':service_id', $id);
        $deleteService->execute();

        echo "<script>window.location.href = 'services.php';</script>";
    }



    if (isset($_POST["edit_service"])) {
        $id = $_POST["service_id"];
        $name = $_POST["name"];
        $type = $_POST["type"];
        $price = $_POST["price"];
        $description = $_POST["description"];
        $editService = $database->prepare("UPDATE services SET service_name = :service_name, service_type = :service_type, service_description = :service_description, service_price = :service_price WHERE service_id = :service_id");
        $editService->bindParam(':service_name', $name);
        $editService->bindParam(':service_type', $type);
        $editService->bindParam(':service_description', $description);
        $editService->bindParam(':service_id', $id);
        $editService->bindParam(':service_price', $price);
        $editService->execute();
        echo "<script>window.location.href = 'services.php';</script>";
    }
    ?>
    <div class="container-fluid">
        <div class="row">
            <?php
            if ($_SESSION['user']->role == "admin") {

                require_once('side-bar.html');
            } elseif ($_SESSION['user']->role == "mechanic") {
                require_once('mechanic/side-bar.html');
            } ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
                <h2>Services Management</h2>

                <div class="mb-4">
                    <button type="button" class="btn btn-warning mt-4" data-bs-toggle="modal" data-bs-target="#addService">Add Service</button>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-sm table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $services = $database->prepare("SELECT * FROM services ORDER BY service_id DESC");
                            $services->execute();
                            $services = $services->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($services as $service) {
                                echo "<tr>";
                                echo "<td>" . $service["service_id"] . "</td>";
                                echo "<td>" . $service["service_name"] . "</td>";
                                echo "<td>" . $service["service_type"] . "</td>";
                                echo "<td>" . $service["service_description"] . "</td>";
                                echo "<td>" . $service["service_price"] . " MAD</td>";
                                echo "<td>";
                                echo '<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editService" data-bs-id="' . $service["service_id"] . '">Edit</button>';
                                // echo '<button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteService" data-bs-id="' . $service["service_id"] . '">Delete</button>';
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <div class="modal fade" id="deleteService" tabindex="-1" aria-labelledby="deleteService" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteService">Delete Service</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure ?</p>
                    <p>You wanna delete this service</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form method="post">
                        <input type="hidden" name="service_id" id="service_id">
                        <button type="submit" name="delete_service" class="btn btn-danger">Delete
                            Service</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addService" tabindex="-1" aria-labelledby="addService" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addService">Add new Service</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <label for="name" class="form-label">Service name</label>
                        <input type="text" name="name" id="name" class="form-control mb-3" required>

                        <label for="type" class="form-label">Type</label>
                        <select name="type" id="type" class="form-select">
                            <option value="Repair">Repair</option>
                            <option value="Maintenance">Maintenance</option>
                        </select>
                        <label for="price" class="mt-3 form-label">Service price</label>
                        <input type="number" min="0" name="price" id="price" class="form-control mb-3" required>

                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="4" class="form-control"></textarea>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_service" class="btn btn-primary">Add Service</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editService" tabindex="-1" aria-labelledby="editService" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editService">Edit Service</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <label for="name" class="form-label">Service name</label>
                        <input type="text" name="name" id="name" class="form-control mb-3" required>

                        <label for="type" class="form-label">Type</label>
                        <select name="type" id="type" class="form-select">
                            <option value="Repair">Repair</option>
                            <option value="Maintenance">Maintenance</option>
                        </select>

                        <label for="price" class="mt-3 form-label">Service price</label>
                        <input type="number" min="0" name="price" id="price" class="form-control mb-3" required>

                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="4" class="form-control"></textarea>
                        <input type="hidden" name="service_id" id="service_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="edit_service" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>











    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        // Edit Service Modal
        $('#editService').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var serviceId = button.data('bs-id'); // Extract info from data-bs-id attribute
            var modal = $(this);
            modal.find('#service_id').val(serviceId);
        });

        // Delete Service Modal
        $('#deleteService').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var serviceId = button.data('bs-id'); // Extract info from data-bs-id attribute
            var modal = $(this);
            modal.find('#service_id').val(serviceId);
        });
    </script>

</body>

</html>