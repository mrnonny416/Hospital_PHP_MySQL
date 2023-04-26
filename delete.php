<?php
session_start();
require_once "db_connect.php";

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if ($_SESSION['user_level'] == 2) {
    header("Location: dashboard.php");
    exit;
}

if (isset($_GET['username'])) {
    $username = $_GET['username'];

    // Query to delete user data
    $query = "DELETE FROM members WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // User data deleted successfully
        if ($_SESSION['username'] == $username) {
            session_unset();
            session_destroy();
            header("Location: index.php");
        } else {
            echo "<script>alert('User data deleted successfully.'); window.location='dashboard.php';</script>";
        }
        exit;
    } else {
        // Error occurred while deleting user data
        echo "<script>alert('Error occurred while deleting user data.'); window.location='dashboard.php';</script>";
        exit;
    }
} else {
    header("Location: dashboard.php");
    exit;
}