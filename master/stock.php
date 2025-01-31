<?php
include "components/navbar.php";
include "components/connection.php";
?>

<!-- Products List -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-6 table-responsive">
            <div class="card-body pt-4">
                <h5 class="text-uppercase py-2">Products Stock</h5>
                <table class="table table-bordered table-hover table-sm display nowrap w-100" id="example">
                    <thead>
                        <tr>
                            <th scope="col" class="fw-bold">Sr No</th>
                            <th scope="col" class="fw-bold">Product Name</th>
                            <th scope="col" class="fw-bold">Product Size</th>
                            <th scope="col" class="fw-bold">Total Purchased</th>
                            <th scope="col" class="fw-bold">Total Sold</th>
                            <th scope="col" class="fw-bold">Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stock_products = "
                            SELECT 
                                p.product_id, 
                                pr.products_name, 
                                ps.product_size, 
                                p.size, 
                                IFNULL(SUM(p.quantity), 0) AS total_purchased, 
                                IFNULL(SUM(s.quantity), 0) AS total_sold, 
                                (IFNULL(SUM(p.quantity), 0) - IFNULL(SUM(s.quantity), 0)) AS stock
                            FROM 
                                purchase_invoice_products p
                            LEFT JOIN 
                                sale_products s 
                            ON 
                                p.product_id = s.product_id AND p.size = s.size
                            LEFT JOIN 
                                products pr 
                            ON 
                                p.product_id = pr.products_id
                            LEFT JOIN 
                                product_size ps 
                            ON 
                               TRIM(LOWER(p.size)) = TRIM(LOWER(ps.product_size_id))
                            GROUP BY 
                                p.product_id, p.size, pr.products_name, ps.product_size;
                        ";

                        $stock_result = mysqli_query($conn, $stock_products);

                        foreach ($stock_result as $key => $data) {
                            ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= $data['products_name'] ?></td>
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

<?php
include "components/footer.php";
?>