<?php
include 'admin/db_connect.php';
?>

<!-- Pie -->
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
                    ['type', 'Number'],
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                        echo "['" . $row["type"] . "', " . $row["number"] . "],";
                    }
                    ?>
                ]);
                var options = {
                    title: 'Percentage of Annual and Student/Senior',
                    is3D: true,
                    pieHole: 0.4
                };
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
            }
        </script>



                <!-- Card Body -->
                <div class="container">

                </div>

                
    </div>