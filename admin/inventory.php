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
            if (isset($_POST["add_item"])) {
                $addItem = $database->prepare("INSERT INTO inventory (item_name, item_car_name, item_brand, item_model, item_price, item_quantity) VALUES (:item_name, :item_car_name, :item_brand, :item_model, :item_price, :item_quantity)");
                $addItem->bindParam(':item_name', $_POST["name"]);
                $addItem->bindParam(':item_car_name', $_POST["nameCar"]);
                $addItem->bindParam(':item_brand', $_POST["brand"]);
                $addItem->bindParam(':item_model', $_POST["model"]);
                $addItem->bindParam(':item_price', $_POST["price"]);
                $addItem->bindParam(':item_quantity', $_POST["qte"]);
                $addItem->execute();
                header("Location: inventory.php");
            }
            if (isset($_POST["edit_qte"])) {
                $editQte = $database->prepare("UPDATE inventory SET item_quantity =  item_quantity + :item_quantity WHERE item_id = :item_id");
                $editQte->bindParam(':item_quantity', $_POST["qte"]);
                $editQte->bindParam(':item_id', $_POST["item_id"]);
                $editQte->execute();
                header("Location: inventory.php");
            }
            if (isset($_POST["delete_item"])) {
                $deleteItem = $database->prepare("DELETE FROM inventory WHERE item_id = :item_id");
                $deleteItem->bindParam(':item_id', $_POST["item_id"]);
                $deleteItem->execute();
                header("Location: inventory.php");
            }
            ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
                <h2>Inventory Management</h2>

                <div class="mb-4 mt-4">
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addItem">Add
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
                            <?php
                            $items = $database->prepare("SELECT * FROM inventory ORDER BY item_id DESC");
                            $items->execute();
                            $items = $items->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($items as $item) {
                                echo "<tr>";
                                echo "<td>" . $item["item_id"] . "</td>";
                                echo "<td>" . $item["item_name"] . "</td>";
                                echo "<td>" . $item["item_brand"] . "</td>";
                                echo "<td>" . $item["item_car_name"] . "</td>";
                                echo "<td>" . $item["item_model"] . "</td>";
                                echo "<td>" . $item["item_price"] . "</td>";
                                echo "<td>" . $item["item_quantity"] . "</td>";
                                echo "<td>";
                                echo '<button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editQte" data-bs-id="' . $item["item_id"] . '">Add Qte</button>';
                                //   echo  '<button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteItem" data-bs-id="' . $item["item_id"] . '">Delete</button>';
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>


            <div class="modal fade" id="editQte" tabindex="-1" aria-labelledby="editQte" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editQte">Add Quantity of Item</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                <label for="qte" class="form-label">Quantity</label>
                                <input type="number" min="1" name="qte" id="qte" class="form-control mb-3" required>
                                <input type="hidden" name="item_id" id="item_id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="edit_qte" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

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
                            <form method="post">
                                <input type="hidden" name="item_id" id="item_id">
                                <button type="submit" name="delete_item" class="btn btn-danger">Delete item</button>
                            </form>
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
                            <form method="post">
                                <label for="name" class="form-label">Item name</label>
                                <input type="text" name="name" id="name" class="form-control mb-3" required>

                                <label for="brand" class="form-label">Brand</label>
                                <input type="text" name="brand" id="brand" class="form-control mb-3" required>

                                <label for="nameCar" class="form-label">Car Name</label>
                                <input type="text" name="nameCar" id="nameCar" class="form-control mb-3" required>

                                <label for="model" class="form-label">Model</label>
                                <input type="number" min="1900" max="<?php echo date("Y"); ?>" name="model" id="model" class="form-control mb-3" required>

                                <label for="price" class="form-label">Price</label>
                                <input type="number" min="1" name="price" id="price" class="form-control mb-3" required>

                                <label for="qte" class="form-label">Quantity</label>
                                <input type="number" min="1" name="qte" id="qte" class="form-control mb-3" required>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="add_item" class="btn btn-primary">Add Item</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
            <script>
                // Edit Quantity Modal
                $('#editQte').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var itemId = button.data('bs-id'); // Extract info from data-bs-id attribute
                    var modal = $(this);
                    modal.find('#item_id').val(itemId);
                });

                // Delete Item Modal
                $('#deleteItem').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var itemId = button.data('bs-id'); // Extract info from data-bs-id attribute
                    var modal = $(this);
                    modal.find('#item_id').val(itemId);
                });
            </script>
</body>

</html>