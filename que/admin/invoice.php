<?php
session_start();
require 'db_connect.php'; //database connectiong

$sql = "SELECT * FROM transaction_windows RIGHT JOIN users 
ON transaction_windows.transaction_id = users.name";  //query

require 'fpdf.php'; //call pdf

$pdf = new FPDF();

$pdf->AddPage();

$width_cell = array(20, 50, 40, 40, 40);
$pdf->SetFont('helvetica', 'B', 20, 20);

$pdf->SetFillColor(193, 229, 252);

$imagePath = '../dist/images/cct-logos.png';
$imageWidth = 50; // Adjust the width of the image
$imageHeight = 0; // Set 0 to automatically calculate the height

// Get the dimensions of the image
list($originalWidth, $originalHeight) = getimagesize($imagePath);

// Calculate the height proportional to the specified width
if ($imageHeight == 0) {
    $imageHeight = ($imageWidth / $originalWidth) * $originalHeight;
}

// Calculate the center position horizontally
$centerX = ($pdf->GetPageWidth() - $imageWidth) / 2;

// Place the image at the center horizontally
$pdf->Image($imagePath, $centerX, 0, $imageWidth, $imageHeight);

$pdf->Ln(37); //space
$pdf->Cell(193, 1, 'Report', 100, 50, 'C');
$pdf->Ln(5);
$pdf->SetLineWidth(0.5);
$pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 190, $pdf->GetY());
$pdf->Ln(5);
$pdf->SetFont('Arial', 'U', 16);
// $pdf->Cell(193, 5, 'USER', 100, 50, 'C');
$pdf->SetFont('Arial', '', 12); // Reset font style

$pdf->Ln(10);

$width_cell = array(80, 80, 60, 50); // Adjusted cell widths
$pdf->SetFillColor(10, 255, 0);
// First header column
// $pdf->Cell($width_cell[0], 10, 'ID', 1, 0, 'C', true);
$pdf->Cell($width_cell[1], 10, 'Name', 1, 0, 'C', true);
$pdf->Cell($width_cell[2], 10, 'Status', 1, 0, 'C', true);
$pdf->Cell($width_cell[3], 10, 'Role', 1, 1, 'C', true); // Changed the last argument to 1

$pdf->SetFont('Arial', '', 14);
$pdf->SetFillColor(235, 236, 236);

$fill = false;
foreach ($conn->query($sql) as $row) {
    $status = ($row['status'] == 1) ? 'Active' : 'Inactive';
    $role = ($row['type'] == 1) ? 'Admin' : 'Staff';

    // $pdf->Cell($width_cell[0], 10, $row['id'], 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[1], 10, $row['name'], 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[2], 10, $status, 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[3], 10, $role, 1, 1, 'C', $fill); // Changed the last argument to 1

    $fill = !$fill;
}

////////////////////////////////////////////////////////////////////////////////////////////////

// $pdf->Ln(1); //space

$pdf->SetFont('Arial', 'U', 16); // Set font style to underlined
// $pdf->Cell(200, 5, 'QUERY', 100, 50, 'C');
$pdf->Ln(10); //space
$pdf->SetFillColor(10, 255, 0);
// $pdf->Cell(100, 10, 'Waiting', 1, 0, 'L');
// $pdf->Cell(90, 10, 'Done', 1, 1, 'R');

// $query = "SELECT status FROM queue_list WHERE status = 0";
// $query_run = mysqli_query($conn, $query);
// $row = mysqli_num_rows($query_run);

// $pdf->Cell(100, 10, $row, 1, 0, 'L');

// $query = "SELECT status FROM queue_list WHERE status = 1";
// $query_run = mysqli_query($conn, $query);
// $row = mysqli_num_rows($query_run);

// $pdf->Cell(90, 10, $row, 1, 1, 'R');

// $query = "SELECT * FROM queue_list";
// $query_run = mysqli_query($conn, $query);
// $row = mysqli_num_rows($query_run);

// $pdf->Cell(100, 10, 'TOTAL', 1, 0, 'L');

// if ($row > 0) {
//     $pdf->Cell(0, 10, $row, 1, 1, 'R');
// } else {
//     $pdf->Cell(0, 10, 'No Record Found', 1, 1, 'R');
// }
////////////////////////////////////////////////////////////////////////////////////////////////

// $query = "SELECT status FROM queue_list WHERE status = 0";
// $query_run = mysqli_query($conn, $query);
// $row = mysqli_num_rows($query_run);

// $pdf->Cell(100, 10, $row, 1, 0, 'L');

// $query = "SELECT status FROM queue_list WHERE status = 1";
// $query_run = mysqli_query($conn, $query);
// $row = mysqli_num_rows($query_run);

// $pdf->Cell(90, 10, $row, 1, 1, 'R');

// $query = "SELECT * FROM queue_list";
// $query_run = mysqli_query($conn, $query);
// $row = mysqli_num_rows($query_run);

// $pdf->Cell(100, 10, 'TOTAL', 1, 0, 'L');
// $pdf->Cell(0, 10, $row, 1, 1, 'R');

$pdf->Ln(10);
$pdf->SetFont('Arial', 'U', 16); // Set font style to underlined
$pdf->Cell(200, 5, 'TRANSACTION', 100, 50, 'C');
$pdf->SetFont('Arial', '', 16); // Reset font style to underlined


// Assuming you have already established a database connection

// Prepare the SQL query
$sql = "SELECT transactions.name, COUNT(queue_list.transaction_id) AS count
        FROM transactions
        LEFT JOIN queue_list ON transactions.id = queue_list.transaction_id
        GROUP BY transactions.name";

$result = mysqli_query($conn, $sql);

// Output the results
foreach ($result as $row) {
    $name = $row['name'];
    $count = $row['count'];

    $pdf->Ln(10);
    $pdf->Cell(0, 10, $name, '', 1, 1, 'L');
    
    if ($count > 0) {
        $pdf->Cell(0, 10, $count, 1, 1, 'R');
    } else {
        $pdf->Cell(0, 10, 'No Record Found', 1, 1, 'R');
    }
}


// $sql = "SELECT transactions.name, COUNT(*) AS matched_records FROM queue_list
//     RIGHT JOIN transactions ON transactions.id = queue_list.transaction_id
//     GROUP BY transactions.id";

// $result = mysqli_query($conn, $sql);

// while ($row = $result->fetch_assoc()) {
//     $category = $row['name'];
//     $count = $row['matched_records'];

//     $pdf->Ln(10);
//     $pdf->Cell(0, 10, $category, $count, 1, 1, 'L');
//     $pdf->Cell(0, 10, $count, 1, 1, 'R');
// }

$pdf->Ln(70); // Decreased spacing
$pdf->AddPage();

// //////////////////////////////////////////////////////////////////

$pdf->SetFont('Arial', 'U', 16); // Set font style to underlined
$pdf->Cell(200, 0, 'LIST OF QUEUE LIST', 100, 50, 'C');
$pdf->SetFont('Arial', '', 16); // Reset font style to underlined


////////////////////////////////////////////////////////////////

$sql = "SELECT q.id, q.transaction_id, q.name AS queue_name, t.name AS transaction_name, q.status
        FROM queue_list q
        LEFT JOIN transactions t ON q.transaction_id = t.id WHERE DATE(date_created) = DATE(NOW())";

$width_cell = array(80, 80, 60, 50); // Adjusted cell widths
$pdf->SetFont('helvetica', '', 14);

// $pdf->SetFillColor(193, 229, 252);

$pdf->Ln(10); // Decreased spacing

// First header column //
// $pdf->Cell($width_cell[0], 10, 'ID', 1, 0, 'C', true);
$pdf->Cell($width_cell[1], 10, 'Name', 1, 0, 'C', true);
$pdf->Cell($width_cell[2], 10, 'Transaction', 1, 0, 'C', true);
$pdf->Cell($width_cell[3], 10, 'Status', 1, 0, 'C', true);
$pdf->Ln(); 

$pdf->SetFont('Arial', '', 14);
$pdf->SetFillColor(235, 236, 236);

$fill = false;

// Execute the query
$query_result = $conn->query($sql);

if ($query_result->num_rows > 0) {
    // Records found
    foreach ($query_result as $row) {
        $status = ($row['status'] == 1) ? 'DONE' : 'WAITING';

        // $pdf->Cell($width_cell[0], 10, $row['id'], 1, 0, 'C', $fill);
        $pdf->Cell($width_cell[1], 10, $row['queue_name'], 1, 0, 'C', $fill);
        $pdf->Cell($width_cell[2], 10, $status, 1, 0, 'C', $fill);
        $pdf->Cell($width_cell[3], 10, $row['transaction_name'], 1, 0, 'C', $fill);
        // Other cells in the queue_list table

        $pdf->Ln(); // Move to the next line
        $fill = !$fill;
    }
} else {
    // No records found
    $pdf->Cell(array_sum($width_cell), 10, '' , 0, 1, '', $fill);
}

////////////////////////////////////////////////////////////////


// $sql = "SELECT q.id, q.transaction_id, q.name AS queue_name, t.name AS transaction_name, q.status
//         FROM queue_list q
//         LEFT JOIN transactions t ON q.transaction_id = t.id WHERE DATE(date_created) = DATE(NOW())";

// $width_cell = array(80, 80, 60, 50); // Adjusted cell widths
// $pdf->SetFont('helvetica', '', 14);

// // $pdf->SetFillColor(193, 229, 252);

// $pdf->Ln(10); // Decreased spacing

// // First header column //
// // $pdf->Cell($width_cell[0], 10, 'ID', 1, 0, 'C', true);
// $pdf->Cell($width_cell[1], 10, 'Name', 1, 0, 'C', true);
// $pdf->Cell($width_cell[2], 10, 'Transaction', 1, 0, 'C', true);
// $pdf->Cell($width_cell[3], 10, 'Status', 1, 0, 'C', true);
// $pdf->Ln(); 

// $pdf->SetFont('Arial', '', 14);
// $pdf->SetFillColor(235, 236, 236);

// $fill = false;

// foreach ($conn->query($sql) as $row) {
//     $status = ($row['status'] == 1) ? 'DONE' : 'WAITING';

//     // $pdf->Cell($width_cell[0], 10, $row['id'], 1, 0, 'C', $fill);
//     $pdf->Cell($width_cell[1], 10, $row['queue_name'], 1, 0, 'C', $fill);
//     $pdf->Cell($width_cell[2], 10, $status, 1, 0, 'C', $fill);
//     $pdf->Cell($width_cell[3], 10, $row['transaction_name'], 1, 0, 'C', $fill);
//     // Other cells in the queue_list table

//     $pdf->Ln(); // Move to the next line
//     $fill = !$fill;
    
// }

// Add the "Nothing to follow" line
// $pdf->Ln(10);
$pdf->SetFillColor(255, 0, 0); // Set the fill color to red (RGB values: 255, 0, 0)
$pdf->SetDrawColor(255, 0, 0); // Set the draw color to red (RGB values: 255, 0, 0)
$pdf->SetTextColor(255, 255, 255); // Set the text color to white (RGB values: 255, 255, 255)
$width_cell = array(0, 0, 0, 0); // Adjusted cell widths
$pdf->Cell(array_sum($width_cell), 10, 'No Further Content', 1, 0, 'C', true);
$pdf->SetFillColor(0, 0, 0); // Set the fill color to black
$pdf->SetDrawColor(0, 0, 0); // Set the draw color to black
$pdf->SetTextColor(0, 0, 0); // Set the text color back to black (RGB values: 0, 0, 0)


// //////////////////////////////////////////////////////////////////


$pdf->Ln(20);
// $currentDate = date('Y-m-d H:i:s', time());
date_default_timezone_set('Asia/Manila');
$currentDateTime = date('Y-m-d h:i:s A');
$pdf->Cell(0, 10, 'Current Date: ' . $currentDateTime, 0, 1, 'R');

$pdf->Ln(30);
$pdf->Cell(50, 5, $_SESSION['login_name'], 0, 1, 'C');
$pdf->SetLineWidth(0.5);
$pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 50, $pdf->GetY());
$pdf->Cell(50, 5, 'Signature', 0, 0, 'C');

$pdf->SetFont('Arial', 'B', 50); // Set font style and size
$pdf->SetTextColor(255, 0, 0); // Set text color to red
$pdf->Output();

?>

<style>
    @page {
        size: 595px 842px;
        margin: 0 !important;
        padding: 0 !important
    }
</style>