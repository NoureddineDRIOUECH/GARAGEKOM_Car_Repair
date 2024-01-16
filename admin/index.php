<?php require_once('../head.html') ?>
<title>GARAGEKOM | Admin</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->

            <?php require_once('side-bar.html') ?>




            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
                <h2>Dashboard</h2>

                <!-- Example Widgets -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Service Requests</h5>
                                <p class="card-text">150</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Completed Requests</h5>
                                <p class="card-text">120</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Pending Requests</h5>
                                <p class="card-text">30</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Employee Count</h5>
                                <p class="card-text">10</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Example Charts (You may use a library like Chart.js for more advanced charts) -->
                <div class="row">
                    <div class="col-md-6">
                        <h3>Service Requests by Type</h3>
                        <canvas id="serviceRequestsChart" width="400" height="200"></canvas>
                    </div>
                    <div class="col-md-6">
                        <h3>Employee Performance</h3>
                        <canvas id="employeePerformanceChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </main>
        </div>














































        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h2>Reports and Analytics</h2>

            <!-- Example Charts (You may use a library like Chart.js for more advanced charts) -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h3>Service Requests by Type</h3>
                    <canvas id="serviceRequestsChart" width="400" height="200"></canvas>
                </div>
                <div class="col-md-6">
                    <h3>Employee Performance</h3>
                    <canvas id="employeePerformanceChart" width="400" height="200"></canvas>
                </div>
            </div>

            <!-- Example Data Table (You may use a library like DataTables for more features) -->
            <div class="table-responsive">
                <h3>Monthly Service Request Summary</h3>
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Total Requests</th>
                            <th>Completed Requests</th>
                            <th>Pending Requests</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>January</td>
                            <td>50</td>
                            <td>40</td>
                            <td>10</td>
                        </tr>
                        <!-- Add more rows for additional months -->
                    </tbody>
                </table>
            </div>
        </main>















    </div>
    </div>
    <script src="code.js"></script>
</body>

</html>