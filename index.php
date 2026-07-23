<?php
    ob_start(); // Prevents "headers already sent" errors by buffering output
    session_start();
?>
<?php include 'functions.php'; ?>
<?php email_send() ?>
<!DOCTYPE html>
<html>
<head>
    <!-- tab-icon -->
    <?php include('tab-name.php') ?>
    <!-- Bootstrap and Font Awesome css -->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Theme stylesheet -->
    <link href="css/style.default.css" rel="stylesheet" id="theme-stylesheet">
    <!-- owl carousel css -->
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/owl.theme.css" rel="stylesheet">

    <!-- CSS Animations -->
    <link href="css/animate.css" rel="stylesheet">
    <link rel="stylesheet" href="css/nlanding.css">

    <!-- Modernizr -->
    <script src="js/modernizr-2.6.2.min.js"></script>
    <style>
        /* Enhanced Modern Design Unified with Login/Registration Split-Screen Theme */
        :root {
            --primary-color: #2c3e50;
            --accent-color: #3498db;
            --light-bg: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #334155;
            --border-color: #e2e8f0;
        }

        body {
            background-color: var(--light-bg);
            color: var(--text-main);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Modern Glassmorphism/Flat Hybrid Navbar */
        .navigation {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }
        .navigation-list > li > a {
            color: var(--primary-color) !important;
            font-weight: 600;
            transition: color 0.2s ease;
        }
        .navigation-list > li.active > a, 
        .navigation-list > li > a:hover {
            color: var(--accent-color) !important;
        }

        /* Hero Panel Matching Login Split Aesthetic */
        .p1 {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 50%, #1d4ed8 100%);
            color: #ffffff;
            padding: 160px 0 120px 0;
            position: relative;
            overflow: hidden;
        }
        .p1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 40px;
            background: linear-gradient(to top, var(--light-bg), transparent);
        }
        .p1 h1 {
            font-weight: 800;
            letter-spacing: -0.5px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .p1 .msg {
            font-size: 1.25rem;
            opacity: 0.9;
            max-width: 700px;
            margin: 20px auto 30px auto;
            line-height: 1.6;
        }
        .login-button {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            color: #ffffff;
            padding: 12px 30px;
            border-radius: 50px;
            display: inline-block;
            font-weight: 600;
            font-size: 1.1rem;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            transition: transform 0.3s ease, background 0.3s ease;
        }
        .login-button:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.2);
        }

        /* Section Cards & Styling */
        .section {
            padding: 90px 0;
            background: var(--light-bg);
        }
        .section.alt-bg {
            background: var(--card-bg);
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }
        .title {
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 15px;
            letter-spacing: -0.5px;
        }
        
        /* Modern Feature Cards mimicking auth panels */
        .services .col-md-4 {
            padding: 15px;
        }
        .service-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 40px 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border: 1px solid var(--border-color);
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            height: 100%;
        }
        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.08);
            border-color: #93c5fd;
        }
        .services .icon {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: #ffffff;
            width: 75px;
            height: 75px;
            line-height: 75px;
            border-radius: 16px;
            text-align: center;
            font-size: 30px;
            margin: 0 auto 25px auto;
            box-shadow: 0 8px 20px rgba(29, 78, 216, 0.25);
        }
        .services .heading {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        .services p {
            color: #64748b;
            line-height: 1.6;
        }

        /* Testimonials / Carousel Cards */
        .testimonial {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.04);
            border: 1px solid var(--border-color);
            padding: 30px;
            transition: transform 0.3s ease;
        }
        .testimonial:hover {
            border-color: #cbd5e1;
        }
        .testimonial .bottom .name-picture img {
            border-radius: 50%;
            border: 2px solid var(--accent-color);
        }

        /* Contact Section */
        #section4 {
            background: linear-gradient(180deg, var(--light-bg) 0%, var(--card-bg) 100%);
        }
        .contact-box {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 50px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.04);
            border: 1px solid var(--border-color);
        }

        /* Footer */
        .footer-main {
            background: #0f172a;
            color: #94a3b8;
            padding: 50px 0;
            border-top: 1px solid #1e293b;
        }
        .footer-ul > li > a {
            color: #94a3b8;
            font-weight: 500;
            transition: color 0.2s ease;
        }
        .footer-ul > li > a:hover {
            color: #ffffff;
        }

        /* Auth Menu Button matching login action style */
        a.menu {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: #fff !important;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(29, 78, 216, 0.3);
            transition: all 0.2s ease;
        }
        a.menu:hover {
            opacity: 0.95;
            transform: translateY(-1px);
        }
    </style>
</head>
<body data-spy="scroll" data-target="#navigation" data-offset="120">

    <!-- ****************************** NAVBAR ********************************** -->
    <?php include('panels/navbar.php'); ?>
    <!-- /#navbar -->

    <div id="all">

        <!-- INTRO -->
        <?php include('panels/hero.php'); ?>

        <!-- INFO / SERVICES -->
        <?php include('panels/info.php'); ?>

        <!-- ABOUT US -->
        <?php include('panels/about.php'); ?>

        <!-- Barangay Profiles Panel -->
        <?php include('panels/barangays.php'); ?>

        <!-- CONTACT -->
        <?php include('panels/contact.php'); ?>

        <!-- FOOTER -->
        <?php include('panels/footer.php'); ?>

    </div>

    <!-- js base -->
    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- waypoints for scroll spy -->
    <script src="js/waypoints.min.js"></script>
    <!-- owl carousel -->
    <script src="js/owl.carousel.min.js"></script>
    <!-- jQuery scroll to -->
    <script src="js/jquery.scrollTo.min.js"></script>
    <!-- main js file -->
    <script src="js/front.js"></script>
</body>
</html>