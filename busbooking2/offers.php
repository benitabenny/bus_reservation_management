<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Offers - Bus Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            text-align: center;
            padding: 50px;
        }
        .offers-container {
            background: linear-gradient(135deg, #ff4e50, #fc913a);
            padding: 40px;
            color: white;
            border-radius: 10px;
            width: 60%;
            margin: auto;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }
        .offer {
            font-size: 24px;
            margin: 20px 0;
            background: rgba(255, 255, 255, 0.2);
            padding: 15px;
            border-radius: 5px;
        }
        .price {
            font-size: 30px;
            font-weight: bold;
            color: yellow;
        }
        .cta {
            margin-top: 20px;
            display: inline-block;
            background: yellow;
            color: #333;
            padding: 15px 30px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            transition: 0.3s;
        }
        .cta:hover {
            background: white;
            color: red;
        }
    </style>
</head>
<body>
    <div class="offers-container">
        <h1>🔥 Special Seasonal Offers 🔥</h1>
        <div class="offer">🎄 Christmas Sale - 50% Off on All Tickets! <br><span class="price">Save upto Rs 250 on KSRTC Bus Tickets</span></div>
        <div class="offer">🌸 Use Code CASH300
        Save up to Rs 300 on Karnataka,Tamil Nadu, Kerala routes <br><span class="price">Limited Time Offer</span></div>
        <div class="offer">🎉 New Year Bonanza - Flat 30% Off! <br><span class="price">Book Now!</span></div>
        <a href="book_ticket.php" class="cta">Book Now</a>
    </div>
</body>
</html>
