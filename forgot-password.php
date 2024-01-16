<?php require_once('head.html') ?>
<title>GARAGEKOM | Forgot Password</title>
</head>

<body>
    <?php require_once('nav.html') ?>
    <div class="container mt-5 mb-5">
        <section id="forgot-password" class="text-center">
            <h2 class="section-heading">Forgot Your Password?</h2>
            <p class="section-subheading">Enter your email to reset your password.</p>
        </section>

        <div class="row mt-4">
            <div class="col-md-4 offset-md-4">
                <form action="#" method="post">
                    <label class="form-label" for="email">Email:</label>
                    <input class="form-control" type="email" id="email" name="email" required>

                    <input class="btn btn-primary mt-3" type="submit" value="Reset Password">
                </form>
                <p class="mt-3">Remember your password? <a class="text-decoration-none" href="login.php">Login</a></p>
            </div>
        </div>
    </div>
    <?php require_once('footer.html') ?>
</body>

</html>