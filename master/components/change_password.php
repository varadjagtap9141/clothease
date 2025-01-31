<?php
session_start();
include 'connection.php';
?>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = trim($_POST['currunt_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        die("All fields are required!");
    }

    if ($new_password !== $confirm_password) {
        die("New Password and Confirm Password do not match!");
    }

    $user_id = $_SESSION['session_id'];

    // Ensure the database connection is valid
    if (!$conn || $conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Fetch current password
    $sql = "SELECT password FROM admin WHERE admin_id = ?";
    // $stmt = mysqli_query( $conn, $query);
   $stand = mysqli_query($conn,$sql);
    if (!$stand) {
        die("Query preparation failed: " . $conn->error);
    }

    $stand->bind_param("i", $user_id);
    $stand->execute();
    $stand->bind_result($db_password);
    if (!$stand->fetch()) {
        die("User not found.");
    }
    $stand->close();

    // Verify current password
    if (!password_verify($current_password, $db_password)) {
        die("Current password is incorrect!");
    }

    // Hash and update the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $update_query = "UPDATE admin SET password = ? WHERE admin_id = ?";
    $update_stmt = $conn->prepare($update_query);
    if (!$update_stmt) {
        die("Query preparation failed: " . $conn->error);
    }

    $update_stmt->bind_param("si", $hashed_password, $user_id);
    if ($update_stmt->execute()) {
        echo "Password updated successfully!";
    } else {
        echo "Error updating password: " . $conn->error;
    }

    $update_stmt->close();
    $conn->close();
}
?>