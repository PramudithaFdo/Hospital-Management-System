<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Hospital Management System</title>
  <link rel="stylesheet" href="css/style.css" />
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>

<body style="background-image: url('img/prescription.jpg'); background-repeat: no-repeat; background-size: cover;">

  <?php
  //include auth_session.php file on all user panel pages
  include("auth_session.php");  //need to uncomment 
  require('db.php');
  // SQL query to select data from database
  $sql = "SELECT * FROM prescriptions where d_id = '" . $_SESSION['id'] . "' ORDER BY id";
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
            <a class="nav-link" href="prescription_management.php">Prescription Management</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="appointment_history_doctor.php">Appointment History</a>
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
    <h2>Patient Prescription Management</h2>

    <form action="upload.php" method="post" enctype="multipart/form-data">
      <div class="row">
        <div class="col-6">
          <select class="form-select" id="app_no" name="app_no">
            <option value="">---- Select Appointment ----</option>
            <?php
            $query2 = "SELECT id, app_no, p_name FROM appointments where d_id = '" . $_SESSION['id'] . "' and done = '0' and cancel = '0'";
            $result2 = $con->query($query2);
            if ($result2->num_rows > 0) {
              while ($optionData = $result2->fetch_assoc()) {
                $app_no = $optionData['app_no'];
                $p_name = $optionData['p_name'];
            ?>
                <option value="<?php echo $app_no; ?>"><?php echo $app_no; ?> - <?php echo $p_name; ?> </option>
            <?php
              }
            }
            ?>
          </select>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-6">
          <input class="form-control" type="file" id="file" name="file" onchange="preview()">
        </div>
      </div>
      <div class="row">
        <div class="col-6">
          <img id="frame" src="" class="img-fluid" />
        </div>
      </div>
      <br>
      <br>
      <button type="submit" name="submit" value="Upload" class="btn btn-primary">Submit</button>
    </form>

    <br>
    <input class="form-control" id="myInput" type="text" placeholder="Search...">
    <br>
    <table class="table table-bordered table-striped" id="myTable">
      <thead>
        <tr>
          <th>Appointment No.</th>
          <th>Prescription</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
        // LOOP TILL END OF DATA
        while ($rows = $result->fetch_assoc()) {
          $imageURL = 'uploads/' . $rows["upload_path"];
        ?>
          <tr>
            <!-- FETCHING DATA FROM EACH
                    ROW OF EVERY COLUMN -->
            <td><?php echo $rows['app_id']; ?></td>
            <td>
              <img src="<?php echo $imageURL; ?>" class="profile-photo" width="50" height="50" alt="photo" />
            </td>
            <td>
              <a href="<?php echo $imageURL; ?>" download>
                <button type="button" class="btn btn-danger"><i class="bi bi-cloud-arrow-down"></i></button></a>
            </td>
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
  <script>
    function preview() {
      frame.src = URL.createObjectURL(event.target.files[0]);
    }

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