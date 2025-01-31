</div>
<!-- / Content -->

<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl">
        <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
            <div class="text-body">
                © ClothEase
                <script>
                    document.write(new Date().getFullYear());
                </script>
                , By
                <a href="https://a2zithub.org/" target="_blank" class="footer-link">A2Z IT HUB PVT LTD</a>
            </div>
            <div class="d-none d-lg-inline-block">
                <a href="#" target="_blank" class="footer-link me-4">Documentation</a>

                <a href="support.php" class="footer-link">Support</a>
            </div>
        </div>
    </div>
</footer>
<!-- / Footer -->

<div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

<!-- <div class="buy-now">
    <a href="#" target="_blank" class="btn btn-danger btn-buy-now text-white">Support</a>
</div> -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->

<script src="../assets/vendor/libs/jquery/jquery.js"></script>
<script src="../assets/vendor/libs/popper/popper.js"></script>
<script src="../assets/vendor/js/bootstrap.js"></script>
<script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="../assets/vendor/js/menu.js"></script>

<!-- endbuild -->

<!-- data tables -->

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.print.min.js"></script>

<script>
    new DataTable('#example', {
        layout: {
            topStart: {
                buttons: ['csv', 'excel', 'pdf', 'print']
            }
        }
    });
</script>
<!-- Today Date script -->
<script>
    document.getElementById('today_date').value = new Date().toISOString().split('T')[0]
</script>

<!-- invoice js -->
<!-- <script src="invoice/js/vendor/jquery-3.6.0.min.js"></script>
<script src="invoice/js/app.min.js"></script>
<script src="invoice/js/main.js"></script> -->


<!-- Vendors JS -->
<script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>

<!-- Main JS -->
<script src="../assets/js/main.js"></script>

<!-- Page JS -->
<script src="../assets/js/dashboards-analytics.js"></script>

<!-- Place this tag before closing body tag for github widget button. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<!-- boxicon cdn -->
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

<!-- Fontawesome cdn -->
<script src="https://kit.fontawesome.com/c229a7ce14.js" crossorigin="anonymous"></script>

<!-- active menu link -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        var currentUrl = window.location.href;

        $('.menu-link').each(function () {
            if (this.href === currentUrl) {
                $(this).addClass('active'); 
                $(this).closest('.menu-item').addClass('open'); 
                $(this).closest('.menu-item').addClass('active'); 
            }
        });
    });
</script>

</body>

</html>