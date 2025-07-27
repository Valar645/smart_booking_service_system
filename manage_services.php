<?php
session_start();
include('../includes/db.php');

// Redirect if not logged in as admin
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle Add Service
if (isset($_POST['add_service'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    mysqli_query($conn, "INSERT INTO services (name, price, description) VALUES ('$name', '$price', '$desc')");
    header("Location: manage_services.php");
    exit();
}

// Handle Delete Service
if (isset($_GET['delete'])) {
    $service_id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM services WHERE service_id=$service_id");
    header("Location: manage_services.php");
    exit();
}

// Fetch all services
$services = mysqli_query($conn, "SELECT * FROM services ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services - Admin Panel</title>
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
                    <li class="nav-item"><a class="nav-link active" href="manage_services.php">Manage Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_users.php">Manage Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_bookings.php">Manage Bookings</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout (<?php echo $_SESSION['admin']; ?>)</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Manage Services</h2>

        <!-- Add Service Form -->
        <div class="card p-4 mb-4">
            <h5>Add New Service</h5>
            <form method="POST">
                <div class="mb-3">
                    <label>Service Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Price (₹)</label>
                    <input type="number" name="price" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" required></textarea>
                </div>
                <button type="submit" name="add_service" class="btn btn-primary">Add Service</button>
            </form>
        </div>

        <!-- Service List Table -->
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price (₹)</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($services)): ?>
                <tr>
                    <td><?php echo $row['service_id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td>
                        <a href="manage_services.php?delete=<?php echo $row['service_id']; ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to delete this service?');">
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
