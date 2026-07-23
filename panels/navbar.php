<?php
// Ensure session is started without throwing header warnings
if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    session_start();
}

// Check logged in state
$is_logged_in = isset($_SESSION['user_id']) || isset($_SESSION['username']);
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'User';
$user_avatar = isset($_SESSION['user_image']) && !empty($_SESSION['user_image']) ? $_SESSION['user_image'] : 'img/default-avatar.png';
?>

<style>
    /* ==========================================
       1. GLOBAL ACCESSIBILITY & THEME ENGINE
       (Applies across the ENTIRE page/index.php)
    ========================================== */
    html {
        font-size: 100%; /* Default Root Base */
        transition: font-size 0.25s ease;
    }

    /* Page-Wide Night Mode Rules */
    body.night-mode {
        background-color: #090d16 !important;
        color: #f1f5f9 !important;
    }

    body.night-mode section,
    body.night-mode header,
    body.night-mode footer,
    body.night-mode main,
    body.night-mode div.card,
    body.night-mode [class*="-card"],
    body.night-mode [class*="-container"],
    body.night-mode [class*="-box"],
    body.night-mode [class*="-section"],
    body.night-mode .about-v2-section {
        background-color: #0f172a !important;
        border-color: #1e293b !important;
        color: #f8fafc !important;
    }

    body.night-mode h1, 
    body.night-mode h2, 
    body.night-mode h3, 
    body.night-mode h4, 
    body.night-mode h5, 
    body.night-mode h6 {
        color: #ffffff !important;
    }

    body.night-mode p, 
    body.night-mode span:not(.dashboard-btn):not(.login-btn):not(.mission-pill), 
    body.night-mode li,
    body.night-mode label {
        color: #cbd5e1 !important;
    }

    /* Page-Wide High Contrast Overrides */
    body.high-contrast-mode,
    body.high-contrast-mode * {
        background-color: #000000 !important;
        color: #ffff00 !important;
        border-color: #ffff00 !important;
        box-shadow: none !important;
        text-shadow: none !important;
    }

    body.high-contrast-mode a,
    body.high-contrast-mode button {
        color: #ffff00 !important;
        text-decoration: underline !important;
    }

    /* ==========================================
       2. NAVBAR DESIGN & GLASSMORPHISM
    ========================================== */
    .navbar-floating {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        width: calc(100% - 40px);
        max-width: 1200px;
        background: rgba(255, 255, 255, 0.88);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 100px;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.06), 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.8);
        z-index: 1050;
        padding: 8px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    body.night-mode .navbar-floating {
        background: rgba(15, 23, 42, 0.88) !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4) !important;
    }

    /* Brand Logo */
    .nav-brand {
        display: flex;
        align-items: center;
        text-decoration: none;
    }

    .nav-brand img {
        height: 42px;
        width: auto;
        object-fit: contain;
        transition: transform 0.2s ease;
    }

    .nav-brand:hover img {
        transform: scale(1.03);
    }

    /* Navigation Links */
    .nav-links {
        display: flex;
        align-items: center;
        gap: 32px;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .nav-links a {
        color: #475569 !important;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        text-decoration: none;
        transition: color 0.2s ease, transform 0.2s ease;
        position: relative;
    }

    body.night-mode .nav-links a {
        color: #cbd5e1 !important;
    }

    .nav-links a:hover {
        color: #2563eb !important;
    }

    body.night-mode .nav-links a:hover {
        color: #60a5fa !important;
    }

    /* Action Controls & User Area */
    .nav-actions {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .acc-controls {
        display: flex;
        align-items: center;
        gap: 6px;
        padding-right: 14px;
        border-right: 2px solid #e2e8f0;
    }

    body.night-mode .acc-controls {
        border-right-color: #334155;
    }

    .acc-btn {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        color: #475569;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.82rem;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    body.night-mode .acc-btn {
        background: #1e293b;
        border-color: #334155;
        color: #cbd5e1;
    }

    .acc-btn:hover {
        background: #2563eb;
        color: #ffffff !important;
        border-color: #2563eb;
        transform: translateY(-2px);
    }

    /* Login & Dashboard Buttons */
    .login-btn {
        background: #0f172a;
        color: #ffffff !important;
        padding: 9px 24px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.18);
    }

    .login-btn:hover {
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.32);
    }

    /* User Profile Pill */
    .user-profile-menu {
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(241, 245, 249, 0.9);
        padding: 4px 6px 4px 6px;
        border-radius: 50px;
        border: 1px solid #cbd5e1;
    }

    body.night-mode .user-profile-menu {
        background: rgba(30, 41, 59, 0.9);
        border-color: #334155;
    }

    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #2563eb;
    }

    .user-name {
        font-size: 0.82rem;
        font-weight: 700;
        color: #0f172a;
        max-width: 110px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding-right: 2px;
    }

    body.night-mode .user-name {
        color: #f8fafc !important;
    }

    .dashboard-btn {
        background: #2563eb;
        color: #ffffff !important;
        padding: 7px 16px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .dashboard-btn:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    /* Mobile Hamburger Menu Icon */
    .mobile-toggle-btn {
        display: none;
        background: transparent;
        border: none;
        font-size: 1.4rem;
        color: #0f172a;
        cursor: pointer;
        padding: 4px;
    }

    body.night-mode .mobile-toggle-btn {
        color: #f8fafc;
    }

    /* Scroll to Top Floating Button */
    .scroll-top-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: #2563eb;
        color: #ffffff;
        border: none;
        width: 46px;
        height: 46px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        cursor: pointer;
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        z-index: 1040;
    }

    .scroll-top-btn.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .scroll-top-btn:hover {
        background: #1d4ed8;
        transform: translateY(-3px);
    }

    /* ==========================================
       3. RESPONSIVE BREAKPOINTS (All Dimensions)
    ========================================== */
    @media (max-width: 992px) {
        .navbar-floating {
            padding: 10px 18px;
            border-radius: 24px;
        }

        .mobile-toggle-btn {
            display: block;
        }

        .nav-links {
            position: absolute;
            top: 68px;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 20px;
            flex-direction: column;
            gap: 18px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(226, 232, 240, 0.8);
            display: none; /* Controlled by JS */
        }

        body.night-mode .nav-links {
            background: rgba(15, 23, 42, 0.96) !important;
            border-color: #334155 !important;
        }

        .nav-links.active {
            display: flex;
        }
    }

    @media (max-width: 600px) {
        .navbar-floating {
            width: calc(100% - 24px);
            top: 12px;
            padding: 8px 14px;
        }

        .user-name {
            display: none; /* Hide name on small mobile phones to conserve space */
        }

        .acc-controls {
            padding-right: 8px;
            gap: 4px;
        }

        .acc-btn {
            width: 32px;
            height: 32px;
            font-size: 0.75rem;
        }

        .login-btn, .dashboard-btn {
            padding: 7px 14px;
            font-size: 0.75rem;
        }
    }
</style>

<!-- Floating Navbar -->
<div class="navbar-floating" role="navigation">
    <!-- Brand Logo -->
    <a href="index.php" class="nav-brand">
        <img src="img/logo.png" alt="Pulilan Logo">
    </a>

    <!-- Navigation Links -->
    <ul class="nav-links" id="navLinks">
        <li><a href="#p1" onclick="closeMobileMenu()">Home</a></li>
        <li><a href="#section1" onclick="closeMobileMenu()">Info</a></li>
        <li><a href="#about_us" onclick="closeMobileMenu()">About Us</a></li>
        <li><a href="#section4" onclick="closeMobileMenu()">Contact</a></li>
    </ul>

    <!-- Action Buttons -->
    <div class="nav-actions">
        <!-- Accessibility & Theme Controls -->
        <div class="acc-controls">
            <button class="acc-btn" onclick="setPageAccessibility('normal')" title="Standard Text Size">A</button>
            <button class="acc-btn" onclick="setPageAccessibility('large')" title="Large Text Size (Page-wide)">A+</button>
            <button class="acc-btn" onclick="toggleNightMode()" id="nightModeBtn" title="Toggle Night Mode">🌙</button>
            <button class="acc-btn" onclick="toggleHighContrast()" title="Toggle High Contrast">👁️</button>
        </div>
        
        <!-- Login or Dashboard State -->
        <?php if ($is_logged_in): ?>
            <div class="user-profile-menu">
                <img src="<?php echo htmlspecialchars($user_avatar); ?>" alt="Profile" class="user-avatar" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($username); ?>&background=2563eb&color=fff';">
                <span class="user-name"><?php echo htmlspecialchars($username); ?></span>
                <a href="dashboard.php" class="dashboard-btn">Dashboard</a>
            </div>
        <?php else: ?>
            <a href="login.php" class="login-btn">Login</a>
        <?php endif; ?>

        <!-- Mobile Menu Hamburger Button -->
        <button class="mobile-toggle-btn" onclick="toggleMobileMenu()" aria-label="Toggle Menu">
            ☰
        </button>
    </div>
</div>

<!-- Scroll to Top Button -->
<button id="scrollTopBtn" class="scroll-top-btn" onclick="scrollToTop()" aria-label="Scroll to top">
    ↑
</button>

<script>
/**
 * 1. Page-Wide Font Scaling (Affects index.php entirely)
 */
function setPageAccessibility(size) {
    const rootHtml = document.documentElement;
    if (size === 'large') {
        rootHtml.style.fontSize = '115%'; // Scales all rem values across the entire page
    } else {
        rootHtml.style.fontSize = '100%';
    }
    localStorage.setItem('page_font_size', size);
}

/**
 * 2. Page-Wide Night Mode Toggle
 */
function toggleNightMode() {
    document.body.classList.toggle('night-mode');
    const isNight = document.body.classList.contains('night-mode');
    
    // Update Button Icon
    const btn = document.getElementById('nightModeBtn');
    if (btn) {
        btn.innerHTML = isNight ? '☀️' : '🌙';
    }
    
    // Store preference
    localStorage.setItem('theme_mode', isNight ? 'night' : 'light');
}

/**
 * 3. Page-Wide High Contrast Toggle
 */
function toggleHighContrast() {
    document.body.classList.toggle('high-contrast-mode');
    const isContrast = document.body.classList.contains('high-contrast-mode');
    localStorage.setItem('high_contrast', isContrast ? 'enabled' : 'disabled');
}

/**
 * 4. Responsive Mobile Navigation Menu
 */
function toggleMobileMenu() {
    const navLinks = document.getElementById('navLinks');
    if (navLinks) {
        navLinks.classList.toggle('active');
    }
}

function closeMobileMenu() {
    const navLinks = document.getElementById('navLinks');
    if (navLinks) {
        navLinks.classList.remove('active');
    }
}

/**
 * 5. Initialize Preferences on Page Load
 */
document.addEventListener('DOMContentLoaded', function() {
    // Restore Saved Theme Mode
    const savedTheme = localStorage.getItem('theme_mode');
    if (savedTheme === 'night') {
        document.body.classList.add('night-mode');
        const btn = document.getElementById('nightModeBtn');
        if (btn) btn.innerHTML = '☀️';
    }

    // Restore Font Size
    const savedFontSize = localStorage.getItem('page_font_size');
    if (savedFontSize === 'large') {
        setPageAccessibility('large');
    }

    // Restore High Contrast Mode
    const savedContrast = localStorage.getItem('high_contrast');
    if (savedContrast === 'enabled') {
        document.body.classList.add('high-contrast-mode');
    }
});

/**
 * 6. Smooth Scroll to Top Logic
 */
const scrollTopBtn = document.getElementById('scrollTopBtn');

window.addEventListener('scroll', function() {
    if (window.scrollY > 280) {
        scrollTopBtn.classList.add('show');
    } else {
        scrollTopBtn.classList.remove('show');
    }
});

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}
</script>