<?php
// เรียกใช้งานไฟล์ db_connect.php เพื่อเชื่อมต่อฐานข้อมูล
require_once 'db_connect.php';

// ตรวจสอบว่ามีการส่งข้อมูลฟอร์มเข้ามาหรือไม่
if (isset($_POST['submit'])) {
    // รับค่าจากฟอร์ม
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];


    // ตรวจสอบว่ามี email นี้อยู่ในฐานข้อมูลแล้วหรือไม่
    $sql = "SELECT * FROM members WHERE username='$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // ถ้ามีอยู่แล้วให้แจ้งเตือนและหยุดการทำงาน
        echo "Username already exists";
        exit();
    } else {
        // ถ้าไม่มีให้ทำการเพิ่มข้อมูลเข้าไปในฐานข้อมูล
        $sql = "INSERT INTO members (username,password,user_level,fname, lname, tel, email) VALUES ('$username','$password',2,'$firstname', '$lastname', '$phone', '$email')";
        if ($conn->query($sql) === TRUE) {
            // เมื่อเพิ่มข้อมูลสำเร็จให้แจ้งเตือนและกลับไปยังหน้าแรก
            echo "New record created successfully";
            header('Location: index.php');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
</head>

<body>
    <h2>Register</h2>
    <form method="post">
        <label>UserName:</label>
        <input type="text" name="username" required><br><br>
        <label>Password:</label>
        <input type="text" name="password" required><br><br>
        <label>First Name:</label>
        <input type="text" name="firstname" required><br><br>
        <label>Last Name:</label>
        <input type="text" name="lastname" required><br><br>
        <label>Phone:</label>
        <input type="text" name="phone" required><br><br>
        <label>Email:</label>
        <input type="email" name="email" required><br><br>
        <input type="submit" name="submit" value="Register">
        <a href="index.php">Login</a>
    </form>
</body>

</html>