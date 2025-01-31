<?php include "connection.php"; 
extract($_POST);
$update_size="UPDATE product_size SET category_id='$category_id',product_size='$product_size',created_date='$created_date' WHERE product_size_id='$product_size_id'";
$res=mysqli_query($conn,$update_size);
print_r($res);

header("location:../productS_size.php");
?>