<?php


// Create connection
$conn = mysqli_connect(
    hostname: "buhogjwp1edaep3ag9my-mysql.services.clever-cloud.com",
    username: "u1yda4m9h9dx54ou",
    password: "l8otBDMZw3H8DTxYfBtM",
    database: "buhogjwp1edaep3ag9my"
);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// echo "Connected successfully";

// Close connection
// mysqli_close($conn);
// exit();
?>