<?php

include './connection.php';

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use a prepared statement to avoid SQL injection
    $sql = "SELECT * FROM `users` WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user["password"])) {
                
                $role = $user["role"];
                session_start();
                session_regenerate_id();
                $_SESSION["user_id"] = $user["userID"];
                if ($role === "Admin") {
                    $message = 'Successfully logged in as a Admin.';
                    $response = array(
                        "status" => "success",
                        "message" => $message,
                        "role" => $role
                    );
                } else if ($role === "Client") {
                    $message = 'You are not authorized to access the Admin panel.';
                    $response = array(
                        "status" => "error",
                        "message" => $message,
                        "role" => $role
                    );
                } else if ($role === "Librarian") {
                    $message = 'You are not authorized to access the Admin panel.';
                    $response = array(
                        "status" => "error",
                        "message" => $message,
                        "role" => $role 
                    );
                }
                $json_response = json_encode($response);
                echo $json_response;

            } else {
                $message = 'Please double-check your password and try again.';
                $response = array(
                    "status" => "warning",
                    "message" => $message
                );
            
                $json_response = json_encode($response);
                echo $json_response;
            }
            
        } else {
            $message = "Invalid email";
            $response = array(
                "status" => "error",
                "message" => $message
            );

            $json_response = json_encode($response);
            echo $json_response;
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "SQL statement preparation error: " . mysqli_error($con);
    }
}
?>
