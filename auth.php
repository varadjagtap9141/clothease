<?php
session_start();

$conn = mysqli_connect(
    "buhogjwp1edaep3ag9my-mysql.services.clever-cloud.com",
    "u1yda4m9h9dx54ou",
    "l8otBDMZw3H8DTxYfBtM",
    "buhogjwp1edaep3ag9my"
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

extract($_POST);
$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);

$sql = "SELECT * FROM business_profiles WHERE mobile='$username' AND password='$password' AND status='Active'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION["session_id"] = $row["business_id"];
    $_SESSION["login_success"] = true; 
    header('location:master/dashboard.php');
    exit();
} else {
    $checkStatusSQL = "SELECT * FROM business_profiles WHERE mobile='$username' AND password='$password'";
    $statusResult = mysqli_query($conn, $checkStatusSQL);
    if (mysqli_num_rows($statusResult) > 0) {
        header('location:index.php?error=Your account is inactive. Please contact support.');
    } else {
        header('location:index.php?error=Login Failed');
    }
    exit();
}
?>