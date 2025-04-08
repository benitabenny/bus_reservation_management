<?php
session_start();
include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $schedule_id = $_POST['schedule_id'];
    $name = trim($_POST['name']);
    $qty = (int)$_POST['qty'];
    $payment_method = $_POST['payment_method']; 
    $ref_no = time() . rand(1000, 9999); 
    
    // Insert booking details into the database
    $sql = "INSERT INTO booked (schedule_id, ref_no, name, qty, status) 
    VALUES ($schedule_id, '$ref_no', '$name', $qty, 0)";

    if ($conn->query($sql) === TRUE) {
    echo "<h2>Booking Successful!</h2>";
    echo "<p>Your Reference Number: <strong>" . $ref_no . "</strong></p>";
    echo "<p>Please save this reference number for future inquiries.</p>";
    } else {
    echo "<h2>Booking Failed!</h2>";
    echo "<p>Error: " . $conn->error . "</p>";
}

$conn->close();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Ticket - EasyBus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Book a Ticket</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="schedule_id" class="form-label">Schedule ID</label>
                <input type="number" class="form-control" id="schedule_id" name="schedule_id" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="qty" class="form-label">Number of Tickets</label>
                <input type="number" class="form-control" id="qty" name="qty" required min="1">
            </div>
            <div class="mb-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <select class="form-control" id="payment_method" name="payment_method" required>
                    <option value="Online">Bank Transfer</option>
                    <option value="UPI">UPI Payment</option>
                    <option value="Card">Debit/Credits Card</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Book Now</button>
        </form>
    </div>
</body>
</html>
