<link rel="icon" href="../src/pics/garagekom.png" />
<?php require_once('../head.html') ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        $('.toast').toast('show');
    });
</script>

<title>GARAGEKOM | Admin</title>
</head>

<body>
    <?php
    require_once("connect-DB.php");
    ?>
    <?php
    if (isset($_POST["login"])) {
        $email = $_POST["email"];
        $login = $database->prepare("SELECT * FROM users WHERE user_email = :admin_email");
        $login->bindParam(":admin_email", $email);
        $login->execute();

        if ($login->rowCount() == 1) {
            $user = $login->fetchObject();

            if (password_verify($_POST["password"], $user->password_hash)) {
                // Successful login
                session_start();
                $_SESSION["user"] = $user;
                if ($user->role == "admin") {
                    header("Location: dashboard.php", true);
                    exit();
                } elseif ($user->role == "mechanic") {
                    header("Location: dashboard.php", true);
                    exit();
                }
            } else {
                // Incorrect password
                echo '<div class="toast align-items-center text-bg-danger border-0 position-absolute mt-3 start-50 translate-middle-x" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        Invalid email or password.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            ';
            }
        } else {
            // User not found
            echo '<div class="toast align-items-center text-bg-danger border-0 position-absolute mt-3 start-50 translate-middle-x" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Unknown user.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        ';
        }
    }
    ?>
    <div class="container mt-1">
        <section id="home" class="text-center">
            <h1 class="main-heading text-primary">Welcome to GARAGEKOM</h1>
            <p class="sub-heading">Your Trusted Automotive Partner</p>
        </section>
    </div>
    <div class="container-fluid mb-5">
        <section id="login" class="text-center">
            <h2 class="section-heading">Login</h2>
        </section>

        <div class="row mt-4">
            <div class="col-md-4 offset-md-4">
                <form method="post">
                    <label class="form-label" for="username">Email:</label>
                    <input class="form-control" type="text" id="username" name="email" required>

                    <label class="mt-3 form-label" for="password">Password:</label>
                    <input class="form-control" type="password" id="password" name="password" required>

                    <input name="login" class="mt-3 btn btn-primary" type="submit" value="Login">
                </form>
                <!-- <p><a href="forgot-password.php" class="text-decoration-none">Forgot your password?</a></p> -->
            </div>
        </div>
    </div>
</body>

</html>