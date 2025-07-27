<?php
session_start();
include('../includes/db.php');

// Redirect if not logged in as admin
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Update Booking Status
if (isset($_GET['update']) && isset($_GET['status'])) {
    $booking_id = intval($_GET['update']);
    $status = mysqli_real_escape_string($conn, $_GET['status']);
    mysqli_query($conn, "UPDATE bookings SET status='$status' WHERE booking_id=$booking_id");
    header("Location: manage_bookings.php");
    exit();
}

// Delete Booking (Optional)
if (isset($_GET['delete'])) {
    $booking_id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM bookings WHERE booking_id=$booking_id");
    header("Location: manage_bookings.php");
    exit();
}

// Fetch all bookings
$sql = "SELECT b.booking_id, b.booking_date, b.status, 
               u.name AS user_name, u.email, 
               s.name AS service_name
        FROM bookings b
        JOIN users u ON b.user_id = u.user_id
        JOIN services s ON b.service_id = s.service_id
        ORDER BY b.booking_date DESC";
$bookings = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_services.php">Manage Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_users.php">Manage Users</a></li>
                    <li class="nav-item"><a class="nav-link active" href="manage_bookings.php">Manage Bookings</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout (<?php echo $_SESSION['admin']; ?>)</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">All Bookings</h2>

        <table class="table table-bordered table-striped mt-4">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($bookings)): ?>
                <tr>
                    <td><?php echo $row['booking_id']; ?></td>
                    <td><?php echo $row['user_name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['service_name']; ?></td>
                    <td><?php echo $row['booking_date']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <a href="manage_bookings.php?update=<?php echo $row['booking_id']; ?>&status=Approved" 
                           class="btn btn-success btn-sm">Approve</a>
                        <a href="manage_bookings.php?update=<?php echo $row['booking_id']; ?>&status=Cancelled" 
                           class="btn btn-warning btn-sm">Cancel</a>
                        <a href="manage_bookings.php?delete=<?php echo $row['booking_id']; ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to delete this booking?');">
                           Delete
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
