<?php
include "components/navbar.php";
extract($_GET);
$edit_customer="SELECT * FROM customer WHERE customer_id='$customer_id'";
$res=mysqli_query($conn,$edit_customer);
$fetch_data=mysqli_fetch_assoc($res);
?>

<div class="row">
    <div class="col-md-12">

        <div class="card mb-6">
            <!-- settings -->

            <div class="card-body pt-4">
                <h5 class="text-uppercase py-2">Update Customer</h5>
                <form method="POST" action="components/update_customer.php">
                    <div class="row g-6">
                        <div class="col-md-3">
                            <label for="customer_id" class="form-label">Customer ID</label>
                            <input class="form-control" value="<?=$fetch_data['customer_id']?>" type="text" id="customer_id" name="customer_id"
                                placeholder="Enter Your Name" autofocus required readonly />
                        </div>
                        <div class="col-md-3">
                            <label for="customer_name" class="form-label">Enter Name</label>
                            <input class="form-control" value="<?=$fetch_data['customer_name']?>" type="text" id="customer_name" name="customer_name"
                                placeholder="Enter Your Name" autofocus required />
                        </div>
                        <div class="col-md-3">
                            <label for="customer_number" class="form-label">Enter Contact No</label>
                            <input class="form-control" value="<?=$fetch_data['customer_number']?>" type="number" name="customer_number"
                                id="customer_number" placeholder="Enter Contact No" required />
                        </div>
                        <div class="col-md-3">
                            <label for="customer_address" class="form-label">Enter Address</label>
                            <input class="form-control" value="<?=$fetch_data['customer_address']?>" type="text" name="customer_address"
                                id="customer_address" placeholder="Enter Your Address" required />
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




<script>
document.getElementById('c_date').value = new Date().toISOString().split('T')[0]
</script>



<?php
include "components/footer.php";
?>