<?php require_once('head.html') ?>
<title>GARAGEKOM | Contact</title>
</head>

<body>
    <?php require_once('nav.html') ?>
    <div class="container mt-5">
        <section id="request" class="text-center">
            <h2 class="section-heading">Service Request</h2>
            <p class="section-subheading">Tell Us About Your Service Needs</p>
        </section>

        <div class="row mt-4 mb-5">
            <div class="col-md-6 offset-md-3">
                <form action="#" method="post">
                    <label class="form-label" for="fullName">Full Name:</label>
                    <input class="form-control mb-2" type="text" id="fullName" name="fullName" required>

                    <label class="form-label" for="phoneNumber">Phone Number:</label>
                    <input class="form-control mb-2" type="tel" id="phoneNumber" name="phoneNumber" required>

                    <label class="form-label" for="email">Email:</label>
                    <input class="form-control mb-2" type="email" id="email" name="email" required>

                    <label class="form-label" for="address">Address:</label>
                    <input class="form-control mb-2" type="text" id="address" name="address" required>

                    <label class="form-label" for="carBrand">Car Brand:</label>
                    <input class="form-control mb-2" type="text" id="carBrand" name="carBrand" required>

                    <label class="form-label" for="carName">Car Name:</label>
                    <input class="form-control mb-2" type="text" id="carName" name="carName" required>

                    <label class="form-label" for="carModel">Car Model:</label>
                    <input class="form-control mb-2" type="text" id="carModel" name="carModel" required>

                    <label class="form-label" for="carRegistration">Car Registration:</label>
                    <input class="form-control mb-2" type="text" id="carRegistration" name="carRegistration" required>

                    <label class="form-label" for="requestType">Request Type:</label>
                    <select id="requestType" name="requestType" class="form-select mb-2" required>
                        <option value="maintenance">Maintenance</option>
                        <option value="repair">Repair</option>
                    </select>

                    <label class="form-label" for="servicesWanted">Services Wanted:</label>
                    <textarea class="form-control" id="servicesWanted" name="servicesWanted" rows="4" required></textarea>

                    <input class="btn btn-primary mt-3" type="submit" value="Submit Request">
                </form>
            </div>
        </div>
    </div>
    <?php require_once('footer.html') ?>
</body>

</html>