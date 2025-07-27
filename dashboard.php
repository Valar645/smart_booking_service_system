<?php
session_start();
include('../includes/db.php');

// Redirect if not logged in as admin
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch statistics
$total_users = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM users"))[0];
$total_services = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM services"))[0];
$total_bookings = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM bookings"))[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="manage_services.php">Manage Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_users.php">Manage Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_bookings.php">Manage Bookings</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout (<?php echo $_SESSION['admin']; ?>)</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Welcome, Admin</h2>
        <div class="row text-center">
            <div class="col-md-4 mb-3">
                <div class="card shadow p-4 bg-primary text-white">
                    <h3><?php echo $total_users; ?></h3>
                    <p>Registered Users</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow p-4 bg-success text-white">
                    <h3><?php echo $total_services; ?></h3>
                    <p>Available Services</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow p-4 bg-warning text-white">
                    <h3><?php echo $total_bookings; ?></h3>
                    <p>Total Bookings</p>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="manage_services.php" class="btn btn-outline-primary m-2">Manage Services</a>
            <a href="manage_users.php" class="btn btn-outline-success m-2">Manage Users</a>
            <a href="manage_bookings.php" class="btn btn-outline-warning m-2">Manage Bookings</a>
        </div>
    </div>
</body>
</html>
