<?php require_once('head.html') ?>
<title>GARAGEKOM</title>
</head>

<body>
    <?php require_once('nav.html') ?>

    <div class="container-fluid">
        <section id="home" class=" position-relative">
            <h1 class="main-heading position-absolute top-50 start-50 translate-middle">Welcome to GARAGEKOM</h1>
            <p class="sub-heading position-absolute mt-5 top-50 start-50 translate-middle">Your Trusted Automotive
                Partner
            </p>
        </section>
        <!-- Services Section -->
        <section id="services" class="text-center mt-5">
            <h2>Our Services</h2>
            <p>Explore a range of automotive services tailored to your needs.</p>

            <div class="row mt-4">
                <!-- Service Card 1 -->
                <div class="col-md-4 mb-4">
                    <div class="card border-0">
                        <img src="src/pics/service1.png" class="card-img-top" alt="Service 1">
                        <div class="card-body">
                            <h5 class="card-title">Oil Change</h5>
                            <p class="card-text">Ensure the smooth operation of your vehicle with our professional oil
                                change service.</p>
                        </div>
                    </div>
                </div>

                <!-- Service Card 2 -->
                <div class="col-md-4 mb-4">
                    <div class="card border-0">
                        <img src="src/pics/brake repair.png" class="card-img-top" alt="Service 2">
                        <div class="card-body">
                            <h5 class="card-title">Brake Repair</h5>
                            <p class="card-text">Trust us for efficient brake repair services to keep your vehicle safe
                                on the road.</p>
                        </div>
                    </div>
                </div>

                <!-- Service Card 3 -->
                <div class="col-md-4 mb-4">
                    <div class="card border-0">
                        <img src="src/pics/tireRotation.png" class="card-img-top" alt="Service 3">
                        <div class="card-body">
                            <h5 class="card-title">Tire Rotation</h5>
                            <p>Extend tire life and improve handling with our tire rotation and balancing services.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Features Section -->
        <!-- Features Section -->
        <section id="features" class="text-center mt-5">
            <h2>Key Features</h2>
            <p>Discover why GARAGEKOM is the right choice for your vehicle needs.</p>

            <div class="row mt-4">
                <!-- Feature Card 1 -->
                <div class="col-md-4 mb-4">
                    <div class="card border-primary">
                        <div class="card-body">
                            <h5 class="card-title text-warning">Experienced Technicians</h5>
                            <p class="card-text">Our team consists of skilled and experienced automotive technicians.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Feature Card 2 -->
                <div class="col-md-4 mb-4">
                    <div class="card border-primary">
                        <div class="card-body">
                            <h5 class="card-title text-warning">Quick and Efficient Service</h5>
                            <p class="card-text">We prioritize quick and efficient service to minimize downtime for your
                                vehicle.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature Card 3 -->
                <div class="col-md-4 mb-4">
                    <div class="card border-primary">
                        <div class="card-body">
                            <h5 class="card-title text-warning">Quality Parts and Equipment</h5>
                            <p class="card-text">We use high-quality parts and state-of-the-art equipment for all our
                                services.</p>
                        </div>
                    </div>
                </div>

                <!-- Add more feature cards as needed -->
            </div>
        </section>


        <!-- Call-to-Action Section -->
        <section id="cta" class="text-center mt-5 mb-5">
            <h2>Ready to Get Started?</h2>
            <p>Contact us for quality automotive services and a seamless experience.</p>

            <a href="request.php" class="btn btn-primary btn-lg">Service Request</a>
        </section>
    </div>

    </div>
    <?php require_once('footer.html') ?>
</body>

</html>