<?php
// เรียกใช้งานไฟล์ db_connect.php เพื่อเชื่อมต่อฐานข้อมูล
require_once 'db_connect.php';
$isUsername = false;
$isName = false;
$isTel = false;
$isEmail = false;
$username = "";
$password = "";
$firstname = "";
$lastname = "";
$phone = "";
$email = "";
$address = "";
$ref_code = "";
$ref_remark = "";

// ตรวจสอบว่ามีการส่งข้อมูลฟอร์มเข้ามาหรือไม่
if (isset($_POST['submit'])) {
    // รับค่าจากฟอร์ม
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $ref_code = $_POST['ref_code'];
    $ref_remark = $_POST['ref_remark'];


    // ตรวจสอบว่ามี email นี้อยู่ในฐานข้อมูลแล้วหรือไม่
    $sql = "SELECT * FROM members WHERE username='$username' or (fname = '$firstname' and lname = '$lastname') or tel = '$phone' or email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = mysqli_fetch_assoc($result);
        if ($user['username'] == $username) {
            $isUsername = true;
        }
        if ($user['fname'] == $firstname and $user['lname'] == $lastname) {
            $isName = true;
        }
        if ($user['tel'] == $phone) {
            $isTel = true;
        }
        if ($user['email'] == $email) {
            $isEmail = true;
        }

        // ถ้ามีอยู่แล้วให้แจ้งเตือนและหยุดการทำงาน
        // echo "Username already exists";
        // exit();
    } else {
        // ถ้าไม่มีให้ทำการเพิ่มข้อมูลเข้าไปในฐานข้อมูล
        date_default_timezone_set("Asia/Bangkok");
        $register_time = date('Y-m-d H:i:s');
        $sql = "INSERT INTO members (username,password,user_level,fname, lname, tel, email,address,ref_code,ref_remark,last_update) VALUES ('$username','$password',2,'$firstname', '$lastname', '$phone', '$email','$address','$ref_code','$ref_remark','$register_time')";
        if ($conn->query($sql) === TRUE) {
            // เมื่อเพิ่มข้อมูลสำเร็จให้แจ้งเตือนและกลับไปยังหน้าแรก
            echo "<script>alert('New user created successfully'); window.location='index.php';</script>";
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header">
                        <h2>Register</h2>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label">UserName:
                                    <?php
                                    if ($isUsername) {
                                        echo "<text class='alert-danger'>username ซ้ำ</text>";
                                    } ?>
                                </label>
                                <input type="text" class="form-control" name="username"
                                    value="<?php echo "$username"; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password:</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">First Name:
                                    <?php
                                    if ($isName) {
                                        echo "<text class='alert-danger'>ชื่อและนามสกุลซ้ำ</text>";
                                    } ?>
                                </label>
                                <input type="text" class="form-control" name="firstname"
                                    value="<?php echo "$firstname"; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Last Name:</label>
                                <input type="text" class="form-control" name="lastname"
                                    value="<?php echo "$lastname"; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone:
                                    <?php
                                    if ($isTel) {
                                        echo "<text class='alert-danger'>โทรศัพท์ซ้ำ</text>";
                                    } ?>
                                </label>
                                <input type="text" class="form-control" name="phone" value="<?php echo "$phone"; ?>"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email:
                                    <?php
                                    if ($isEmail) {
                                        echo "<text class='alert-danger'>Email ซ้ำ</text>";
                                    } ?>
                                </label>
                                <input type="email" class="form-control" name="email" value="<?php echo "$email"; ?>"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address:</label>
                                <input type="text" class="form-control" name="address" value="<?php echo "$address"; ?>"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ref Code:</label>
                                <input type="text" class="form-control" name="ref_code"
                                    value="<?php echo "$ref_code"; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ref Remark:</label>
                                <input type="text" class="form-control" name="ref_remark"
                                    value="<?php echo "$ref_remark"; ?>">
                            </div>
                            <div class="d-grid gap-2">
                                <input type="submit" class="btn btn-primary" name="submit" value="Register">
                            </div>
                            <div class="text-center mt-3">
                                <a href="index.php">Already have an account? Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-KyZwhaO1rlmxa8K4y4Oi4J0/0pXWxG8BhFotAuFNCOim36vMVRD2tu8+rv11GnUJ" crossorigin="anonymous">
        </script>
</body>

</html>