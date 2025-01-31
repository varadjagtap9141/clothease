<?php include "connection.php"; 
extract($_POST);
$update_category="UPDATE category SET category_name ='$category_name' WHERE category_id = '$category_id'";
$res=mysqli_query($conn,$update_category);
header("location:../category.php");
?>