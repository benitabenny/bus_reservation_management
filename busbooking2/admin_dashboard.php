<?php
session_start();
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_type'] != 1) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Admin Dashboard</h1>
        <p>Welcome, Admin <?php echo $_SESSION['user_name']; ?>!</p>
        <a href="bookings.php" class="btn btn-primary">Manage Bookings</a>
        <a href="buses.php" class="btn btn-primary">Manage Buses</a>
        <a href="locations.php" class="btn btn-primary">Manage Locations</a>
        <a href="schedules.php" class="btn btn-primary">Manage Schedules</a>
        <a href="users.php" class="btn btn-primary">Manage Users</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>