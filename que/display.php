<style>
	body {
		background-color: #343a40;
		margin: 0px;
		padding: 1px;
	}

	h2 {
		font-size: 40px;
	}

	h1 {
		font-size: 100px;
	}

	blink {
		animation: 2s linear infinite condemned_blink_effect;
	}

	.card-container {
		background-color: #0F6;
		width: 100%;
		height: auto;
		margin: auto 0;
		display: flex;
		justify-content: center;
		padding: 1px;
	}

	.card-container ul {
		text-align: center;
		margin: auto 0;
	}

	.card:hover {
		box-shadow: 0 5px 5px 0 rgba(0, 0, 33, 1);
	}

	@keyframes condemned_blink_effect {
		0% {
			visibility: hidden;
		}

		50% {
			visibility: hidden;
		}

		100% {
			visibility: visible;
		}
	}

	.card-body {
		padding: 5px;
	}

	.card-header {
		padding: 5px;
	}

	.myNotif{
		padding: 0px;
	}

	.card-queue{
		padding: -10px;
	}

	.card-theme{
		padding: 3px;
		margin: 0px;
	}
</style>

<!-- <meta http-equiv="refresh" content="15"> -->

<?php include "admin/db_connect.php" ?>
<?php
$tname = $conn->query("SELECT * FROM transactions where id =" . $_GET['id'])->fetch_array()['name'];
function nserving()
{
	include "admin/db_connect.php";

	$query = $conn->query("SELECT q.*,t.name as wname FROM queue_list q inner join transaction_windows t on t.id = q.window_id where date(q.date_created) = '" . date('Y-m-d') . "' and q.transaction_id = '" . $_GET['id'] . "' and q.status = 1 order by q.id desc limit 1  ");
	if ($query->num_rows > 0) {
		foreach ($query->fetch_array() as $key => $value) {
			if (!is_numeric($key))
				$data[$key] = $value;
		}
		return json_encode(array('status' => 1, "data" => $data));
	} else {
		return json_encode(array('status' => 0));
	}
	$conn->close();
}
?>
<?php
// $query = "SELECT * FROM notif WHERE notif_created >= DATE_SUB(NOW(), INTERVAL 10 MINUTE)";
$query = "SELECT * FROM notif WHERE DATE(notif_created) = DATE(NOW())";
$query_run = mysqli_query($conn, $query);

if (mysqli_num_rows($query_run) > 0) {
	foreach ($query_run as $student) {

?>
		<!-- <a href="index.php" class="btn btn-sm btn-success"><i class="fa fa-home"></i> Home</a> -->

			<marquee>
				<div id="myNotif">
					<h5 style="color:wheat"><?= $student['name'] ?></h5>
				</div>
			</marquee>

<?php
	}
}
?>

<div class="left-side bg-dark">
	<div class="col-md-12 offset-md-12">
		<div class="card">
			<div class="card-body bg-dark">
				<div class="container-fluid">
					<div class="card">
						<div class="card-body bg-danger">
							<h6 class="text-center text-white"><b><?php echo strtoupper($tname) ?></b></h6>
						</div>
					</div>
					<br>
					<div class="card bg-dark">
						<div class="card-header bg-danger text-white">
							<h6 class="text-center"><b>Now Serving</b></h6>
						</div>
						<div class="card-body bg-danger">
							<h6 class="text-center text-white" id="sname"></h6>
							<!-- name -->
							<hr class="divider">
							<blink>
								<h6 class="text-center text-white" style="font-size: 10em;" id="squeue">--</h6>
							</blink>
							<!-- que number -->
							<h6 class="text-center text-white" id="window"></h6>
							<!-- window number -->
						</div>
					</div>
				</div>
			</div>

			<ul class="card-container bg-dark">
				<div class="card bg-danger">
					<div class="card-queue">
						<center>
							<Label style="color:white">Next Number</Label>
						</center>
					</div>

					<div class="card-theme btn btn-dark" id="myDiv">
						<?php
						$query = "SELECT queue_no FROM queue_list WHERE DATE(date_created) = DATE(NOW()) AND status = 0 AND transaction_id = '" . $_GET['id'] . "' LIMIT 1000";
						$result = mysqli_query($conn, $query);

						if ($result->num_rows > 0) {
							$lowest_queue_no = PHP_INT_MAX; // Initialize with a large value
							while ($array = mysqli_fetch_row($result)) {
								$queue_no = $array[0];
								if ($queue_no < $lowest_queue_no) {
									$lowest_queue_no = $queue_no;
								}
						?>
								<tr>
									<td>
										<div class="alert <?php echo $queue_no == $lowest_queue_no ? 'alert-warning' : 'alert-primary'; ?>" role="alert" style="display: inline-block">
									<th scope="row"><?php echo $queue_no; ?></th>
					</div>
					</td>
					</tr>
				<?php
							}
						} else {
				?>
				<tr>
					<td colspan="1" rowspan="1" headers="">No Data Found</td>
				</tr>
			<?php
						}
			?>
			<?php mysqli_free_result($result); ?>
				</div>
		</div>
		</ul>
	</div>


	<script>
		$("button").on("click", function() {
			$('#myDiv').load(' #myDiv')
			alert('Reloaded')
		});
	</script>

	<br>


</div>
</div>

</div>

</div>
</div>



<!-- <div class="right-side">
	<?php
	$uploads = $conn->query("SELECT * FROM file_uploads order by rand() ");
	$slides = array();
	while ($row = $uploads->fetch_assoc()) {
		$slides[] = $row['file_path'];
	}
	?>
	<div class="slideShow">

	</div>
</div> -->

<script>
	var slides = <?php echo json_encode($slides) ?>;
	var scount = slides.length;
	if (scount > 0) {
		$(document).ready(function() {
			render_slides(0)
		})
	}

	function render_slides(k) {
		if (k >= scount)
			k = 0;
		var src = slides[k]
		k++;
		var t = src.split('.');
		var file;
		t = t[1];
		if (t == 'mp4') {
			file = $("<video id='slide' src='admin/assets/uploads/" + src + "' onended='render_slides(" + k + ")' autoplay='true' muted='muted'></video>");
		} else {
			file = $("<img id='slide' src='admin/assets/uploads/" + src + "' onload='slideInterval(" + k + ")' />");
		}
		console.log(file)
		if ($('#slide').length > 0) {
			$('#slide').css({
				"opacity": 0
			});
			setTimeout(function() {
				$('.slideShow').html('');
				$('.slideShow').append(file)
				$('#slide').css({
					"opacity": 1
				});
				if (t == 'mp4')
					$('video').trigger('play');


			}, 500)
		} else {
			$('.slideShow').append(file)
			$('#slide').css({
				"opacity": 1
			});

		}

	}

	function slideInterval(i = 0) {
		setTimeout(function() {
			render_slides(i)
		}, 2500)

	}

	$(document).ready(function() {
		var queue = '';
		var renderServe = setInterval(function() {
			$.ajax({
				url: 'admin/ajax.php?action=get_queue',
				method: "POST",
				data: {
					id: '<?php echo $_GET['id'] ?>'
				},
				success: function(resp) {
					resp = JSON.parse(resp)
					$('#sname').html(resp.data.name)
					$('#squeue').html(resp.data.queue_no)
					$('#window').html(resp.data.wname)
				}
			})

		}, 1500)
	})
</script>

<!-- notif -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<script>
	$(document).on('submit', '#saveStudent', function(e) {
		e.preventDefault();

		var formData = new FormData(this);
		formData.append("save_student", true);

		$.ajax({
			type: "POST",
			url: "../code.php",
			data: formData,
			processData: false,
			contentType: false,
			success: function(response) {

				var res = jQuery.parseJSON(response);
				if (res.status == 422) {
					$('#errorMessage').removeClass('d-none');
					$('#errorMessage').text(res.message);

				} else if (res.status == 200) {

					$('#errorMessage').addClass('d-none');
					$('#studentAddModal').modal('hide');
					$('#saveStudent')[0].reset();

					alertify.set('notifier', 'position', 'top-right');
					alertify.success(res.message);

					$('#myTable').load(location.href + " #myTable");

				} else if (res.status == 500) {
					alert(res.message);
				}
			}
		});

	});

	$(document).on('click', '.editStudentBtn', function() {

		var student_id = $(this).val();

		$.ajax({
			type: "GET",
			url: "../code.php?student_id=" + student_id,
			success: function(response) {

				var res = jQuery.parseJSON(response);
				if (res.status == 404) {

					alert(res.message);
				} else if (res.status == 200) {

					$('#student_id').val(res.data.id);
					$('#name').val(res.data.name);

					$('#studentEditModal').modal('show');
				}
			}
		});

	});

	$(document).on('submit', '#updateStudent', function(e) {
		e.preventDefault();

		var formData = new FormData(this);
		formData.append("update_student", true);

		$.ajax({
			type: "POST",
			url: "../code.php",
			data: formData,
			processData: false,
			contentType: false,
			success: function(response) {

				var res = jQuery.parseJSON(response);
				if (res.status == 422) {
					$('#errorMessageUpdate').removeClass('d-none');
					$('#errorMessageUpdate').text(res.message);

				} else if (res.status == 200) {

					$('#errorMessageUpdate').addClass('d-none');

					alertify.set('notifier', 'position', 'top-right');
					alertify.success(res.message);

					$('#studentEditModal').modal('hide');
					$('#updateStudent')[0].reset();

					$('#myTable').load(location.href + " #myTable");

				} else if (res.status == 500) {
					alert(res.message);
				}
			}
		});

	});

	$(document).on('click', '.viewStudentBtn', function() {

		var student_id = $(this).val();
		$.ajax({
			type: "GET",
			url: "../code.php?student_id=" + student_id,
			success: function(response) {

				var res = jQuery.parseJSON(response);
				if (res.status == 404) {

					alert(res.message);
				} else if (res.status == 200) {

					$('#view_name').text(res.data.name);
					$('#view_email').text(res.data.email);
					$('#view_phone').text(res.data.phone);
					$('#view_course').text(res.data.course);

					$('#studentViewModal').modal('show');
				}
			}
		});
	});

	$(document).on('click', '.deleteStudentBtn', function(e) {
		e.preventDefault();

		if (confirm('Are you sure you want to delete this data?')) {
			var student_id = $(this).val();
			$.ajax({
				type: "POST",
				url: "../code.php",
				data: {
					'delete_student': true,
					'student_id': student_id
				},
				success: function(response) {

					var res = jQuery.parseJSON(response);
					if (res.status == 500) {

						alert(res.message);
					} else {
						alertify.set('notifier', 'position', 'top-right');
						alertify.success(res.message);

						$('#myTable').load(location.href + " #myTable");
					}
				}
			});
		}
	});
</script>

<script>
	$(document).ready(function() {

		setInterval(function() {
			$("#myDiv").load(location.href + " #myDiv");
		}, 1000);

	});
</script>

<script>
	$(document).ready(function() {

		setInterval(function() {
			$("#myNotif").load(location.href + " #myNotif");
		}, 1000);

	});
</script>