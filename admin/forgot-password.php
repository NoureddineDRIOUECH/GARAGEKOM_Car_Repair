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