<?php
include '../config/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user details into the database
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashedPassword, $role);

    if ($stmt->execute()) {
        echo "Signup successful! You can now login.";
    } else {
        if ($conn->errno === 1062) { // Duplicate entry error code
            echo "Username already exists. Please choose another.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>
