<?php include "connection.php";
extract($_GET);
$delete_brand="DELETE FROM brands WHERE brands_id='$brands_id'";
$res=mysqli_query($conn,$delete_brand);
header("location:../brands.php"); 
?>