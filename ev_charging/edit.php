<?php
// Include the database connection file
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $vehicle_number = $_POST['vehicle_number'];
    $date = $_POST['date'];
    $slot_time = $_POST['slot_time'];

    // Update the booking in the database
    $sql = "UPDATE bookings SET name='$name', vehicle_number='$vehicle_number', date='$date', slot_time='$slot_time' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: booked_slots.php?message=Slot updated successfully");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch the booking details for the given ID
$id = $_GET['id'];
$sql = "SELECT * FROM bookings WHERE id='$id'";
$result = $conn->query($sql);
$booking = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Edit Booking</h2>
    <form action="edit.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $booking['id']; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($booking['name']); ?>" required>
        
        <label for="vehicle_number">Vehicle Number:</label>
        <input type="text" id="vehicle_number" name="vehicle_number" value="<?php echo htmlspecialchars($booking['vehicle_number']); ?>" required>
        
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($booking['date']); ?>" required>

        <label for="slot_time">Time:</label>
        <input type="time" id="slot_time" name="slot_time" value="<?php echo htmlspecialchars($booking['slot_time']); ?>" required>

        <input type="submit" value="Update Slot">
    </form>
</body>
</html>

<?php
$conn->close();
?>