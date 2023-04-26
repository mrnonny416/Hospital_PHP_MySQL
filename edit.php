<?php
session_start();
require_once "db_connect.php";

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];

if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];

    $query = "UPDATE members SET fname = '$fname', lname = '$lname', email = '$email' WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Profile updated successfully.";
    } else {
        echo "Error updating profile.";
    }
}


// show only own data
$query = "SELECT * FROM members WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Edit Profile</title>
</head>

<body>
    <h1>Edit Profile</h1>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?php echo $user['username']; ?>">

        <label for="fname">First Name:</label>
        <input type="text" name="fname" id="fname" value="<?php echo $user['fname']; ?>">

        <label for="lname">Last Name:</label>
        <input type="text" name="lname" id="lname" value="<?php echo $user['lname']; ?>">

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $user['email']; ?>">

        <input type="submit" name="submit" value="Update Profile">
    </form>
</body>

</html>