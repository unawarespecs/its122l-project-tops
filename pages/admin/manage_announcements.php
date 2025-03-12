<?php
include "common_sessionid.php";
include_once "../../config_announcements.php";
global $isAuthorized;
global $conn;
global $conn_announcements;
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
        <title>Manage Announcements</title>
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

            <a href="dashboard.php" class="menu-item">
                <i class="fas fa-users"></i> Users
            </a>
            <a href="#" class="menu-item active">
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
                <h2>Manage Announcements</h2>
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
            <!-- Add Modal HTML -->
            <div id="addAnnounceModal" tabindex="-1" aria-hidden="true" class="modal fade">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form id="user_form" method="POST" action="announcement_backend.php">
                            <div class="modal-header">
                                <h4 class="modal-title">Post New Announcement</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" id="title" name="title" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="content" class="form-label">Announcement Text</label>
                                    <textarea id="content" name="announcement_content" class="form-control" required></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="author" class="form-label">Author</label>
                                    <input type="text" id="author" name="author" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <input type="text" id="category" name="category" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-secondary" data-bs-dismiss="modal" value="Cancel">
                                <button type="submit" class="btn btn-success" name="submit" id="addAnnouncement">Post Announcement</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="users-container">
                <h3>List of Announcements</h3>
                <button data-bs-toggle="modal" class="btn btn-success" data-bs-target="#addAnnounceModal"><i
                            class="fas fa-plus"></i> Add Announcement
                </button>
                <br/>
                <br/>
                <div class="user-table-container">
                    <table>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Date</th>
                            <th>Author</th>
                            <th>Category</th>
                        </tr>
                        </thead>
                        <tbody id="userTableBody">
                        <?php
                        $result = mysqli_query($conn_announcements, "SELECT * FROM announcements ORDER BY id DESC");
                        $i = 1;
                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                            <tr>
                                <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $row["title"]; ?></td>
                                <td><?php echo $row["content"]; ?></td>
                                <td><?php echo $row["publication_date"]; ?></td>
                                <td><?php echo $row["author"]; ?></td>
                                <td><?php echo $row["category"]; ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Alerts -->
            <div id="successAlert" class="alert alert-success">
                Operation completed successfully!
            </div>

            <div id="errorAlert" class="alert alert-danger">
                An error occurred. Please try again.
            </div>
        </div>
    </div>

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