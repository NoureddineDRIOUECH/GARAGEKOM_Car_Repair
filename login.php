<?php require_once('head.html') ?>
<title>GARAGEKOM | Login</title>
</head>

<body>
    <?php require_once('nav.html') ?>
    <div class="container mt-5 mb-5">
        <section id="login" class="text-center">
            <h2 class="section-heading">Login to GARAGEKOM</h2>
        </section>

        <div class="row mt-4">
            <div class="col-md-4 offset-md-4">
                <form action="#" method="post">
                    <label class="form-label" for="username">Username:</label>
                    <input class="form-control" type="text" id="username" name="username" required>

                    <label class="mt-3 form-label" for="password">Password:</label>
                    <input class="form-control" type="password" id="password" name="password" required>

                    <input class="mt-3 btn btn-primary" type="submit" value="Login">
                </form>
                <p class="mt-3">Don't have an account? <a class="text-decoration-none" href="signup.php">Sign Up</a>
                </p>
                <p><a href="forgot-password.php" class="text-decoration-none">Forgot your password?</a></p>
            </div>
        </div>
    </div>
    <?php require_once('footer.html') ?>
</body>

</html>