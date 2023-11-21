<?php
session_start(); // Start the session if not already started

include './connection.php'; // Include your database connection

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["userID"]) && isset($_POST["newRole"])) {
    $userID = $_POST["userID"];
    $newRole = $_POST["newRole"];

    
    // Debugging: Output received values
    echo "Received userID: " . $userID . "<br>";
    echo "Received newRole: " . $newRole . "<br>";

    // Perform the update in the database
    $sql = "UPDATE users SET role = ? WHERE userID = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("si", $newRole, $userID);

    if ($stmt->execute()) {
        echo "Role updated successfully!";
    } else {
        echo "Error updating role: " . $stmt->error;
    }
    exit();
} else {
    echo "Invalid request!";
}

$con->close(); // Close the database connection
?>
