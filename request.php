<?php require_once('head.html') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<title>GARAGEKOM | Request</title>
</head>

<body>
    <?php require_once('admin/connect-DB.php');

    if (isset($_POST['submit'])) {
        $name = $_POST['fullName'];
        $phone = $_POST['phoneNumber'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $carReg = $_POST['carRegistration'];
        $requestType = $_POST['requestType'];
        $serviceWanted = $_POST['servicesWanted'];
        $carBrand = $_POST['carBrand'];
        $carModel = $_POST['carModel'];
        $carName = $_POST['carName'];

        // Add client
        $addClient = $database->prepare('INSERT INTO clients (client_name, client_phone, client_email, client_address , client_added_date) VALUES (:fullName, :phoneNumber, :email, :address , NOW())');
        $addClient->bindParam(':fullName', $name);
        $addClient->bindParam(':phoneNumber', $phone);
        $addClient->bindParam(':email', $email);
        $addClient->bindParam(':address', $address);
        $addClient->execute();

        // Get last inserted client ID
        $clientId = $database->lastInsertId();

        // Add car
        $addCar = $database->prepare('INSERT INTO cars (car_registration, client_id, car_name , car_brand, car_model) VALUES (:carRegistration, :clientId, :carName , :carBrand, :carModel)');
        $addCar->bindParam(':carRegistration', $carReg);
        $addCar->bindParam(':clientId', $clientId);
        $addCar->bindParam(':carName', $carName);
        $addCar->bindParam(':carBrand', $carBrand);
        $addCar->bindParam(':carModel', $carModel);
        $addCar->execute();

        // Get last inserted car ID
        $carId = $database->lastInsertId();

        // Get available employee ID (You may need to adjust this logic based on your requirements)
        $employeeId = $database->query('SELECT employee_id FROM employees ORDER BY RAND() LIMIT 1')->fetchColumn();

        // Add service request
        $addRequest = $database->prepare('INSERT INTO service_requests (client_id, service_id, car_id, employee_id, request_date) VALUES (:clientId, :serviceId, :carId, :employeeId , NOW())');
        $addRequest->bindParam(':clientId', $clientId);
        $addRequest->bindParam(':serviceId', $serviceWanted);
        $addRequest->bindParam(':carId', $carId);
        $addRequest->bindParam(':employeeId', $employeeId);
        if ($addRequest->execute()) {
            require_once "mail.php";
            $mail->addAddress($email);
            $mail->Subject = "Service Request";
            $mail->Body = "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>GARAGEKOM Service Request Confirmation</title>
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
                        border-radius: 5px;
                        overflow: hidden;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                        border-radius : 25px;
                    }
                    .bg-primary {
                        background-color: #0d6efd;
                        padding: 20px;
                        color: #fff;
                    }
                    .text-primary {
                        color: #0d6efd;
                    }
                    .p-4 {
                        padding: 20px;
                    }
                    .bg-light {
                        background-color: #f8f9fa;
                        padding: 10px;
                        text-align: center;
                    }
                    .text-muted {
                        color: #6c757d;
                    }
                </style>
            </head>
            <body>
                <table class='container'>
                    <tr>
                        <td class='bg-primary text-center'>
                            <h1 class='mb-0'>GARAGEKOM</h1>
                        </td>
                    </tr>
                    <tr>
                        <td class='p-4'>
                            <h2 class='text-primary'>Service Request Confirmation</h2>
                            <p>Thank you for your request. We will get back to you shortly.</p>
                        </td>
                    </tr>
                    <tr>
                        <td class='bg-light'>
                            <p class='mb-0 text-muted'>GARAGEKOM - Casablanca</p>
                        </td>
                    </tr>
                </table>
            </body>
            </html>
            ";

            $mail->setFrom("oyuncoyt@gmail.com", "Garagekom");
            $mail->send();
            header('Location: request.php?success=true');
        }
    }
    ?>

    <?php require_once('nav.html') ?>
    <div class="container mt-5">
        <section id="request" class="text-center">
            <h2 class="section-heading">Service Request</h2>
            <p class="section-subheading">Tell Us About Your Service Needs</p>
        </section>

        <div class="row mt-4 mb-5">
            <div class="col-md-6 offset-md-3">
                <form method="post">
                    <label class="form-label" for="fullName">Full Name:</label>
                    <input class="form-control mb-2" type="text" id="fullName" name="fullName" required>

                    <label class="form-label" for="phoneNumber">Phone Number:</label>
                    <input class="form-control mb-2" type="tel" id="phoneNumber" name="phoneNumber" min="10" max="15" required>

                    <label class="form-label" for="email">Email:</label>
                    <input class="form-control mb-2" type="email" id="email" name="email" required>

                    <label class="form-label" for="address">Address:</label>
                    <input class="form-control mb-2" type="text" id="address" name="address" required>

                    <label class="form-label" for="carBrand">Car Brand:</label>
                    <input class="form-control mb-2" type="text" id="carBrand" placeholder="Mercedes" name="carBrand" required>

                    <label class="form-label" for="carName">Car Name:</label>
                    <input class="form-control mb-2" type="text" id="carName" placeholder="G63" name="carName" required>

                    <label class="form-label" for="carModel">Car Model:</label>
                    <input class="form-control mb-2" min="1900" max="<?php echo date("Y"); ?>" type="number" id="carModel" placeholder="2024" name="carModel" required>

                    <label class="form-label" for="carRegistration">Car Registration:</label>
                    <input class="form-control mb-2" type="text" id="carRegistration" placeholder="example :  36176 A 10" name="carRegistration" required>

                    <label class="form-label" for="requestType">Request Type:</label>
                    <select id="requestType" name="requestType" class="form-select mb-2" required>
                        <option value="maintenance">Maintenance</option>
                        <option value="repair">Repair</option>
                    </select>

                    <label class="form-label" for="servicesWanted">Services Wanted:</label>
                    <select name="servicesWanted" id="servicesWanted" class="form-select mb-2">
                        <?php
                        $services = $database->query('SELECT * FROM services');
                        foreach ($services as $service) {
                            echo "<option value='$service[service_id]'>$service[service_name]</option>";
                        }
                        ?>
                    </select>
                    <input class="btn btn-primary mt-3" type="submit" value="Submit Request" name="submit">
                </form>
            </div>
        </div>
    </div>
    <?php require_once('footer.html') ?>
    <script>
        $(document).ready(function() {
            <?php if (isset($_GET['success']) && $_GET['success'] === 'true') : ?>
                toastr.success('Your service request has been submitted successfully!');
            <?php endif; ?>
        });
    </script>
</body>

</html>