<?php
require 'db_connect.php'; //database connection

$sql = "SELECT transactions.name, COUNT(*) AS matched_records FROM queue_list
RIGHT JOIN transactions ON transactions.id = queue_list.transaction_id
GROUP BY transactions.id
";

$result = mysqli_query($conn, $sql);

while ($row = $result->fetch_assoc()) {
    $category = $row['name'];
    $count = $row['matched_records'];
    echo $category . ': ' . $count . ' ' . '<br>';
}
