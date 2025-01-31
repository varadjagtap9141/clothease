<?php
include "connection.php";
?>
<!-- Delete Category -->
<?php
 extract($_GET);
 $delete_category="DELETE FROM category WHERE category_id='$category_id'";
 $del_res=mysqli_query($conn,$delete_category);
 if($del_res){
    header("location:../category.php");
 }
?>