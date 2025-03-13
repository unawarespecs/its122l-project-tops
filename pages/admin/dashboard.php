<?php
include "common_sessionid.php";
global $isAuthorized;
global $conn;
global $username;
global $email;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if (!$isAuthorized): ?>
        <title>401 Unauthorized</title>
    <?php else: ?>
        <title>TOPS Admin Dashboard</title>
    <?php endif; ?>
    <link rel="icon" type="image/x-icon" href="../../assets/images/topslogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="../../css/dashboard.css" rel="stylesheet">
    <link href="../../css/dashboard_responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
</head>

<body>
<!-- Admin Authentication Check -->
<?php if (!$isAuthorized): ?>
    <div id="notAuthorized" class="container">
        <h2>You are not authorized to access this page.</h2>
        <p>Please <a href="../admin_login/login.php">sign in</a> to continue.</p>
    </div>

<?php else: ?>
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

            <!-- User List -->
            <div class="users-container">
                <h3>Registered Users</h3>
                <button data-bs-toggle="modal" class="btn btn-success" data-bs-target="#addAdminModal"><i
                            class="fas fa-plus"></i> Add New User
                </button>
                <br/>
                <br/>
                <div class="user-table-container">
                    <table id="users_table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody id="userTableBody">
                        <?php
                        $query = "SELECT * FROM users ORDER BY id";
                        $query_run = mysqli_query($conn, $query);

                        if(mysqli_num_rows($query_run) > 0)
                        {
                            foreach($query_run as $user)
                            {
                                ?>
                                <tr>
                                    <td><?= $user['id'] ?></td>
                                    <td><?= $user['username'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td>
                                        <button type="button" value="<?=$user['id'];?>" class="editUserBtn btn btn-success btn-sm">Edit</button>
                                        <button type="button" value="<?=$user['id'];?>" class="deleteUserBtn btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Add Modal HTML -->
            <div id="addAdminModal" tabindex="-1" aria-hidden="true" class="modal fade">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form id="user_form" method="POST" action="register_backend.php">
                            <div class="modal-header">
                                <h4 class="modal-title">Add User</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-3">
                                    <label for="username" class="form-label">User Name</label>
                                    <input type="text" id="username" name="username" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" value="1" name="type">
                                <input type="button" class="btn btn-secondary" data-bs-dismiss="modal" value="Cancel">
                                <button type="submit" class="btn btn-success" id="addUser">Add User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Edit Modal HTML -->
            <div id="editAdminModal" class="modal fade" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit User</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <form id="update_form">
                            <div class="modal-body">
                                <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>
                                <input type="hidden" name="user_id" id="user_id" >
                                <div class="mb-3">
                                    <label for="">User Name</label>
                                    <input type="text" name="name" id="name" class="form-control" />
                                </div>
                                <div class="mb-3">
                                    <label for="">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../js/ajax.js"></script>
<script src="../../js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>

</body>
</html>