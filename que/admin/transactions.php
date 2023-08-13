<?php
include('db_connect.php');
include 'include-admin/header.php';
?>

<link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<hr>

<center>
	<div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--12-col-phone">
		<div class="col-md-8">
			<div class="card">
				<!-- FORM Panel -->
				<div class="card-body">
					<form action="" id="manage-transaction">
						<div class="card">
							<div class="card-header bg-dark" style="color: white;">
								Transactions Form
							</div>
							<div class="card-body">
								<div id="msg"></div>
								<input type="hidden" name="id">
								<div class="form-group">
									<label class="control-label">Name</label>
									<textarea name="name" id="" cols="10" rows="1" class="form-control"></textarea>
								</div>
							</div>

							<div class="card-footer">
								<div class="row">
									<div class="col-md-12">
										<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"><i class="fa fa-save"></i></button>
										<button class="btn btn-sm btn-danger col-sm-3" type="button" onclick="_reset()"> Clear</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
</center>

<!-- Table Panel -->
<center>
	<div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--12-col-phone">
		<div class="col-md-8">
			<div class="card">
				<div class="card-body">
					<table id="example" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th class="text-center">Transaction Type</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 1;
							$types = $conn->query("SELECT * FROM transactions where status = 1 order by id asc");
							while ($row = $types->fetch_assoc()) :
							?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>

									<td class="">
										<p> <b><?php echo $row['name'] ?></b></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_transaction" type="button" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>"><i class="fa fa-edit"></i></button>
										<button class="btn btn-sm btn-danger delete_transaction" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-archive"></i></button>
									</td>
								</tr>
							<?php endwhile; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- Table Panel -->
	</div>

	</div>
	</div>
</center>
<style>
	td {
		vertical-align: middle !important;
	}

	td p {
		margin: unset
	}

	img {
		max-width: 100px;
		max-height: 150px;
	}
</style>
<script>
	function _reset() {
		$('[name="id"]').val('');
		$('#msg').html('')
		$('#manage-transaction').get(0).reset();
	}

	$('#manage-transaction').submit(function(e) {
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url: 'ajax.php?action=save_transaction',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully added", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				} else if (resp == 2) {
					$('#msg').html("<div class='alert alert-danger'>Name already exist.</div>")
					end_load()

				}
			}
		})
	})
	$('.edit_transaction').click(function() {
		start_load()
		var cat = $('#manage-transaction')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='name']").val($(this).attr('data-name'))
		end_load()
	})
	$('.delete_transaction').click(function() {
		_conf("Are you sure to delete this transaction type?", "delete_transaction", [$(this).attr('data-id')])
	})

	function displayImg(input, _this) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#cimg').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}

	function delete_transaction($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_transaction',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully deleted", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}
</script>

<script>
	$(document).ready(function() {
		$('#example').DataTable();
	});
</script>

<!-- navbar -->
<script src="./dist/js/material.min.js"></script>
<!-- layout || scrollbar -->
<script src="./dist/js/layout/layout.min.js"></script>
<script src="./dist/js/scroll/scroll.min.js"></script>

<script src="./dist/js/nv.d3.min.js"></script>
<script src="./dist/js/d3.min.js"></script>
<script src="./dist/js/getmdl-select.min.js"></script>

<?php
// include 'include-admin/script.php';
?>