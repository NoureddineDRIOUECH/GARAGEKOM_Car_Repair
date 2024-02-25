<link rel="icon" href="../src/pics/garagekom.png" />
<?php require_once('../head.html') ?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $('.toast').toast('show');
    });
</script>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<title>GARAGEKOM | Admin</title>
</head>

<body>
    <?php
    require_once("connect-DB.php");
    if (isset($_POST['reset'])) {
        $email = $_POST['email'];
        $checkMail = $database->prepare("SELECT user_email FROM users WHERE user_email = :admin_email");
        $checkMail->bindParam(":admin_email", $email);
        $checkMail->execute();

        if ($checkMail->rowCount() === 1) {
            require_once '../mail.php';
            $mail->addAddress($email);
            $user = $checkMail->fetchObject();
            $code = bin2hex(random_bytes(32));
            $expiryTime = date('Y-m-d H:i:s', time() + 3600);


            $updateCode = $database->prepare("UPDATE users SET reset_token = :code, reset_token_expiry = :expiry WHERE user_email = :email");
            $updateCode->bindParam(":code", $code);

            $updateCode->bindParam(":expiry", $expiryTime);
            $updateCode->bindParam(":email", $email);

            $updateCode->execute();

            $mail->Subject = "Password Reset Request - GARAGEKOM";
            $mail->Body = "Hello,\n\nWe have received a request to reset your password for your account on GARAGEKOM. If you made this request, please click on the following link to reset your password: \n\nhttp://localhost/GARAGEKOM/admin/new-password.php?code=$code\n\nThis link will expire in one hour. If you did not request a password reset, please ignore this email.\n\nRegards,\nThe GARAGEKOM Team";
            $mail->send();

            echo '<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <strong class="me-auto">Success</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">A password reset link has been sent to your email. Please check your inbox.</div>
                </div>';
        } else {
            echo '<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <strong class="me-auto">Error</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">The email address provided is not registered with us. Please try again.</div>
                </div>';
        }
    }
    ?>
    <div class="container mt-1">
        <section id="home" class="text-center">
            <h1 class="main-heading text-primary">GARAGEKOM</h1>
            <p class="sub-heading">Your Trusted Automotive Partner</p>
        </section>
    </div>
    <div class="container mb-5">
        <section id="forgot-password" class="text-center">
            <h2 class="section-heading">Forgot Your Password?</h2>
            <p class="section-subheading">Enter your email to reset your password.</p>
        </section>

        <div class="row mt-4">
            <div class="col-md-4 offset-md-4">
                <form method="post">
                    <label class="form-label" for="email">Email:</label>
                    <input class="form-control" type="email" id="email" name="email" required>

                    <input class="btn btn-primary mt-3" type="submit" name="reset" value="Reset Password">
                </form>
                <p class="mt-3">Remember your password? <a class="text-decoration-none" href="login.php">Login</a></p>
            </div>
        </div>
    </div>
</body>

</html>