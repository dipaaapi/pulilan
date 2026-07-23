<style>
    /* Section & Container */
    .about-v2-section {
        padding: 90px 20px;
        background: #f1f5f9;
        position: relative;
        z-index: 1;
    }

    .about-v2-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 40px;
    }

    /* Section Title Header */
    .about-v2-header {
        text-align: center;
    }

    .about-v2-header h2 {
        font-size: 2.5rem;
        font-weight: 800;
        color: #0f172a !important;
        margin: 0 0 10px 0;
        letter-spacing: -0.5px;
    }

    .about-v2-header .divider {
        width: 60px;
        height: 4px;
        background: #2563eb;
        margin: 0 auto;
        border-radius: 2px;
    }

    /* Main Split Grid */
    .about-v2-grid {
        display: grid;
        grid-template-columns: 1.1fr 1fr;
        gap: 35px;
        align-items: stretch;
    }

    /* Left Mission Hero Card */
    .mission-hero-card {
        background: #ffffff !important;
        border: 1px solid #e2e8f0;
        border-radius: 28px;
        padding: 40px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.04);
        display: flex !important;
        flex-direction: column !important;
        justify-content: center;
        position: relative !important;
        overflow: hidden !important;
    }

    .mission-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #eff6ff;
        color: #2563eb;
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 16px;
        align-self: flex-start;
    }

    /* Lock the H3 inside the white card */
    .mission-hero-card h3 {
        position: static !important;
        float: none !important;
        font-size: 1.85rem !important;
        font-weight: 800 !important;
        color: #0f172a !important;
        line-height: 1.3 !important;
        margin: 0 0 16px 0 !important;
        display: block !important;
        opacity: 1 !important;
        visibility: visible !important;
        background: none !important;
        -webkit-text-fill-color: initial !important;
        width: 100% !important;
        text-align: center !important
    }

    .mission-hero-card p {
        color: #64748b !important;
        font-size: 1rem !important;
        line-height: 1.65 !important;
        margin: 0 0 25px 0 !important;
        text-align: justify !important;
    }

    .mission-stats {
        display: flex;
        gap: 30px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
    }

    .stat-item h5 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .stat-item p {
        font-size: 0.85rem;
        color: #94a3b8;
        margin: 0;
    }

    /* Right Vertical Carousel Mask */
    .carousel-wrapper {
        position: relative;
        height: 400px;
        overflow: hidden;
        border-radius: 28px;
        mask-image: linear-gradient(to bottom, transparent, black 12%, black 88%, transparent);
        -webkit-mask-image: linear-gradient(to bottom, transparent, black 12%, black 88%, transparent);
    }

    /* Animated Vertical Track */
    .vertical-track {
        display: flex;
        flex-direction: column;
        gap: 16px;
        animation: scrollUp 16s linear infinite;
    }

    /* Pause animation on hover */
    .carousel-wrapper:hover .vertical-track {
        animation-play-state: paused;
    }

    /* Individual Vertical Pillar Cards */
    .v-pillar-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 22px 26px;
        border-radius: 20px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.03);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: transform 0.3s ease, border-color 0.3s ease;
    }

    .v-pillar-card:hover {
        border-color: #2563eb;
        transform: scale(1.02);
    }

    .v-pillar-icon {
        width: 50px;
        height: 50px;
        min-width: 50px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
    }

    .v-pillar-text h4 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 4px 0;
    }

    .v-pillar-text p {
        font-size: 0.88rem;
        color: #64748b;
        margin: 0;
        line-height: 1.4;
    }

    /* Continuous Bottom-to-Top Keyframes */
    @keyframes scrollUp {
        0% {
            transform: translateY(0);
        }
        100% {
            transform: translateY(-50%);
        }
    }

    /* Legal Disclaimer Footer Card */
    .disclaimer-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        border-radius: 24px;
        padding: 35px 40px;
        display: flex;
        gap: 25px;
        align-items: flex-start;
        box-shadow: 0 15px 35px rgba(15, 23, 42, 0.12);
    }

    .disclaimer-banner .badge-icon {
        background: rgba(255, 255, 255, 0.1);
        width: 48px;
        height: 48px;
        min-width: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    .disclaimer-banner h4 {
        font-size: 1.2rem;
        font-weight: 700;
        color: #ffffff !important;
        margin: 0 0 8px 0;
    }

    .disclaimer-banner p {
        color: #94a3b8;
        font-size: 0.92rem;
        margin: 0 0 12px 0;
        line-height: 1.6;
    }

    .disclaimer-banner ul {
        margin: 0;
        padding-left: 18px;
        color: #cbd5e1;
        font-size: 0.88rem;
        line-height: 1.6;
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .about-v2-grid {
            grid-template-columns: 1fr;
        }
        .carousel-wrapper {
            height: 320px;
        }
    }

    @media (max-width: 600px) {
        .disclaimer-banner {
            flex-direction: column;
            padding: 25px;
        }
        .mission-hero-card {
            padding: 30px 20px;
        }
        .mission-stats {
            flex-direction: column;
            gap: 15px;
        }
    }
</style>

<section id="about_us" class="about-v2-section">
    <div class="about-v2-container">
        
        <!-- Header -->
        <div class="about-v2-header">
            <h2>About the Platform</h2>
            <div class="divider"></div>
        </div>

        <!-- Main Split Layout -->
        <div class="about-v2-grid">
            
            <!-- Left Side: Mission Hero Card -->
            <div class="mission-hero-card">
                <div class="mission-pill">
                    <span>•</span> Public Service Portal
                </div>
                
                <!-- Explicitly Styled Title Inside the Card -->
                <h3>Empowering Pulilenyos Through Digital Innovation</h3>
                
                <p>
                    The Municipality of Pulilan is committed to providing a transparent, accessible, and user-centric platform. This web portal streamlines communication, public announcements, and citizen inquiry management across all barangays.
                </p>
                
                <div class="mission-stats">
                    <div class="stat-item">
                        <h5>100%</h5>
                        <p>Digital Access</p>
                    </div>
                    <div class="stat-item">
                        <h5>24/7</h5>
                        <p>Inquiry Submission</p>
                    </div>
                </div>
            </div>

            <!-- Right Side: Auto-Play Vertical Carousel -->
            <div class="carousel-wrapper" title="Hover to pause scroll">
                <div class="vertical-track">
                    
                    <!-- Original 4 Cards -->
                    <div class="v-pillar-card">
                        <div class="v-pillar-icon">🏛️</div>
                        <div class="v-pillar-text">
                            <h4>Heritage</h4>
                            <p>Preserving Pulilan's rich cultural legacy and vibrant community spirit.</p>
                        </div>
                    </div>

                    <div class="v-pillar-card">
                        <div class="v-pillar-icon">🤝</div>
                        <div class="v-pillar-text">
                            <h4>Transparency</h4>
                            <p>Open and direct communication channels between officials and citizens.</p>
                        </div>
                    </div>

                    <div class="v-pillar-card">
                        <div class="v-pillar-icon">⚡</div>
                        <div class="v-pillar-text">
                            <h4>Accessibility</h4>
                            <p>Fast, user-friendly digital services available whenever you need them.</p>
                        </div>
                    </div>

                    <div class="v-pillar-card">
                        <div class="v-pillar-icon">🛡️</div>
                        <div class="v-pillar-text">
                            <h4>Security</h4>
                            <p>Ensuring data privacy and encrypted storage across database records.</p>
                        </div>
                    </div>

                    <!-- Duplicated 4 Cards for Seamless Loop -->
                    <div class="v-pillar-card">
                        <div class="v-pillar-icon">🏛️</div>
                        <div class="v-pillar-text">
                            <h4>Heritage</h4>
                            <p>Preserving Pulilan's rich cultural legacy and vibrant community spirit.</p>
                        </div>
                    </div>

                    <div class="v-pillar-card">
                        <div class="v-pillar-icon">🤝</div>
                        <div class="v-pillar-text">
                            <h4>Transparency</h4>
                            <p>Open and direct communication channels between officials and citizens.</p>
                        </div>
                    </div>

                    <div class="v-pillar-card">
                        <div class="v-pillar-icon">⚡</div>
                        <div class="v-pillar-text">
                            <h4>Accessibility</h4>
                            <p>Fast, user-friendly digital services available whenever you need them.</p>
                        </div>
                    </div>

                    <div class="v-pillar-card">
                        <div class="v-pillar-icon">🛡️</div>
                        <div class="v-pillar-text">
                            <h4>Security</h4>
                            <p>Ensuring data privacy and encrypted storage across database records.</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- Bottom: Legal & System Disclaimer -->
        <div class="disclaimer-banner">
            <div class="badge-icon">⚖️</div>
            <div class="disclaimer-text">
                <h4>System & Legal Disclaimer</h4>
                <p>Please review the operational terms for the Pulilenyo Information Portal:</p>
                <ul>
                    <li><strong>Official Usage:</strong> Platform created solely for official public information and inquiry handling in Pulilan, Bulacan.</li>
                    <li><strong>Data Security:</strong> User submissions are securely transferred into local database structures (`message_tbl`).</li>
                    <li><strong>Policy Updates:</strong> Government notices and procedural guidelines are regularly updated to reflect current municipal ordinances.</li>
                </ul>
            </div>
        </div>

    </div>
</section>