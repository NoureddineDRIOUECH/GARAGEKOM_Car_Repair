<?php require_once('check_login.php'); ?>
<link rel="icon" href="../src/pics/garagekom.png" />
<?php require_once('../head.html') ?>
<link rel="icon" href="../src/pics/garagekom.png" />
<title>GARAGEKOM | Admin</title>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <?php require_once('side-bar.html') ?>
      <?php require_once('connect-DB.php') ?>
      <?php
      if (isset($_POST["add_user"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $role = $_POST["role"];
        $addUser = $database->prepare("INSERT INTO users (username, user_email, password_hash, role) VALUES (:username, :email, :password, :role)");
        $addUser->bindParam(':username', $name);
        $addUser->bindParam(':email', $email);
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $addUser->bindParam(':password', $password_hash);
        $addUser->bindParam(':role', $role);
        $addUser->execute();
        echo "<script>window.location.href = 'user-management.php';</script>";
      }
      if (isset($_POST["edit_user"])) {
        $id = $_POST["user_id"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $role = $_POST["role"];
        $editUser = $database->prepare("UPDATE users SET username = :username, user_email = :email, password_hash = :password, role = :role WHERE user_id = :user_id");
        $editUser->bindParam(':username', $name);
        $editUser->bindParam(':email', $email);
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $editUser->bindParam(':password', $password_hash);
        $editUser->bindParam(':role', $role);
        $editUser->bindParam(':user_id', $id);
        $editUser->execute();
        echo "<script>window.location.href = 'user-management.php';</script>";
      }
      if (isset($_POST["delete_user"])) {
        $id = $_POST["user_id"];
        $deleteUser = $database->prepare("DELETE FROM users WHERE user_id = :user_id");
        $deleteUser->bindParam(':user_id', $id);
        $deleteUser->execute();
        echo "<script>window.location.href = 'user-management.php';</script>";
      }
      ?>
      <main class="col-md-9 mt-5 ms-sm-auto col-lg-10 px-md-4">
        <h2 class="mb-4">User Management</h2>
        <div class="mb-4">
          <button type="button" class="btn btn-warning mt-4" data-bs-toggle="modal" data-bs-target="#addUser">Add User</button>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-sm table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $users = $database->query("SELECT * FROM users");
              $users = $users->fetchAll(PDO::FETCH_ASSOC);
              foreach ($users as $user) {
                echo '
                               <tr>
                                   <td>' . $user["user_id"] . '</td>
                                   <td>' . $user["username"] . '</td>
                                   <td>' . $user["user_email"] . '</td>
                                   <td>' . $user["role"] . '</td>
                                   <td>
                                       <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editUser" data-bs-id="' . $user["user_id"] . '">Edit</button>
                                       <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUser" data-bs-id="' . $user["user_id"] . ')">Delete</button>
                                   </td>
                               </tr>
                               ';
              }
              ?>
            </tbody>
          </table>
        </div>
      </main>

      <div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="editUser" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="editUser">Edit User</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="post">
                <label for="name" class="form-label">Full name</label>
                <input type="text" name="name" id="name" class="form-control mb-3" required>

                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control mb-3" required>

                <label for="password" class="form-label">Password</label>
                <input type="text" name="password" id="password" class="form-control mb-3" required>

                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-select mb-2">
                  <option value="admin">Admin</option>
                  <option value="mechanic">Mechanic</option>
                </select>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="user_id" id="user_id">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" name="edit_user" class="btn btn-primary">Save changes</button>
              </form>
            </div>
          </div>
        </div>
      </div>


      <div class="modal fade" id="deleteUser" tabindex="-1" aria-labelledby="deleteUser" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="deleteUser">Delete User</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Are you sure ?</p>
              <p>You wanna delete user</p>
            </div>
            <div class="modal-footer">
              <form method="post">
                <input type="hidden" name="user_id" id="user_id">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="delete_user" class="btn btn-danger">Delete user</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="addUser" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="addUser">Add new User</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="post">
                <label for="name" class="form-label">Full name</label>
                <input type="text" name="name" id="name" class="form-control mb-3" required>

                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control mb-3" required>

                <label for="password" class="form-label">Password</label>
                <input type="text" name="password" id="password" class="form-control mb-3" required>

                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-select mb-2">
                  <option value="admin">Admin</option>
                  <option value="mechanic">Mechanic</option>
                </select>

            </div>
            <div class="modal-footer">
              <input type="hidden" name="user_id" id="user_id">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" name="add_user" class="btn btn-primary">Add user</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
      <script>
        // Edit User Modal
        $('#editUser').on('show.bs.modal', function(event) {
          var button = $(event.relatedTarget); // Button that triggered the modal
          var userId = button.data('bs-id'); // Extract info from data-bs-id attribute
          var modal = $(this);
          modal.find('#user_id').val(userId);
        });

        // Delete User Modal
        $('#deleteUser').on('show.bs.modal', function(event) {
          var button = $(event.relatedTarget); // Button that triggered the modal
          var userId = button.data('bs-id'); // Extract info from data-bs-id attribute
          var modal = $(this);
          modal.find('#user_id').val(userId);
        });
      </script>
</body>

</html>