<?php
include 'admin/db_connect.php';
include 'admin/include-admin/header.php';
?>

<style>
	body,
	html {
		height: 10%;
		margin: 0;
		background-color: #202020;
		background-image: url("dist/images/bg.jpg");
	}

	.bg {
		background-image: url("dist/images/bg.jpg");

		height: 100%;

		background-position: center;
		background-repeat: no-repeat;
		background-size: cover;
	}
</style>
	<div class="bg">
		<center>
			<div class="mdl-cell mdl-cell--6-col-desktop mdl-cell--6-col-tablet mdl-cell--6-col-phone">
				<div class="mdl-card mdl-shadow--2dp">
					<div class="mdl-card__title">
						<h2 class="mdl-card__title-text">Welcome to CCT-SHS Transaction Queuing Management System</h2>
						<a href="index.php?page=queue_registration" class="btn btn btn-danger btn-sm col-md-4 float-right">Queue Registration <i class="fa fa-angle-right">
							</i></a>
					</div>
					<div class="mdl-card__supporting-text mdl-card--expand">
						<?php
						$trans = $conn->query("SELECT * FROM transactions where status = 1 order by name asc");
						while ($row = $trans->fetch_assoc()) :
						?>
							<div class="col-md-12 mt-1">
								<a class="btn btn-danger btn-lg" href="index.php?page=display&id=<?php echo $row['id'] ?>" class="btn btn btn-primary btn-block "><?php echo ucwords($row['name']); ?> <i class="fa fa-angle-right"></i></a>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
			</div>
		</center>
	</div>

</html>

<?php
include 'admin/include-admin/script.php';
?>