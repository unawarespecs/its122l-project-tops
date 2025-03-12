<?php
$host = 'localhost';
$db_username = 'root'; 
$db_password = '';
$database = 'announcements';

$conn_announcements = mysqli_connect($host, $db_username, $db_password, $database, null);


if (mysqli_connect_errno()) {  
    die('Failed to connect to MySQL: ' . mysqli_connect_error());
}
?>