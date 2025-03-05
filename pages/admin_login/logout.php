<?php
   session_start();
   unset($_SESSION["adminUserID"]);
   
   header('Refresh: 2; URL = logout_redirect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../../css/logout.css">
   <title>Logging out...</title>
</head>
<body>
<div class="login-container">
		<h1>Logging out...</h1>
      <br/>
      <div class="progress-bar">
         <span></span>
      </div>
</div>
</body>
</html>