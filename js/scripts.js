/*!
* Start Bootstrap - Landing Page v6.0.5 (https://startbootstrap.com/theme/landing-page)
* Copyright 2013-2022 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-landing-page/blob/master/LICENSE)
*/
// This file is intentionally blank
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
        window.location.href = 'profile.php';
    }
}

function confirmLogOut() {
    const confirm = window.confirm('Are you sure you want to log out?');
    if(confirm) {
        alert("Logging out...");
        window.location.href = 'logout.php';
    }
}