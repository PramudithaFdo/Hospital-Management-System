<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Hospital Management System</title>
  <link rel="stylesheet" href="css/style.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>

<body style="background-image: url('img/doc_av.jpg'); background-repeat: no-repeat; background-size: cover;">

  <?php
  //include auth_session.php file on all user panel pages
  include("auth_session.php");  //need to uncomment 
  require('db.php');
  // SQL query to select data from database
  $sql = "SELECT * FROM doctors ORDER BY id";
  $result = mysqli_query($con, $sql) or die($mysqli->error());
  if (isset($_REQUEST['id'])) {
    $id = stripslashes($_REQUEST['id']);
    $name = stripslashes($_REQUEST['name']);
    $specialization = stripslashes($_REQUEST['specialization']);
    $avl_time_from = stripslashes($_REQUEST['avl_time_from']);
    $avl_time_to = stripslashes($_REQUEST['avl_time_to']);
    $avl_dates = stripslashes($_REQUEST['avl_dates']);
    $create_datetime = date("Y-m-d H:i:s");
    $query    = "INSERT into `doctors` (id, name, specialization, time_from, time_to, available_date, create_datetime)
                 VALUES ('$id', '$name', '$specialization', '$avl_time_from', '$avl_time_to', '$avl_dates', '$create_datetime')";
    $result   = mysqli_query($con, $query);
    header("Location: doctor_management.php");
  } else {
  ?>

    <nav class="navbar navbar-expand-sm bg-primary navbar-dark fixed-top">
      <div class="container-fluid">
        <a href="dashboard_admin.php">
          <h5 class="navbar-text text-dark">Hospital Management System</h5>
        </a>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="doctor_management.php">Doctor Management</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="user_management.php">User Management</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="appointment_history_admin.php">Appointment History</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="registration.php">Register Users</a>
            </li>
          </ul>
        </div>
      </div>
      <form class="d-flex">
        <p class="text-white">Hey, <?php echo $_SESSION['username']; ?> <a class="text-dark" href="logout.php">Logout</a></p>
        <img src="img/user.jpg" alt="Avatar Logo" style="width:60px;" class="rounded-pill">
      </form>
    </nav>

    <br>
    <br>
    <br>
    <div class="container mt-3">
      <h2>Doctor Detail Management</h2>

      <form action="" action="" method="post">
        <div class="row">
          <div class="col">
            <select class="form-select" id="id" name="id" onchange="loadDoctorName()" required>
              <option value="">---- Select Doctor Name ----</option>
              <?php
              $query2 = "SELECT u.id, u.name FROM users u 
              LEFT JOIN doctors d ON d.id = u.id
              WHERE d.id IS NULL AND user_type = '2'";
              $result2 = $con->query($query2);
              if ($result2->num_rows > 0) {
                while ($optionData = $result2->fetch_assoc()) {
                  $name = $optionData['name'];
                  $id = $optionData['id'];
              ?>
                  <option value="<?php echo $id; ?>"><?php echo $name; ?> </option>
              <?php
                }
              }
              ?>
            </select>
            <input hidden id="name" name="name">
          </div>
          <div class="col">
            <input type="text" class="form-control" placeholder="Enter Specialization" name="specialization">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col">
            <input type="time" class="form-control" placeholder="Enter Available Time From" name="avl_time_from">
          </div>
          <div class="col">
            <input type="time" class="form-control" placeholder="Enter Available Time To" name="avl_time_to">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-6">
            <select class="form-select" id="avl_dates" name="avl_dates">
              <option value="">---- Select Week ----</option>
              <option value="Monday">Monday</option>
              <option value="Tuesday">Tuesday</option>
              <option value="Wednesday">Wednesday</option>
              <option value="Thursday">Thursday</option>
              <option value="Friday">Friday</option>
              <option value="Saturday">Saturday</option>
              <option value="Sunday">Sunday</option>
            </select>
          </div>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>

      <br>
      <input class="form-control" id="myInput" type="text" placeholder="Search...">
      <br>
      <table class="table table-bordered table-striped" id="myTable">
        <thead>
          <tr>
            <th>Doctor Name</th>
            <th>Specialization</th>
            <th>Available Date</th>
            <th>Available Time (From)</th>
            <th>Available Time (To)</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php
          // LOOP TILL END OF DATA
          while ($rows = $result->fetch_assoc()) {
          ?>
            <tr>
              <!-- FETCHING DATA FROM EACH
                    ROW OF EVERY COLUMN -->
              <td><?php echo $rows['name']; ?></td>
              <td><?php echo $rows['specialization']; ?></td>
              <td><?php echo $rows['available_date']; ?></td>
              <td><?php echo $rows['time_from']; ?></td>
              <td><?php echo $rows['time_to']; ?></td>
              <td><button type="button" class="btn edit_btn btn-info" data-bs-toggle="modal" data-bs-target="#myModal"><i class="bi bi-pencil"></i></button>
                <button type="button" class="btn btn-danger" onclick="deleteRow(<?php echo $rows['id']; ?>)"><i class="bi bi-trash"></i></button>
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  <?php
  }
  ?>

  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Update Doctor Details</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <form action="">
          <div class="modal-body">
            <div class="mb-3 mt-3">
              <label for="name" class="form-label">Doctor Name</label>
              <input type="text" class="form-control" readonly id="m_name" placeholder="Enter Name" name="m_name">
            </div>
            <div class="mb-3">
              <label for="specialization" class="form-label">Specialization</label>
              <input type="text" class="form-control" id="m_specialization" placeholder="Enter Tel. No." name="m_specialization">
            </div>
            <div class="mb-3">
              <label for="time_from" class="form-label">Available Time From</label>
              <input type="time" class="form-control" id="m_avl_time_from" name="m_avl_time_from">
            </div>
            <div class="mb-3">
              <label for="time_to" class="form-label">Available Time To</label>
              <input type="time" class="form-control" id="m_avl_time_to" name="m_avl_time_to">
            </div>
            <div class="mb-3">
              <label for="m_avl_dates" class="form-label">Available Date</label>
              <select class="form-select" id="m_avl_dates" name="m_avl_dates">
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
              </select>
            </div>
            <button type="submit" class="btn edit_submit btn-primary">Submit</button>
          </div>
        </form>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>

  <nav class="navbar navbar-expand-sm bg-primary navbar-dark fixed-bottom">
    ...
  </nav>
  <script type="text/javascript">
    $(document).ready(function() {

      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });

      $('.edit_btn').on('click', function() {

        $('#myModal').modal('show');
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
          return $(this).text();
        }).get();

        $('#m_name').val(data[0]);
        $('#m_specialization').val(data[1]);
        $('#m_avl_time_from').val(data[3]);
        $('#m_avl_time_to').val(data[4]);
        $('#m_avl_dates').val(data[2]);
      });

      $('.edit_submit').on('click', function() {
        var m_name = $("#m_name").val();
        var m_specialization = $("#m_specialization").val();
        var m_avl_time_from = $("#m_avl_time_from").val();
        var m_avl_time_to = $("#m_avl_time_to").val();
        var m_avl_dates = $("#m_avl_dates").val();

        $.ajax({
          method: 'POST',
          url: 'modal_edit_script.php',
          data: {
            'm_name': m_name,
            'm_specialization': m_specialization,
            'm_avl_time_from': m_avl_time_from,
            'm_avl_time_to': m_avl_time_to,
            'm_avl_dates': m_avl_dates,
            'ajax': true
          },
          success: function(data) {

          }
        });

      });
    });

    function loadDoctorName() {

      var d_name = $("#id option:selected").text();
      $('#name').val(d_name);

    }

    function deleteRow(id) {
      $.ajax({
        method: 'POST',
        url: 'modal_delete_script.php',
        data: {
          'id': id,
          'ajax': true
        },
        success: function(data) {
          location.reload();
        }
      });
    };
  </script>

</body>

</html>