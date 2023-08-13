<?php
include 'include-admin/header.php';
?>

<style>
	tr {
		text-align: center;
	}

	.wrapper {
		display: flex;
		align-items: center;
		justify-content: space-between;
	}

	.wrapper>div:first-child {
		margin-left: 10px;
	}

	.label {
		flex-grow: 1;
		text-align: center;
		text-decoration: none;
		/* Add this line */
		font-size: 20px;
	}
</style>

<?php
if ($_SESSION['login_type'] == 1) :
?>

    <center>
        <br>
        <br>

        <div class="mdl-cell mdl-cell--8-col-desktop mdl-cell--8-col-tablet mdl-cell--8-col-phone">
            <div class="container">
                <div class="col-xl-12 col-md-12 mb-12">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="card border-left-primary shadow h-100 py-1 text-center text-white" style="background-color: transparent">
                                <div class="wrapper">
                                    <div><a href="index.php?page=archive" class="btn btn-warning"><i class="fa fa-archive fa-2x" title="archive"></i></a></div>
                                    <div class="label"><span>Active User</span></div>
                                    <div><a class="btn btn-primary" id="new_user"><i class="fa fa-user fa-2x" style="color: skyblue;" title="add user"></i></a></div>
                                </div>
                            </div>
                            <br>

                            <div class="card col-md-12">
                                <div class="card-body">
                                    <div class="table-responsive" style="min-width: 100%;">
                                        <div style="overflow-x: auto;">
                                            <table id="example" class="table align-middle mb-0 bg-white">
                                                <thead class="bg-light">
                                                    <tr style="background-color: skyblue">
                                                        <th>NAME</th>
                                                        <th>WINDOW</th>
                                                        <th>ACTION</th>
                                                        <!-- Add additional columns here -->
                                                    </tr>
                                                </thead>
                                                <tbody>
												<?php
													include 'db_connect.php';
													$query = $conn->query("SELECT w.*,t.name as tname FROM transaction_windows w inner join transactions t on t.id = w.transaction_id  order by id asc");
													while ($row = $query->fetch_assoc()) :
														$window[$row['id']] = ucwords($row['tname'] . ' ' . $row['name']);
													endwhile;
													$users = $conn->query("SELECT * FROM users u WHERE status = 1");
													$i = 1;
													while ($row = $users->fetch_assoc()) :
													?>
														<tr>
															<td><?php echo ucwords($row['name']) ?></td>
															<td><?php echo isset($window[$row['window_id']]) ? $window[$row['window_id']] : "ADMINISTRATOR" ?></td>
															<td>
																<?php
																if ($row['status'] == 1) {
																	echo '<p><a href="inactive.php?id=' . $row['id'] . '"><i class="fa fa-archive fa-lg" aria-hidden="true"style="color:#0275d8" onclick="myFunction()" title="active""></i></a></p>';
																} else {
																	echo '<p><a href="active.php?id=' . $row['id'] . '&status=1"><i class="fa fa-archive fa-lg" aria-hidden="true"style="color:#d9534f" function myFunction() {
												  alert(location.hostname);
												} title="inactive"></i></a></p>';
																}
																?>
																<center>
																	<div class="btn-group">
																		<a class="edit_user" href="javascript:void(0)" data-id='<?php echo $row['id'] ?>'><i class="fa fa-edit fa-lg" title="Edit"></i></a>
																	</div>
																</center>
															</td>
														<?php endwhile; ?>
														</tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </center>

    <!-- Rest of the code remains the same -->

    <script>
        function myFunction() {
            alert('Are you sure you want to archive');
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                lengthMenu: [
                    [5, 10, 20, -1],
                    [5, 10, 20, 'All'],
                ],
            });
        });
    </script>

    <script>
        $('#new_user').click(function() {
            uni_modal('New User', 'manage_user.php')
        })
        $('.edit_user').click(function() {
            uni_modal('Edit User', 'manage_user.php?id=' + $(this).attr('data-id'))
        })
        $('.delete_user').click(function() {
            _conf("Are you sure to delete this user?", "delete_user", [$(this).attr('data-id')])
        })

        function delete_user($id) {
            start_load()
            $.ajax({
                url: 'ajax.php?action=delete_user',
                method: 'POST',
                data: {
                    id: $id
                },
                success: function(resp) {
                    if (resp == 1) {
                        alert_toast("Successfully deleted", 'success')
                        setTimeout(function() {
                            location.reload()
                        }, 1500)

                    }
                }
            })
        }
    </script>

    <script src="./dist/js/material.min.js"></script>
    <script src="./dist/js/layout/layout.min.js"></script>
    <script src="./dist/js/scroll/scroll.min.js"></script>

    <script src="./dist/js/nv.d3.min.js"></script>
    <script src="./dist/js/d3.min.js"></script>
    <script src="./dist/js/getmdl-select.min.js"></script>

<?php
endif;
?>
