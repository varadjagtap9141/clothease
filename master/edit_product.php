<?php
include "components/navbar.php";
include "components/connection.php";
extract($_GET);
$edit_product="SELECT * FROM products WHERE products_id='$products_id'";
$res=mysqli_query($conn,$edit_product);
$fetch=mysqli_fetch_assoc($res);
?>
<!-- Fetch categories -->
<?php
$category = $conn->query("SELECT category_id, category_name FROM category");
$brands = $conn->query("SELECT brands_id, brands_name FROM brands");
?>
<div class="row">
    <div class="col-md-12">

        <div class="card mb-6">
            <!-- settings -->

            <div class="card-body pt-4">
                <h5 class="text-uppercase py-2">Update Products</h5>
                <form method="POST" action="components/update_products.php">
                    <div class="row">
                    <input class="form-control" type="hidden" id="products_id" name="products_id"
                    placeholder="Enter products name" required value="<?=$fetch['products_id']?>"/>
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
                            <label for="product_brands" class="form-label">Select Brands</label>
                            <select name="brands_id" id="brands_id" class="form-select">
                                <option value="" disabled>Choose Category</option>
                                <?php foreach ($brands as $row) { ?>
                                    <option value="<?= $row['brands_id'] ?>"
                                        <?= isset($products[0]['brands_id']) && $row['brands_id'] == $products[0]['brands_id'] ? 'selected' : ' ' ?>>
                                        <?= $row['brands_name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label for="products_name" class="form-label">Enter Products Name</label>
                            <input class="form-control" type="text" id="products_name" name="products_name"
                                placeholder="Enter products name" required value="<?=$fetch['products_name']?>" />
                        </div>
                        <div class="col-md-4 mt-2">
                            <label for="products_code" class="form-label">Enter Products Code</label>
                            <input class="form-control" type="text" id="products_code" name="products_code"
                                placeholder="Enter products code" required value="<?=$fetch['products_code']?>" />
                        </div>
                        <div class="col-md-4 mt-2">
                            <label for="product_udm" class="form-label">Product Unit</label>
                            <select class="form-select" id="product_udm" name="product_udm" aria-label="product unit">
                                <option selected ><?=$fetch['product_udm']?></option>
                                <option value="Piece">Piece</option>
                                <option value="Pack">Pack</option>
                            </select>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label for="products_mrp_price" class="form-label">Enter Products MRP</label>
                            <input class="form-control" type="text" id="products_mrp_price" name="products_mrp_price"
                                placeholder="Enter products MRP" required value="<?=$fetch['products_mrp_price']?>" />
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="products_description" class="form-label">Enter Products Description</label>
                            <textarea class="form-control" id="products_description" name="products_description"
                                rows="3" placeholder="Enter products description" required  ><?=$fetch['products_description']?></textarea>
                        </div>
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



<select name="category_manage_id" id="category_manage_id" class="form-control">
                                <option value="" disabled>Choose Category</option>
                                <?php foreach ($category_manage as $row) { ?>
                                    <option value="<?= $row['category_manage_id'] ?>"
                                        <?= isset($products[0]['category_manage_id']) && $row['category_manage_id'] == $products[0]['category_manage_id'] ? 'selected' : ' ' ?>>
                                        <?= $row['category_name'] ?>
                                    </option>
                                <?php } ?>
                            </select>