<?php
session_start();
require_once "db_connect.php";

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}



if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];

$query = "SELECT * FROM members WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

$user_level = $user['user_level'];

if ($user_level == 0) {
    // show all users' data
    $query = "SELECT * FROM members";
    $result = mysqli_query($conn, $query);

    echo "<table>";
    echo "<tr><th>Name</th><th>User Level</th><th>Action</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>{$row['username']}</td><td>{$row['user_level']}</td><td><a href='edit.php?username={$row['username']}'>Edit</a> | <a href='delete.php?username={$row['username']}' onClick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a></td></tr>";
    }

    echo "</table>";
} else if ($user_level == 1) {
    // show level 1 and 2 users' data
    $query = "SELECT * FROM members WHERE user_level IN (1, 2)";
    $result = mysqli_query($conn, $query);

    echo "<table>";
    echo "<tr><th>Name</th><th>User Level</th><th>Action</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>{$row['username']}</td><td>{$row['user_level']}</td><td><a href='edit.php?username={$row['username']}'>Edit</a> | <a href='delete.php?username={$row['username']}' onClick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a></td></tr>";
    }

    echo "</table>";
} else {
    // show only own data
    echo "<table>";
    echo "<tr><th>Name</th><th>User Level</th><th>Action</th></tr>";

    echo "<tr><td>{$user['username']}</td><td>{$user['user_level']}</td><td><a href='edit.php?username={$user['username']}'>Edit</a> | <a href='delete.php?username={$user['username']}' onClick=\"return confirm('Are you sure you want to delete your account?');\">Delete</a></td></tr>";

    echo "</table>";
}

// add logout button
echo "<form method='post' >
<button type='submit' name='logout'>Logout</button>
</form>";
