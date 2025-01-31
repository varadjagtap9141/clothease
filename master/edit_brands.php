<?php include "components/navbar.php";
extract($_GET);
$edit_brands="SELECT * FROM brands WHERE brands_id='$brands_id'";
$res=mysqli_query($conn,$edit_brands);
$fetch=mysqli_fetch_assoc($res);
?>
<div class="row">
    <div class="col-md-12">

        <div class="card mb-6">
            <!-- settings -->

            <div class="card-body pt-4">
                <h5 class="text-uppercase py-2">Update Brands</h5>
                <form method="POST" action="components/update_brands.php" enctype="multipart/form-data">
                    <div class="row g-6">
                        <input type="hidden" class="form-control" value="<?=$fetch['brands_id']?>" type="text" id="category_id"
                            name="brands_id" placeholder="Enter Your Name" autofocus />
                        <div class="col-md-5">
                            <label for="brands_name" class="form-label">Enter Brands Name</label>
                            <input class="form-control" type="text" id="brands_name" name="brands_name"
                                placeholder="Enter brands name" autofocus required value="<?=$fetch['brands_name']?>" />
                        </div>
                        <div class="col-md-5">
                            <label for="brands_image" class="form-label">Upload Brands Image</label>
                            <input class="form-control" type="file" id="brands_image" name="brands_image"
                                accept=".jpg,.jpeg,.png"/>
                        </div>
                        <div class="col-md-2 text-center">
                        <img class="mt-2 border" width="auto" height="80" src="components/uploads/<?=$fetch['brands_image']?>" alt="Brands" />
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