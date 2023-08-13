<?php
ini_set('display_errors', 0);
include 'db_connect.php';
include 'include-admin/header.php';
?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header is-small-screen">

    <?php if ($_SESSION['login_type'] == 1) : ?> <!-- admin -->
        <main class="mdl-layout__content">
            <div class="mdl-grid mdl-grid--no-spacing dashboard">
                <div class="mdl-grid mdl-cell mdl-cell--9-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone mdl-cell--top">
                    <div class="mdl-cell mdl-cell--4-col-desktop mdl-cell--4-col-tablet mdl-cell--2-col-phone">

                    </div>

                    <div class="mdl-cell mdl-cell--4-col-desktop mdl-cell--4-col-tablet mdl-cell--2-col-phone">

                    </div>

                    <div class="mdl-cell mdl-cell--4-col-desktop mdl-cell--4-col-tablet mdl-cell--2-col-phone">
                        <a href="invoice.php" class="btn btn-success btn-md" style="float: right;">Generate</a>
                    </div>

                    <!-- flex box -->
                    <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--12-col-phone">
                        <div class="col-xl-12 col-md-12 mb-12 bg-info">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Registered User</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                $query = "SELECT type FROM users WHERE type = 1";
                                                $query_run = mysqli_query($conn, $query);
                                                $row = mysqli_num_rows($query_run);
                                                echo '<small> Admin: ' . $row . '</small>';
                                                ?>
                                                <hr class="bg-dark">
                                                <?php
                                                $query = "SELECT type FROM users WHERE type = 2";
                                                $query_run = mysqli_query($conn, $query);
                                                $row = mysqli_num_rows($query_run);
                                                echo '<small> Registrar: ' . $row . '</small>';
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="far fa-user fa-2x text-gray-1000"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--12-col-phone">
                        <div class="col-xl-12 col-md-12 mb-12 bg-info">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Queue
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">

                                                <?php
                                                $que = "SELECT * FROM queue_list WHERE DATE(date_created) = DATE(NOW()) AND status = 0";
                                                $q = mysqli_query($conn, $que);
                                                $row = mysqli_num_rows($q);
                                                echo '<small> Waiting: ' . $row . '</small>';
                                                ?>
                                                <hr class="bg-dark">
                                                <?php
                                                $que = "SELECT * FROM queue_list WHERE status = 1";
                                                $q = mysqli_query($conn, $que);
                                                $row = mysqli_num_rows($q);
                                                echo '<small> Assisted: ' . $row . '</small>';
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class='far fa-pause-circle fa-2x text-gray-1000' style='font-size:36px'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="mdl-cell mdl-cell--3-col-desktop mdl-cell--6-col-tablet mdl-cell--2-col-phone">
                        <div class="mdl-card mdl-shadow--2dp">
                            <div class="mdl-card__title">
                                <h2 class="mdl-card__title-text">User</h2>
                            </div>
                            <div class="mdl-card__supporting-text">
                                <div id="piechart2">

                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $query = "SELECT name, count(*) as number FROM transactions GROUP BY name";
                    $result = mysqli_query($conn, $query);
                    ?>

                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                    <script type="text/javascript">
                        google.charts.load('current', {
                            'packages': ['corechart']
                        });
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                                ['name', 'Number'],
                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "['" . $row["name"] . "', " . $row["number"] . "],";
                                }
                                ?>
                            ]);
                            var options = {
                                width: 500,
                                height: 500,
                                pieHole: 0.4,
                                backgroundColor: {
                                    fill: 'transparent'
                                }

                            };

                            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                            chart.draw(data, options);
                        }
                    </script>

                    <div class="mdl-cell mdl-cell--3-col-desktop mdl-cell--6-col-tablet mdl-cell--2-col-phone">
                        <div class="mdl-card mdl-shadow--2dp">
                            <div class="mdl-card__title">
                                <h2 class="mdl-card__title-text">Queue status</h2>
                            </div>
                            <div class="mdl-card__supporting-text">
                                <div id="piechart"></div>
                            </div>
                        </div>
                    </div>

                    <!-- User Details -->
                    <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell---col-phone">
                        <div class="mdl-card mdl-shadow--2dp pie-chart">
                            <div class="mdl-card__title">
                                <h2 class="mdl-card__title-text">User Details</h2>
                            </div>
                            <div class="mdl-card__supporting-text mdl-card--expand">
                                <div id="chart_div" style="width: 100%; height: 500px;"></div>

                            </div>
                        </div>
                    </div>

                    <!-- <div class="mdl-cell mdl-cell--3-col-desktop mdl-cell--6-col-tablet mdl-cell--6-col-phone">
                        <div class="mdl-card mdl-shadow--2dp pie-chart">
                            <div class="mdl-card__title bg-danger">
                                <h2 class="mdl-card__title-text">Discrete Bar Chart</h2>
                            </div>
                            <div class="mdl-card__supporting-text mdl-card--expand">
                                <div id="chart_div" style="width: 100%; height: 500px;"></div>

                            </div>
                        </div>
                    </div> -->

                </div>
            </div>
        </main>
        <hr>
        <hr>


        <!-- registrar -->
    <?php else : ?>
        <main class="mdl-layout__content">
            <div class="mdl-grid mdl-grid--no-spacing dashboard">
                <div class="mdl-grid mdl-cell mdl-cell--9-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone mdl-cell--top">

                    <div class="mdl-cell mdl-cell--4-col-desktop mdl-cell--4-col-tablet mdl-cell--2-col-phone">

                    </div>

                    <!-- <div class="mdl-cell mdl-cell--4-col-desktop mdl-cell--4-col-tablet mdl-cell--2-col-phone">

                    </div> -->

                    <div class="mdl-cell mdl-cell--4-col-desktop mdl-cell--4-col-tablet mdl-cell--2-col-phone">
                        <a href="invoice.php" class="btn btn-success btn-md" style="float: right;">Generate</a>
                    </div>

                    <!-- flex box -->
                    <div class="col-xl-6 col-md-6 mb-6">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Registered User</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php
                                            $query = "SELECT type FROM users WHERE type = 1";
                                            $query_run = mysqli_query($conn, $query);
                                            $row = mysqli_num_rows($query_run);
                                            echo '<small> Admin: ' . $row . '</small>';
                                            ?>
                                            <hr class="bg-dark">
                                            <?php
                                            $query = "SELECT type FROM users WHERE type = 2";
                                            $query_run = mysqli_query($conn, $query);
                                            $row = mysqli_num_rows($query_run);
                                            echo '<small> Registrar: ' . $row . '</small>';
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="far fa-user fa-2x text-gray-1000"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-6 mb-6">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Queue</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php
                                            $que = "SELECT * FROM queue_list WHERE status = 0";
                                            $q = mysqli_query($conn, $que);
                                            $row = mysqli_num_rows($q);
                                            echo '<small> Waiting: ' . $row . '</small>';
                                            ?>
                                            <hr class="bg-dark">
                                            <?php
                                            $que = "SELECT * FROM queue_list WHERE status = 1";
                                            $q = mysqli_query($conn, $que);
                                            $row = mysqli_num_rows($q);
                                            echo '<small> Assisted: ' . $row . '</small>';
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="far fa-user fa-2x text-gray-1000"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
</div>

<?php endif; ?>

<!-- script for USER pie -->

<?php
$query = "SELECT type, count(*) as number FROM users GROUP BY type";
$result = mysqli_query($conn, $query);
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['admin', 'staff'],
            <?php
            while ($row = mysqli_fetch_array($result)) {
                echo "['" . $row["type"] . "', " . $row["number"] . "],";
            }
            ?>
        ]);
        var options = {
            width: 500,
            height: 500,
            pieHole: 0.4,
            backgroundColor: {
                fill: 'transparent'
            },
            legend: {
                position: 'bottom'
            }
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
        chart.draw(data, options);
    }
</script>

<!-- USER DETAILS -->

<?php
$sql = "SELECT name, status FROM users";
if ($result = mysqli_query($conn, $sql)) {
    while ($row = $result->fetch_assoc()) {
        echo $chart .= "['" . $row['name'] . "'," . $row['status'] . "],";
    }
}
?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {
        packages: ["corechart"]
    });
    google.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['name', 'status'],
            <?php echo $chart ?>
        ]);
        var options = {
            title: '1 = Active 2 = Inactive>',
            hAxis: {
                minValue: 0,
                maxValue: 7
            },
            pointSize: 30,
            series: {
                0: {
                    pointShape: 'circle'
                },
                1: {
                    pointShape: 'triangle'
                },
                2: {
                    pointShape: 'square'
                },
                3: {
                    pointShape: 'diamond'
                },
                4: {
                    pointShape: 'star'
                },
                5: {
                    pointShape: 'polygon'
                }
            },
            legend: {
                position: 'bottom'
            },
            backgroundColor: {
                fill: '#6c757d'
            },
        };
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>
</body>

</html>

<?php
include 'include-admin/script.php';
?>