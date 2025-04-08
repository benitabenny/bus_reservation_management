<?php
session_start();
include 'db.php'; 


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Function to fetch bookings from the database
function getBookingsFromDatabase($userId, $conn) {
    $stmt = $conn->prepare("SELECT id,ref_no,name,qty FROM booked ");
    $stmt->execute();
    $result = $stmt->get_result();

    $bookings = [];
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }

    $stmt->close();
    return $bookings;
}

// Fetch bookings
$bookings = getBookingsFromDatabase($userId, $conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings | EasyBus</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>EasyBus</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="my_bookings.php">My Bookings</a></li>
                <li><a href="offers.php">Offers</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Your Bookings</h2>
        <table>
            <thead>
                <tr>
                    <th>Booking_ID</th>
                    <th>Reference Number</th>
                    <th>Name</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($bookings)): ?>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?= htmlspecialchars($booking['id']) ?></td>
                            <td><?= htmlspecialchars($booking['ref_no']) ?></td>
                            <td><?= htmlspecialchars($booking['name']) ?></td>
                            <td><?= htmlspecialchars($booking['qty']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No bookings found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; 2024 EasyBus. All rights reserved.</p>
    </footer>
</body>
</html>
