<?php
session_start();
require_once "db_connect.php";

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];
$username_select = $_GET['username'];

if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $ref_code = $_POST['ref_code'];
    $ref_remark = $_POST['ref_remark'];
    $remark = $_POST['remark'];
    if ($_SESSION['user_level'] != 0) {
        $user_level_selected = $_SESSION['user_level'];
    } else {
        $user_level_selected = $_POST['user_level'];
        $_SESSION['user_level'] = $user_level_selected;
    }
    date_default_timezone_set("Asia/Bangkok");
    $edit_time = date('Y-m-d H:i:s');
    $query = "UPDATE members SET fname = '$fname', lname = '$lname', email = '$email',tel='$tel',address='$address',ref_code='$ref_code',ref_remark='$ref_remark',remark='$remark' ,last_update = '$edit_time' , user_level='$user_level_selected' WHERE username = '$username_select'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Update successfully'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Update Error'); window.location='index.php';</script>";
    }
}


// show only own data
$query = "SELECT * FROM members WHERE username = '$username_select'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Edit Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <h1>Edit Profile</h1>
    <form method="post" action="" class="col-md-6 mx-auto my-5 p-3 border rounded">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" class="form-control"
                value="<?php echo $user['username']; ?>" disabled>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="text" name="password" id="password" class="form-control"
                value="<?php echo $user['password']; ?>">
        </div>
        <?php if ($_SESSION['user_level'] == 0) { ?>
            <div class="form-group">
                <label for="password">User Level:</label>

                <select name="user_level" id="user_level">
                    <option value="0" <?php if ($user['user_level'] == 0) {
                        echo "selected";
                    } ?>>admin</option>
                    <option value="1" <?php if ($user['user_level'] == 1) {
                        echo "selected";
                    } ?>>staff</option>
                    <option value="2" <?php if ($user['user_level'] == 2) {
                        echo "selected";
                    } ?>>user</option>
                </select>
            </div>
        <?php } ?>

        <div class="form-group">
            <label for="fname">First Name:</label>
            <input type="text" name="fname" id="fname" class="form-control" value="<?php echo $user['fname']; ?>">
        </div>

        <div class="form-group">
            <label for="lname">Last Name:</label>
            <input type="text" name="lname" id="lname" class="form-control" value="<?php echo $user['lname']; ?>">
        </div>

        <div class="form-group">
            <label for="tel">Tel:</label>
            <input type="text" name="tel" id="tel" class="form-control" value="<?php echo $user['tel']; ?>">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo $user['email']; ?>">
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" name="address" id="address" class="form-control" value="<?php echo $user['address']; ?>">
        </div>

        <div class="form-group">
            <label for="ref_code">Ref code:</label>
            <input type="text" name="ref_code" id="ref_code" class="form-control"
                value="<?php echo $user['ref_code']; ?>">
        </div>

        <div class="form-group">
            <label for="ref_remark">Ref remark:</label>
            <input type="text" name="ref_remark" id="ref_remark" class="form-control"
                value="<?php echo $user['ref_remark']; ?>">
        </div>

        <div class="form-group">
            <label for="remark">remark:</label>
            <input type="text" name="remark" id="remark" class="form-control" value="<?php echo $user['remark']; ?>"
                <?php if ($_SESSION['user_level'] == 2) {
                    echo "disabled";
                } ?>>
        </div>

        <div class="d-grid gap-2">
            <input type="submit" name="submit" class="btn btn-primary" value="Update Profile">
        </div>

    </form>

</body>

</html>