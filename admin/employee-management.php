<?php require_once('check_login.php'); ?>
<link rel="icon" href="../src/pics/garagekom.png" />
<?php require_once('../head.html') ?>
<title>GARAGEKOM | Admin</title>
</head>

<body>
    <?php require_once("connect-DB.php") ?>
    <?php
    if (isset($_POST["add_employee"])) {
        $name = $_POST["name"];
        $address = $_POST["address"];
        $phone = $_POST["phone"];
        $position = $_POST["position"];
        $salary = $_POST["salary"];
        $addEmployee = $database->prepare("INSERT INTO employees (employee_name, employee_address, employee_phone, employee_salary, employee_added_date , employee_position) VALUES (:employee_name, :employee_address, :employee_phone, :employee_salary, NOW(), :employee_position)");
        $addEmployee->bindParam(':employee_name', $name);
        $addEmployee->bindParam(':employee_address', $address);
        $addEmployee->bindParam(':employee_phone', $phone);
        $addEmployee->bindParam(':employee_salary', $salary);
        $addEmployee->bindParam(':employee_position', $position);
        $addEmployee->execute();
        echo "<script>window.location.href = 'employee-management.php';</script>";
    }
    if (isset($_POST["delete_employee"])) {
        $id = $_POST["employee_id"];
        $deleteInventory_usage = $database->prepare("DELETE FROM inventory_usage WHERE employee_id = :employee_id");
        $deleteInventory_usage->bindParam(':employee_id', $id);
        $deleteInventory_usage->execute();
        $deleteRequestService = $database->prepare("DELETE FROM request_services WHERE employee_id = :employee_id");
        $deleteRequestService->bindParam(':employee_id', $id);
        $deleteRequestService->execute();
        $deleteEmployee = $database->prepare("DELETE FROM employees WHERE employee_id = :employee_id");
        $deleteEmployee->bindParam(':employee_id', $id);
        $deleteEmployee->execute();
        echo "<script>window.location.href = 'employee-management.php';</script>";
    }
    if (isset($_POST['edit_employee'])) {
        $id = $_POST["employee_id"];
        $name = $_POST["name"];
        $address = $_POST["address"];
        $phone = $_POST["phone"];
        $position = $_POST["position"];
        $salary = $_POST["salary"];
        $editEmployee = $database->prepare("UPDATE employees SET employee_name = :employee_name, employee_address = :employee_address, employee_phone = :employee_phone, employee_salary = :employee_salary, employee_position = :employee_position WHERE employee_id = :employee_id");
        $editEmployee->bindParam(':employee_name', $name);
        $editEmployee->bindParam(':employee_address', $address);
        $editEmployee->bindParam(':employee_phone', $phone);
        $editEmployee->bindParam(':employee_salary', $salary);
        $editEmployee->bindParam(':employee_position', $position);
        $editEmployee->bindParam(':employee_id', $id);
        $editEmployee->execute();
        echo "<script>window.location.href = 'employee-management.php';</script>";
    }
    ?>
    <div class="container-fluid">
        <div class="row">
            <?php require_once('side-bar.html') ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
                <h2>Employee Management</h2>

                <!-- Add Employee Form -->
                <div class="mb-4">
                    <button type="button" class="btn btn-warning mt-4" data-bs-toggle="modal" data-bs-target="#addEmployee">Add Employee</button>
                </div>

                <!-- Employee List Table -->
                <div class="table-responsive">
                    <h3>Employee List</h3>
                    <table class="table table-striped table-sm table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Salary</th>
                                <th>Position</th>
                                <th>Date Added</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $employees = $database->prepare("SELECT * FROM employees");
                            $employees->execute();
                            $employees = $employees->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($employees as $employee) {
                                echo "<tr>";
                                echo "<td>" . $employee["employee_id"] . "</td>";
                                echo "<td>" . $employee["employee_name"] . "</td>";
                                echo "<td>" . $employee["employee_phone"] . "</td>";
                                echo "<td>" . $employee["employee_address"] . "</td>";
                                echo "<td>" . $employee["employee_salary"] . "</td>";
                                echo "<td>" . $employee["employee_position"] . "</td>";
                                echo "<td>" . $employee["employee_added_date"] . "</td>";
                                echo "<td>";
                                echo '<button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editEmployee" data-bs-id="' . $employee["employee_id"] . '">Edit</button>';
                                // echo '<button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteEmployee" data-bs-id="' . $employee["employee_id"] . '">Delete</button>';
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>
            <div class="modal fade" id="editEmployee" tabindex="-1" aria-labelledby="editEmployee" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editEmployee">Edit Employee</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                <label for="name" class="form-label">Full name</label>
                                <input type="text" name="name" id="name" class="form-control mb-3" required>

                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" id="address" class="form-control mb-3" required>

                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" name="phone" id="phone" class="form-control mb-3" required>

                                <label for="position" class="form-label">Position</label>
                                <input type="text" name="position" id="position" class="form-control mb-3" required>

                                <label for="salary" class="form-label">Salary</label>
                                <input type="number" name="salary" id="salary" class="form-control mb-3" required>
                                <input type="hidden" name="employee_id" id="edit_employee_id">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="edit_employee" class="btn btn-primary">Save changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteEmployee" tabindex="-1" aria-labelledby="deleteEmployee" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="deleteEmployee">Delete Employee</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure ?</p>
                            <p>You wanna delete Employee</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <form method="post">
                                <input type="hidden" name="employee_id" id="delete_employee_id">
                                <button type="submit" name="delete_employee" class="btn btn-danger">Delete
                                    Employee</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="addEmployee" tabindex="-1" aria-labelledby="addEmployee" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="addEmployee">Add new Employee</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                <label for="name" class="form-label">Full name</label>
                                <input type="text" name="name" id="name" class="form-control mb-3" required>

                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" id="address" class="form-control mb-3" required>

                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" name="phone" id="phone" class="form-control mb-3" required>

                                <label for="position" class="form-label">Position</label>
                                <input type="text" name="position" id="position" class="form-control mb-3" required>

                                <label for="salary" class="form-label">Salary</label>
                                <input type="number" min="2000" name="salary" id="salary" class="form-control mb-3" required>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="add_employee" class="btn btn-primary">Add Employee</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
            <script>
                // Edit Employee Modal
                $('#editEmployee').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var employeeId = button.data('bs-id'); // Extract info from data-bs-id attribute
                    var modal = $(this);
                    modal.find('#edit_employee_id').val(employeeId);
                });

                // Delete Employee Modal
                $('#deleteEmployee').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var employeeId = button.data('bs-id'); // Extract info from data-bs-id attribute
                    var modal = $(this);
                    modal.find('#delete_employee_id').val(employeeId);
                });
            </script>

</body>

</html>