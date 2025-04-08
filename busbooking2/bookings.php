<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle booking creation
    $schedule_id = $_POST['schedule_id'];
    $ref_no = $_POST['ref_no'];
    $name = $_POST['name'];
    $qty = $_POST['qty'];
    $status = $_POST['status'];

    $sql = "INSERT INTO booked (schedule_id, ref_no, name, qty, status) VALUES ('$schedule_id', '$ref_no', '$name', '$qty', '$status')";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Booking created successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

// Fetch bookings
$bookings = $conn->query("SELECT * FROM booked");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Manage Bookings</h1>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label for="schedule_id" class="form-label">Schedule ID</label>
                <input type="number" class="form-control" id="schedule_id" name="schedule_id" required>
            </div>
            <div class="mb-3">
                <label for="ref_no" class="form-label">Reference No</label>
                <input type="text" class="form-control" id="ref_no" name="ref_no" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="qty" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="qty" name="qty" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="0">Unpaid</option>
                    <option value="1">Paid</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create Booking</button>
        </form>

        <h2>Existing Bookings</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Schedule ID</th>
                    <th>Reference No</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Date Updated</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $bookings->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['schedule_id']; ?></td>
                        <td><?php echo $row['ref_no']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['qty']; ?></td>
                        <td><?php echo $row['status'] == 1 ? 'Paid' : 'Unpaid'; ?></td>
                        <td><?php echo $row['date_updated']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>