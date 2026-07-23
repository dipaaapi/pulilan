<style>
    /* Main Footer Container */
    .site-footer {
        background: #0f172a;
        color: #94a3b8;
        padding: 70px 20px 30px;
        font-family: inherit;
        border-top: 1px solid #1e293b;
        position: relative;
        z-index: 10;
    }

    .footer-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1.2fr 0.8fr 1fr 1fr;
        gap: 40px;
        padding-bottom: 50px;
        border-bottom: 1px solid #1e293b;
    }

    /* Column Headings */
    .footer-col h4, 
    .footer-col h5 {
        color: #ffffff !important;
        font-size: 0.95rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin: 0 0 20px 0 !important;
    }

    /* Column 1: Municipal Brand & Info */
    .footer-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    .footer-brand img {
        height: 45px;
        width: auto;
        object-fit: contain;
    }

    .footer-text {
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 20px;
        color: #94a3b8;
    }

    .contact-info-list {
        list-style: none;
        padding: 0;
        margin: 0;
        font-size: 0.88rem;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .contact-info-list li {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Column Links */
    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .footer-links a {
        color: #cbd5e1;
        text-decoration: none;
        font-size: 0.88rem;
        transition: color 0.2s ease, transform 0.2s ease;
        display: inline-block;
    }

    .footer-links a:hover {
        color: #60a5fa;
        transform: translateX(3px);
    }

    /* Standard PH Government Badges */
    .gov-badge-box {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 12px;
        padding: 15px;
        margin-top: 15px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .gov-badge-icon {
        font-size: 1.8rem;
    }

    .gov-badge-text {
        font-size: 0.8rem;
        line-height: 1.4;
        color: #cbd5e1;
    }

    .gov-badge-text strong {
        color: #ffffff;
        display: block;
    }

    /* Bottom Copyright & Legal Strip */
    .footer-bottom {
        max-width: 1200px;
        margin: 30px auto 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        font-size: 0.85rem;
        color: #64748b;
    }

    .footer-bottom-links {
        display: flex;
        gap: 20px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-bottom-links a {
        color: #64748b;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .footer-bottom-links a:hover {
        color: #cbd5e1;
    }

    /* Responsive Breakdown */
    @media (max-width: 992px) {
        .footer-wrapper {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 600px) {
        .footer-wrapper {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        .footer-bottom {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<footer class="site-footer">
    <div class="footer-wrapper">
        
        <!-- Column 1: Local Municipal Identity -->
        <div class="footer-col">
            <div class="footer-brand">
                <img src="img/logo.png" alt="Pulilan Seal">
            </div>
            <p class="footer-text">
                Official web portal of the Municipal Government of Pulilan. Dedicated to delivering accessible public services, transparency, and community development.
            </p>
            <ul class="contact-info-list">
                <li>📍 Municipal Hall, Pulilan, Bulacan</li>
                <li>📞 (044) 815-0000</li>
                <li>✉️ contact@pulilan.gov.ph</li>
            </ul>
        </div>

        <!-- Column 2: Quick Navigation -->
        <div class="footer-col">
            <h4>Quick Links</h4>
            <ul class="footer-links">
                <li><a href="#p1">Home Portal</a></li>
                <li><a href="#section1">Public Info</a></li>
                <li><a href="#about_us">About Municipal Gov</a></li>
                <li><a href="#section4">Contact Us</a></li>
                <li><a href="login.php">Employee / Citizen Login</a></li>
            </ul>
        </div>

        <!-- Column 3: Republic of the Philippines Standard Links -->
        <div class="footer-col">
            <h4>Republic of the PH</h4>
            <ul class="footer-links">
                <li><a href="https://www.gov.ph" target="_blank" rel="noopener">GOV.PH Portal</a></li>
                <li><a href="https://www.officialgazette.gov.ph" target="_blank" rel="noopener">Official Gazette</a></li>
                <li><a href="https://data.gov.ph" target="_blank" rel="noopener">Open Data Portal</a></li>
                <li><a href="https://www.foi.gov.ph" target="_blank" rel="noopener">Freedom of Information (FOI)</a></li>
            </ul>

            <a href="https://www.foi.gov.ph/agencies/ntc/complaints/" target="_blank" rel="noopener" class="gov-badge-box">
                <img src="assets/img/foi.webp" alt="FOI Badge" class="gov-badge-icon" style="width: 40px; height: 40px;">
                <div class="gov-badge-text">
                    <strong>FOI Compliant</strong>
                    Freedom of Information Portal
                </div>
            </a>
        </div>

        <!-- Column 4: Government Executive Branches -->
        <div class="footer-col">
            <h4>Government Links</h4>
            <ul class="footer-links">
                <li><a href="https://op-proproper.gov.ph" target="_blank" rel="noopener">Office of the President</a></li>
                <li><a href="https://ovp.gov.ph" target="_blank" rel="noopener">Office of the Vice President</a></li>
                <li><a href="https://senate.gov.ph" target="_blank" rel="noopener">Senate of the Philippines</a></li>
                <li><a href="https://www.congress.gov.ph" target="_blank" rel="noopener">House of Representatives</a></li>
                <li><a href="https://sc.judiciary.gov.ph" target="_blank" rel="noopener">Supreme Court</a></li>
                <li><a href="https://sandigan.judiciary.gov.ph" target="_blank" rel="noopener">Sandiganbayan</a></li>
            </ul>
        </div>

    </div>

    <!-- Bottom Strip -->
    <div class="footer-bottom">
        <div>
            &copy; <?php echo date('Y'); ?> Municipality of Pulilan. All Rights Reserved.
        </div>
        <ul class="footer-bottom-links">
            <li><a href="#about_us">Privacy Policy</a></li>
            <li><a href="#about_us">Terms of Service</a></li>
            <li><a href="#about_us">Disclaimer</a></li>
        </ul>
    </div>
</footer>