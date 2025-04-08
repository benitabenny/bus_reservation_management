
<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle bus creation
    $name = $_POST['name'];
    $bus_number = $_POST['bus_number'];
    $status = $_POST['status'];

    $sql = "INSERT INTO bus (name, bus_number, status) VALUES ('$name', '$bus_number', '$status')";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Bus added successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}


$buses = $conn->query("SELECT * FROM bus");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Buses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Manage Buses</h1>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label for="name" class="form-label">Bus Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="bus_number" class="form-label">Bus Number</label>
                <input type="text" class="form-control" id="bus_number" name="bus_number" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Bus</button>
        </form>

        <h2>Existing Buses</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Bus Number</th>
                    <th>Status</th>
                    <th>Date Updated</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $buses->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['bus_number']; ?></td>
                        <td><?php echo $row['status'] == 1 ? 'Active' : 'Inactive'; ?></td>
                        <td><?php echo $row['date_updated']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>