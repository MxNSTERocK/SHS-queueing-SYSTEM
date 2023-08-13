<?php
include 'admin/db_connect.php';
include 'admin/include-admin/header.php';
include 'header.php';

$qry = $conn->query("SELECT q.*,t.name as tname FROM queue_list q inner join transactions t on t.id = q.transaction_id  where q.id=" . $_GET['id'])->fetch_array();
foreach ($qry as $k => $v) {
	$$k = $v;
}
?>

<center>
	<br>
	<br>
	<br>

	<div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--12-col-phone">
		<div class="mdl-card mdl-shadow--2dp">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">QUEUE NO#</h2>
			</div>
			<div class="mdl-card__supporting-text mdl-card--expand">
				<h1 style="text-align:center"><?php echo ucwords($tname) ?></h1>
				<h1 style="text-align:center"><b><?php echo ucwords($name) ?></b></h1>
				<hr>
				<h1 style="text-align:center"><b><?php echo ucwords($queue_no) ?></b></h1>
			</div>

			<?php
			// if (isset($_POST['submit'])) {
			// 	if (!empty($_POST['fruit'])) {
			// 		foreach ($_POST['fruit'] as $checked) {
			// 			echo $checked . "</br>";
			// 		}
			// 	}
			// }
			?>

		</div>
	</div>

	<div class="container">
		<a href="index.php" id="print" class="btn btn-danger btn-lg"><i class="fa fa-caret-left"></i>&nbsp;&nbsp;&nbsp;Back</a>
		<button class="btn btn-success btn-lg" id="print" onclick="window.print()"><i class="fa fa-print"></i>&nbsp;&nbsp;&nbsp;PRINT</button>
	</div>

</center>

<style>
	body * {
		margin: unset;
	}

	@media print {
		#print {
			display: none;
		}
	}
</style>