<?php
include_once '../../config_announcements.php';

global $conn_announcements;
$conn = $conn_announcements;

$timezone = date_default_timezone_set('Asia/Manila');
$date_global = date('Y-m-d H:i:s');

try {
    if (isset($_POST['submit'])) {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $announcement_content = mysqli_real_escape_string($conn, $_POST['announcement_content']);
        $date = mysqli_real_escape_string($conn, $date_global);
        $author = mysqli_real_escape_string($conn, $_POST['author']);
        $category = mysqli_real_escape_string($conn, $_POST['category']);

        // Insert user data into table
        $result = mysqli_query($conn, "INSERT INTO announcements (title, content, publication_date, author, category) 
    VALUES('$title', '$announcement_content', '$date', '$author','$category')");

        // Auto redirect to announcement management page.
        header("Location: manage_announcements.php");
    }
} catch (Exception $e) {
    echo $e->getMessage();
    $response = "Error: " . $e->getMessage(); // Capture any SOAP or system error
}


?>