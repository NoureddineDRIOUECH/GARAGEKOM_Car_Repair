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
    if (isset($_POST['submit'])) {
        $code = $_GET['code'];
        $newPassword = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);

        $checkCode = $database->prepare("SELECT user_id, reset_token_expiry FROM users WHERE reset_token = :code");
        $checkCode->bindParam(":code", $code);
        $checkCode->execute();

        if ($checkCode->rowCount() === 1) {
            $user = $checkCode->fetchObject();
            $currentTime = time();

            if ($currentTime <= $user->reset_token_expiry) {
                $updatePassword = $database->prepare("UPDATE users SET password_hash = :password WHERE reset_token = :code");
                $updatePassword->bindParam(":password", $newPassword);
                $updatePassword->bindParam(":code", $code);
                $updatePassword->execute();

                // Redirect the user to the login page
                header("Location: login.php");
                exit;
            } else {
                echo '<p class="error-message">The password reset link has expired. Please request a new one.</p>';
            }
        } else {
            echo '<p class="error-message">Invalid password reset link.</p>';
        }
    }
    ?>
    <div class="container mt-1">
        <section id="home" class="text-center">
            <h1 class="main-heading text-primary">GARAGEKOM</h1>
            <p class="sub-heading">Your Trusted Automotive Partner</p>
        </section>
    </div>
    <div class="container  mb-5">
        <section id="new-password" class="text-center">
            <h2 class="section-heading">Set a New Password</h2>
            <p class="section-subheading">Enter your new password below.</p>
        </section>

        <div class="row mt-4">
            <div class="col-md-4 offset-md-4">
                <form method="post">
                    <label class="form-label" for="newPassword">New Password:</label>
                    <input class="form-control" type="password" id="newPassword" name="newPassword" required>



                    <input class="btn btn-primary mt-3" name="submit" type="submit" value="Set New Password">
                </form>
                <p class="mt-3">Remember your password? <a class="text-decoration-none" href="login.php">Login</a></p>
            </div>
        </div>
    </div>
</body>

</html>