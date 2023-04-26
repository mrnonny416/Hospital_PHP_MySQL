<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

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


    echo "<h1>Dashboard</h1>";
    echo "<div class='d-grid ms-3 gap-2 d-md-block'> <form method='post'>";
    if ($_SESSION['user_level'] == 0) {
        echo "<a href='login_log.php' class='btn btn-primary me-3'>Login Log</a>";
    }
    echo "<button type='submit' name='logout' class='btn btn-warning ms-auto'>Logout</button></form></div>";




    $user_level = $user['user_level'];
    echo "<table class='table table-striped table-bordered table-hover mt-4 '>";
    echo "<tr class='table-dark'>
    <th>Username</th>
    <th>User Level</th>
    <th>Name</th>
    <th>Tel</th>
    <th>E-mail</th>
    <th>Address</th>
    <th>Ref Code</th>
    <th>Ref Remark</th>
    <th>Remark</th>
    <th>lastUpdate</th>
    

    <th>Action</th>
    </tr>";
    if ($user_level == 0) {
        // show all users' data
        $query = "SELECT * FROM members ORDER BY user_level ASC";
        $result = mysqli_query($conn, $query);



        while ($row = mysqli_fetch_assoc($result)) {
            echo "
        <tr>
        <td>{$row['username']}</td>
        ";
            if ($row['user_level'] == 0) {
                echo "<td>admin</td>";
            } elseif ($row['user_level'] == 1) {
                echo "<td>staff</td>";
            } elseif ($row['user_level'] == 2) {
                echo "<td>user</td>";
            }

            echo "
        <td>{$row['fname']}  {$row['lname']}</td>
        <td>{$row['tel']}</td>
        <td>{$row['email']}</td>
        <td>{$row['address']}</td>
        <td>{$row['ref_code']}</td>
        <td>{$row['ref_remark']}</td>
        <td>{$row['remark']}</td>
        <td>{$row['last_update']}</td>
    <td class='text-center'>
        <a class='btn btn-primary btn-sm' href='edit.php?username={$row['username']}' target='_blank'>Edit</a>
        <a class='btn btn-danger btn-sm mt-1' href='delete.php?username={$row['username']}' onClick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>
        </td>    
        </tr>";
        }

        echo "</table>";
    } else if ($user_level == 1) {
        // show level 1 and 2 users' data
        $query = "SELECT * FROM members WHERE user_level = 2 OR username = '$username' ORDER BY user_level ASC";
        $result = mysqli_query($conn, $query);



        while ($row = mysqli_fetch_assoc($result)) {
            echo "
        <tr>
        <td>{$row['username']}</td>
        ";
            if ($row['user_level'] == 0) {
                echo "<td>admin</td>";
            } elseif ($row['user_level'] == 1) {
                echo "<td>staff</td>";
            } elseif ($row['user_level'] == 2) {
                echo "<td>user</td>";
            }

            echo "
        <td>{$row['fname']}  {$row['lname']}</td>
        <td>{$row['tel']}</td>
        <td>{$row['email']}</td>
        <td>{$row['address']}</td>
        <td>{$row['ref_code']}</td>
        <td>{$row['ref_remark']}</td>
        <td>{$row['remark']}</td>
        <td>{$row['last_update']}</td>
        <td class='text-center'>
        <a class='btn btn-primary btn-sm' href='edit.php?username={$row['username']}' target='_blank'>Edit</a>
        <a class='btn btn-danger btn-sm mt-1' href='delete.php?username={$row['username']}' onClick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>
        </td>   
        </tr>";
        }
        echo "</table>";
    } else {
        // show only own data
    

        echo "
        <tr>
        <td>{$user['username']}</td>
        <td>user</td>
        <td>{$user['fname']}  {$user['lname']}</td>
        <td>{$user['tel']}</td>
        <td>{$user['email']}</td>
        <td>{$user['address']}</td>
        <td>{$user['ref_code']}</td>
        <td>{$user['ref_remark']}</td>
        <td>{$user['remark']}</td>
        <td>{$user['last_update']}</td>
        <td class='text-center'>
        <a class='btn btn-primary btn-sm' href='edit.php?username={$user['username']}' target='_blank'>Edit</a></td>   
        </tr>";
        echo "</table>";
    }

    // add logout button
    echo "<form method='post' >

</form>";
    ?>
</body>