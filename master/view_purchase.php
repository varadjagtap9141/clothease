<?php
include "components/navbar.php";
include "components/connection.php";
?>
<?php
// Get the invoice ID from the URL
$invoice_id = $_GET['id'] ?? 0;

// Fetch invoice details
$invoice = $conn->query("
    SELECT 
        pi.purchase_invoice_id, 
        s.supplier_name, 
        s.supplier_number, 
        s.gst_number, 
        s.supplier_address, 
        pi.purchase_date, 
        pi.total_amount, 
        pi.total_gst, 
        pi.total_bill, 
        pi.paid_amount, 
        pi.balance_amount 
    FROM purchase_invoices pi
    JOIN supplier s ON pi.supplier_id = s.supplier_id
    WHERE pi.purchase_invoice_id = $invoice_id
")->fetch_assoc();

// Updated query to fetch products with size from the product_size table
$products = $conn->query("
    SELECT 
        pip.product_id, 
        p.products_name, 
        p.products_code, 
        pip.color, 
        ps.product_size AS size, 
        pip.price, 
        pip.quantity, 
        pip.total 
    FROM purchase_invoice_products pip
    JOIN products p ON pip.product_id = p.products_id
    JOIN product_size ps ON pip.size = ps.product_size_id
    WHERE pip.purchase_invoice_id = $invoice_id
");

?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="m-0">Purchase Invoice #CE00<?= htmlspecialchars($invoice['purchase_invoice_id']) ?></h5>
                <hr class="mt-1">

                <!-- Supplier Details -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6>Supplier Details</h6>
                        <p>
                            <strong>Name:</strong> <?= htmlspecialchars($invoice['supplier_name']) ?><br>
                            <strong>Mobile:</strong> <?= htmlspecialchars($invoice['supplier_number']) ?><br>
                            <strong>GST:</strong> <?= htmlspecialchars($invoice['gst_number']) ?><br>
                            <strong>Address:</strong> <?= htmlspecialchars($invoice['supplier_address']) ?><br>
                            <strong>Invoice Date:</strong> <?= htmlspecialchars($invoice['purchase_date']) ?>
                        </p>
                    </div>
                    <div class="col-md-6 text-end">
                        <h6>Invoice Summary</h6>
                        <p>
                            <strong>Total Amount:</strong> ₹<?= number_format($invoice['total_amount'], 2) ?><br>
                            <strong>Total GST (28%):</strong> ₹<?= number_format($invoice['total_gst'], 2) ?><br>
                            <strong>Total Bill:</strong> ₹<?= number_format($invoice['total_bill'], 2) ?><br>
                            <strong>Paid Amount:</strong> ₹<?= number_format($invoice['paid_amount'], 2) ?><br>
                            <strong>Balance:</strong> ₹<?= number_format($invoice['balance_amount'], 2) ?>
                        </p>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="table-responsive">
                    <h6>Purchased Products</h6>
                    <table class="table table-bordered table-sm">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Product Code</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($products->num_rows > 0): ?>
                                <?php $i = 1; while ($row = $products->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= htmlspecialchars($row['products_name']) ?></td>
                                        <td><?= htmlspecialchars($row['products_code']) ?></td>
                                        <td><?= htmlspecialchars($row['color']) ?></td>
                                        <td><?= htmlspecialchars($row['size']) ?></td>
                                        <td>₹<?= number_format($row['price'], 2) ?></td>
                                        <td><?= htmlspecialchars($row['quantity']) ?></td>
                                        <td>₹<?= number_format($row['total'], 2) ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No products found for this invoice</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Back Button -->
                <div class="text-end mt-4">
                    <a href="purchase_list.php" class="btn btn-secondary">Back to Purchase List</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "components/footer.php"; ?>