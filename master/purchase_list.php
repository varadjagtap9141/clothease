<?php
include "components/navbar.php";
include "components/connection.php";
?>
<?php
// Fetch purchase invoices
$invoices = $conn->query("
    SELECT 
        pi.purchase_invoice_id, 
        s.supplier_name, 
        pi.purchase_date, 
        pi.total_amount, 
        pi.total_gst, 
        pi.total_bill, 
        pi.paid_amount, 
        pi.balance_amount
    FROM purchase_invoices pi
    JOIN supplier s ON pi.supplier_id = s.supplier_id
    ORDER BY pi.purchase_date DESC
");

// total Purchase
$purchase = "SELECT SUM(total_bill) AS sum_sale FROM purchase_invoices";
$result = $conn->query($purchase);
$totalPurchaseSum = 0;
if ($result && $row = $result->fetch_assoc()) {
    $totalPurchaseSum = $row['sum_sale'] ?? 0; 
}

// total Payment In
$PaymentIn = "SELECT SUM(paid_amount) AS sum_payment_in FROM purchase_invoices";
$result = $conn->query($PaymentIn);
$totalPaymentOut = 0;
if ($result && $row = $result->fetch_assoc()) {
    $totalPaymentOut = $row['sum_payment_in'] ?? 0; 
}

// total Due Payent
$DuePayment = "SELECT SUM(balance_amount) AS sum_due_payment FROM purchase_invoices";
$result = $conn->query($DuePayment);
$totalDuePayment = 0;
if ($result && $row = $result->fetch_assoc()) {
    $totalDuePayment = $row['sum_due_payment'] ?? 0; 
}
?>

<div class="row">
            <div class="col-lg-3 col-md-12 col-6 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success"
                                    class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1">Total Purchase</p>
                        <h4 class="card-title">&#8377; <?php echo number_format($totalPurchaseSum, 2); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-12 col-6 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="../assets/img/icons/unicons/wallet-info.png" alt="wallet info" class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1">Total Payment Out</p>
                        <h4 class="card-title">&#8377; <?php echo number_format($totalPaymentOut, 2); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-12 col-6 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="../assets/img/icons/unicons/wallet-info.png" alt="wallet info" class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1">Total Due</p>
                        <h4 class="card-title">&#8377; <?php echo number_format($totalDuePayment, 2); ?></h4>
                    </div>
                </div>
            </div>
        </div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="m-0">Purchase List</h5>
                <hr class="mt-1">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="example" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th></th>
                                <!-- <th>Invoice ID</th> -->
                                <th>Supplier</th>
                                <th>Purchase Date</th>
                                <th>Total Amount</th>
                                <th>GST</th>
                                <th>Total Bill</th>
                                <th>Paid</th>
                                <th>Balance</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($invoices->num_rows > 0): ?>
                                <?php $i = 1; while ($row = $invoices->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <!-- <td><?= htmlspecialchars($row['purchase_invoice_id']) ?></td> -->
                                        <td><?= htmlspecialchars($row['supplier_name']) ?></td>
                                        <td><?= htmlspecialchars($row['purchase_date']) ?></td>
                                        <td>&#8377; <?= number_format($row['total_amount'], 2) ?></td>
                                        <td>&#8377; <?= number_format($row['total_gst'], 2) ?></td>
                                        <td>&#8377; <?= number_format($row['total_bill'], 2) ?></td>
                                        <td>&#8377; <?= number_format($row['paid_amount'], 2) ?></td>
                                        <td>&#8377; <?= number_format($row['balance_amount'], 2) ?></td>
                                        <td>
                                            <a href="view_purchase.php?id=<?= $row['purchase_invoice_id'] ?>" 
                                               class="btn btn-sm btn-primary"><i class="fa-solid fa-eye"></i></a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center">No purchases found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "components/footer.php"; ?>