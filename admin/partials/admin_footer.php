</main>
</div>

<footer class="admin-footer">
    <div>&copy; <?php echo date('Y'); ?> <strong>CBMS Pulilan</strong>. All rights reserved.</div>
    <div>Admin Dashboard v2.0</div>
</footer>

<button id="scrollTopBtn" title="Go to top">
    <i class="fa fa-chevron-up"></i>
</button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
(function () {
    document.querySelectorAll('[data-submenu]').forEach(function (trigger) {
        trigger.addEventListener('click', function (event) {
            event.preventDefault();
            const submenuId = this.getAttribute('data-submenu');
            const submenu = document.getElementById(submenuId);
            const isOpen = submenu && submenu.classList.contains('open');
            document.querySelectorAll('.submenu.open').forEach((menu) => menu.classList.remove('open'));
            document.querySelectorAll('.submenu-trigger[aria-expanded="true"]').forEach((btn) => btn.setAttribute('aria-expanded', 'false'));
            if (!isOpen && submenu) {
                submenu.classList.add('open');
                this.setAttribute('aria-expanded', 'true');
            }
        });
    });

    const sidebarToggle = document.getElementById('sidebarToggleMobile');
    const sidebar = document.getElementById('mainSidebar');
    sidebarToggle && sidebarToggle.addEventListener('click', function () {
        sidebar && sidebar.classList.toggle('mobile-open');
    });

    document.addEventListener('click', function (event) {
        if (window.innerWidth > 768) return;
        if (!sidebar || !sidebarToggle) return;
        if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
            sidebar.classList.remove('mobile-open');
        }
    });

    const scrollBtn = document.getElementById('scrollTopBtn');
    window.addEventListener('scroll', function () {
        if (!scrollBtn) return;
        scrollBtn.classList.toggle('visible', window.scrollY > 300);
    });
    scrollBtn && scrollBtn.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: 'smooth' }); });
})();
</script>
</body>
</html>