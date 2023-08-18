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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $newPassword = $_POST["password"];

    // Hash the new password using password_hash()
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Check if the email exists in the database
    $emailCheck = "SELECT * FROM users WHERE email = '$email'";
    $emailResult = $conn->query($emailCheck);
    
    if ($emailResult->num_rows > 0) {
        // Update the password for the user
        $updatePassword = "UPDATE users SET password = '$hashedPassword' WHERE email = '$email'";
        if ($conn->query($updatePassword) === TRUE) {
            echo "Password updated successfully!";
        } else {
            echo "Error updating password: " . $conn->error;
        }
    } else {
        echo "Email not found in the database.";
    }
}

$conn->close();
?>
