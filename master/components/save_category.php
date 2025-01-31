<?php
include "connection.php";
?>

<?php
extract($_POST);

$insert_category = "INSERT INTO category (category_name, register_date) VALUES ('$category_name', '$register_date')";
$result_category = mysqli_query($conn, $insert_category);

if ($result_category) {
    header("Location: ../category.php");
} else {
    // Debugging information in case of failure
    echo "Error: " . mysqli_error($conn);
}
?>
