<?php
session_start();

$host = 'localhost';
$db_username = 'root'; 
$db_password = '';
$database = 'user_registration';

$conn = mysqli_connect($host, $db_username, $db_password, $database, null, '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock');

if (mysqli_connect_errno()) {  
    die('Failed to connect to MySQL: ' . mysqli_connect_error());
}
?>