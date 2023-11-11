<?php
// Include your database connection script
include './connection.php';

// Check if the user ID parameter is provided in the URL
if (isset($_GET['id'])) {
    // Get the user ID from the URL
    $userID = $_GET['id'];

    // Define your SQL query to retrieve the user's email
    $sql = "SELECT email FROM users WHERE userID = $userID";

    // Perform the database query
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the email from the query result
        $row = $result->fetch_assoc();
        $email = $row['email'];

        // Prepare a JSON response
        $response = ["email" => $email];

        // Send the JSON response with the email
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // User not found, return an error JSON response
        header('HTTP/1.1 404 Not Found');
        echo json_encode(["error" => "User not found"]);
    }
} else {
    // User ID parameter not provided, return an error JSON response
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(["error" => "Missing user ID"]);
}

// Close the database connection
$con->close();
?>
