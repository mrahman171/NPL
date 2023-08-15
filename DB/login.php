<?php
session_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form
    $myusername = mysqli_real_escape_string($conn, $_POST['username']);
    $mypassword = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE username = '$myusername' and password = '$mypassword'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $count = mysqli_num_rows($result);

        // If result matched $myusername and $mypassword, table row must be 1 row
        if ($count == 1) {
            $_SESSION['login_user'] = $myusername;
            echo "Login successful!";
        } else {
            echo "Your Login Name or Password is invalid";
        }
    } else {
        echo "Query failed: " . mysqli_error($conn);
    }
}

$conn->close();
?>
