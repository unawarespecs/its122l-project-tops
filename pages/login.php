<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register Page</title>
    <link rel="stylesheet" href="../css/login.css">
    <script defer src="../js/login_script.js"></script>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form method="POST" action="register_backend.php">
                <input type="text" id="username_register" name="username" placeholder="Enter your username" required>
                <input type="password" id="password_register" name="password" placeholder="Enter your password" required>
                <input type="email" id="email_register" name="email" placeholder="Enter your email" required>

                <input type="submit" value="Sign Up">
            </form>
        </div>
        <div class="form-container sign-in">
            <form method="POST" action="login_backend.php">
                <h1>Sign In</h1>
                <input type="email" id="email_login" name="email" placeholder="Enter your email" required>
                <input type="password" id="password_login" name="password" placeholder="Enter your password" required>

                <input type="submit" value="Login">

            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <?php if (!empty($response)): ?>
                        <div class="response-message">
                            <?php echo htmlspecialchars($response); ?>
                        </div>
                    <?php endif; ?>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <script src="login_script.js"></script>
</body>

</html>