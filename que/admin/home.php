<?php
include 'db_connect.php';
include 'include-admin/header.php';
?>

<?php
if ($_SESSION['login_type'] == 2) :
?>

    <div class="containe-fluid">
        <hr>
        <script>
            var currentQueue = null; // Track the current queue number

            function queueNow() {
                $.ajax({
                    url: 'ajax.php?action=update_queue',
                    success: function(resp) {
                        resp = JSON.parse(resp);

                        if (resp.status === 1) {
                            // Display the queue details on the screen
                            $('#sname').html(resp.data.name);
                            $('#squeue').html(resp.data.queue_no);
                            $('#window').html(resp.data.wname);
                            $('#id').html(resp.data.id);

                            // Store the current queue number
                            currentQueue = resp.data.queue_no;
                        } else {
                            // No queue numbers available, reset to the beginning
                            currentQueue = null;
                        }
                    }
                });
            }

            function queuePend() {
                $.ajax({
                    url: 'ajax.php?action=pending_queue',
                    success: function(resp) {
                        resp = JSON.parse(resp)
                        if (resp.status === 1) {
                            $('#sname').html(resp.data.name)
                            $('#squeue').html(resp.data.queue_no)
                            $('#window').html(resp.data.wname)
                            $('#id').html(resp.data.id)
                        } else {
                            // Handle no more pending queues
                            $('#sname').html('')
                            $('#squeue').html('')
                            $('#window').html('')
                            $('#id').html('')
                            alert(resp.message);
                        }
                    }
                })
            }
        </script>

        <center>
            <div class="row">
                <div class="col-md-4 text-center">
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h6 class="text-center"><b>Now Serving</b></h6>
                        </div>
                        <div class="card-body">
                            <h4 class="text-center" id="sname"></h4>
                            <hr class="divider">
                            <h3 class="text-center" id="squeue"></h3>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-md-4 text-center">
                <a href="javascript:void(0)" class="btn btn-success" onclick="queueNow('next')">Next Serve</a>
                <a href="javascript:void(0)" class="btn btn-warning" onclick="queuePend('pending')">Pending</a>
                <button type="button" id="notify" value="PLAY" onclick="play()" class="btn btn-success"><i class="fa fa-bullhorn"></i> Notify</button>
                <audio id="audio" src="assets/noti.wav"></audio>
            </div><br>
        <?php
    endif;
        ?>
    </div>
    </center>

    <script>
        function play() {
            var audio = document.getElementById("audio");
            audio.play();
        }
    </script>

    <?php
    include 'include-admin/script.php';
    ?>