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
        <li><a href="available_stations.php">Available Stations</a></li>
        <li><a href="booked_slots.php">Booked Slots</a></li>
        <li><a href="#contact">Contact</a></li>
    </ul>
</nav>

<!-- Home Section -->
<section id="home" class="home-section">
    <div class="home-content">
        <h2>Welcome to the EV Charging Station</h2>
        <p>Your one-stop solution for booking EV charging slots.</p>
        
        <div class="input-group">
            <label for="location">Choose Your Location:</label>
            <input type="text" id="location" placeholder="Enter your location" />
            <button id="search-button" onclick="showStations()">Search</button>
        </div>

        <div class="input-group">
            <label for="additional-location">Search for Charging Stations:</label>
            <input type="text" id="additional-location" placeholder="Enter location for stations" />
            <button id="additional-search-button" onclick="searchStations()">Search Stations</button>
        </div>
    </div>
</section>

<!-- Available Stations Section -->
<section id="available-stations" class="available-stations-section">
    <h2>Available Stations</h2>
    <div class="station-container">
        <?php
        // Dummy data for available stations
        $dummy_stations = [
            ['name' => 'Station A', 'address' => '123 Main St, Kochi, Kerala', 'availability' => 'Available'],
            ['name' => 'Station B', 'address' => '456 Elm St, Thiruvananthapuram, Kerala', 'availability' => 'Available'],
            ['name' => 'Station C', 'address' => '789 Oak St, Kozhikode, Kerala', 'availability' => 'Full'],
            ['name' => 'Station D', 'address' => '101 Pine St, Kottayam, Kerala', 'availability' => 'Available'],
            ['name' => 'Station E', 'address' => '202 Maple St, Thrissur, Kerala', 'availability' => 'Available'],
        ];

        // Display the dummy data
        foreach ($dummy_stations as $station) {
            echo "<div class='station-box'>";
            echo "<h3>" . htmlspecialchars($station['name']) . "</h3>";
            echo "<p>Address: " . htmlspecialchars($station['address']) . "</p>";
            echo "<p>Availability: " . htmlspecialchars($station['availability']) . "</p>";
            echo "<button onclick=\"location.href='booking.php?station_name=" . urlencode($station['name']) . "&station_address=" . urlencode($station['address']) . "'\">Book Slot</button>";
            echo "<button onclick=\"viewLocation('" . htmlspecialchars($station['address']) . "')\">View Location</button>";
            echo "</div>";
        }
        ?>
    </div>
</section>

<!-- Contact Information Section -->
<section id="contact" class="contact-section">
    <h2>Contact Information</h2>
    <div class="contact-box">
        <p>If you have any questions or need assistance, feel free to reach out to us:</p>
        <p>Email: info@evchargingstation.com</p>
        <p>Phone: +1 (234) 567-8901</p>
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
        function showStations() {
            const location = document.getElementById('location').value;
            if (location) {
                // Redirect to the available charging stations page with the entered location
                window.location.href = `available_stations.php?location=${encodeURIComponent(location)}`;
            } else {
                alert("Please enter a location.");
            }
        }

        function searchStations() {
            const additionalLocation = document.getElementById('additional-location').value;
            if (additionalLocation) {
                // Redirect to the available charging stations page with the additional location
                window.location.href = `search_results.php?location=${encodeURIComponent(additionalLocation)}`;
            } else {
                alert("Please enter a location for stations.");
            }
        }

        function viewLocation(address) {
            alert("Viewing location for " + address);
            // Here you can add logic to show the location on a map or redirect to a map service
        }
    </script>
</body>
</html>