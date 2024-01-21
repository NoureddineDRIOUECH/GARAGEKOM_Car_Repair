<?php require_once('head.html') ?>
<title>GARAGEKOM | Contact</title>
</head>

<body>
    <?php require_once('nav.html') ?>
    <?php require_once('admin/connect-DB.php') ?>
    <?php
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['tel'];
        $message = $_POST['message'];
        $contact = $database->prepare("INSERT INTO contacts (name, email, phone, message) VALUES (:name, :email, :phone, :message)");
        $contact->bindParam(':name', $name);
        $contact->bindParam(':email', $email);
        $contact->bindParam(':phone', $phone);
        $contact->bindParam(':message', $message);
        $contact->execute();
    }
    ?>
    <div class="container mt-5">
        <section id="contact" class="text-center">
            <h2 class="section-heading">Contact GARAGEKOM</h2>
            <p class="section-subheading">Have a Question or Need Assistance? Reach Out to Us!</p>
        </section>

        <div class="row mt-4 mb-5">
            <div class="col-md-6">
                <h3>Contact Information</h3>
                <ul class="contact-info">
                    <li><strong>Address:</strong>Hay Moulay Rachid Massira 3, Casablanca Maroc</li>
                    <li><strong>Phone:</strong> +212 660 1318 89</li>
                    <li><strong>Email:</strong> contact@garagekom.com</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h3>Get in Touch</h3>
                <form method="post">
                    <label class="form-label" for="name">Name:</label>
                    <input class="form-control" type="text" id="name" name="name" required>

                    <label class="form-label" for="email">Email:</label>
                    <input class="form-control" type="email" id="email" name="email" required>

                    <label class="form-label" for="tel">Phone:</label>
                    <input class="form-control" type="text" id="tel" name="tel" required>

                    <label class="form-label" for="message">Message:</label>
                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>

                    <input name="submit" class="btn btn-primary mt-3" type="submit" value="Send Message">
                </form>
            </div>
        </div>
    </div>
    <?php require_once('footer.html') ?>
</body>

</html>