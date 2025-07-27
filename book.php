<?php
session_start();
include 'includes/db.php';

// Redirect if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if service_id is provided
if (!isset($_GET['service_id'])) {
    die("No service selected!");
}

$service_id = intval($_GET['service_id']);

// Fetch service details
$serviceQuery = mysqli_query($conn, "SELECT * FROM services WHERE service_id = $service_id");
$service = mysqli_fetch_assoc($serviceQuery);

if (!$service) {
    die("Service not found!");
}

$message = "";

// Handle booking form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_date = mysqli_real_escape_string($conn, $_POST['booking_date']);
    $user_id = $_SESSION['user_id'];

    // Insert booking into database
    $sql = "INSERT INTO bookings (user_id, service_id, booking_date, status) 
            VALUES ('$user_id', '$service_id', '$booking_date', 'Pending')";
    if (mysqli_query($conn, $sql)) {
        $message = "Booking successful! Our team will contact you soon.";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Service - Smart Booking</title>
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
        <h2 class="text-center">Book Service: <?php echo $service['name']; ?></h2>
        <div class="card p-4 mx-auto mt-4" style="max-width:500px;">
            <?php if($message) echo "<div class='alert alert-success'>$message</div>"; ?>
            <form method="POST">
                <div class="mb-3">
                    <label>Service</label>
                    <input type="text" class="form-control" value="<?php echo $service['name']; ?>" disabled>
                </div>
                <div class="mb-3">
                    <label>Select Booking Date</label>
                    <input type="date" class="form-control" name="booking_date" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Confirm Booking</button>
            </form>
            <p class="mt-3 text-center">
                <a href="services.php" class="btn btn-secondary">Back to Services</a>
            </p>
        </div>
    </div>
</body>
</html>
