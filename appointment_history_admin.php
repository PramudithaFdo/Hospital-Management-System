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

<body style="background-image: url('img/appoinment.jpg'); background-repeat: no-repeat; background-size: cover;">

  <?php
  //include auth_session.php file on all user panel pages
  include("auth_session.php");  //need to uncomment 
  require('db.php');
  // SQL query to select data from database
  $sql = "SELECT * FROM appointments ORDER BY id";
  $result = mysqli_query($con, $sql) or die($mysqli->error());
  ?>

  <nav class="navbar navbar-expand-sm bg-primary navbar-dark fixed-top">
    <div class="container-fluid">
      <a href="dashboard_doctor.php">
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
    <h2>Appointment History</h2>
    <br>
    <input class="form-control" id="myInput" type="text" placeholder="Search...">
    <br>
    <table class="table table-bordered table-striped" id="myTable">
      <thead>
        <tr>
          <th>Patient</th>
          <th>Appointment No.</th>
          <th>Doctor Name</th>
          <th>Appointment Date</th>
          <th>Appointment Time (From - To)</th>
          <th>Reason</th>
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
            <td><?php echo $rows['p_name']; ?></td>
            <td><?php echo $rows['app_no']; ?></td>
            <td><?php echo $rows['d_name']; ?></td>
            <td><?php echo $rows['avl_date']; ?></td>
            <td><?php echo $rows['avl_time']; ?></td>
            <td><?php echo $rows['reason']; ?></td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
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
    });
  </script>

</body>

</html>