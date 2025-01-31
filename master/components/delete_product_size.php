<?php include "connection.php";
extract($_GET);
$delete_size="DELETE FROM product_size WHERE product_size_id='$product_size_id'";
$res=mysqli_query($conn,$delete_size);
header("location:../products_size.php");
print_r($res);
?>