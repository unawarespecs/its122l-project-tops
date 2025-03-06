<?php

require "../../config_admin.php";

global $conn;
$username = "";
$email = "";

$isAuthorized = false;

// preparing sql statement & retrieving user data
if (isset($_SESSION['adminUserID']) && is_numeric($_SESSION['adminUserID'])) {
    if ($stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?")) {

        $stmt->bind_param("i", $_SESSION['adminUserID']);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $isAuthorized = true;
            while ($row = $result->fetch_assoc()) {
                $username = $row['username'];
                $email = $row['email'];
            }
        }
        $stmt->close();
        $result = mysqli_query($conn, "SELECT * FROM users ORDER BY id");
    }
}