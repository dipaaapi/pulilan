<style>
    /* ==========================================
       INFO SECTION - MODERN SPOTLIGHT LAYOUT
    ========================================== */
    .info-v2-section {
        padding: 90px 20px;
        background: #ffffff;
        position: relative;
        overflow: hidden;
        width: 100%;
        box-sizing: border-box;
    }

    body.night-mode .info-v2-section {
        background: #0b1120 !important;
    }

    .info-container {
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
    }

    /* Section Header */
    .info-header {
        text-align: center;
        max-width: 750px;
        margin: 0 auto 60px;
    }

    .info-header .section-tag {
        display: inline-block;
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        font-size: 0.8rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 6px 16px;
        border-radius: 50px;
        margin-bottom: 16px;
    }

    body.night-mode .info-header .section-tag {
        background: #1e293b;
        color: #60a5fa;
        border-color: #334155;
    }

    .info-header h2 {
        font-size: 2.5rem;
        font-weight: 800;
        color: #0f172a !important;
        line-height: 1.25;
        margin: 0 0 16px 0;
        letter-spacing: -0.5px;
    }

    .info-header p {
        font-size: 1.05rem;
        color: #64748b !important;
        line-height: 1.6;
        margin: 0;
    }

    /* Asymmetric Spotlight Layout Grid */
    .spotlight-grid {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 30px;
        margin-bottom: 50px;
    }

    /* Main Highlight Card */
    .spotlight-main-card {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        border-radius: 28px;
        padding: 40px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 20px 40px rgba(37, 99, 235, 0.22);
    }

    .spotlight-main-card::after {
        content: '';
        position: absolute;
        bottom: -60px;
        right: -60px;
        width: 260px;
        height: 260px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        pointer-events: none;
    }

    .spotlight-main-card h3 {
        font-size: 1.8rem;
        font-weight: 800;
        color: #ffffff !important;
        margin: 0 0 16px 0;
        line-height: 1.3;
        position: static !important;
        background-color: transparent !important;
        width: 100% !important;
    }

    .spotlight-main-card p {
        color: #dbeafe !important;
        font-size: 1rem;
        line-height: 1.65;
        margin-bottom: 30px;
    }

    .impact-metrics-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        padding-top: 25px;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    .metric-item strong {
        display: block;
        font-size: 1.5rem;
        font-weight: 800;
        color: #ffffff;
    }

    .metric-item span {
        font-size: 0.78rem;
        color: #93c5fd;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    /* Side Feature Stack */
    .spotlight-side-stack {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .side-feature-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 24px;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        gap: 20px;
        align-items: flex-start;
    }

    body.night-mode .side-feature-card {
        background: #0f172a;
        border-color: #1e293b;
    }

    .side-feature-card:hover {
        transform: translateY(-3px);
        border-color: #93c5fd;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
    }

    .feature-card-icon {
        width: 48px;
        height: 48px;
        min-width: 48px;
        background: #eff6ff;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        border: 1px solid #bfdbfe;
    }

    body.night-mode .feature-card-icon {
        background: #1e293b;
        border-color: #334155;
    }

    .feature-card-content h4 {
        margin: 0 0 6px 0;
        font-size: 1.1rem;
        font-weight: 800;
        color: #0f172a !important;
        position: static !important;
    }

    .feature-card-content p {
        margin: 0;
        font-size: 0.88rem;
        color: #64748b !important;
        line-height: 1.5;
    }

    /* Emergency Preparedness Callout Banner */
    .emergency-banner {
        background: linear-gradient(135deg, #fef2f2 0%, #fff1f2 100%);
        border: 1px solid #fecdd3;
        border-radius: 24px;
        padding: 30px 35px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 25px;
        margin-bottom: 50px;
    }

    body.night-mode .emergency-banner {
        background: rgba(127, 29, 29, 0.15);
        border-color: #7f1d1d;
    }

    .emergency-text {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .emergency-icon {
        font-size: 2.2rem;
        background: #ffe4e6;
        width: 60px;
        height: 60px;
        min-width: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    body.night-mode .emergency-icon {
        background: #450a0a;
    }

    .emergency-info h4 {
        margin: 0 0 4px 0;
        font-size: 1.15rem;
        font-weight: 800;
        color: #991b1b !important;
        position: static !important;
    }

    body.night-mode .emergency-info h4 {
        color: #fca5a5 !important;
    }

    .emergency-info p {
        margin: 0;
        font-size: 0.9rem;
        color: #7f1d1d !important;
        line-height: 1.4;
    }

    body.night-mode .emergency-info p {
        color: #fecdd3 !important;
    }

    /* ==========================================
       FIXED FAQ CONTAINER & TITLE LOCKING
    ========================================== */
    .info-accordion-section {
        position: relative !important;
        display: block !important;
        background: #f8fafc;
        border-radius: 28px;
        padding: 40px;
        border: 1px solid #e2e8f0;
        width: 100% !important;
        box-sizing: border-box !important;
        clear: both !important;
    }

    body.night-mode .info-accordion-section {
        background: #0f172a;
        border-color: #1e293b;
    }

    /* Explicit positioning resets to fix the floating/unanchored FAQ Title */
    .info-accordion-section h3.faq-title {
        position: static !important;
        float: none !important;
        display: block !important;
        width: 100% !important;
        text-align: center !important;
        font-size: 1.6rem !important;
        font-weight: 800 !important;
        color: #0f172a !important;
        margin: 0 0 30px 0 !important;
        padding: 0 !important;
        left: auto !important;
        right: auto !important;
        top: auto !important;
        bottom: auto !important;
        transform: none !important;
    }

    body.night-mode .info-accordion-section h3.faq-title {
        color: #ffffff !important;
    }

    .accordion-item {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        margin-bottom: 12px;
        overflow: hidden;
        transition: border-color 0.2s ease;
    }

    body.night-mode .accordion-item {
        background: #1e293b;
        border-color: #334155;
    }

    .accordion-header {
        width: 100%;
        padding: 18px 24px;
        background: transparent;
        border: none;
        text-align: left;
        font-size: 0.98rem;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }

    body.night-mode .accordion-header {
        color: #f8fafc;
    }

    .accordion-icon {
        font-size: 1.1rem;
        transition: transform 0.3s ease;
    }

    .accordion-item.active .accordion-icon {
        transform: rotate(180deg);
    }

    .accordion-body {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s cubic-bezier(0, 1, 0, 1);
        padding: 0 24px;
    }

    .accordion-item.active .accordion-body {
        max-height: 300px;
        padding: 0 24px 20px 24px;
    }

    .accordion-body p {
        margin: 0;
        font-size: 0.9rem;
        color: #64748b !important;
        line-height: 1.6;
    }

    /* ==========================================
       RESPONSIVE BREAKPOINTS
    ========================================== */
    @media (max-width: 992px) {
        .spotlight-grid {
            grid-template-columns: 1fr;
        }

        .emergency-banner {
            flex-direction: column;
            text-align: center;
        }

        .emergency-text {
            flex-direction: column;
        }
    }

    @media (max-width: 600px) {
        .info-v2-section {
            padding: 60px 15px;
        }

        .info-header h2 {
            font-size: 1.85rem;
        }

        .spotlight-main-card {
            padding: 25px;
        }

        .impact-metrics-row {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .info-accordion-section {
            padding: 24px 16px;
        }
    }
</style>

<!-- Information Section Container (#section1 matches navbar anchor) -->
<section id="section1" class="info-v2-section">
    <div class="info-container">

        <!-- Section Header -->
        <div class="info-header">
            <span class="section-tag">Why Register?</span>
            <h2>One Unified System.<br>Endless Benefits for Pulilan.</h2>
            <p>
                The Pulilenyo Master Registration system isn't just a database—it's a vital digital bridge connecting every household to municipal resources, disaster relief, and faster public services.
            </p>
        </div>

        <!-- Asymmetric Spotlight Grid Layout -->
        <div class="spotlight-grid">
            
            <!-- Main Spotlight Card -->
            <div class="spotlight-main-card">
                <div>
                    <span style="background: rgba(255,255,255,0.2); padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                        🏛️ Municipal Progress
                    </span>
                    <h3 style="margin-top: 16px;">Direct Impact on Local Governance & Budgeting</h3>
                    <p>
                        When you register, you help the Municipality of Pulilan accurately gauge real-time population needs. Your census entry directly influences how local budgets are allocated—ensuring better roads, cleaner barangay facilities, and properly funded public schools where they matter most.
                    </p>
                </div>

                <!-- Core Impact Metrics -->
                <div class="impact-metrics-row">
                    <div class="metric-item">
                        <strong>100%</strong>
                        <span>Verified Identity</span>
                    </div>
                    <div class="metric-item">
                        <strong>3x</strong>
                        <span>Faster Processing</span>
                    </div>
                    <div class="metric-item">
                        <strong>24/7</strong>
                        <span>Digital Support</span>
                    </div>
                </div>
            </div>

            <!-- Side Feature Stack -->
            <div class="spotlight-side-stack">
                
                <!-- Feature 1 -->
                <div class="side-feature-card">
                    <div class="feature-card-icon">⚡</div>
                    <div class="feature-card-content">
                        <h4>Zero Repetitive Paperwork</h4>
                        <p>No more filling out duplicate forms at Town Hall. Your single registered account verifies your barangay residency instantly for certificates, permits, and clearances.</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="side-feature-card">
                    <div class="feature-card-icon">👨‍👩‍👧‍👦</div>
                    <div class="feature-card-content">
                        <h4>Family Social Welfare Protection</h4>
                        <p>Ensure your family is prioritized for local government assistance programs, senior citizen medical support, PWD benefits, and youth educational scholarships.</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="side-feature-card">
                    <div class="feature-card-icon">🔒</div>
                    <div class="feature-card-content">
                        <h4>Data Privacy Guarantee</h4>
                        <p>Your information is stored strictly in compliance with the Data Privacy Act of 2012 (R.A. 10173). Your records are encrypted and accessible only by authorized personnel.</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Emergency & Calamity Relief Alert Banner -->
        <div class="emergency-banner">
            <div class="emergency-text">
                <div class="emergency-icon">🚨</div>
                <div class="emergency-info">
                    <h4>Critical for Rapid Relief & Disaster Response</h4>
                    <p>
                        During natural disasters or typhoons, verified registered households receive emergency food packs, medical aid, and evacuation priority without master-list delays.
                    </p>
                </div>
            </div>
            <div>
                <a href="login.php" class="btn-hero-primary" style="padding: 10px 22px; font-size: 0.85rem; white-space: nowrap;">
                    Register Family Today
                </a>
            </div>
        </div>

        <!-- FAQ Accordion with Locked Title -->
        <div class="info-accordion-section">
            <h3 class="faq-title">Frequently Asked Questions</h3>

            <div class="accordion-item">
                <button class="accordion-header" onclick="toggleAccordion(this)">
                    <span>Who is eligible to register in the Pulilenyo system?</span>
                    <span class="accordion-icon">▼</span>
                </button>
                <div class="accordion-body">
                    <p>Any current resident of the Municipality of Pulilan, Bulacan—regardless of length of residency—can register. Head of households can also register their family members under a single unified record.</p>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-header" onclick="toggleAccordion(this)">
                    <span>Is there any registration fee required?</span>
                    <span class="accordion-icon">▼</span>
                </button>
                <div class="accordion-body">
                    <p>No. Registration in the official Pulilenyo resident portal is 100% free of charge provided by the Municipal Government of Pulilan.</p>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-header" onclick="toggleAccordion(this)">
                    <span>How does this system help during emergencies?</span>
                    <span class="accordion-icon">▼</span>
                </button>
                <div class="accordion-body">
                    <p>The municipal disaster risk reduction management office (MDRRMO) uses registered barangay counts to mobilize rescue operations and distribute relief packs accurately to every household in affected flood zones.</p>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
/**
 * Accordion Toggle Logic
 */
function toggleAccordion(button) {
    const item = button.parentElement;
    const isActive = item.classList.contains('active');
    
    // Close all other accordion items
    document.querySelectorAll('.accordion-item').forEach(el => {
        el.classList.remove('active');
    });

    // Toggle clicked item
    if (!isActive) {
        item.classList.add('active');
    }
}
</script>