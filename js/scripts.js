// Use this file to add JavaScript to your project
function confirmViewUsers() {
    const confirm = window.confirm('Are you sure you want to leave this page?');
    if(confirm) {
        alert("Leaving page...");
        window.location.href = 'users.php';
    }
}

function confirmViewProfile() {
    const confirm = window.confirm('Are you sure you want to leave this page?');
    if(confirm) {
        alert("Leaving page...");
        window.location.href = 'dashboard.php';
    }
}

function confirmLogOut() {
    const confirm = window.confirm('Are you sure you want to log out?');
    if(confirm) {
        alert("Logging out...");
        window.location.href = '../user_login/logout.php';
    }
}

function confirmLogOutAdmin() {
    const confirm = window.confirm('Are you sure you want to log out?');
    if(confirm) {
        alert("Logging out...");
        window.location.href = '../admin_login/logout.php';
    }
}