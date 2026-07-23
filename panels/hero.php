<style>
    /* ==========================================
       HERO SECTION STYLES
    ========================================== */
    .hero-v2-section {
        position: relative;
        padding: 140px 20px 80px; /* Top padding clears the floating navbar */
        background: linear-gradient(135deg, #f8fafc 0%, #eff6ff 50%, #e0f2fe 100%);
        overflow: hidden;
        z-index: 1;
    }

    /* Ambient Background Glow Accents */
    .hero-v2-section::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 450px;
        height: 450px;
        background: rgba(37, 99, 235, 0.12);
        filter: blur(90px);
        border-radius: 50%;
        z-index: -1;
    }

    .hero-v2-container {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 50px;
        align-items: center;
    }

    /* Left Content Column */
    .hero-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ffffff;
        border: 1px solid #bfdbfe;
        color: #2563eb;
        padding: 8px 18px;
        border-radius: 50px;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 24px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        color: #0f172a !important;
        line-height: 1.2;
        letter-spacing: -0.8px;
        margin: 0 0 20px 0;
    }

    .hero-title span {
        color: #2563eb;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-description {
        font-size: 1.1rem;
        color: #475569 !important;
        line-height: 1.7;
        margin-bottom: 35px;
    }

    /* CTA Button Group */
    .hero-cta-group {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 0;
    }

    .btn-hero-primary {
        background: #2563eb;
        color: #ffffff !important;
        padding: 14px 34px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.3);
    }

    .btn-hero-primary:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(37, 99, 235, 0.4);
    }

    .btn-hero-secondary {
        background: #ffffff;
        color: #0f172a !important;
        border: 1px solid #cbd5e1;
        padding: 14px 28px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-hero-secondary:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        transform: translateY(-2px);
    }

    /* Right Visual Card Widget */
    .hero-visual-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        border-radius: 28px;
        padding: 35px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
        position: relative;
    }

    .visual-card-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    }

    .visual-card-header .seal-icon {
        width: 55px;
        height: 55px;
        background: #eff6ff;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        border: 1px solid #bfdbfe;
    }

    .visual-card-header h4 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a !important;
    }

    .visual-card-header p {
        margin: 0;
        font-size: 0.82rem;
        color: #64748b !important;
    }

    /* Interactive Status Indicators inside Card */
    .visual-step-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .step-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: transform 0.2s ease;
    }

    .step-item:hover {
        transform: translateX(4px);
        border-color: #93c5fd;
    }

    .step-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .step-num {
        width: 28px;
        height: 28px;
        background: #2563eb;
        color: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.8rem;
    }

    .step-info span {
        font-size: 0.88rem;
        font-weight: 700;
        color: #1e293b;
    }

    .step-tag {
        font-size: 0.72rem;
        font-weight: 700;
        color: #16a34a;
        background: #dcfce7;
        padding: 4px 10px;
        border-radius: 50px;
    }

    /* ==========================================
       NIGHT MODE SPECIFIC OVERRIDES
    ========================================== */
    body.night-mode .hero-v2-section {
        background: linear-gradient(135deg, #090d16 0%, #0f172a 50%, #1e293b 100%) !important;
    }

    body.night-mode .hero-badge-pill {
        background: #1e293b;
        border-color: #334155;
        color: #60a5fa;
    }

    body.night-mode .btn-hero-secondary {
        background: #1e293b;
        color: #ffffff !important;
        border-color: #334155;
    }

    body.night-mode .hero-visual-card {
        background: rgba(15, 23, 42, 0.85);
        border-color: rgba(255, 255, 255, 0.1);
    }

    body.night-mode .visual-card-header .seal-icon {
        background: #1e293b;
        border-color: #334155;
    }

    body.night-mode .step-item {
        background: #1e293b;
        border-color: #334155;
    }

    body.night-mode .step-info span {
        color: #f8fafc;
    }

    /* ==========================================
       RESPONSIVE BREAKPOINTS
    ========================================== */
    @media (max-width: 992px) {
        .hero-v2-container {
            grid-template-columns: 1fr;
            text-align: center;
            gap: 40px;
        }

        .hero-title {
            font-size: 2.3rem;
        }

        .hero-badge-pill {
            margin-left: auto;
            margin-right: auto;
        }

        .hero-cta-group {
            justify-content: center;
        }
    }

    @media (max-width: 600px) {
        .hero-v2-section {
            padding: 110px 15px 50px;
        }

        .hero-title {
            font-size: 1.85rem;
        }

        .btn-hero-primary, .btn-hero-secondary {
            width: 100%;
            justify-content: center;
        }

        .hero-visual-card {
            padding: 22px;
        }
    }
</style>

<!-- Hero Section Container (#p1 matches the navbar anchor) -->
<section id="p1" class="hero-v2-section">
    <div class="hero-v2-container">
        
        <!-- Left Side: Call to Action Header -->
        <div class="hero-content">
            <div class="hero-badge-pill">
                <span>🇵🇭</span> Official Municipal Registration Portal
            </div>

            <h1 class="hero-title">
                Be Counted. Be Empowered.<br>
                <span>Register Your Pulilenyo Account Today.</span>
            </h1>

            <p class="hero-description">
                Join the official digital community database of Pulilan. By registering, you build an accurate, verified record for every resident—helping us deliver faster municipal services, emergency assistance, and public support directly to you, your family, and our entire community.
            </p>

            <div class="hero-cta-group">
                <!-- Direct link to login / registration -->
                <a href="login.php" class="btn-hero-primary">
                    Register Now <span>→</span>
                </a>
                <a href="#about_us" class="btn-hero-secondary">
                    Why Register?
                </a>
            </div>
        </div>

        <!-- Right Side: Interactive Registration Portal Preview -->
        <div class="hero-visual-card">
            <div class="visual-card-header">
                <div class="seal-icon">📜</div>
                <div>
                    <h4>Pulilenyo Digital Identification</h4>
                    <p>Securing every citizen's record in Bulacan</p>
                </div>
            </div>

            <div class="visual-step-list">
                <div class="step-item">
                    <div class="step-info">
                        <div class="step-num">1</div>
                        <span>Create Resident Account</span>
                    </div>
                    <span class="step-tag">Easy Step</span>
                </div>

                <div class="step-item">
                    <div class="step-info">
                        <div class="step-num">2</div>
                        <span>Verify Barangay Details</span>
                    </div>
                    <span class="step-tag">Secure</span>
                </div>

                <div class="step-item">
                    <div class="step-info">
                        <div class="step-num">3</div>
                        <span>Access Community Benefits</span>
                    </div>
                    <span class="step-tag">Instant</span>
                </div>
            </div>
        </div>

    </div>
</section>