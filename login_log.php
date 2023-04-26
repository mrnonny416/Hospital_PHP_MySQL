<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login Log</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="my-4">Login Log</h1>

        <div class='d-grid ms-3 gap-2 d-md-block mb-3'>
            <form method='post'>
                <a href='dashboard.php' class='btn btn-primary'>Dash board</a>
                <button type='submit' name='logout' class='btn btn-warning ms-auto'>Logout</button>
            </form>
        </div>
        <table class="table table-striped table-bordered rounded">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Login Flag</th>
                    <th>IP Address</th>
                    <th>Last Update</th>
                </tr>
            </thead>
            <tbody>
                <?php
                session_start(); // เรียกใช้ session
                require_once "db_connect.php";
                if (!isset($_SESSION['username'])) {
                    header("Location: index.php");
                    exit;
                }

                if ($_SESSION['user_level'] != 0) {
                    header("Location: dashboard.php");
                    exit;
                }

                if (isset($_POST['logout'])) {
                    session_unset();
                    session_destroy();
                    header("Location: index.php");
                    exit();
                }

                // SQL query to select all records from the login_log table
                $sql = "SELECT * FROM login_log";

                // Execute the query
                $result = mysqli_query($conn, $sql);

                // Loop through the result set and output each record
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";

                    if ($row['login_flag'] == 1) {
                        echo "<td>Login Fail</td>";
                    } else {
                        echo "<td>Login Pass</td>";
                    }
                    echo "<td>" . $row['ip_address'] . "</td>";
                    echo "<td>" . $row['last_update'] . "</td>";
                    echo "</tr>";
                }

                // Close database connection
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>