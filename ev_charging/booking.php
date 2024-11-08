<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ev_charging";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $vehicle_number = $_POST['vehicle_number'];
    $date = $_POST['date'];
    $slot_time = $_POST['slot_time'];
    $station_name = $_POST['station_name'];
    $station_address = $_POST['station_address'];

    // Insert the booking into the database
    $sql = "INSERT INTO bookings (name, vehicle_number, date, slot_time, station_name, station_address) VALUES ('$name', '$vehicle_number', '$date', '$slot_time', '$station_name', '$station_address')";

    if ($conn->query($sql) === TRUE) {
        // Redirect with a success message
        header("Location: index.php?message=Slot booked successfully");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EV Charging Station Slot Booking</title>
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
            <li><a href="#stations">Charging Stations</a></li>
            <li><a href="#book">Book</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </nav>

    <!-- Display success message if available -->
    <?php if (isset($_GET['message'])): ?>
        <div class="success-message"><?php echo htmlspecialchars($_GET['message']); ?></div>
    <?php endif; ?>

    <!-- Booking Section -->
    <section id="book" class="section">
        <h2>Book a Charging Slot</h2>
        <form action="booking.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="vehicle_number">Vehicle Number:</label>
            <input type="text" id="vehicle_number" name="vehicle_number" required>
            
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="slot_time">Time:</label>
            <input type="time" id="slot_time" name="slot_time" required>

            <input type="hidden" id="station_name" name="station_name" value="<?php echo htmlspecialchars($_GET['station_name']); ?>">
            <input type="hidden" id="station_address" name="station_address" value="<?php echo htmlspecialchars($_GET['station_address']); ?>">

            <input type="submit" value="Book Slot">
        </form>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section">
        <h2>Contact Us</h2>
        <p>If you have any questions or concerns, feel free to reach out.</p>
    </section>

    <script src="app.js"></script>
</body>
</html>