<?php
include "components/navbar.php";
include "components/connection.php";
?>
<?php
// Fetch sale invoices
$invoices = $conn->query("
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
    ORDER BY si.sale_date DESC
");

// total Sale
$sale = "SELECT SUM(total_bill) AS sum_sale FROM sales";
$result = $conn->query($sale);
$totalSaleSum = 0;
if ($result && $row = $result->fetch_assoc()) {
    $totalSaleSum = $row['sum_sale'] ?? 0; 
}

// total Payment In
$PaymentIn = "SELECT SUM(paid_amount) AS sum_payment_in FROM sales";
$result = $conn->query($PaymentIn);
$totalPaymentIn = 0;
if ($result && $row = $result->fetch_assoc()) {
    $totalPaymentIn = $row['sum_payment_in'] ?? 0; 
}

// total Due Payent
$DuePayment = "SELECT SUM(balance_amount) AS sum_due_payment FROM sales";
$result = $conn->query($DuePayment);
$totalDuePayment = 0;
if ($result && $row = $result->fetch_assoc()) {
    $totalDuePayment = $row['sum_due_payment'] ?? 0; 
}
?>

<div class="row">
            <div class="col-lg-3 col-md-12 col-12 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success"
                                    class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1">Total Sale</p>
                        <h4 class="card-title">&#8377; <?php echo number_format($totalSaleSum, 2); ?></h4>
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
                        <h4 class="card-title">&#8377; <?php echo number_format($totalPaymentIn, 2); ?></h4>
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
                        <h4 class="card-title">&#8377; <?php echo number_format($totalDuePayment, 2); ?></h4>
                    </div>
                </div>
            </div>
        </div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="m-0 text-uppercase">Sale List</h5>
                <hr class="mt-1">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="example" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th></th>
                                <!-- <th>Invoice ID</th> -->
                                <th>customer</th>
                                <th>Sale Date</th>
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
                                        <!-- <td><?= htmlspecialchars($row['sale_id']) ?></td> -->
                                        <td><?= htmlspecialchars($row['customer_name']) ?></td>
                                        <td><?= htmlspecialchars($row['sale_date']) ?></td>
                                        <td>&#8377; <?= number_format($row['total_amount'], 2) ?></td>
                                        <td>&#8377; <?= number_format($row['total_gst'], 2) ?></td>
                                        <td>&#8377; <?= number_format($row['total_bill'], 2) ?></td>
                                        <td>&#8377; <?= number_format($row['paid_amount'], 2) ?></td>
                                        <td>&#8377; <?= number_format($row['balance_amount'], 2) ?></td>
                                        <td>
                                            <a href="view_sale.php?id=<?= $row['sale_id'] ?>" 
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