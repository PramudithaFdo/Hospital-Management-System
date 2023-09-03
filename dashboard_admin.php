<?php
//include auth_session.php file on all user panel pages
include("auth_session.php");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Dashboard - Admin Area</title>
    <link rel="stylesheet" href="css/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .fakeimg {
            height: 500px;
            background: url('img/update.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body style="background-image: url('img/admin_bg.jpg'); background-repeat: no-repeat; background-size: cover;">

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

    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-4">
                <br>
                <br>
                <br>
                <div class="fakeimg"></div>
            </div>
            <div class="col-sm-8">
                <br>
                <br>
                <br>
                <h2>TITLE HEADING</h2>
                <h5>Title description, Feb 28, 2023</h5>
                <div></div>
                <p>Some text..</p>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-sm bg-primary navbar-dark fixed-bottom">
        ...
    </nav>

</body>

</html>