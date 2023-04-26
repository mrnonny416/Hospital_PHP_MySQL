<?php
session_start(); // เรียกใช้ session
$incorrect_password = false;
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}
if (isset($_POST['submit'])) {
    date_default_timezone_set("Asia/Bangkok");
    require('db_connect.php'); // ดึงไฟล์เชื่อมต่อฐานข้อมูล
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ค้นหาข้อมูลผู้ใช้จากฐานข้อมูล
    $sql = "SELECT * FROM members WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    // ถ้าพบข้อมูลผู้ใช้
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username']; // เก็บ session ชื่อผู้ใช้
        $_SESSION['user_level'] = $row['user_level']; // เก็บ session เวลา login

        // เพิ่มประวัติการเข้าสู่ระบบในตาราง login_log
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $login_time = date('Y-m-d H:i:s');
        $login_flag = 0; // สถานะการ login 0=login สำเร็จ
        $sql = "INSERT INTO login_log (username, login_flag, ip_address, last_update) VALUES ('$username', '$login_flag', '$ip_address', '$login_time')";
        mysqli_query($conn, $sql);

        header('Location: dashboard.php'); // ลิ้งค์ไปยังหน้า Dashboard
        exit();
    } else {
        // เพิ่มประวัติการเข้าสู่ระบบไม่สำเร็จในตาราง login_log
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $login_time = date('Y-m-d H:i:s');
        $login_flag = 1; // สถานะการ login 1=login ไม่สำเร็จ
        $sql = "INSERT INTO login_log (username, login_flag, ip_address, last_update) VALUES ('$username', '$login_flag', '$ip_address', '$login_time')";
        mysqli_query($conn, $sql);
        $incorrect_password = true;
        $error_message = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Login Form</h2>
                    </div>
                    <?php if ($incorrect_password) { ?>
                        <div class="alert alert-danger text-center" role="alert">
                            username หรือ password ไม่ถูกต้อง
                        </div>
                    <?php } ?>
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Login</button>
                            <a href="register.php" class="btn btn-link">Register</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>