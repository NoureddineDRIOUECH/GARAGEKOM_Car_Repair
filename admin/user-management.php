<?php require_once('../head.html') ?>
<link rel="icon" href="../src/pics/garagekom.png" />
<title>GARAGEKOM | Admin</title>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <?php require_once('side-bar.html') ?>

      <main class="col-md-9 mt-5 ms-sm-auto col-lg-10 px-md-4">
        <h2 class="mb-4">User Management</h2>
        <div class="table-responsive">
          <table class="table table-striped table-sm table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>John Doe</td>
                <td>john@example.com</td>
                <td>32892197129</td>
                <td>Admin</td>
                <td>
                  <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editUser">Edit</button>
                  <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteUser">Delete</button>
                </td>
              </tr>
              <!-- Add more rows for additional users -->
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
              <form action="">
                <label for="name" class="form-label">Full name</label>
                <input type="text" name="name" id="name" class="form-control mb-3" required>

                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control mb-3" required>

                <label for="phone" class="form-label">Phone</label>
                <input type="tel" name="phone" id="phone" class="form-control mb-3" required>

                <label for="role" class="form-label">Role</label>
                <input type="text" name="role" id="role" class="form-control mb-3" required>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
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
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-danger">Delete user</button>
            </div>
          </div>
        </div>
      </div>
</body>

</html>