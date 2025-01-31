<?php
include "components/navbar.php";
extract($_GET);
$edit_supplier = "SELECT * FROM supplier WHERE supplier_id=$supplier_id";
$res=mysqli_query($conn,$edit_supplier);
$fetch=mysqli_fetch_assoc($res);
?>
<div class="row">
    <div class="col-md-12">

        <div class="card mb-6">
            <!-- settings -->

            <div class="card-body pt-4">
                <h5 class="text-uppercase py-2">Update Supplier</h5>
                <form method="POST" action="components/update_supplier.php">
                    <div class="row g-6">
                        <div class="col-md-3">
                            <label for="supplier_id" class="form-label">Supplier Id</label>
                            <input class="form-control" type="text" id="supplier_id" name="supplier_id"
                                placeholder="Enter Your Name" autofocus required value="<?=$fetch['supplier_id']?>" readonly/>
                        </div>
                        <div class="col-md-3">
                            <label for="supplier_name" class="form-label">Enter Name</label>
                            <input class="form-control" type="text" id="supplier_name" name="supplier_name"
                                placeholder="Enter Your Name" autofocus required value="<?=$fetch['supplier_name']?>" />
                        </div>
                        <div class="col-md-3">
                            <label for="supplier_number" class="form-label">Enter Contact No</label>
                            <input class="form-control" type="number" name="supplier_number" id="supplier_number"
                                placeholder="Enter Contact No" required value="<?=$fetch['supplier_number']?>" />
                        </div>
                        <div class="col-md-3">
                            <label for="gst_number" class="form-label">Enter GST No</label>
                            <input class="form-control" type="number" name="gst_number" id="gst_number"
                                placeholder="Enter GST No" required value="<?=$fetch['gst_number']?>" />
                        </div>
                        <div class="col-md-3">
                            <label for="supplier_address" class="form-label">Enter Address</label>
                            <input class="form-control" type="text" name="supplier_address" id="supplier_address"
                                placeholder="Enter Your Address" required value="<?=$fetch['supplier_address']?>" />
                        </div>
                        <input type="hidden" id="c_date" name="register_date">
                    </div>
                    <div class="mt-6">
                        <button onClick="return confirm('Are You Sure?');" type="submit" class="btn btn-primary me-3 float-end">Update</button>
                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>

    </div>
</div>




<script>
document.getElementById('c_date').value = new Date().toISOString().split('T')[0]
</script>


<?php
include "components/footer.php";
?>