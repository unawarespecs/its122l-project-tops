<?php
   session_start();
   unset($_SESSION["adminUserID"]);
   
   header('Refresh: 2; URL = ../home.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../../css/logout.css">
   <title>Logging out...</title>
</head>
<body class="register">
<div align="center" class="login-container">
		<h1>Logged Out</h1>
        <h4>You have successfully logged out!</h4>
</div>
</body>
</html>