        </div><!-- end page-wrapper -->
    </div><!-- end #wrapper -->

    <!-- ============================================================
         FOOTER COMPONENT (Fixed at bottom)
    ============================================================ -->
    <footer class="admin-footer">
        <div class="container-fluid d-flex justify-content-between align-items-center px-4">
            <span class="text-muted small">
                <i class="fa fa-copyright me-1"></i><?php echo date('Y'); ?> CBMS Pulilan &mdash; All Rights Reserved.
            </span>
            <div class="d-flex align-items-center gap-3">
                <a href="adminindex.php" class="text-muted small text-decoration-none" style="font-size:0.78rem">
                    <i class="fa fa-home me-1"></i>Dashboard
                </a>
                <span class="text-muted" style="font-size:0.75rem">|</span>
                <a href="change_password.php" class="text-muted small text-decoration-none" style="font-size:0.78rem">
                    <i class="fa fa-cog me-1"></i>Settings
                </a>
            </div>
        </div>
    </footer>

    <!-- Scroll to top button -->
    <button id="scrollTopBtn" title="Back to top">
        <i class="fa fa-chevron-up"></i>
    </button>

    <!-- ============================================================
         CORE SCRIPTS
    ============================================================ -->
    <script src="assets/plugins/jquery-1.10.2.js"></script>
    <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="assets/plugins/pace/pace.js"></script>

    <!-- Charts & DataTables (kept for legacy pages) -->
    <script src="assets/plugins/flot/jquery.flot.js"></script>
    <script src="assets/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="assets/plugins/flot/jquery.flot.resize.js"></script>
    <script src="assets/plugins/flot/jquery.flot.pie.js"></script>
    <script src="assets/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/plugins/morris/morris.js"></script>
    <script src="assets/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="assets/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- Bootstrap 5 JS Bundle (Kinakailangan para sa dropdown at collapse functionality) -->
    <script src="assets/plugins/bootstrap/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle mobile sidebar
        document.getElementById('sidebarToggleMobile')?.addEventListener('click', function () {
            document.getElementById('mainSidebar').classList.toggle('mobile-open');
        });

        // Scroll to top button logic (optional enhancement)
        window.addEventListener('scroll', function() {
            const btn = document.getElementById('scrollTopBtn');
            if (btn) {
                if (window.scrollY > 300) {
                    btn.classList.add('visible');
                } else {
                    btn.classList.remove('visible');
                }
            }
        });
    </script>

    <script>
    $(document).ready(function () {
        // Initialize DataTables if present
        if ($('#dataTables-example').length > 0 && $.fn.dataTable) {
            $('#dataTables-example').dataTable();
        }

        // Mobile sidebar toggle
        $('#sidebarToggleMobile').on('click', function () {
            $('#mainSidebar').toggleClass('mobile-open');
        });

        // Scroll to top button
        $(window).on('scroll', function () {
            if ($(this).scrollTop() > 200) {
                $('#scrollTopBtn').addClass('visible');
            } else {
                $('#scrollTopBtn').removeClass('visible');
            }
        });
        $('#scrollTopBtn').on('click', function () {
            $('html, body').animate({ scrollTop: 0 }, 400);
        });

        // Navbar live search (basic filter on current page links)
        $('#navbarSearch').on('keyup', function () {
            var query = $(this).val().toLowerCase();
            // highlight matching sidebar links
            $('.sidebar .nav-link .link-text').each(function () {
                var text = $(this).text().toLowerCase();
                var $link = $(this).closest('.nav-link');
                if (query.length > 0 && text.includes(query)) {
                    $link.css('color', '#fbbf24');
                } else {
                    $link.css('color', '');
                }
            });
        });
    });
    </script>

</body>
</html>