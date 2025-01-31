<?php 
include "components/navbar.php"; 
include "components/connection.php"; 
?>


<!-- Fetch categories -->
<?php
$category = $conn->query("SELECT category_id, category_name FROM category");
// select product size by id
extract($_GET);
$edit_size="SELECT * FROM product_size WHERE product_size_id='$product_size_id'";
$res=mysqli_query($conn,$edit_size);
$fetch=mysqli_fetch_assoc($res);
?>

<div class="row">
    <div class="col-md-12">

        <div class="card mb-6">
            <!-- settings -->

            <div class="card-body pt-4">
                <h5 class="text-uppercase py-2">Update product size</h5>
                <form method="POST" action="components/update_product_size.php">
                    <div class="row g-6">
                    <input class="form-control" type="hidden" id="product_size_id" name="product_size_id"
                    placeholder="Enter product Size" required value="<?=$fetch['product_size_id']?>"/>
                    <div class="col-md-4 mt-2">
                    <label for="category_id" class="form-label">Select Category</label>
                            <select name="category_id" id="category_id" class="form-select">
                                <option value="" disabled>Choose Category</option>
                                <?php foreach ($category as $row) { ?>
                                    <option value="<?= $row['category_id'] ?>"
                                        <?= isset($products[0]['category_id']) && $row['category_id'] == $products[0]['category_id'] ? 'selected' : ' ' ?>>
                                        <?= $row['category_name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label for="product_size" class="form-label">Products Size</label>
                            <input class="form-control" type="text" id="product_size" name="product_size"
                                placeholder="Enter product Size" required value="<?=$fetch['product_size']?>"/>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label for="product_size" class="form-label">Date</label>
                            <input class="form-control" type="date" id="c_date" name="created_date">
                        </div>
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

<!-- Product Size List -->
<?php include "components/footer.php"; ?>