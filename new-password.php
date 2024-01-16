<?php require_once('head.html') ?>
<title>GARAGEKOM | New Password</title>
</head>

<body>
    <?php require_once('nav.html') ?>
    <div class="container mt-5 mb-5">
        <section id="new-password" class="text-center">
            <h2 class="section-heading">Set a New Password</h2>
            <p class="section-subheading">Enter your new password below.</p>
        </section>

        <div class="row mt-4">
            <div class="col-md-4 offset-md-4">
                <form action="#" method="post">
                    <label class="form-label" for="newPassword">New Password:</label>
                    <input class="form-control" type="password" id="newPassword" name="newPassword" required>

                    <label class="form-label" for="confirmNewPassword">Confirm New Password:</label>
                    <input class="form-control" type="password" id="confirmNewPassword" name="confirmNewPassword"
                        required>

                    <input class="btn btn-primary mt-3" type="submit" value="Set New Password">
                </form>
                <p class="mt-3">Remember your password? <a class="text-decoration-none" href="login.php">Login</a></p>
            </div>
        </div>
    </div>
    <?php require_once('footer.html') ?>
</body>

</html>