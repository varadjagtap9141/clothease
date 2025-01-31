<?php
include "components/navbar.php";
include "components/connection.php";
?>


<!-- Products List -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-6 table-responsive">

            <div class="card-body pt-4">
                <h5 class="text-uppercase">Products Reports</h5>
                <div class="d-flex">
                    <div class="p-2">
                        <select id="filter_product_size" name="product_size" class="form-select">
                            <option value="">All Sizes</option>
                            <?php
            $sizes_query = "SELECT product_size_id, product_size FROM product_size";
            $sizes_result = mysqli_query($conn, $sizes_query);
            while ($size = mysqli_fetch_assoc($sizes_result)) {
                echo "<option value='{$size['product_size_id']}'>{$size['product_size']}</option>";
            }
            ?>
                        </select>
                    </div>
                    <div class="p-2">

                        <select id="filter_category" name="category" class="form-select">
                            <option value="">All Categories</option>
                            <?php
            $categories_query = "SELECT category_id, category_name FROM category";
            $categories_result = mysqli_query($conn, $categories_query);
            while ($category = mysqli_fetch_assoc($categories_result)) {
                echo "<option value='{$category['category_id']}'>{$category['category_name']}</option>";
            }
            ?>
                        </select>
                    </div>
                    <div class="p-2">

                        <select id="filter_brand" name="brand" class="form-select">
                            <option value="">All Brands</option>
                            <?php
            $brands_query = "SELECT brands_id, brands_name FROM brands";
            $brands_result = mysqli_query($conn, $brands_query);
            while ($brand = mysqli_fetch_assoc($brands_result)) {
                echo "<option value='{$brand['brands_id']}'>{$brand['brands_name']}</option>";
            }
            ?>
                        </select>
                    </div>
                    <div class="ms-auto p-2">
                        <button id="apply_filters" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Filter" class="btn btn-primary btn-sm"><i class='bx bx-filter-alt'></i></button>
                        <a href="products_reports.php" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Reset" class="btn btn-secondary btn-sm"><i class='bx bx-reset'></i></a>

                    </div>
                </div>

                <!--  -->
                <table class="table table-bordered table-hover table-sm display nowrap w-100" id="example">
                    <thead>
                        <tr>
                            <th scope="col" class="fw-bold">Sr No</th>
                            <th scope="col" class="fw-bold">Product Name</th>
                            <th scope="col" class="fw-bold">Category</th>
                            <th scope="col" class="fw-bold">Brand</th>
                            <th scope="col" class="fw-bold">Product Size</th>
                            <th scope="col" class="fw-bold">Total Purchased</th>
                            <th scope="col" class="fw-bold">Total Sold</th>
                            <th scope="col" class="fw-bold">Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Capture filter values
                        $filter_size = $_GET['product_size'] ?? '';
                        $filter_category = $_GET['category'] ?? '';
                        $filter_brand = $_GET['brand'] ?? '';

                        // Add filter conditions to the query
                        $conditions = [];
                        if ($filter_size) {
                            $conditions[] = "ps.product_size_id = '$filter_size'";
                        }
                        if ($filter_category) {
                            $conditions[] = "c.category_id = '$filter_category'";
                        }
                        if ($filter_brand) {
                            $conditions[] = "b.brands_id = '$filter_brand'";
                        }

                        $where_clause = '';
                        if (!empty($conditions)) {
                            $where_clause = 'WHERE ' . implode(' AND ', $conditions);
                        }

                        $stock_products = "
SELECT 
    p.product_id, 
    pr.products_name,
    c.category_name,
    b.brands_name, 
    ps.product_size, 
    IFNULL(SUM(p.quantity), 0) AS total_purchased, 
    IFNULL(SUM(s.quantity), 0) AS total_sold, 
    (IFNULL(SUM(p.quantity), 0) - IFNULL(SUM(s.quantity), 0)) AS stock
FROM 
    purchase_invoice_products p
LEFT JOIN 
    sale_products s 
ON 
    p.product_id = s.product_id
LEFT JOIN 
    products pr 
ON 
    p.product_id = pr.products_id
LEFT JOIN 
    product_size ps 
ON 
    p.size = ps.product_size_id
LEFT JOIN 
    category c 
ON 
    pr.category_id = c.category_id
LEFT JOIN 
    brands b 
ON 
    pr.brands_id = b.brands_id
$where_clause
GROUP BY 
    p.product_id, ps.product_size, pr.products_name, c.category_name, b.brands_name
HAVING 
    stock > 0;
                        ";

                        $stock_result = mysqli_query($conn, $stock_products);

                        foreach ($stock_result as $key => $data) {
                            ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $data['products_name'] ?></td>
                            <td><?= $data['category_name'] ?></td>
                            <td><?= $data['brands_name'] ?></td>
                            <td><?= $data['product_size'] ?></td>
                            <td><?= $data['total_purchased'] ?></td>
                            <td><?= $data['total_sold'] ?></td>
                            <td><?= $data['stock'] ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('apply_filters').addEventListener('click', function() {
    const size = document.getElementById('filter_product_size').value;
    const category = document.getElementById('filter_category').value;
    const brand = document.getElementById('filter_brand').value;

    const queryParams = new URLSearchParams();
    if (size) queryParams.append('product_size', size);
    if (category) queryParams.append('category', category);
    if (brand) queryParams.append('brand', brand);

    window.location.href = '?' + queryParams.toString();
});
// tooltip
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>

<?php
include "components/footer.php";
?>