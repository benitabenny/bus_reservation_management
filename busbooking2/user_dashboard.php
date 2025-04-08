

<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: login.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $from = $_POST['from'];
    $to = $_POST['to'];
    $journey_date = $_POST['date'];

    $stmt = $conn->query("SELECT * FROM buses WHERE departure_city = '$from' AND arrival_city = '$to' AND journey_date = '$journey_date'");

    $buses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($buses) > 0) {
        $result = "Found " . count($buses) . " buses.";
    } else {
        $result = "No buses found.";
    }
    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyBus User Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        :root {
            --primary: #1a73e8;
            --primary-dark: #0d47a1;
            --secondary: #f50057;
            --light-gray: #f5f5f5;
            --gray: #e0e0e0;
            --dark-gray: #757575;
            --white: #ffffff;
            --black: #212121;
            --success: #4caf50;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light-gray);
            color: var(--black);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header */
        header {
            background-color: var(--white);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: var(--primary);
            text-decoration: none;
        }
        
        .logo span {
            color: var(--secondary);
        }
        
        .nav-links {
            display: flex;
            gap: 20px;
        }
        
        .nav-links a {
            text-decoration: none;
            color: var(--black);
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        .nav-links a:hover {
            background-color: var(--light-gray);
        }
        
        .nav-links a.active {
            color: var(--primary);
        }
        
        .auth-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 8px 16px;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
        }
        
        .btn-outline {
            background-color: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
        }
        
        .btn-outline:hover {
            background-color: rgba(26, 115, 232, 0.1);
        }
        
        /* Hero Section */
        .hero {
            background-color: var(--primary);
            color: var(--white);
            padding: 60px 0;
            background-image: linear-gradient(135deg, var(--primary), var(--primary-dark));
        }
        
        .hero-content {
            max-width: 600px;
        }
        
        .hero-title {
            font-size: 36px;
            margin-bottom: 20px;
        }
        
        .hero-subtitle {
            font-size: 18px;
            margin-bottom: 30px;
            opacity: 0.9;
        }
        
        /* Search Form */
        .search-box {
            background-color: var(--white);
            border-radius: 8px;
            padding: 30px;
            margin-top: -40px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 10;
        }
        
        .search-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--dark-gray);
        }
        
        .form-control {
            padding: 12px;
            border: 1px solid var(--gray);
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
        }
        
        .search-btn {
            background-color: var(--secondary);
            color: var(--white);
            padding: 12px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
            align-self: flex-end;
        }
        
        .search-btn:hover {
            background-color: #d1004a;
        }
        
        /* Features Section */
        .features {
            padding: 60px 0;
        }
        
        .section-title {
            text-align: center;
            font-size: 28px;
            margin-bottom: 40px;
            color: var(--black);
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }
        
        .feature-card {
            background-color: var(--white);
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: transform 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-icon {
            font-size: 40px;
            color: var(--primary);
            margin-bottom: 20px;
        }
        
        .feature-title {
            font-size: 20px;
            margin-bottom: 15px;
        }
        
        .feature-description {
            color: var(--dark-gray);
            line-height: 1.6;
        }
        
        /* Bus Results Section */
        .bus-results {
            padding: 40px 0;
            display: none;
        }
        
        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .results-title {
            font-size: 24px;
        }
        
        .filters {
            display: flex;
            gap: 15px;
        }
        
        .filter-dropdown {
            padding: 8px 12px;
            border: 1px solid var(--gray);
            border-radius: 4px;
            background-color: var(--white);
        }
        
        .bus-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .bus-card {
            background-color: var(--white);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
            gap: 20px;
            align-items: center;
        }
        
        .bus-operator {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .operator-name {
            font-weight: 600;
            font-size: 18px;
        }
        
        .bus-type {
            color: var(--dark-gray);
            font-size: 14px;
        }
        
        .bus-details {
            display: flex;
            gap: 30px;
        }
        
        .time-info {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .time {
            font-weight: 600;
            font-size: 20px;
        }
        
        .location {
            color: var(--dark-gray);
        }
        
        .journey-line {
            position: relative;
            padding: 0 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .journey-line::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background-color: var(--primary);
        }
        
        .journey-start, .journey-end {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: var(--primary);
            position: absolute;
        }
        
        .journey-start {
            left: 0;
        }
        
        .journey-end {
            right: 0;
        }
        
        .duration {
            background-color: var(--white);
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 14px;
            z-index: 1;
        }
        
        .price-section {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 10px;
        }
        
        .price {
            font-weight: 600;
            font-size: 24px;
            color: var(--primary);
        }
        
        .seats-left {
            font-size: 14px;
            color: var(--dark-gray);
        }
        
        .book-btn {
            background-color: var(--success);
            color: var(--white);
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .book-btn:hover {
            background-color: #388e3c;
        }
        
        /* Footer */
        footer {
            background-color: var(--black);
            color: var(--white);
            padding: 50px 0 20px;
            margin-top: 60px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-logo {
            font-size: 24px;
            font-weight: bold;
            color: var(--white);
            margin-bottom: 15px;
        }
        
        .footer-logo span {
            color: var(--secondary);
        }
        
        .footer-description {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
        }
        
        .footer-links h3 {
            font-size: 18px;
            margin-bottom: 20px;
            color: var(--white);
        }
        
        .footer-links ul {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: var(--white);
        }
        
        .copyright {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
        }
        
        /* Modal for seat selection */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            overflow: auto;
        }
        
        .modal-content {
            background-color: var(--white);
            margin: 50px auto;
            width: 90%;
            max-width: 800px;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .modal-header {
            background-color: var(--primary);
            color: var(--white);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-title {
            font-size: 20px;
            font-weight: 600;
        }
        
        .close-modal {
            background: none;
            border: none;
            color: var(--white);
            font-size: 24px;
            cursor: pointer;
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .bus-info {
            display: flex;
            justify-content: space-between;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--gray);
            margin-bottom: 20px;
        }
        
        .bus-info-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .info-label {
            font-size: 14px;
            color: var(--dark-gray);
        }
        
        .info-value {
            font-weight: 600;
        }
        
        .seat-selection {
            margin-top: 30px;
        }
        
        .seat-layout {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin: 20px 0;
        }
        
        .seat-row {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        
        .seat {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--gray);
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .seat.available {
            background-color: var(--white);
        }
        
        .seat.selected {
            background-color: var(--primary);
            color: var(--white);
            border-color: var(--primary);
        }
        
        .seat.booked {
            background-color: var(--gray);
            color: var(--dark-gray);
            cursor: not-allowed;
        }
        
        .seat-info {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        
        .seat-type {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .seat-color {
            width: 20px;
            height: 20px;
            border-radius: 4px;
        }
        
        .seat-color.available {
            border: 1px solid var(--gray);
            background-color: var(--white);
        }
        
        .seat-color.selected {
            background-color: var(--primary);
        }
        
        .seat-color.booked {
            background-color: var(--gray);
        }
        
        .booking-summary {
            margin-top: 30px;
            background-color: var(--light-gray);
            padding: 20px;
            border-radius: 8px;
        }
        
        .summary-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .summary-label {
            color: var(--dark-gray);
        }
        
        .summary-value {
            font-weight: 500;
        }
        
        .total-amount {
            font-size: 18px;
            font-weight: 600;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid var(--gray);
        }
        
        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
        }
        
        .cancel-btn {
            background-color: var(--light-gray);
            color: var(--black);
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
        }
        
        .proceed-btn {
            background-color: var(--success);
            color: var(--white);
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                padding: 15px 0;
            }
            
            .nav-links {
                margin: 15px 0;
            }
            
            .hero-title {
                font-size: 28px;
            }
            
            .search-form {
                grid-template-columns: 1fr;
            }
            
            .bus-card {
                grid-template-columns: 1fr;
            }
            
            .bus-details {
                flex-direction: column;
                gap: 15px;
                margin: 15px 0;
            }
            
            .price-section {
                align-items: flex-start;
            }
            
            .journey-line {
                display: none;
            }
            
            .bus-info {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <header>
    <div class="container">
        <div class="navbar">
            <a href="#" class="logo">Easy<span>Bus</span></a>
            <nav class="nav-links">
                <a href="user_dashboard.php" class="active">Home</a>
                <a href="my_bookings.php">My Bookings</a>
                <a href="offers.php">Offers</a>
                <a href="contact.php">Contact</a>
            </nav>
            <div class="auth-buttons">
                <button class="btn btn-primary" onclick="window.location.href='logout.php'">Logout</button>
            </div>
        </div>
    </header>
   
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Book Bus Tickets Online</h1>
                <p>Hassle-free booking, safe travel, and comfortable journeys at your fingertips.</p>
            </div>
        </div>
    </section>
        <!-- Search Box -->
        <div class="container">
            <div class="search-box">
                <form class="search-form" id="search-form" action="search_results.php" method="post">
                     <div class="form-group">
                        <label class="form-label">From</label>
                        <input type="text" class="form-control" name="from" placeholder="Enter city" required>
                    </div>
            <div class="form-group">
                <label class="form-label">To</label>
                <input type="text" class="form-control" name="to" placeholder="Enter city" required>
            </div>
            <div class="form-group">
                <label class="form-label">Date of Journey</label>
                <input type="date" class="form-control" name="date_of_journey" required>
            </div>
            <div class="form-group">
                
                <button type="submit" class="search-btn">Search Buses</button>
            </div>
        </form>
    </div>
</div>

        <?php
        if (isset($result)) {
            echo "<div class='alert alert-info mt-3'>$result</div>";
        }
        ?>

        <!-- Features Section -->
    <section class="features">
        <div class="container">
            <h2 class="section-title">Why Choose EasyBus?</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🛡️</div>
                    <h3 class="feature-title">Safe & Secure</h3>
                    <p class="feature-description">All our bus partners follow strict safety protocols to ensure your journey is secure.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💰</div>
                    <h3 class="feature-title">Best Prices</h3>
                    <p class="feature-description">Get the best deals on bus tickets with our exclusive offers and discounts.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔄</div>
                    <h3 class="feature-title">Easy Cancellation</h3>
                    <p class="feature-description">Hassle-free cancellation and instant refunds with minimal charges.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🎫</div>
                    <h3 class="feature-title">E-Tickets</h3>
                    <p class="feature-description">Go paperless with e-tickets sent directly to your email and phone.</p>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
