<?php
// Include the database connection file
include 'db_connection.php';

// Fetch booked slots from the database
$sql = "SELECT * FROM bookings";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booked Slots</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navbar -->
    <nav>
        <div class="logo">
            <h1>EV Charging Station</h1>
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="available_stations.php">Available Stations</a></li>
            <li><a href="booked_slots.php">Booked Slots</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </nav>

    <!-- Booked Slots Section -->
    <section id="booked-slots" class="booked-slots-section">
        <h2>Booked Slots</h2>
        <div class="booked-slots-container">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="booked-slot">
                        <p>Name: <?php echo htmlspecialchars($row['name']); ?></p>
                        <p>Vehicle Number: <?php echo htmlspecialchars($row['vehicle_number']); ?></p>
                        <p>Date: <?php echo htmlspecialchars($row['date']); ?></p>
                        <p>Time: <?php echo htmlspecialchars($row['slot_time']); ?></p>
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="edit">Edit</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="delete">Delete</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No booked slots available.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <div class="footer-content">
            <p>&copy; 2023 EV Charging Station. All rights reserved.</p>
            <p>Contact us: info@evchargingstation.com</p>
        </div>
    </footer>

    <script src="app.js"></script>
</body>
</html>

<?php
$conn->close();
?>