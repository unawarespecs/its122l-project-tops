<?php
require "../../config_admin.php";

$username = "";
$email = "";

// preparing sql statement & retrieving user data
if (isset($_SESSION['adminUserID']) && is_numeric($_SESSION['adminUserID'])) {
    if ($stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?")) {

        $stmt->bind_param("i", $_SESSION['adminUserID']);

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

$result = mysqli_query($conn, "SELECT * FROM users ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOPS Admin Dashboard</title>
    <link rel="icon" type="image/x-icon" href="../../assets/images/topslogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="../../css/dashboard.css" rel="stylesheet">
    <link href="../../css/dashboard_responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!-- Admin Authentication Check -->
    <div id="authCheck" style="display: none;">
        <div style="text-align: center; padding: 50px;">
            <h2>You are not authorized to access this page.</h2>
            <p>Please <a href="../admin_login/login.php">login</a> to continue.</p>
        </div>
    </div>

    <div id="adminPanel">
        <!-- Sidebar Navigation -->
        <div class="admin-sidebar">
            <a class="navbar-brand" href="../home.php">
                <img src="../../assets/images/topslogo.png" alt="TOPS Logo">
                <span>TOPS Admin</span>
            </a>

            <a href="#" class="menu-item active">
                <i class="fas fa-users"></i> Users
            </a>
            <a href="manage_announcements.php" class="menu-item">
                <i class="fas fa-bullhorn"></i> Announcements
            </a>
            <a href="manage_donations.php" class="menu-item">
                <i class="fas fa-circle-dollar-to-slot"></i> Donations
            </a>
            <a href="manage_schedule.php" class="menu-item">
                <i class="fas fa-calendar-days"></i> Schedule
            </a>

        </div>

        <!-- Main Content Area -->
        <div class="admin-content">
            <!-- Header -->
            <div class="admin-header">
                <h2>User Management</h2>
                <div class="admin-profile">
                    <div class="profile-info">
                        <div class="name"><?php echo $username ?></div>
                        <div class="role"><?php echo $email ?></div>
                    </div>
                    <button id="logoutBtn" class="logout-btn" onclick="return confirmLogOutAdmin()">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </div>
            </div>

            <!-- Alerts -->
            <div id="successAlert" class="alert alert-success">
                Operation completed successfully!
            </div>

            <div id="errorAlert" class="alert alert-danger">
                An error occurred. Please try again.
            </div>

            <!-- Stats -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon blue-bg">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h4 id="totalUsers">
                            <?php
                            $totalUsersQuery = "SELECT COUNT(*) AS total_users FROM users";
                            $totalUsersResult = mysqli_query($conn, $totalUsersQuery);
                            $totalUsersRow = mysqli_fetch_assoc($totalUsersResult);
                            echo $totalUsers = $totalUsersRow['total_users'];
                            ?>
                        </h4>
                        <p>Total Users</p>
                    </div>
                </div>
            </div>

            <div class="users-container">
                <h3>Add New User</h3>
                <form id="userForm" class="users-form-container" method="POST" action="register_backend.php">
                    <input type="text" id="username" name="username" placeholder="User Name" required>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                    <button type="submit">
                        <i class="fas fa-plus"></i> Add User
                    </button>
                </form>
            </div>

            <!-- User List -->
            <div class="users-container">
                <h3>Registered Users</h3>
                <div class="user-table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody">
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['username'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="../../js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>

</body>

</html>