<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        /* Reset Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(255, 253, 253);
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        td {
            background-color: #fff;
        }

        td a {
            text-decoration: none;
            color: #337ab7;
        }

        td a:hover {
            color: #23527c;
        }

        .go-back {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #337ab7;
        }

        .go-back:hover {
            color: #23527c;
        }

    </style>
</head>
<body>
    <div class="container">
 
        <?php
        include 'db.php';
        if (isset($_POST['from']) && isset($_POST['to']) && isset($_POST['date_of_journey'])) {
            $from = $_POST['from'];
            $to = $_POST['to'];
            $date_of_journey = $_POST['date_of_journey'];

           // SQL query to fetch bus details
            $sql = "SELECT bus.id, bus.name, location.terminal_name, location.city, bus.price 
                    FROM bus 
                    INNER JOIN location ON bus.id = location.id
                    WHERE bus.date_updated LIKE '%$date_of_journey%' 
                    OR location.terminal_name LIKE '%$from%'
                    OR location.city LIKE '%$to%'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Display search results
                ?>
                <h3 style="color: blue">Search Results</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Bus Name</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Price</th>
                            <th>Booking Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['terminal_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['city']); ?></td>
                                <td><?php echo htmlspecialchars($row['price']); ?></td>
                                <td><a href="book_ticket.php?bus_id=<?php echo $row['id']; ?>&name=<?php echo urlencode($row['name']); ?>&from=<?php echo urlencode($row['terminal_name']); ?>&to=<?php echo urlencode($row['city']); ?>&price=<?php echo urlencode($row['price']); ?>">Book Now</a></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "<p>No results found.</p>";
            }
        } else {
            header('Location: user_dashboard.php');
            exit;
        }
        ?>
        <a href="user_dashboard.php" class="go-back">Go Back</a>
    </div>
</body>
</html>