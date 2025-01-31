<?php
include "connection.php";

echo "<pre>";
print_r($_POST);
print_r($_FILES);
echo "</pre>";

$uploadDir = 'uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true); 
}

$brands_img = time() . "_" . basename($_FILES['brands_image']['name']);
$uploadPath = $uploadDir . $brands_img;

if (move_uploaded_file($_FILES['brands_image']['tmp_name'], $uploadPath)) {
    extract($_POST);

    $sql = "INSERT INTO brands (brands_name, brands_image, brands_date) 
            VALUES ('$brands_name', '$brands_img', '$brands_date')";
    
    if (mysqli_query($conn, $sql)) {
        echo "Data inserted successfully.";
        header('location:../brands.php');
    } else {
        echo "Error inserting data: " . mysqli_error($conn);
    }
} else {
    echo "Error uploading file.";
}
?>