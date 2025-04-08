<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bus_id = $_POST['bus_id'];
    $from_location = $_POST['from_location'];
    $to_location = $_POST['to_location'];
    $departure_time = $_POST['departure_time'];
    $eta = $_POST['eta'];
    $status = $_POST['status'];
    $availability = $_POST['availability'];
    $price = $_POST['price'];

    $sql = "INSERT INTO schedule_list (bus_id, from_location, to_location, departure_time, eta, status, availability, price) 
            VALUES ('$bus_id', '$from_location', '$to_location', '$departure_time', '$eta', '$status', '$availability', '$price')";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Schedule added successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

//fetching
$schedules = $conn->query("SELECT * FROM schedule_list");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Schedules</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Manage Schedules</h1>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label for="bus_id" class="form-label">Bus ID</label>
                <input type="number" class="form-control" id="bus_id" name="bus_id" required>
            </div>
            <div class="mb-3">
                <label for="from_location" class="form-label">From Location</label>
                <input type="number" class="form-control" id="from_location" name="from_location" required>
            </div>
            <div class="mb-3">
                <label for="to_location" class="form-label">To Location</label>
                <input type="number" class="form-control" id="to_location" name="to_location" required>
            </div>
            <div class="mb-3">
                <label for="departure_time" class="form-label">Departure Time</label>
                <input type="datetime-local" class="form-control" id="departure_time" name="departure_time" required>
            </div>
            <div class="mb-3">
                <label for="eta" class="form-label">ETA</label>
                <input type="datetime-local" class="form-control" id="eta" name="eta" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="availability" class="form-label">Availability</label>
                <input type="number" class="form-control" id="availability" name="availability" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" id="price" name="price" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Schedule</button>
        </form>

        <h2>Existing Schedules</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Bus ID</th>
                    <th>From Location</th>
                    <th>To Location</th>
                    <th>Departure Time</th>
                    <th>ETA</th>
                    <th>Status</th>
                    <th>Availability</th>
                    <th>Price</th>
                    <th>Date Updated</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $schedules->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['bus_id']; ?></td>
                        <td><?php echo $row['from_location']; ?></td>
                        <td><?php echo $row['to_location']; ?></td>
                        <td><?php echo $row['departure_time']; ?></td>
                        <td><?php echo $row['eta']; ?></td>
                        <td><?php echo $row['status'] == 1 ? 'Active' : 'Inactive'; ?></td>
                        <td><?php echo $row['availability']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['date_updated']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>