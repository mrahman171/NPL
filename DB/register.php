<?php
// Connect to your database (replace placeholders with actual values)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Hash the password using password_hash()
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email is already in the database
    $emailCheck = "SELECT * FROM users WHERE email = '$email'";
    $emailResult = $conn->query($emailCheck);
    if ($emailResult->num_rows > 0) {
        echo "Email already exists in the database.";
        exit; // Stop further processing
    }

    // Check if the username is already in the database
    $usernameCheck = "SELECT * FROM users WHERE username = '$username'";
    $usernameResult = $conn->query($usernameCheck);
    if ($usernameResult->num_rows > 0) {
        echo "Username already exists in the database.";
        exit; // Stop further processing
    }

    // Perform data validation and sanitization here

    // Insert data into the database
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
