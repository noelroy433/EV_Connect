<?php
// Include the database connection file
include 'db_connection.php';

// Get the search query from the URL
$search_query = isset($_GET['location']) ? $_GET['location'] : '';

// Dummy data for available stations (you can replace this with a database query)
$dummy_stations = [
    ['name' => 'Station A', 'address' => '123 Main St, Kochi, Kerala', 'availability' => 'Available'],
    ['name' => 'Station B', 'address' => '456 Elm St, Thiruvananthapuram, Kerala', 'availability' => 'Available'],
    ['name' => 'Station C', 'address' => '789 Oak St, Kozhikode, Kerala', 'availability' => 'Full'],
    ['name' => 'Station D', 'address' => '101 Pine St, Kottayam, Kerala', 'availability' => 'Available'],
    ['name' => 'Station E', 'address' => '202 Maple St, Thrissur, Kerala', 'availability' => 'Available'],
];

// Filter stations based on the search query (case-insensitive)
$filtered_stations = array_filter($dummy_stations, function($station) use ($search_query) {
    return stripos($station['name'], $search_query) !== false || stripos($station['address'], $search_query) !== false;
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
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

    <!-- Search Results Section -->
    <section id="search-results" class="available-stations-section">
        <h2>Search Results for "<?php echo htmlspecialchars($search_query); ?>"</h2>
        <div class="station-container">
            <?php if (count($filtered_stations) > 0): ?>
                <?php foreach ($filtered_stations as $station): ?>
                    <div class="station-box">
                        <h3><?php echo htmlspecialchars($station['name']); ?></h3>
                        <p>Address: <?php echo htmlspecialchars($station['address']); ?></p>
                        <p>Availability: <?php echo htmlspecialchars($station['availability']); ?></p>
                        <button onclick="location.href='booking.php?station_name=<?php echo urlencode($station['name']); ?>&station_address=<?php echo urlencode($station['address']); ?>'">Book Slot</button>
                        <button onclick="viewLocation('<?php echo htmlspecialchars($station['address']); ?>')">View Location</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No charging stations found matching your search.</p>
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

    <script>
        function viewLocation(address) {
            alert("Viewing location for " + address);
            // Here you can add logic to show the location on a map or redirect to a map service
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>