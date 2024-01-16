<?php require_once('head.html') ?>
<title>GARAGEKOM | Sign Up</title>
</head>

<body>
    <?php require_once('nav.html') ?>
    <div class="container mt-5 mb-5">
        <section id="signup" class="text-center">
            <h2 class="section-heading">Sign Up for GARAGEKOM</h2>
        </section>

        <div class="row mt-4">
            <div class="col-md-4 offset-md-4">
                <form action="#" method="post">
                    <label class="form-label" class="" for="fullName">Full Name:</label>
                    <input class="form-control mb-2" type="text" id="fullName" name="fullName" required>

                    <label class="form-label" for="username">Username:</label>
                    <input class="form-control mb-2" type="text" id="username" name="username" required>

                    <label class="form-label" for="email">Email:</label>
                    <input class="form-control mb-2" type="email" id="email" name="email" required>

                    <label for="password">Password:</label>
                    <input class="form-control mb-2" type="password" id="password" name="password" required>

                    <label class="form-label" for="confirmPassword">Confirm Password:</label>
                    <input class="form-control" type="password" id="confirmPassword" name="confirmPassword" required>

                    <input class="btn btn-primary mt-3" type="submit" value="Sign Up">
                </form>
                <p class="mt-3">Already have an account? <a class="text-decoration-none" href="login.php">Login</a></p>
            </div>
        </div>
    </div>
    <?php require_once('footer.html') ?>
</body>

</html>