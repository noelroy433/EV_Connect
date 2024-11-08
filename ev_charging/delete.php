<?php
// Include the database connection file
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the booking from the database
    $sql = "DELETE FROM bookings WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: booked_slots.php?message=Slot deleted successfully");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>