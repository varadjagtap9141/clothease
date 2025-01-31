<?php include "connection.php";
extract($_GET);
$delete_product="DELETE FROM products WHERE products_id ='$products_id'";
$res=mysqli_query($conn,$delete_product);
header("location:../products.php"); 
?>