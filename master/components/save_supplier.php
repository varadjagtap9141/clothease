<!-- Supplier Insert -->
<?php
include "connection.php"
?>
<?php
extract($_POST);

$insert_supplier="INSERT INTO supplier(supplier_name,supplier_number,gst_number,supplier_address,register_date) VALUES ('$supplier_name','$supplier_number','$gst_number','$supplier_address','$register_date')";
$result_supplier=mysqli_query($conn,$insert_supplier);
if($result_supplier){
header("location:../supplier.php");}
?>