<?php require_once('../head.html') ?>
<title>GARAGEKOM | Admin</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php require_once('side-bar.html') ?>


            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
                <h2 class="mb-4">Service Request Management</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Request ID</th>
                                <th>Client Name</th>
                                <th>Car Registration</th>
                                <th>Service Type</th>
                                <th>Problem</th>
                                <th>Mechanic</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>John Doe</td>
                                <td>A1</td>
                                <td>Oil Change</td>
                                <td>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tempore, repellat.</td>
                                <td>Noureddine</td>
                                <td> <span class="badge rounded-pill text-bg-warning">Pending</span></td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#details">View Details</button>

                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#update">Update Status</button>
                                    <a href="tel:3298839" class="btn btn-success btn-sm">Call</a>
                                </td>
                            </tr>
                            <!-- Add more rows for additional service requests -->
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
                        <form action="" class="m-auto">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="inProgress">
                                <label class="form-check-label text-warning" for="inProgress">
                                    In progress
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="done">
                                <label class="form-check-label text-success" for="done">
                                    Done
                                </label>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Update status</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="details" tabindex="-1" aria-labelledby="details" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header mb-3">
                        <h1 class="modal-title fs-5" id="details">Request detail</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <p class="text-center">Time Added : <span class="text-warning"> 383298</span></p>


                </div>
            </div>
        </div>
    </div>

</body>

</html>