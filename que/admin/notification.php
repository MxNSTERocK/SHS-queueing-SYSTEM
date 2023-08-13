<?php
include  'include-admin/header.php';
?>

<?php
if ($_SESSION['login_type'] == 2) :
?>

    <!doctype html>
    <html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    </head>

    <body>
        <!-- Add Student -->
        <center>
        <div class="mdl-cell mdl-cell--8-col-desktop mdl-cell--8-col-tablet mdl-cell--8-col-phone">
        <div class="modal fade" id="studentAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Notification</h5>
                    </div>
                    <form id="saveStudent">
                        <div class="modal-body">

                            <div id="errorMessage" class="alert alert-warning d-none"></div>

                            <div class="mb-3">
                                <label for="">Notification</label>
                                <textarea type="text" name="name" class="form-control"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>

        <div class="mdl-cell mdl-cell--8-col-desktop mdl-cell--8-col-tablet mdl-cell--8-col-phone">
        <div class="container mt-1">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <button type="button" class="btn btn-success" style="float: right;" data-bs-toggle="modal" data-bs-target="#studentAddModal">
                                <!-- <i class="material-icons" role="presentation">notifications</i> -->
                                New Notification
                            </button>
                        </div>

                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <table id="myTable" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Notification</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    require 'db_connect.php';

                                                    $date = date('Y-m-d');

                                                    $query = "SELECT * FROM notif WHERE DATE(notif_created) = '$date'";
                                                    $query_run = mysqli_query($conn, $query);

                                                    if (mysqli_num_rows($query_run) > 0) {
                                                        foreach ($query_run as $row) {
                                                    ?>
                                                            <tr>
                                                                <td><?= $row['name'] ?></td>
                                                                <td>
                                                                    <button type="button" value="<?= $row['id']; ?>" class="deleteStudentBtn btn btn-danger btn-sm"><i class="fa fa-archive"></i></button>
                                                                </td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>

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
        </div>
        </div>
        </center>


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
                    url: "code.php",
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


            $(document).on('click', '.deleteStudentBtn', function(e) {
                e.preventDefault();

                if (confirm('Are you sure you want to delete this data?')) {
                    var student_id = $(this).val();
                    $.ajax({
                        type: "POST",
                        url: "code.php",
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

    </body>

    </html>

<?php
endif
?>

<?php
include  'include-admin/script.php';
?>