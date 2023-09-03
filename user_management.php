<?php
//include auth_session.php file on all user panel pages
include("auth_session.php");  //need to uncomment 
require('db.php');
// SQL query to select data from database
$sql = "SELECT * FROM users where id != '1' ORDER BY id";
$result = mysqli_query($con, $sql) or die($mysqli->error());
?>
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

<body style="background-image: url('img/user_management.jpg'); background-repeat: no-repeat; background-size: cover;">

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
    <h2>User Management</h2>
    <input class="form-control" id="myInput" type="text" placeholder="Search...">
    <br>
    <table class="table table-bordered table-striped" id="myTable">
      <thead>
        <tr>
          <th>Patient Name</th>
          <th>Tel. No.</th>
          <th>Blood Group</th>
          <th>Email</th>
          <th>NIC</th>
          <th>Address</th>
          <th>Gender</th>
          <th>DOB</th>
          <th> </th>
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
            <td><?php echo $rows['username']; ?></td>
            <td><?php echo $rows['blood_group']; ?></td>
            <td><?php echo $rows['email']; ?></td>
            <td><?php echo $rows['nic']; ?></td>
            <td><?php echo $rows['address']; ?></td>
            <td><?php echo $rows['gender']; ?></td>
            <td><?php echo $rows['date_of_birth']; ?></td>
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

  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Update User</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <form action="">
          <div class="modal-body">
            <div class="mb-3 mt-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" readonly id="name" placeholder="Enter Name" name="name">
            </div>
            <div class="mb-3">
              <label for="telNo" class="form-label">Tel. No. (Username)</label>
              <input type="number" class="form-control" readonly id="telNo" placeholder="Enter Tel. No." name="telNo">
            </div>
            <div class="mb-3">
              <label for="bloodGroup" class="form-label">Blood Group</label>
              <select class="form-select" id="blood_group" name="blood_group">
                <option value="A+">A+</option>
                <option value="A-">B+</option>
                <option value="AB+">AB+</option>
                <option value="A-">A-</option>
                <option value="B-">B-</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email">
            </div>
            <div class="mb-3">
              <label for="nic" class="form-label">NIC</label>
              <input type="text" class="form-control" id="nic" placeholder="Enter NIC" name="nic">
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" id="address" placeholder="Enter Address" name="address">
            </div>
            <div class="mb-3">
              <label for="gender" class="form-label">Gender</label>
              <select class="form-select" id="gender" name="gender">
                <option value="">---- Select Gender ----</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="dob" class="form-label">Date of Birth</label>
              <input type="date" class="form-control" id="dob" placeholder="Enter DOB" name="dob">
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
  <script>
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

        $('#name').val(data[0]);
        $('#telNo').val(data[1]);
        $('#blood_group').val(data[2]);
        $('#email').val(data[3]);
        $('#nic').val(data[4]);
        $('#address').val(data[5]);
        $('#gender').val(data[6]);
        $('#dob').val(data[7]);
      });

      $('.edit_submit').on('click', function() {
        var telNo = $("#telNo").val();
        var blood_group = $("#blood_group").val();
        var email = $("#email").val();
        var nic = $("#nic").val();
        var address = $("#address").val();
        var gender = $("#gender").val();
        var dob = $("#dob").val();

        $.ajax({
          method: 'POST',
          url: 'modal_edit_script2.php',
          data: {
            'telNo': telNo,
            'blood_group': blood_group,
            'email': email,
            'nic': nic,
            'address': address,
            'gender': gender,
            'dob': dob,
            'ajax': true
          },
          success: function(data) {

          }
        });

      });
    });

    function deleteRow(id) {
      $.ajax({
        method: 'POST',
        url: 'modal_delete_script2.php',
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