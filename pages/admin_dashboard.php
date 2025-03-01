<?php
require "../config.php";

$username = "";
$email = "";

// preparing sql statement & retrieving user data
if (isset($_SESSION['userID']) && is_numeric($_SESSION['userID'])) {
    if ($stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?")) {

        $stmt->bind_param("i", $_SESSION['userID']);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $username = $row['username'];
                $email = $row['email'];
            }
        } else {
            echo "No user found with the specified ID.";
        }

        $stmt->close();
    } else {
        echo "Failed to prepare the SQL statement.";
    }
} else {
    echo "Invalid or missing user ID.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
</head>

<body>
    <div class="bg-image">

    </div>

    <div class="container">
        <div class="form-section">
            <div class="landing-heading">
                <h3><label for="username">Welcome, <span style="color:#0070f3"><?php echo $username ?>!</label></span>
                </h3>
            </div>
            <h2> We unfortunately do not have content yet, but we're glad you're here!</h2>

            <h3><label for="email">Email: <span
                        style="color:#0070f3;"><?php echo $email ?></label></span></h3>
            <br>
            <br>
            <button type="button" name="log-out" class="generic-button-link" onclick="return confirmLogOut()">Log
                Out</button>

            <script src="../js/scripts.js"></script>
        </div>
        <div class="image-section">
            <img src="https://www.pngplay.com/wp-content/uploads/5/Graphic-Web-Design-Vector-PNG.png"
                alt="Learning illustration">
        </div>
    </div>

</body>

</html>