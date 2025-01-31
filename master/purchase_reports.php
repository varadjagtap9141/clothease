<?php
include "components/navbar.php";
include "components/connection.php";

// Initialize date range filters
$startDate = $_GET['start_date'] ?? '';
$endDate = $_GET['end_date'] ?? '';

// Fetch purchase invoices with date filtering
$query = "
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
";
if (!empty($startDate) && !empty($endDate)) {
    $query .= " WHERE pi.purchase_date BETWEEN '$startDate' AND '$endDate'";
}
$query .= " ORDER BY pi.purchase_date DESC";

$invoices = $conn->query($query);

// total Purchase
$purchase = "SELECT SUM(total_bill) AS sum_sale FROM purchase_invoices";
if (!empty($startDate) && !empty($endDate)) {
    $purchase .= " WHERE purchase_date BETWEEN '$startDate' AND '$endDate'";
}
$result = $conn->query($purchase);
$totalPurchaseSum = 0;
if ($result && $row = $result->fetch_assoc()) {
    $totalPurchaseSum = $row['sum_sale'] ?? 0;
}

// total Payment Out
$PaymentIn = "SELECT SUM(paid_amount) AS sum_payment_in FROM purchase_invoices";
if (!empty($startDate) && !empty($endDate)) {
    $PaymentIn .= " WHERE purchase_date BETWEEN '$startDate' AND '$endDate'";
}
$result = $conn->query($PaymentIn);
$totalPaymentOut = 0;
if ($result && $row = $result->fetch_assoc()) {
    $totalPaymentOut = $row['sum_payment_in'] ?? 0;
}

// total Due Payment
$DuePayment = "SELECT SUM(balance_amount) AS sum_due_payment FROM purchase_invoices";
if (!empty($startDate) && !empty($endDate)) {
    $DuePayment .= " WHERE purchase_date BETWEEN '$startDate' AND '$endDate'";
}
$result = $conn->query($DuePayment);
$totalDuePayment = 0;
if ($result && $row = $result->fetch_assoc()) {
    $totalDuePayment = $row['sum_due_payment'] ?? 0;
}
?>







<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="m-0">Purchase List</h5>
                <hr class="mt-1">
                <form method="GET">
                <div class="d-flex mb-3">
                        <div class="p-2">
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="<?= htmlspecialchars($startDate) ?>" title="Enter Start Date" required>
                        </div>
                        <div class="p-2">
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="<?= htmlspecialchars($endDate) ?>" title="Enter End Date" required>
                        </div>
                        <div class="ms-auto p-2">
                            <button type="submit" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Filter" class="btn btn-primary btn-sm"><i class='bx bx-filter-alt' ></i></button>
                            <a href="purchase_reports.php" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Reset" class="btn btn-secondary btn-sm"><i class='bx bx-reset'></i></a>
                        </div>
                </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="example" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th></th>
                                <th>Supplier</th>
                                <th>Purchase Date</th>
                                <th>Total Amount</th>
                                <th>GST</th>
                                <th>Total Bill</th>
                                <th>Paid</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($invoices->num_rows > 0): ?>
                            <?php $i = 1; while ($row = $invoices->fetch_assoc()): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= htmlspecialchars($row['supplier_name']) ?></td>
                                <td><?= htmlspecialchars($row['purchase_date']) ?></td>
                                <td>&#8377; <?= number_format($row['total_amount'], 2) ?></td>
                                <td>&#8377; <?= number_format($row['total_gst'], 2) ?></td>
                                <td>&#8377; <?= number_format($row['total_bill'], 2) ?></td>
                                <td>&#8377; <?= number_format($row['paid_amount'], 2) ?></td>
                                <td>&#8377; <?= number_format($row['balance_amount'], 2) ?></td>
                            </tr>
                            <?php endwhile; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center">No purchases found</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>
<?php include "components/footer.php"; ?>