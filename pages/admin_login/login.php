<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register Page</title>
    <link rel="stylesheet" href="../../css/login.css">
    <link rel="icon" type="image/x-icon" href="../../assets/images/topslogo.png">
    <script defer src="../../js/login_script.js"></script>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form method="POST" action="register_backend.php">
                <label for="username"></label><input type="text" id="username" name="username" placeholder="Enter your username" required>
                <label for="password"></label><input type="password" id="password" name="password" placeholder="Enter your password" required>
                <label for="email"></label><input type="email" id="email" name="email" placeholder="Enter your email" required>

                <input type="submit" value="Sign Up">
            </form>
        </div>
        <div class="form-container sign-in">
            <form method="POST" action="login_backend.php">
                <h1>Sign In</h1>
                <?php if (!empty($_GET['error'])): ?>
                    <br/>
                    <div class="response-message" style="color: red;">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php endif; ?>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>

                <input type="submit" value="Login">
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Hello, Friend!</h1>
                    <p>Register to gain access to the administrator dashboard. </p>
                    <button class="hidden" id="login">Have an account? Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Welcome Back to the TOPS Admin Dashboard!</h1>
                    <p>Sign in with your admin credentials.</p>
                    <button class="hidden" id="register">No account? Sign Up</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>