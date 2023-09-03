<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration</title>
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body style="background-image: url('img/registration.png'); background-repeat: no-repeat;">
    <?php
    include("auth_session.php");  //need to uncomment 
    require('db.php');
    // When form submitted, insert values into the database.
    if (isset($_REQUEST['username'])) {
        // removes backslashes
        $username = stripslashes($_REQUEST['username']);
        //escapes special characters in a string
        $username = mysqli_real_escape_string($con, $username);
        $email    = stripslashes($_REQUEST['email']);
        $email    = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $name = stripslashes($_REQUEST['name']);
        $nic = stripslashes($_REQUEST['nic']);
        $blood_group = stripslashes($_REQUEST['blood_group']);
        $gender = stripslashes($_REQUEST['gender']);
        $address = stripslashes($_REQUEST['address']);
        $date_of_birth = stripslashes($_REQUEST['date_of_birth']);
        $user_type = stripslashes($_REQUEST['user_type']);
        $create_datetime = date("Y-m-d H:i:s");
        $query    = "INSERT into `users` (username, password, email, name, nic, blood_group, gender, address, date_of_birth, 
        user_type, create_datetime)
                     VALUES ('$username', '" . md5($password) . "', '$email', '$name', '$nic', '$blood_group', '$gender', 
                     '$address', '$date_of_birth', '$user_type', '$create_datetime')";
        $result   = mysqli_query($con, $query);
        if ($result) {
            echo "<div class='form'>
                  <h3>You are registered successfully.</h3><br/>
                  <p class='link'>Click here to <a href='dashboard_admin.php'>Return Back</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Required fields are missing.</h3><br/>
                  <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                  </div>";
        }
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

        <form class="form_register" action="" method="post">
            <h1 class="login-title">Registration</h1>
            <input type="text" class="form-control" name="name" placeholder="Name" required>
            <br>
            <input type="text" class="form-control" name="username" placeholder="Mobile No. (Username)" required />
            <br>
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <br>
            <input type="email" class="form-control" name="email" placeholder="Email">
            <br>
            <input type="text" class="form-control" name="nic" placeholder="NIC" required>
            <br>
            <select class="form-select" name="blood_group">
                <option value="A+">A+</option>
                <option value="A-">B+</option>
                <option value="AB+">AB+</option>
                <option value="A-">A-</option>
                <option value="B-">B-</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>
            <br>
            <select class="form-select" name="gender" required>
                <option value="">---- Select Gender ----</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            <br>
            <input type="text" class="form-control" name="address" placeholder="Address" required>
            <br>
            <input type="date" class="form-control" name="date_of_birth" placeholder="DOB" required>
            <br>
            <select class="form-select" id="user_type" name="user_type" required>
                <option value="">---- Select User Type ----</option>
                <?php
                $query2 = "SELECT id, user_type FROM user_type";
                $result2 = $con->query($query2);
                if ($result2->num_rows > 0) {
                    while ($optionData = $result2->fetch_assoc()) {
                        $name = $optionData['user_type'];
                        $id = $optionData['id'];
                ?>
                        <option value="<?php echo $id; ?>"><?php echo $name; ?> </option>
                <?php
                    }
                }
                ?>
            </select>
            <br>
            <input type="submit" name="submit" value="Register" class="login-button">
        </form>

        <nav class="navbar navbar-expand-sm bg-primary navbar-dark fixed-bottom">
            ...
        </nav>
    <?php
    }
    ?>
</body>

</html>