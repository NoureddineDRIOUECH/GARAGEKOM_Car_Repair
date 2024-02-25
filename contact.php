<?php require_once('head.html') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
        if ($contact->execute()) {
            require_once "mail.php";
            $mail->addAddress($email);
            $mail->Subject = "Garagekom Messaging";
            $mail->Body = "
            <!DOCTYPE html>
<html lang='en'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>GARAGEKOM | Your Message Received</title>
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f4f4f4;
      color: #333;
      margin: 0;
      padding: 20px;
    }
    .container {
      max-width: 600px;
      margin: 0 auto;
      background-color: #fff;
      border-radius: 10px; /* Updated for rounded corners */
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .header {
      background-color: #0d6efd;
      padding: 20px;
      color: #fff;
      text-align: center;
    }
    .body {
      padding: 20px;
    }
    .footer {
      background-color: #f8f9fa;
      padding: 10px;
      text-align: center;
    }
    h1 {
      margin-bottom: 0;
    }
    p {
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class='container'>
    <div class='header'>
      <h1>GARAGEKOM</h1>
    </div>
    <div class='body'>
      <h2>Thanks for reaching out!</h2>
      <p>We've received your message and will respond as soon as possible. In the meantime, you can visit our website for more information: <a href='http://garagekom.liveblog365.com/?i=1'>garagekom.com</a></p>
    </div>
    <div class='footer'>
      <p class='text-muted'>GARAGEKOM - Casablanca</p>
    </div>
  </div>
</body>
</html>

            ";

            $mail->setFrom("oyuncoyt@gmail.com", "Garagekom");
            $mail->send();
            header('Location: contact.php?success=true');
        }
    }
    ?>
    <div class="container mt-5">
        <section id="contact" class="text-center">
            <h2 class="section-heading">Contact GARAGEKOM</h2>
            <p class="section-subheading">We value your user experience! If you have any questions or need assistance,
                please don't hesitate to reach out to us. Your feedback is important to us as we strive to enhance your
                experience on GARAGEKOM.</p>
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
    <script>
        $(document).ready(function() {
            <?php if (isset($_GET['success']) && $_GET['success'] === 'true') : ?>
                toastr.success('Your message has been sent successfully!');
            <?php endif; ?>
        });
    </script>
</body>

</html>