<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $terminal_name = $_POST['terminal_name'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $status = $_POST['status'];

    $sql = "INSERT INTO location (terminal_name, city, state, status) VALUES ('$terminal_name', '$city', '$state', '$status')";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Location added successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

// Fetch locations
$locations = $conn->query("SELECT * FROM location");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Locations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Manage Locations</h1>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label for="terminal_name" class="form-label">Terminal Name</label>
                <input type="text" class="form-control" id="terminal_name" name="terminal_name" required>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" required>
            </div>
            <div class="mb-3">
                <label for="state" class="form-label">State</label>
                <input type="text" class="form-control" id="state" name="state" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Location</button>
        </form>

        <h2>Existing Locations</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Terminal Name</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Status</th>
                    <th>Date Updated</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $locations->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['terminal_name']; ?></td>
                        <td><?php echo $row['city']; ?></td>
                        <td><?php echo $row['state']; ?></td>
                        <td><?php echo $row['status'] == 1 ? 'Active' : 'Inactive'; ?></td>
                        <td><?php echo $row['date_updated']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>