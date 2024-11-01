<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EV Charging Station Slot Booking</title>
    <style>
        /* Inline CSS */
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; }
        header, footer { background-color: #28a745; color: white; text-align: center; padding: 1rem 0; }
        main { max-width: 900px; margin: 0 auto; padding: 2rem; }
        .station { padding: 1rem; border-bottom: 1px solid #ddd; }
        .station h2 { color: #28a745; }
        .station button { padding: 0.5rem 1rem; background-color: #28a745; color: white; border: none; cursor: pointer; }
        footer { margin-top: 2rem; }
    </style>
</head>
<body>
    <header>
        <h1>EV Charging Station Slot Booking</h1>
        <p>Select a station in Ernakulam and book a slot.</p>
    </header>
    <?php
// Database connection
$host = 'localhost';
$dbname = 'ev_charging';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch available stations
$stations = $pdo->query("SELECT * FROM stations WHERE location = 'Ernakulam'")->fetchAll();

// Book a slot
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['station_id']) && isset($_POST['username'])) {
    $station_id = $_POST['station_id'];
    $username = $_POST['username'];

    // Check slot availability
    $stmt = $pdo->prepare("SELECT slots FROM stations WHERE id = :station_id");
    $stmt->execute(['station_id' => $station_id]);
    $available_slots = $stmt->fetchColumn();

    if ($available_slots > 0) {
        // Insert booking and update slot count
        $pdo->prepare("INSERT INTO bookings (station_id, username, status) VALUES (:station_id, :username, 'Confirmed')")
            ->execute(['station_id' => $station_id, 'username' => $username]);
        
        $pdo->prepare("UPDATE stations SET slots = slots - 1 WHERE id = :station_id")
            ->execute(['station_id' => $station_id]);
        
        echo "<p>Booking confirmed for $username at station $station_id.</p>";
    } else {
        echo "<p>No slots available for the selected station.</p>";
    }
}

// Cancel a booking
if (isset($_GET['cancel_booking_id'])) {
    $booking_id = $_GET['cancel_booking_id'];

    // Retrieve the booking
    $stmt = $pdo->prepare("SELECT station_id FROM bookings WHERE id = :booking_id");
    $stmt->execute(['booking_id' => $booking_id]);
    $station_id = $stmt->fetchColumn();

    if ($station_id) {
        // Update the booking status and restore slot count
        $pdo->prepare("UPDATE bookings SET status = 'Canceled' WHERE id = :booking_id")
            ->execute(['booking_id' => $booking_id]);

        $pdo->prepare("UPDATE stations SET slots = slots + 1 WHERE id = :station_id")
            ->execute(['station_id' => $station_id]);

        echo "<p>Booking canceled successfully.</p>";
    } else {
        echo "<p>Invalid booking ID.</p>";
    }
}

// View all bookings
$all_bookings = $pdo->query("SELECT b.id, s.name as station_name, b.username, b.status 
                             FROM bookings b JOIN stations s ON b.station_id = s.id")
                    ->fetchAll();
?>
    <main>
        <?php foreach ($stations as $station): ?>
            <div class="station">
                <h2><?= htmlspecialchars($station['name']) ?></h2>
                <p>Available Slots: <?= $station['slots'] ?></p>
                <form method="POST">
                    <input type="hidden" name="station_id" value="<?= $station['id'] ?>">
                    <label for="username">Enter your name:</label>
                    <input type="text" name="username" required>
                    <button type="submit">Book Slot</button>
                </form>
            </div>
        <?php endforeach; ?>

        <section>
            <h3>All Bookings</h3>
            <ul>
                <?php foreach ($all_bookings as $booking): ?>
                    <li>
                        <?= htmlspecialchars($booking['username']) ?> - 
                        <?= htmlspecialchars($booking['station_name']) ?> - 
                        <?= htmlspecialchars($booking['status']) ?>
                        <?php if ($booking['status'] == 'Confirmed'): ?>
                            <a href="?cancel_booking_id=<?= $booking['id'] ?>">Cancel</a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 EV Charging Booking. All rights reserved.</p>
    </footer>
</body>
</html>
