<?php
include 'db_connect.php';
include 'include-admin/header.php';
?>


<?php
if ($_SESSION['login_type'] == 2) :
?>

  <style>
    /* .table-responsive {
      max-height: 550px;
      overflow: scroll;
    }

    th,
    thead {
      position: sticky;
      top: 0;
    } */
  </style>

  <br>
  <center>
    <br>
    <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--12-col-phone">
      <!-- <div class="col-md-8"> -->
        <div class="card">
          <!-- <div class="col mr-4"> -->
          <div class="card-body py-1">
            <div class="card border-left-primary shadow h-100 py-4 text-center bg-success">
              Queue Registration
            </div>
            <!-- <div class="h5 mb-0 font-weight-bold text-gray-800"> -->
              <div class="table-responsive">
                <table id="example" class="table table-sm" style="width:100%" border="white">
                  <thead class="bg-success">
                    <tr>
                      <th>Name</th>
                      <th>Status</th>
                      <th>Queue #</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $date = 'Y-M-D';
                    include 'db_connect.php';
                    $query = $conn->query("SELECT * FROM queue_list");
                    while ($row = $query->fetch_assoc()) :
                      $window[$row['name']] = ucwords($row['queue_no'] . ' ' . $row['status']);
                    ?>
                      <tr>
                        <td>
                          <?php echo $row['name'] ?>
                        </td>
                        <td>
                          <?php
                          if ($row['status'] == 0) {
                            echo '<span class="badge badge-info rounded-pill d-inline">Waiting</span>';
                          } else {
                            echo '<span class="badge badge-success rounded-pill d-inline">Done</span>';
                          }
                          ?>
                        </td>
                        <td><?php echo $row['queue_no']; ?></td>
                        <td>
                          <button type="submit" class="btn btn-success">Mark as Pending</button>
                        </td>
                      <?php endwhile; ?>
                      </tr>
                  </tbody>
                </table>
              </div>
              <!-- </div> -->
            <!-- </div> -->
          </div>
        </div>
      <!-- </div> -->

  </center>

<?php
endif;
?>

<script>
  $(document).ready(function() {
    $('#example').DataTable();
  });
</script>

<script src="./dist/js/material.min.js"></script>
<script src="./dist/js/layout/layout.min.js"></script>
<script src="./dist/js/scroll/scroll.min.js"></script>

<script src="./dist/js/nv.d3.min.js"></script>
<script src="./dist/js/d3.min.js"></script>
<script src="./dist/js/getmdl-select.min.js"></script>