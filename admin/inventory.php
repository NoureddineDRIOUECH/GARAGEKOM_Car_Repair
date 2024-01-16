<?php require_once('../head.html') ?>
<title>GARAGEKOM | Admin</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php require_once('side-bar.html') ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
                <h2>Inventory Management</h2>

                <div class="mb-4 mt-4">
                    <button type="submit" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addItem">Add
                        Item</button>

                </div>

                <!-- Inventory List Table -->
                <div class="table-responsive">
                    <h3>Inventory List</h3>
                    <table class="table table-striped table-sm table-hover ">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Item Name</th>
                                <th>Brand</th>
                                <th>Car name</th>
                                <th>Model</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Oil Filter</td>
                                <td>Dacia</td>
                                <td>Sandero</td>
                                <td>2014</td>
                                <td>324 MAD</td>
                                <td>100</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deleteItem">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>


            <div class="modal fade" id="deleteItem" tabindex="-1" aria-labelledby="deleteItem" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="deleteItem">Delete Item</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure ?</p>
                            <p>You wanna delete this item</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger">Delete item</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="addItem" tabindex="-1" aria-labelledby="addItem" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="addItem">Add New Inventory Item</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="">
                                <label for="name" class="form-label">Item name</label>
                                <input type="text" name="name" id="name" class="form-control mb-3" required>

                                <label for="brand" class="form-label">Brand</label>
                                <input type="text" name="brand" id="brand" class="form-control mb-3" required>

                                <label for="nameCar" class="form-label">Car Name</label>
                                <input type="text" name="nameCar" id="nameCar" class="form-control mb-3" required>

                                <label for="model" class="form-label">Model</label>
                                <input type="number" name="model" id="model" class="form-control mb-3" required>

                                <label for="price" class="form-label">Price</label>
                                <input type="number" name="price" id="price" class="form-control mb-3" required>

                                <label for="qte" class="form-label">Quantity</label>
                                <input type="number" name="qte" id="qte" class="form-control mb-3" required>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Item</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</body>

</html>