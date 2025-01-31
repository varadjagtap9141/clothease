<?php include "connection.php";
extract($_POST);
$update_supplier="UPDATE supplier SET supplier_name='$supplier_name', supplier_number='$supplier_number', gst_number='$gst_number',supplier_address='$supplier_address' WHERE supplier_id='$supplier_id'";
$res=mysqli_query($conn,$update_supplier);
// print_r($res);
header("location:../supplier.php");
?>