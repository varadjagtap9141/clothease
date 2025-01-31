<!-- Delete Supplier -->
<?php
include "connection.php";
?>
<?php
extract($_GET);
$delete_supplier="DELETE FROM supplier WHERE supplier_id ='$supplier_id'";
$supply_res=mysqli_query($conn,$delete_supplier);
if($supply_res)
 {
header("location:../supplier.php");
 }
?>