<?php
// กำหนดค่าพื้นฐานสำหรับการเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_DB";

// สร้างการเชื่อมต่อฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
