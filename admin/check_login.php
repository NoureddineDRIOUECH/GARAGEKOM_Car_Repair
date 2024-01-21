<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Ensure that only admins have access to the dashboard
if ($_SESSION['user']->role !== "admin") {
    header("Location: login.php");
    exit();
}
