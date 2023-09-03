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

<body>

  <?php
  //include auth_session.php file on all user panel pages
  include("auth_session.php");  //need to uncomment 
  require('db.php');
  // SQL query to select data from database
  $sql = "SELECT * FROM doctors ORDER BY id";
  $result = mysqli_query($con, $sql) or die($mysqli->error());
  if (isset($_REQUEST['app_no'])) {
    $app_no = stripslashes($_REQUEST['app_no']);
    $p_name = stripslashes($_REQUEST['p_name']);
    $d_id = stripslashes($_REQUEST['d_id']);
    $d_name = stripslashes($_REQUEST['hidden_doctor_name']);
    $avl_date = stripslashes($_REQUEST['avl_date']);
    $avl_time = stripslashes($_REQUEST['avl_time']);
    $reason = stripslashes($_REQUEST['reason']);
    $create_datetime = date("Y-m-d H:i:s");
    $query    = "INSERT into `appointments` (app_no, p_name, d_id, d_name, avl_date, avl_time, reason, create_datetime)
               VALUES ('$app_no', '$p_name', '$d_id', '$d_name', '$avl_date', '$avl_time', '$reason', '$create_datetime')";
    $result   = mysqli_query($con, $query);
    header("Location: doctor_channeling.php");
  } else {
  ?>


    <nav class="navbar navbar-expand-sm bg-primary navbar-dark fixed-top">
      <div class="container-fluid">
        <a href="dashboard_patient.php">
          <h5 class="navbar-text text-dark">Hospital Management System</h5>
        </a>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="doctor_availability.php">Check Doctor Availability</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="doctor_channeling.php">Book Doctor Appointment</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="appointment_history.php">Appointment History</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="prescription_management_patient.php">View Prescription</a>
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
      <h2>Doctor Channeling</h2>

      <form action="">
        <div class="row">
          <div class="col-4">
            <input type="text" readonly class="form-control" id="app_no" name="app_no" placeholder="Appointment No.">
          </div>
          <div class="col-4">
            <input type="text" readonly class="form-control" name="p_name" value="<?php echo $_SESSION['username']; ?>">
          </div>
          <div class="col-4">
            <input type="hidden" id="hidden_doctor_name" name="hidden_doctor_name">
            <select class="form-select" id="d_id" name="d_id" onchange="loadDoctorDetail()">
              <option value="">---- Select Doctor ----</option>
              <?php
              $query2 = "SELECT id, name, specialization FROM doctors";
              $result2 = $con->query($query2);
              if ($result2->num_rows > 0) {
                while ($optionData = $result2->fetch_assoc()) {
                  $name = $optionData['name'];
                  $specialization = $optionData['specialization'];
                  $id = $optionData['id'];
              ?>
                  <option value="<?php echo $id; ?>"><?php echo $name; ?> - <?php echo $specialization; ?> </option>
              <?php
                }
              }
              ?>
            </select>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-4">
            <input type="date" class="form-control" placeholder="Enter Available Date" id="avl_date" name="avl_date">
            <input type="hidden" id="hidden_week_id" name="hidden_week_id">
          </div>
          <div class="col-4">
            <input type="text" readonly class="form-control" placeholder="Available Time" id="avl_time" name="avl_time">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-12">
            <textarea type="text" class="form-control" placeholder="Enter Reason" id="reason" name="reason"> </textarea>
          </div>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>

      <nav class="navbar navbar-expand-sm bg-primary navbar-dark fixed-bottom">
        ...
      </nav>

    <?php
  }
    ?>
    <script>
      now = new Date();
      randomNum = '';
      var min = 10000;
      var max = 99999;
      var randomNum = Math.floor(Math.random() * (max - min + 1)) + min;
      window.onload = function() {
        document.getElementById("app_no").value = randomNum;
      }

      function loadDoctorDetail() {

        var d_id = $("#d_id").val();
        var d_name = $("#d_id option:selected").text();
        $('#hidden_doctor_name').val(d_name);

        $.ajax({
          method: 'GET',
          url: 'script.php',
          data: {
            'd_id': d_id,
            'ajax': true
          },
          success: function(data) {
            if (data == 'Sunday') {
              $('#hidden_week_id').val(0);
            } else if (data == 'Monday') {
              $('#hidden_week_id').val(1);
            } else if (data == 'Tuesday') {
              $('#hidden_week_id').val(2);
            } else if (data == 'Wednesday') {
              $('#hidden_week_id').val(3);
            } else if (data == 'Thursday') {
              $('#hidden_week_id').val(4);
            } else if (data == 'Friday') {
              $('#hidden_week_id').val(5);
            } else if (data == 'Saturday') {
              $('#hidden_week_id').val(6);
            }
          }
        });

        $.ajax({
          method: 'get',
          url: 'script2.php',
          data: {
            'd_id': d_id,
            'ajax': true
          },
          success: function(data) {
            $('#avl_time').val(data);
          }
        });
      }

      const validate = dateString => {
        var hidden_week_id = $("#hidden_week_id").val();
        const day = (new Date(dateString)).getDay();
        if (day != hidden_week_id) {
          return false;
        }
        return true;
      }

      // Sets the value to '' in case of an invalid date
      document.getElementById('avl_date').onchange = evt => {
        if (!validate(evt.target.value)) {
          alert("Doctor not Available")
          evt.target.value = '';
        }
      }
    </script>

</body>

</html>