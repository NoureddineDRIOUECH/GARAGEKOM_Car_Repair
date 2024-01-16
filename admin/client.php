<?php require_once('../head.html') ?>
<title>GARAGEKOM | Admin</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php require_once('side-bar.html') ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
                <h2>Client Management</h2>

                <!-- Add Client Form -->
                <div class="mb-4">
                    <button type="submit" class="btn btn-warning mt-3" data-bs-toggle="modal"
                        data-bs-target="#addClient">Add Client</button>
                </div>

                <!-- Client List Table -->
                <div class="table-responsive">
                    <h3>Client List</h3>
                    <table class="table table-striped table-sm table-hover ">
                        <thead class="table-primaryrrt">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Car Registration</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>John Doe</td>
                                <td>john.doe@example.com</td>
                                <td>(123) 456-7890</td>
                                <td>4893A10</td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#aditClient">Edit</button>
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deleteClient">Delete</button>
                                </td>
                            </tr>
                            <!-- Add more rows for additional clients -->
                        </tbody>
                    </table>
                </div>
            </main>


            <div class="modal fade" id="aditClient" tabindex="-1" aria-labelledby="aditClient" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="aditClient">Edit Employee</h1>
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

                                <label for="registration" class="form-label">Car Registration</label>
                                <input type="text" name="registration" id="registration" class="form-control mb-3"
                                    required>

                                <label for="carName" class="form-label">Car Name</label>
                                <input type="text" name="carName" id="carName" class="form-control mb-3" required>

                                <label for="model" class="form-label">Model</label>
                                <input type="number" name="model" id="model" class="form-control mb-3" required>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
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
                            <button type="button" class="btn btn-danger">Delete Client</button>
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
                            <form action="">
                                <label for="name" class="form-label">Full name</label>
                                <input type="text" name="name" id="name" class="form-control mb-3" required>

                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control mb-3" required>

                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" name="phone" id="phone" class="form-control mb-3" required>

                                <label for="registration" class="form-label">Car Registration</label>
                                <input type="text" name="registration" id="registration" class="form-control mb-3"
                                    required>

                                <label for="carName" class="form-label">Car Name</label>
                                <input type="text" name="carName" id="carName" class="form-control mb-3" required>

                                <label for="model" class="form-label">Model</label>
                                <input type="number" name="model" id="model" class="form-control mb-3" required>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add client</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</body>

</html>