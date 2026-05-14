<?php
include 'auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Hotel Booking System'; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar">
    <div class="container">
        <div class="nav-content">
            <div class="logo">
                <a href="index.php"><i class="fas fa-hotel"></i> LuxeStay</a>
            </div>
            <div class="nav-menu" id="navMenu">
                <a href="index.php">Home</a>
                <a href="rooms.php">Rooms</a>
                <a href="about.php">About</a>
                <a href="contact.php">Contact</a>
                <?php if (isLoggedIn()): ?>
                    <a href="profile.php">Profile</a>
                    <?php if (isAdmin()): ?>
                        <a href="admin/dashboard.php">Admin</a>
                    <?php endif; ?>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a href="register.php">Register</a>
                <?php endif; ?>
            </div>
            <div class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</nav>
