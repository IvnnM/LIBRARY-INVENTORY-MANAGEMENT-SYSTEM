<?php
session_start();

include './connection.php';

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["empid"]) && isset($_POST["email"]) && isset($_POST["password"])) {
    $empid = $_POST["empid"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if the given empid exists in tbempinfo
    $checkEmpIdQuery = "SELECT * FROM tbempinfo WHERE empid = ?";
    $stmtCheckEmpId = $con->prepare($checkEmpIdQuery);
    $stmtCheckEmpId->bind_param("i", $empid);
    $stmtCheckEmpId->execute();
    $resultEmpId = $stmtCheckEmpId->get_result();

    // Check if the empid exists in tb_librarian
    $checkLibrarianQuery = "SELECT * FROM tb_librarian WHERE empid = ?";
    $stmtCheckLibrarian = $con->prepare($checkLibrarianQuery);
    $stmtCheckLibrarian->bind_param("i", $empid);
    $stmtCheckLibrarian->execute();
    $resultLibrarian = $stmtCheckLibrarian->get_result();

    if ($resultEmpId->num_rows > 0) {
        if ($resultLibrarian->num_rows > 0) {
            echo json_encode(["success" => false, "message" => "Invalid id. Employee is already a librarian."]);
        } else {
            // Insert into tb_librarian with hashed password
            $insertLibrarianQuery = "INSERT INTO tb_librarian (empid, email, password) VALUES (?, ?, ?)";
            $stmtInsertLibrarian = $con->prepare($insertLibrarianQuery);
            $stmtInsertLibrarian->bind_param("iss", $empid, $email, $hashedPassword);

            if ($stmtInsertLibrarian->execute()) {
                echo json_encode(["success" => true, "message" => "Librarian account created successfully"]);
            } else {
                echo json_encode(["success" => false, "message" => "Error creating librarian account: " . $stmtInsertLibrarian->error]);
            }
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid id. Employee not found."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}

$con->close();
?>
