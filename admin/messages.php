<?php require_once('check_login.php'); ?>
<link rel="icon" href="../src/pics/garagekom.png" />
<?php require_once('../head.html') ?>
<title>GARAGEKOM | Admin</title>
</head>

<body>
    <?php require_once("connect-DB.php") ?>
    <?php
    if (isset($_POST["delete_message"])) {
        $id = $_POST["message_id"];
        $deleteMessage = $database->prepare("DELETE FROM contacts WHERE id = :id");
        $deleteMessage->bindParam(':id', $id);
        $deleteMessage->execute();
        echo "<script>window.location.href = 'messages.php';</script>";
    }
    ?>
    <div class="container-fluid">
        <div class="row">
            <?php require_once('side-bar.html') ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
                <h2>Messages Management</h2>

                <div class="table-responsive">
                    <table class="table table-striped table-sm table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $messages = $database->prepare("SELECT * FROM contacts ORDER BY id DESC");
                            $messages->execute();
                            $messages = $messages->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($messages as $message) {
                                echo "<tr>";
                                echo "<td>" . $message["id"] . "</td>";
                                echo "<td>" . $message["name"] . "</td>";
                                echo "<td>" . $message["phone"] . "</td>";
                                echo "<td>" . $message["email"] . "</td>";
                                echo "<td>" . $message["message"] . "</td>";
                                echo "<td>";
                                echo '<a href="tel:' . $message["phone"] . '" class="btn btn-success btn-sm">Call</a>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteMessage" data-bs-id="' . $message["id"] . '">Delete</button>';
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

    <div class="modal fade" id="deleteMessage" tabindex="-1" aria-labelledby="deleteMessage" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteMessage">Delete Message</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure ?</p>
                    <p>You wanna delete this message</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form method="post">
                        <input type="hidden" name="message_id" id="message_id">
                        <button type="submit" name="delete_message" class="btn btn-danger">Delete
                            Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        // Delete Message Modal
        $('#deleteMessage').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var messageId = button.data('bs-id'); // Extract info from data-bs-id attribute
            var modal = $(this);
            modal.find('#message_id').val(messageId);
        });
    </script>

</body>

</html>