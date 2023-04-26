<?php
session_start(); // เรียกใช้ session

if (isset($_POST['submit'])) {
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
        $_SESSION['login_time'] = time(); // เก็บ session เวลา login

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

        $error_message = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>
    <h2>Login Form</h2>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" name="submit" value="Login">
    </form>
</body>

</html>