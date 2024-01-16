<?php require_once('../head.html') ?>
<title>GARAGEKOM | Admin</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php require_once('side-bar.html') ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
                <h2>Employee Management</h2>

                <!-- Add Employee Form -->
                <div class="mb-4">
                    <button type="submit" class="btn btn-warning mt-4" data-bs-toggle="modal"
                        data-bs-target="#addEmployee">Add Employee</button>
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
                                <th>Email</th>
                                <th>Salary</th>
                                <th>Position</th>
                                <th>Date Added</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Jane Doe</td>
                                <td>230349239</td>
                                <td>no@dis,com</td>
                                <td>3290 MAD</td>
                                <td>Mechanic</td>
                                <td>39/23/2032</td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editEmployee">Edit</button>
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deleteEmployee">Delete</button>
                                </td>
                            </tr>
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
                            <form action="">
                                <label for="name" class="form-label">Full name</label>
                                <input type="text" name="name" id="name" class="form-control mb-3" required>

                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control mb-3" required>

                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" name="phone" id="phone" class="form-control mb-3" required>

                                <label for="position" class="form-label">Position</label>
                                <input type="text" name="position" id="position" class="form-control mb-3" required>

                                <label for="salary" class="form-label">Salary</label>
                                <input type="tel" name="salary" id="salary" class="form-control mb-3" required>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteEmployee" tabindex="-1" aria-labelledby="deleteEmployee"
                aria-hidden="true">
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
                            <button type="button" class="btn btn-danger">Delete Employee</button>
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
                            <form action="">
                                <label for="name" class="form-label">Full name</label>
                                <input type="text" name="name" id="name" class="form-control mb-3" required>

                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control mb-3" required>

                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" name="phone" id="phone" class="form-control mb-3" required>

                                <label for="position" class="form-label">Position</label>
                                <input type="text" name="position" id="position" class="form-control mb-3" required>

                                <label for="salary" class="form-label">Salary</label>
                                <input type="number" name="salary" id="salary" class="form-control mb-3" required>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add employee</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</body>

</html>