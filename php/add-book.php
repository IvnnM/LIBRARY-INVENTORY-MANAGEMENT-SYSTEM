<?php
session_start();

include './connection.php';

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["title"]) && isset($_POST["author"]) && isset($_POST["genre"]) && isset($_POST["isbn"]) && isset($_POST["description"]) && isset($_POST["quantity"])) {
    $title = $_POST["title"];
    $author = $_POST["author"];
    $genre = $_POST["genre"];
    $isbn = $_POST["isbn"];
    $description = $_POST["description"];
    $quantity = $_POST["quantity"];

    // Perform the insert into the database with CURRENT_TIMESTAMP for publication_date
    $sql = "INSERT INTO books (title, author, genre, isbn, description, quantity, publication_date) VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sssssi", $title, $author, $genre, $isbn, $description, $quantity);

    if ($stmt->execute()) {
        echo "Book added successfully!";
    } else {
        echo "Error adding book: " . $stmt->error;
    }
    exit();
} else {
    echo "Invalid request!";
}

$con->close(); // Close the database connection
?>
