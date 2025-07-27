<?php
// Start the session (for user login)
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Online Service Booking</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Bootstrap CDN for quick styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Smart Booking</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="my_bookings.php">My Bookings</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <?php if(isset($_SESSION['username'])): ?>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout (<?php echo $_SESSION['username']; ?>)</a></li>
                        
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container text-center mt-5">
        <h1 class="display-4">Welcome to Smart Online Service Booking</h1>
        <p class="lead">Book services like home cleaning, repair, and more – all online!</p>
        <a href="services.php" class="btn btn-primary btn-lg mt-3">Book a Service</a>
    </div>

    <!-- Sample Services Section -->
    <div class="container mt-5">
        <h2 class="text-center">Popular Services</h2>
        <div class="row mt-4">
            <!-- Service Card 1 -->
            <div class="col-md-4">
                <div class="card">
                    <img src="images/images_cleaning.jpg" class="card-img-top" alt="Cleaning Service">
                    <div class="card-body">
                        <h5 class="card-title">Home Cleaning</h5>
                        <p class="card-text">Professional cleaning services at your doorstep.</p>
                        <a href="book.php?service=cleaning" class="btn btn-success">Book Now</a>
                    </div>
                </div>
            </div>
            <!-- Service Card 2 -->
            <div class="col-md-4">
                <div class="card">
                    <img src="images/plumbing_image.jpg" class="card-img-top" alt="Plumbing Service">
                    <div class="card-body">
                        <h5 class="card-title">Plumbing Repair</h5>
                        <p class="card-text">Quick and reliable plumbing services.</p>
                        <a href="book.php?service=plumbing" class="btn btn-success">Book Now</a>
                    </div>
                </div>
            </div>
            <!-- Service Card 3 -->
            <div class="col-md-4">
                <div class="card">
                    <img src="images/salon_image.jpeg" class="card-img-top" alt="Salon Service">
                    <div class="card-body">
                        <h5 class="card-title">Salon at Home</h5>
                        <p class="card-text">Get beauty services at your home.</p>
                        <a href="book.php?service=salon" class="btn btn-success">Book Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light text-center p-3 mt-5">
        &copy; 2025 Smart Online Service Booking | All Rights Reserved
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
