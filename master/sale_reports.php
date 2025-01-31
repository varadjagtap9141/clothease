<?php
include "components/navbar.php";
include "components/connection.php";

$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

$query = "
    SELECT 
        si.sale_id, 
        c.customer_name, 
        si.sale_date, 
        si.total_amount, 
        si.total_gst, 
        si.total_bill, 
        si.paid_amount, 
        si.balance_amount
    FROM sales si
    JOIN customer c ON si.customer_id = c.customer_id
";

if (!empty($start_date) && !empty($end_date)) {
    $query .= " WHERE si.sale_date BETWEEN '$start_date' AND '$end_date'";
}

$query .= " ORDER BY si.sale_date DESC";

$invoices = $conn->query($query);

$totalSaleSum = $totalPaymentIn = $totalDuePayment = 0;

if (!empty($start_date) && !empty($end_date)) {
    $sale = "SELECT SUM(total_bill) AS sum_sale FROM sales WHERE sale_date BETWEEN '$start_date' AND '$end_date'";
    $PaymentIn = "SELECT SUM(paid_amount) AS sum_payment_in FROM sales WHERE sale_date BETWEEN '$start_date' AND '$end_date'";
    $DuePayment = "SELECT SUM(balance_amount) AS sum_due_payment FROM sales WHERE sale_date BETWEEN '$start_date' AND '$end_date'";
} else {
    $sale = "SELECT SUM(total_bill) AS sum_sale FROM sales";
    $PaymentIn = "SELECT SUM(paid_amount) AS sum_payment_in FROM sales";
    $DuePayment = "SELECT SUM(balance_amount) AS sum_due_payment FROM sales";
}

// Execute the queries
$result = $conn->query($sale);
if ($result && $row = $result->fetch_assoc()) {
    $totalSaleSum = $row['sum_sale'] ?? 0;
}

$result = $conn->query($PaymentIn);
if ($result && $row = $result->fetch_assoc()) {
    $totalPaymentIn = $row['sum_payment_in'] ?? 0;
}

$result = $conn->query($DuePayment);
if ($result && $row = $result->fetch_assoc()) {
    $totalDuePayment = $row['sum_due_payment'] ?? 0;
}
?>
<!-- <div class="row">
    <div class="col-lg-3 col-md-12 col-12 mb-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between mb-4">
                    <div class="avatar flex-shrink-0">
                        <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded" />
                    </div>
                </div>
                <p class="mb-1">Total Sale</p>
                <h4 class="card-title">&#8377; <?= number_format($totalSaleSum, 2); ?></h4>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-12 col-12 mb-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between mb-4">
                    <div class="avatar flex-shrink-0">
                        <img src="../assets/img/icons/unicons/wallet-info.png" alt="wallet info" class="rounded" />
                    </div>
                </div>
                <p class="mb-1">Total Payment In</p>
                <h4 class="card-title">&#8377; <?= number_format($totalPaymentIn, 2); ?></h4>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-12 col-12 mb-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between mb-4">
                    <div class="avatar flex-shrink-0">
                        <img src="../assets/img/icons/unicons/wallet-info.png" alt="wallet info" class="rounded" />
                    </div>
                </div>
                <p class="mb-1">Total Due Payment</p>
                <h4 class="card-title">&#8377; <?= number_format($totalDuePayment, 2); ?></h4>
            </div>
        </div>
    </div>
</div> -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="m-0 text-uppercase">Product Sale Reports</h5>
                <hr class="mt-1">
                <form method="GET" action="">
                    <div class="d-flex mb-3">
                        <div class="p-1">
                            <input type="date" name="start_date" class="form-control"
                                value="<?= htmlspecialchars($start_date) ?>" title="Enter Start Date" required>
                        </div>
                        <div class="p-1">
                            <input type="date" name="end_date" class="form-control"
                                value="<?= htmlspecialchars($end_date) ?>" title="Enter End Date" required>
                        </div>
                        <div class="ms-auto p-1 filters">
                            <button type="submit" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Filter" class="btn btn-primary btn-sm"><i class='bx bx-filter-alt' ></i></button>
                            <a href="sale_reports.php" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Reset" class="btn btn-secondary btn-sm"><i class='bx bx-reset'></i></a>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="example" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>SrNo</th>
                                <th>Customer</th>
                                <th>Sale Date</th>
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
                                <td><?= htmlspecialchars($row['customer_name']) ?></td>
                                <td><?= htmlspecialchars($row['sale_date']) ?></td>
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