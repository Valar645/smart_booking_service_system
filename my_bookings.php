<?php
session_start();
include('includes/db.php');  // Not ../includes/db.php



// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle booking cancellation
if (isset($_GET['cancel_id'])) {
    $cancel_id = intval($_GET['cancel_id']);
    mysqli_query($conn, "DELETE FROM bookings WHERE booking_id = $cancel_id AND user_id = $user_id");
   // header("Location: my_bookings.php");
    header("Location: /smart_booking_system/my_bookings.php");
 
    exit();
}

// Fetch all bookings for this user
$sql = "SELECT b.booking_id, b.booking_date, b.status, s.name AS service_name, s.price
        FROM bookings b 
        JOIN services s ON b.service_id = s.service_id
        WHERE b.user_id = $user_id
        ORDER BY b.booking_date DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - Smart Booking</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Smart Booking</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="my_bookings.php">My Bookings</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout (<?php echo $_SESSION['username']; ?>)</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">My Bookings</h2>
        <table class="table table-striped table-bordered mt-4">
            <thead class="table-dark">
                <tr>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Price (₹)</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['service_name']; ?></td>
                            <td><?php echo $row['booking_date']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <a href="/smart_booking_system/my_bookings.php?cancel_id=<?php echo $row['booking_id']; ?>"
                                                              class="btn btn-danger btn-sm"
                                   onclick="return confirm('Are you sure you want to cancel this booking?');">
                                   Cancel
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center">No bookings yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="text-center">
            <a href="services.php" class="btn btn-primary">Book Another Service</a>
        </div>
    </div>
</body>
</html>
