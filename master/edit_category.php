<?php include "components/navbar.php";
extract($_GET);
$edit_category="SELECT * FROM category WHERE category_id='$category_id'";
$res=mysqli_query($conn,$edit_category);
$fetch_category=mysqli_fetch_assoc($res);
?>
<div class="row">
    <div class="col-md-12">

        <div class="card mb-6">
            <!-- settings -->

            <div class="card-body pt-4">
                <h5 class="text-uppercase py-2">Update Category</h5>
                <form method="POST" action="components/update_category.php">
                    <div class="row g-6">
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Category ID</label>
                            <input class="form-control" value="<?=$fetch_category['category_id']?>" type="text" id="category_id" name="category_id"
                                placeholder="Enter Your Name" autofocus required readonly />
                        </div>
                        <div class="col-md-6">
                            <label for="category_name" class="form-label">Enter Name</label>
                            <input class="form-control" value="<?=$fetch_category['category_name']?>" type="text" id="category_name" name="category_name"
                                placeholder="Enter Your Name" autofocus required />
                        </div>
                        <input type="hidden" id="c_date" name="register_date">
                    </div>
                    <div class="mt-6">
                        <button onClick="return confirm('Are You Sure?');" type="submit"
                            class="btn btn-primary me-3 float-end">Update</button>
                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>

    </div>
</div>


<!-- Auto Date script -->
<script>
document.getElementById('c_date').value = new Date().toISOString().split('T')[0]
</script>


<?php include "components/footer.php";?>