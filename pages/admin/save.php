<?php
include '../../config_admin.php';
global $conn;

// edit user
if (count($_POST) > 0) {
    if ($_POST['type'] == 2) {
        // Check for required fields
        if (empty($_POST['id']) || empty($_POST['username']) || empty($_POST['email'])) {
            echo json_encode(array("statusCode" => 400, "message" => "All fields are required"));
            exit;
        }

        // Sanitize inputs to avoid SQL syntax errors
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        // Ensure `id` is numeric for security reasons
        if (!is_numeric($id)) {
            echo json_encode(array("statusCode" => 400, "message" => "Invalid user ID"));
            exit;
        }

        // Use a prepared statement to construct the query
        $sql = "UPDATE `users` SET `username` = ?, `email` = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            // Bind parameters to the prepared statement (string, string, integer types)
            mysqli_stmt_bind_param($stmt, "ssi", $username, $email, $id);

            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(array("statusCode" => 200, "message" => "User updated successfully"));
            } else {
                echo json_encode(array("statusCode" => 500, "message" => "Database query failed: " . mysqli_error($conn)));
            }

            // Close the prepared statement
            mysqli_stmt_close($stmt);
        } else {
            echo json_encode(array("statusCode" => 500, "message" => "Failed to prepare SQL statement: " . mysqli_error($conn)));
        }
    }
}


// delete user
if (count($_POST) > 0) {
    if ($_POST['type'] == 3) {
        $id = $_POST['id'];
        $sql = "DELETE FROM `users` WHERE id=$id";
        if (mysqli_query($conn, $sql)) {
            echo $id;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

// delete multiple users
if (count($_POST) > 0) {
    if ($_POST['type'] == 4) {
        $id = $_POST['id'];
        $sql = "DELETE FROM users WHERE id in ($id)";
        if (mysqli_query($conn, $sql)) {
            echo $id;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}