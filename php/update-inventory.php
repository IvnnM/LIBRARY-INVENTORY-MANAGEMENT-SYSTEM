<?php
session_start();

include './connection.php';

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the necessary POST data is set
    if (isset($_POST["action"]) && isset($_POST["bookID"]) && isset($_POST["quantity"])) {
        $action = $_POST["action"];
        $bookID = $_POST["bookID"];
        $quantity = intval($_POST["quantity"]);

        // Check if the action is "OUT" and the requested quantity exceeds the available quantity
        if ($action === "OUT") {
            $availableQuantity = mysqli_fetch_assoc(mysqli_query($con, "SELECT quantity FROM books WHERE bookID = $bookID"))["quantity"];
            if ($quantity > $availableQuantity) {
                echo json_encode(["success" => false, "message" => "Requested OUT quantity exceeds available quantity"]);
                exit;
            }
        }

        // Define your SQL query to update the inventory based on the action
        if ($action === "IN") {
            $sql = "UPDATE books SET quantity = quantity + ? WHERE bookID = ?";
        } elseif ($action === "OUT") {
            $sql = "UPDATE books SET quantity = GREATEST(quantity - ?, 0) WHERE bookID = ?";
        } else {
            echo json_encode(["success" => false, "message" => "Invalid action"]);
            exit;
        }

        // Prepare and execute the SQL query to update the books table
        if ($stmt = $con->prepare($sql)) {
            $stmt->bind_param("ii", $quantity, $bookID);

            if ($stmt->execute()) {
                // Retrieve the updated quantity from the database
                $updatedQuantity = mysqli_fetch_assoc(mysqli_query($con, "SELECT quantity FROM books WHERE bookID = $bookID"))["quantity"];

                // Insert a record into the 'book_transactions' table
                $userID = $_SESSION["user_id"];
                $date = date("Y-m-d H:i:s");

                // Prepare and execute the SQL query to insert into the book_transactions table
                $insertBookTransactionSQL = "INSERT INTO book_transactions (userID, bookID, inQuantity, outQuantity, date) VALUES (?, ?, ?, ?, ?)";

                if ($stmt2 = $con->prepare($insertBookTransactionSQL)) {
                    $inQuantity = ($action === "IN") ? $quantity : 0;
                    $outQuantity = ($action === "OUT") ? $quantity : 0;
                    $stmt2->bind_param("iiiss", $userID, $bookID, $inQuantity, $outQuantity, $date);

                    if ($stmt2->execute()) {
                        // Get the last inserted transactionID
                        $transactionID = $stmt2->insert_id;

                        // Prepare a response in JSON format
                        $response = [
                            "success" => true,
                            "message" => "Inventory updated successfully",
                            "newQuantity" => $updatedQuantity,
                            "transactionID" => $transactionID, // Include the transactionID in the response
                        ];

                        // Send the JSON response
                        header('Content-Type: application/json');
                        echo json_encode($response);
                    } else {
                        echo json_encode(["success" => false, "message" => "An error occurred while inserting into 'book_transactions' table: " . $stmt2->error]);
                    }
                } else {
                    echo json_encode(["success" => false, "message" => "An error occurred while preparing the 'book_transactions' insert statement: " . $stmt2->error]);
                }
            } else {
                echo json_encode(["success" => false, "message" => "An error occurred while updating inventory: " . $stmt->error]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "An error occurred while preparing the 'update books' statement: " . $con->error]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Missing required POST data"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}

$con->close();
?>
