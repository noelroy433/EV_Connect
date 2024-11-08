<?php
// Get the location from the URL
$location = isset($_GET['location']) ? $_GET['location'] : 'Kerala';

// Dummy data for charging stations in Kerala
$dummy_stations = [
    ['name' => 'Station A', 'address' => '123 Main St, Kochi, Kerala', 'availability' => 'Available', 'location' => 'Kochi'],
    ['name' => 'Station B', 'address' => '456 Elm St, Thiruvananthapuram, Kerala', 'availability' => 'Available', 'location' => 'Thiruvananthapuram'],
    ['name' => 'Station C', 'address' => '789 Oak St, Kozhikode, Kerala', 'availability' => 'Full', 'location' => 'Kozhikode'],
    ['name' => 'Station D', 'address' => '101 Pine St, Kottayam, Kerala', 'availability' => 'Available', 'location' => 'Kottayam'],
    ['name' => 'Station E', 'address' => '202 Maple St, Thrissur, Kerala', 'availability' => 'Available', 'location' => 'Thrissur'],
];

// Limit the number of stations to display to 5
$stations_to_display = array_slice($dummy_stations, 0, 5);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Charging Stations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <div class="logo">
            <h1>EV Charging Station</h1>
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="#stations">Available Stations</a></li>
            <li><a href="booked_slots.php">Booked Slots</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </nav>

    <section id="stations" class="section">
        <h2>Available Charging Stations</h2>
        <p>Here are the available charging stations near your selected location: <?php echo htmlspecialchars($location); ?></p>
        <div class="station-container">
            <?php if (count($stations_to_display) > 0): ?>
                <?php foreach ($stations_to_display as $station): ?>
                    <div class="station-box">
                        <h3><?php echo htmlspecialchars($station['name']); ?></h3>
                        <p>Address: <?php echo htmlspecialchars($station['address']); ?></p>
                        <p>Availability: <?php echo htmlspecialchars($station['availability']); ?></p>
                        <button onclick="location.href='booking.php?station_name=<?php echo urlencode($station['name']); ?>&station_address=<?php echo urlencode($station['address']); ?>'">Book Slot</button>
                        <button onclick="viewLocation('<?php echo htmlspecialchars($station['location']); ?>')">View Location</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No charging stations found in this location.</p>
            <?php endif; ?>
        </div>
    </section>

    <script>
        function viewLocation(location) {
            alert("Viewing location for " + location);
            // Here you can add logic to show the location on a map or redirect to a map service
        }
    </script>
</body>
</html>