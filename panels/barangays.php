<?php
// Fetch barangays from database with fallback to exact reference data
if (file_exists(__DIR__ . '/../config/db.php')) {
    require_once __DIR__ . '/../config/db.php';
} elseif (file_exists(__DIR__ . '/../db.php')) {
    require_once __DIR__ . '/../db.php';
}

$barangays = [];
if (isset($pdo) && $pdo instanceof PDO) {
    try {
        $stmt = $pdo->query("SELECT * FROM brgy_tbl ORDER BY brgy_name ASC");
        $barangays = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $barangays = [];
    }
} elseif (isset($conn) && $conn instanceof mysqli) {
    $result = $conn->query("SELECT * FROM brgy_tbl ORDER BY brgy_name ASC");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $barangays[] = $row;
        }
    }
}

// Fallback exact reference data if database is empty or not connected
if (empty($barangays)) {
    $barangays = [
        ['psgc' => '031414001', 'brgy_name' => 'Balatong A', 'brgy_alt_name' => 'South Munland', 'classification' => 'Urban', 'density' => '1,392', 'land_area_per_square_meter' => '1.19', 'c_pop' => '1,656'],
        ['psgc' => '031414002', 'brgy_name' => 'Balatong B', 'brgy_alt_name' => 'North Munland', 'classification' => 'Urban', 'density' => '1,932', 'land_area_per_square_meter' => '1.91', 'c_pop' => '3,690'],
        ['psgc' => '031414003', 'brgy_name' => 'Cutcot', 'brgy_alt_name' => 'Stravengie', 'classification' => 'Urban', 'density' => '2,221', 'land_area_per_square_meter' => '3.22', 'c_pop' => '7,152'],
        ['psgc' => '031414004', 'brgy_name' => 'Dampol 1st', 'brgy_alt_name' => 'Lower Dalapeny', 'classification' => 'Urban', 'density' => '4,129', 'land_area_per_square_meter' => '1.46', 'c_pop' => '6,028'],
        ['psgc' => '031414005', 'brgy_name' => 'Dampol 2nd A', 'brgy_alt_name' => 'Upper Dalapeny', 'classification' => 'Urban', 'density' => '3,642', 'land_area_per_square_meter' => '1.16', 'c_pop' => '4,225'],
        ['psgc' => '031414006', 'brgy_name' => 'Dampol 2nd B', 'brgy_alt_name' => 'New Dalapeny', 'classification' => 'Urban', 'density' => '3,180', 'land_area_per_square_meter' => '1.48', 'c_pop' => '4,706'],
        ['psgc' => '031414007', 'brgy_name' => 'Dulong Malabon', 'brgy_alt_name' => 'Cornerwood', 'classification' => 'Rural', 'density' => '720', 'land_area_per_square_meter' => '5.46', 'c_pop' => '3,931'],
        ['psgc' => '031414008', 'brgy_name' => 'Inaon', 'brgy_alt_name' => 'Brizzia', 'classification' => 'Urban', 'density' => '2,295', 'land_area_per_square_meter' => '3.50', 'c_pop' => '8,033'],
        ['psgc' => '031414009', 'brgy_name' => 'Longos', 'brgy_alt_name' => 'Lonivia', 'classification' => 'Urban', 'density' => '4,580', 'land_area_per_square_meter' => '1.19', 'c_pop' => '5,450'],
        ['psgc' => '031414010', 'brgy_name' => 'Lumbac', 'brgy_alt_name' => 'Valle de Bao', 'classification' => 'Rural', 'density' => '3,247', 'land_area_per_square_meter' => '1.24', 'c_pop' => '4,026'],
        ['psgc' => '031414011', 'brgy_name' => 'Paltao', 'brgy_alt_name' => 'Shantena', 'classification' => 'Urban', 'density' => '3,001', 'land_area_per_square_meter' => '2.18', 'c_pop' => '6,542'],
        ['psgc' => '031414012', 'brgy_name' => 'Peñabatan', 'brgy_alt_name' => 'Pineaville', 'classification' => 'Rural', 'density' => '644', 'land_area_per_square_meter' => '3.10', 'c_pop' => '1,996'],
        ['psgc' => '031414013', 'brgy_name' => 'Poblacion', 'brgy_alt_name' => 'Ciudad Centralle', 'classification' => 'Urban', 'density' => '5,326', 'land_area_per_square_meter' => '2.27', 'c_pop' => '12,090'],
        ['psgc' => '031414014', 'brgy_name' => 'Sta Peregrina', 'brgy_alt_name' => 'Perigine', 'classification' => 'Urban', 'density' => '1,028', 'land_area_per_square_meter' => '1.51', 'c_pop' => '1,552'],
        ['psgc' => '031414015', 'brgy_name' => 'Sto Cristo', 'brgy_alt_name' => 'La Croix', 'classification' => 'Urban', 'density' => '4,436', 'land_area_per_square_meter' => '1.54', 'c_pop' => '6,831'],
        ['psgc' => '031414016', 'brgy_name' => 'Taal', 'brgy_alt_name' => 'Mont Nord', 'classification' => 'Urban', 'density' => '2,779', 'land_area_per_square_meter' => '3.42', 'c_pop' => '9,504'],
        ['psgc' => '031414017', 'brgy_name' => 'Tabon', 'brgy_alt_name' => 'Tabostan', 'classification' => 'Rural', 'density' => '1,839', 'land_area_per_square_meter' => '2.37', 'c_pop' => '4,358'],
        ['psgc' => '031414018', 'brgy_name' => 'Tinejero', 'brgy_alt_name' => 'Atiny', 'classification' => 'Urban', 'density' => '3,283', 'land_area_per_square_meter' => '1.29', 'c_pop' => '4,235'],
        ['psgc' => '031414019', 'brgy_name' => 'Tibag', 'brgy_alt_name' => 'Zorbenia', 'classification' => 'Urban', 'density' => '3,087', 'land_area_per_square_meter' => '1.26', 'c_pop' => '3,890']
    ];
}
?>

<style>
    .barangay-section {
        padding: 90px 20px;
        background: #f1f5f9;
        position: relative;
    }
    body.night-mode .barangay-section {
        background: #0b0f19 !important;
    }
    .barangay-container {
        max-width: 1240px;
        margin: 0 auto;
    }
    .barangay-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 30px;
    }
    .barangay-header h2 {
        font-size: 2.3rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 12px;
    }
    body.night-mode .barangay-header h2 {
        color: #f8fafc !important;
    }
    .barangay-header p {
        color: #64748b;
        font-size: 1rem;
    }
    body.night-mode .barangay-header p {
        color: #94a3b8 !important;
    }

    /* Container Views */
    .view-wrapper {
        display: none;
    }
    .view-wrapper.active-view {
        display: block;
        animation: fadeInView 0.3s ease;
    }

    @keyframes fadeInView {
        from { opacity: 0; transform: translateY(6px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Table View Styles */
    .barangay-table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 24px;
        box-shadow: 0 15px 35px rgba(15, 23, 42, 0.05);
        overflow-x: auto;
    }
    body.night-mode .barangay-table-card {
        background: #0f172a;
        border-color: #1e293b;
    }
    .brgy-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 0.9rem;
    }
    .brgy-table th {
        background: #f8fafc;
        color: #334155;
        font-weight: 700;
        padding: 14px 16px;
        border-bottom: 2px solid #e2e8f0;
    }
    body.night-mode .brgy-table th {
        background: #1e293b;
        color: #cbd5e1;
        border-color: #334155;
    }
    .brgy-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #475569;
    }
    body.night-mode .brgy-table td {
        border-color: #1e293b;
        color: #94a3b8;
    }
    .brgy-table tr:hover td {
        background: #f8fafc;
        color: #0f172a;
    }
    body.night-mode .brgy-table tr:hover td {
        background: #1e293b;
        color: #f8fafc;
    }

    /* Carousel Multi-Item Container Styles */
    .carousel-outer-container {
        position: relative;
        max-width: 1160px;
        margin: 0 auto;
        padding: 40px 60px;
    }
    .carousel-viewport {
        overflow: hidden;
        width: 100%;
        padding: 30px 0;
    }
    .carousel-track {
        display: flex;
        gap: 24px;
        transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        will-change: transform;
    }

    /* Carousel Arrow Buttons */
    .carousel-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #1e293b;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 20;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.2s ease;
        font-size: 1.2rem;
        font-weight: bold;
    }
    body.night-mode .carousel-arrow {
        background: #0f172a;
        border-color: #334155;
        color: #f8fafc;
    }
    .carousel-arrow:hover {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.25);
    }
    .prev-arrow {
        left: 0;
    }
    .next-arrow {
        right: 0;
    }

    /* Modern Card Design */
    .brgy-card {
        flex: 0 0 100%; /* Mobile view: exactly 1 card displayed */
        box-sizing: border-box;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-top: 5px solid #2563eb;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.3s ease, box-shadow 0.3s ease, opacity 0.3s ease;
    }

    /* Tablet view: 2 cards displayed (left side active, not scaled) */
    @media (min-width: 768px) and (max-width: 1023px) {
        .brgy-card {
            flex: 0 0 calc(50% - 12px);
        }
        .brgy-card.tablet-left-active {
            transform: scale(1);
            opacity: 1;
            box-shadow: 0 15px 35px rgba(37, 99, 235, 0.12);
            z-index: 5;
        }
    }

    /* Desktop view: 3 cards displayed (center active, scaled 1.2) */
    @media (min-width: 1024px) {
        .brgy-card {
            flex: 0 0 calc(33.333% - 16px);
            opacity: 0.85;
        }
        .brgy-card.desktop-center-active {
            transform: scale(1.2);
            opacity: 1;
            z-index: 10;
            box-shadow: 0 25px 50px rgba(37, 99, 235, 0.2);
            border-top-width: 6px;
        }
    }

    .brgy-card.urban-card {
        border-top-color: #2563eb;
    }
    .brgy-card.rural-card {
        border-top-color: #16a34a;
    }
    body.night-mode .brgy-card {
        background: #0f172a;
        border-color: #1e293b;
    }
    body.night-mode .brgy-card.urban-card {
        border-top-color: #3b82f6;
    }
    body.night-mode .brgy-card.rural-card {
        border-top-color: #22c55e;
    }

    /* Card Header Default (Desktop & Tablet) */
    .brgy-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 12px;
    }
    body.night-mode .brgy-card-header {
        border-color: #1e293b;
    }
    .brgy-card-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        text-align: right;
        flex: 1;
        min-width: 0;
        overflow-wrap: break-word;
        word-break: normal;
    }
    body.night-mode .brgy-card-title {
        color: #f8fafc;
    }
    .brgy-card-psgc {
        font-size: 0.75rem;
        color: #64748b;
        background: #f1f5f9;
        padding: 4px 9px;
        border-radius: 6px;
        font-family: monospace;
        white-space: nowrap;
        font-weight: 600;
        flex-shrink: 0;
    }
    body.night-mode .brgy-card-psgc {
        background: #1e293b;
        color: #94a3b8;
    }

    /* Mobile View Overrides: Title on top of card, fully visible & not hidden */
    @media (max-width: 767px) {
        .carousel-outer-container {
            padding: 20px 10px;
        }
        .carousel-arrow {
            width: 38px;
            height: 38px;
            font-size: 1rem;
        }
        .prev-arrow {
            left: 2px;
        }
        .next-arrow {
            right: 2px;
        }
        .brgy-card-header {
            flex-direction: column-reverse;
            align-items: flex-start;
            gap: 8px;
        }
        .brgy-card-title {
            text-align: left;
            width: 100%;
            font-size: 1.25rem;
        }
        .brgy-card-psgc {
            align-self: flex-start;
        }
    }

    .brgy-card-body {
        display: flex;
        flex-direction: column;
        gap: 10px;
        font-size: 0.88rem;
        color: #475569;
        margin-bottom: 20px;
    }
    body.night-mode .brgy-card-body {
        color: #94a3b8;
    }
    .brgy-meta-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8fafc;
        padding: 8px 12px;
        border-radius: 10px;
    }
    body.night-mode .brgy-meta-item {
        background: #1e293b;
    }
    .brgy-meta-label {
        font-weight: 600;
        color: #64748b;
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    body.night-mode .brgy-meta-label {
        color: #94a3b8;
    }
    .brgy-card-footer {
        border-top: 1px solid #f1f5f9;
        padding-top: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    body.night-mode .brgy-card-footer {
        border-color: #1e293b;
    }
    .pop-rate-badge {
        font-weight: 700;
        color: #2563eb;
        background: rgba(37, 99, 235, 0.1);
        padding: 4px 10px;
        border-radius: 10px;
        font-size: 0.85rem;
    }
    body.night-mode .pop-rate-badge {
        color: #93c5fd;
        background: rgba(37, 99, 235, 0.2);
    }

    /* Action Buttons */
    .btn-action-copy {
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        color: #334155;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s ease;
    }
    body.night-mode .btn-action-copy {
        background: #1e293b;
        border-color: #334155;
        color: #cbd5e1;
    }
    .btn-action-copy:hover {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
    }

    /* Badges */
    .badge-urban {
        background: #dbeafe;
        color: #1e40af;
        padding: 3px 10px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    .badge-rural {
        background: #dcfce7;
        color: #166534;
        padding: 3px 10px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    body.night-mode .badge-urban {
        background: rgba(30, 64, 175, 0.3);
        color: #93c5fd;
    }
    body.night-mode .badge-rural {
        background: rgba(22, 101, 52, 0.3);
        color: #86efac;
    }

    /* Controls Bar at the Bottom */
    .controls-bar-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 35px;
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
    }
    .view-switcher {
        display: flex;
        gap: 10px;
    }
    .switch-btn, .btn-copy-all {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #334155;
        padding: 8px 18px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.88rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }
    body.night-mode .switch-btn, body.night-mode .btn-copy-all {
        background: #0f172a;
        border-color: #334155;
        color: #cbd5e1;
    }
    .switch-btn.active {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }
    .switch-btn:hover:not(.active), .btn-copy-all:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
    }
    body.night-mode .switch-btn:hover:not(.active), body.night-mode .btn-copy-all:hover {
        background: #1e293b;
        color: #f8fafc;
    }
    .btn-copy-all {
        background: #0ea5e9;
        color: #ffffff;
        border-color: #0ea5e9;
    }
    .btn-copy-all:hover {
        background: #0284c7 !important;
        color: #ffffff !important;
    }

    /* Toast Notification */
    .brgy-toast-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 10px;
        pointer-events: none;
    }
    .brgy-toast {
        pointer-events: auto;
        min-width: 280px;
        background: rgba(15, 23, 42, 0.95);
        color: #ffffff;
        padding: 12px 18px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        font-size: 0.88rem;
        font-weight: 600;
        backdrop-filter: blur(8px);
        animation: toastSlideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .brgy-toast.hide {
        animation: toastSlideDown 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes toastSlideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes toastSlideDown {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(20px); }
    }
</style>

<!-- Floating Toast Notification Container -->
<div class="brgy-toast-container" id="brgyToastContainer"></div>

<section id="section_barangays" class="barangay-section">
    <div class="barangay-container">
        <div class="barangay-header">
            <h2>Barangay Profiles of Pulilan</h2>
            <p>Official directory, classification, land area, population distribution, and demographic density across all 19 barangays.</p>
        </div>

        <?php if (!empty($barangays)): ?>
            
            <?php 
                $all_text_data = "";
                foreach ($barangays as $b) {
                    $all_text_data .= "PSGC: {$b['psgc']} | Name: {$b['brgy_name']} | Alt Name: {$b['brgy_alt_name']} | Class: {$b['classification']} | Land Area: {$b['land_area_per_square_meter']} km² | Density: {$b['density']} /km² | Pop Rate: {$b['c_pop']}\n";
                }
            ?>

            <!-- 1. TABLE VIEW CONTAINER -->
            <div id="tableViewWrapper" class="view-wrapper active-view">
                <div class="barangay-table-card">
                    <table class="brgy-table">
                        <thead>
                            <tr>
                                <th>PSGC</th>
                                <th>Barangay Name</th>
                                <th>Classification</th>
                                <th>Alt Name</th>
                                <th>Density (/km²)</th>
                                <th>Land Area (km²)</th>
                                <th>Population Rate</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($barangays as $row): ?>
                                <?php 
                                    $raw_data = "PSGC: {$row['psgc']}\nBarangay Name: {$row['brgy_name']}\nClassification: {$row['classification']}\nAlt Name: {$row['brgy_alt_name']}\nDensity: {$row['density']} /km²\nLand Area: {$row['land_area_per_square_meter']} km²\nPopulation Rate: {$row['c_pop']}";
                                ?>
                                <tr>
                                    <td><code><?php echo htmlspecialchars($row['psgc']); ?></code></td>
                                    <td><strong><?php echo htmlspecialchars($row['brgy_name']); ?></strong></td>
                                    <td>
                                        <?php if (strtolower($row['classification']) === 'urban'): ?>
                                            <span class="badge-urban">Urban</span>
                                        <?php else: ?>
                                            <span class="badge-rural">Rural</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['brgy_alt_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['density']); ?></td>
                                    <td><?php echo htmlspecialchars($row['land_area_per_square_meter']); ?></td>
                                    <td><strong><?php echo htmlspecialchars($row['c_pop']); ?></strong></td>
                                    <td style="text-align: center;">
                                        <button type="button" class="btn-action-copy" onclick="copyBarangayData(<?php echo htmlspecialchars(json_encode($raw_data), ENT_QUOTES, 'UTF-8'); ?>, '<?php echo htmlspecialchars($row['brgy_name'], ENT_QUOTES); ?>')">
                                            📋 Copy
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 2. CAROUSEL CARD VIEW CONTAINER -->
            <div id="cardViewWrapper" class="view-wrapper">
                <div class="carousel-outer-container" onmouseenter="pauseAutoplay()" onmouseleave="resumeAutoplay()">
                    <button type="button" class="carousel-arrow prev-arrow" onclick="slideCarousel(-1)" title="Previous Barangay">&#10094;</button>
                    <div class="carousel-viewport">
                        <div class="carousel-track" id="carouselTrack">
                            <?php foreach ($barangays as $index => $row): ?>
                                <?php 
                                    $raw_data = "PSGC: {$row['psgc']}\nBarangay Name: {$row['brgy_name']}\nClassification: {$row['classification']}\nAlt Name: {$row['brgy_alt_name']}\nDensity: {$row['density']} /km²\nLand Area: {$row['land_area_per_square_meter']} km²\nPopulation Rate: {$row['c_pop']}";
                                    $isUrban = (strtolower($row['classification']) === 'urban');
                                ?>
                                <div class="brgy-card <?php echo $isUrban ? 'urban-card' : 'rural-card'; ?>" data-index="<?php echo $index; ?>">
                                    <div>
                                        <!-- Card Header: Title on top of the card header on mobile, fully visible -->
                                        <div class="brgy-card-header">
                                            <h3 class="brgy-card-title"><?php echo htmlspecialchars($row['brgy_name']); ?></h3>
                                            <span class="brgy-card-psgc"><?php echo htmlspecialchars($row['psgc']); ?></span>
                                        </div>
                                        <div class="brgy-card-body">
                                            <div class="brgy-meta-item">
                                                <span class="brgy-meta-label">Classification</span>
                                                <?php if ($isUrban): ?>
                                                    <span class="badge-urban">Urban</span>
                                                <?php else: ?>
                                                    <span class="badge-rural">Rural</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="brgy-meta-item">
                                                <span class="brgy-meta-label">Alt Name</span>
                                                <span style="font-weight: 600; color: #0f172a;"><?php echo htmlspecialchars($row['brgy_alt_name']); ?></span>
                                            </div>
                                            <div class="brgy-meta-item">
                                                <span class="brgy-meta-label">Density</span>
                                                <span style="font-weight: 600; color: #0f172a;"><?php echo htmlspecialchars($row['density']); ?> /km²</span>
                                            </div>
                                            <div class="brgy-meta-item">
                                                <span class="brgy-meta-label">Land Area</span>
                                                <span style="font-weight: 600; color: #0f172a;"><?php echo htmlspecialchars($row['land_area_per_square_meter']); ?> km²</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="brgy-card-footer">
                                        <div>
                                            <span class="brgy-meta-label" style="font-size: 0.7rem; display:block; margin-bottom: 2px;">Population</span>
                                            <span class="pop-rate-badge"><?php echo htmlspecialchars($row['c_pop']); ?></span>
                                        </div>
                                        <button type="button" class="btn-action-copy" onclick="copyBarangayData(<?php echo htmlspecialchars(json_encode($raw_data), ENT_QUOTES, 'UTF-8'); ?>, '<?php echo htmlspecialchars($row['brgy_name'], ENT_QUOTES); ?>')">
                                            📋 Copy Data
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <button type="button" class="carousel-arrow next-arrow" onclick="slideCarousel(1)" title="Next Barangay">&#10095;</button>
                </div>
            </div>

            <!-- 3. CONTROLS BAR AT THE BOTTOM -->
            <div class="controls-bar-bottom">
                <div class="view-switcher">
                    <button type="button" class="switch-btn active" id="btnTableView" onclick="switchView('table')">
                        📋 Table View
                    </button>
                    <button type="button" class="switch-btn" id="btnCardView" onclick="switchView('card')">
                        🗂️ Carousel View
                    </button>
                </div>
                <div>
                    <button type="button" class="btn-copy-all" onclick="copyAllBarangaysData()">
                        📋 Copy All Barangays Data
                    </button>
                </div>
            </div>

        <?php else: ?>
            <div class="barangay-table-card" style="text-align: center; padding: 40px;">
                <p>No barangay records found. Please check your database connection.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
let currentIndex = 0;
let autoplayTimer = null;
const totalCards = <?php echo count($barangays); ?>;

function getVisibleCount() {
    if (window.innerWidth >= 1024) return 3; // Desktop
    if (window.innerWidth >= 768) return 2;  // Tablet
    return 1;                                // Mobile (1 card display)
}

function updateCarousel() {
    const track = document.getElementById('carouselTrack');
    if (!track) return;
    
    const visibleCount = getVisibleCount();
    const maxIndex = Math.max(0, totalCards - visibleCount);
    if (currentIndex > maxIndex) {
        currentIndex = maxIndex;
    }

    const cardElement = track.querySelector('.brgy-card');
    if (!cardElement) return;

    const cardWidth = cardElement.offsetWidth;
    const gap = 24;
    const moveAmount = currentIndex * (cardWidth + gap);
    track.style.transform = `translateX(-${moveAmount}px)`;

    const cards = track.querySelectorAll('.brgy-card');
    cards.forEach((card, idx) => {
        card.classList.remove('desktop-center-active', 'tablet-left-active');
        
        if (window.innerWidth >= 1024) {
            // Desktop: 3 cards, center active (index currentIndex + 1)
            if (idx === currentIndex + 1 && visibleCount === 3) {
                card.classList.add('desktop-center-active');
            }
        } else if (window.innerWidth >= 768 && window.innerWidth < 1024) {
            // Tablet: 2 cards, left active (index currentIndex)
            if (idx === currentIndex && visibleCount === 2) {
                card.classList.add('tablet-left-active');
            }
        }
    });
}

function slideCarousel(direction) {
    const visibleCount = getVisibleCount();
    const maxIndex = Math.max(0, totalCards - visibleCount);
    
    currentIndex += direction;
    if (currentIndex < 0) {
        currentIndex = maxIndex;
    } else if (currentIndex > maxIndex) {
        currentIndex = 0;
    }
    updateCarousel();
}

function switchView(viewType) {
    const tableView = document.getElementById('tableViewWrapper');
    const cardView = document.getElementById('cardViewWrapper');
    const btnTable = document.getElementById('btnTableView');
    const btnCard = document.getElementById('btnCardView');

    if (viewType === 'table') {
        tableView.classList.add('active-view');
        cardView.classList.remove('active-view');
        btnTable.classList.add('active');
        btnCard.classList.remove('active');
        stopAutoplay();
        localStorage.setItem('pulilan_brgy_view', 'table');
    } else {
        cardView.classList.add('active-view');
        tableView.classList.remove('active-view');
        btnCard.classList.add('active');
        btnTable.classList.remove('active');
        updateCarousel();
        startAutoplay();
        localStorage.setItem('pulilan_brgy_view', 'card');
    }
}

function startAutoplay() {
    stopAutoplay();
    autoplayTimer = setInterval(() => {
        if (document.hidden) return;
        slideCarousel(1);
    }, 4000);
}

function stopAutoplay() {
    if (autoplayTimer) {
        clearInterval(autoplayTimer);
        autoplayTimer = null;
    }
}

function pauseAutoplay() {
    stopAutoplay();
}

function resumeAutoplay() {
    const cardView = document.getElementById('cardViewWrapper');
    if (cardView && cardView.classList.contains('active-view')) {
        startAutoplay();
    }
}

function copyBarangayData(dataText, brgyName) {
    navigator.clipboard.writeText(dataText).then(() => {
        showBrgyToast(`✅ Copied full data for ${brgyName}!`);
    }).catch(err => {
        showBrgyToast(`❌ Failed to copy data.`);
    });
}

function copyAllBarangaysData() {
    const allData = <?php echo json_encode($all_text_data ?? ''); ?>;
    navigator.clipboard.writeText(allData).then(() => {
        showBrgyToast(`✅ Copied data for all 19 barangays!`);
    }).catch(err => {
        showBrgyToast(`❌ Failed to copy all data.`);
    });
}

function showBrgyToast(message) {
    const container = document.getElementById('brgyToastContainer');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = 'brgy-toast';
    toast.innerHTML = `
        <span>${message}</span>
        <button type="button" onclick="this.parentElement.remove()" style="background:none; border:none; color:#fff; font-weight:bold; cursor:pointer; font-size:1rem;">&times;</button>
    `;

    container.appendChild(toast);

    setTimeout(() => {
        toast.classList.add('hide');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

window.addEventListener('resize', () => {
    updateCarousel();
});

document.addEventListener('DOMContentLoaded', function() {
    const savedView = localStorage.getItem('pulilan_brgy_view');
    if (savedView === 'card') {
        switchView('card');
    }
});
</script>