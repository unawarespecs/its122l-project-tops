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
                <button onclick="void(0);" class="btn btn-danger" id="delete_multiple"><i class="fas fa-trash-can"></i>
                    Delete Selected Users
                </button>
                <br/>
                <br/>
                <div class="user-table-container">
                    <table>
                        <thead>
                        <tr>
                            <th>
							<span class="custom-checkbox">
								<input type="checkbox" id="selectAll">
								<label for="selectAll"></label>
							</span>
                            </th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody id="userTableBody">
                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM users ORDER BY id");
                        $i = 1;
                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                            <tr id="<?php echo $row["id"]; ?>">
                                <td>
							<span class="custom-checkbox">
								<input type="checkbox" class="user_checkbox" id="checkbox2" data-user-id="<?php echo $row["id"]; ?>">
								<label for="checkbox2"></label>
							</span>
                                </td>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row["username"]; ?></td>
                                <td><?php echo $row["email"]; ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editAdminModal">Edit
                                    </button>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#deleteAdminModal">Delete
                                    </button>
                                </td>
                            </tr>
                            <?php
                            $i++;
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
                        <form id="update_form">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit User</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="id_edit" name="id" class="form-control" required>
                                <div class="form-group mb-3">
                                    <label for="username_edit" class="form-label">Username</label>
                                    <input type="text" id="username_edit" name="username" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email_edit" class="form-label">Email</label>
                                    <input type="email" id="email_edit" name="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" value="2" name="type">
                                <input type="button" class="btn btn-secondary" data-bs-dismiss="modal" value="Cancel">
                                <button type="button" class="btn btn-primary" id="updateUser">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Delete Modal HTML -->
            <div id="deleteAdminModal" class="modal fade">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form>

                            <div class="modal-header">
                                <h4 class="modal-title">Delete User</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="id_d" name="id" class="form-control">
                                <p>Are you sure you want to delete this user?</p>
                                <h5 class="text-warning"><small>This action cannot be undone.</small></h5>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-secondary" data-bs-dismiss="modal" value="Cancel">
                                <button type="button" class="btn btn-primary" id="deleteUser">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('delete_multiple').addEventListener('click', function () {
            alert('Not implemented');
        });

        document.getElementById('updateUser').addEventListener('click', function () {
            alert('Not implemented');
        });

        document.getElementById('deleteUser').addEventListener('click', function () {
            alert('Not implemented');
        });
    </script>
<?php endif; ?>
<script src="../../js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>

</body>
</html>