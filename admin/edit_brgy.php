<?php
session_start();

include('navbar.php');

if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

if (isset($_POST['update_brgy'])) {
    // Form processing logic

    if (isset($connection)) { // Use $connection from the included file
        $brgydetails_id_post = $_POST['brgydetails_id'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $contact = $_POST['contact'];
        $gender = $_POST['gender'];
        $position = $_POST['position'];
        $brgy_location = $_POST['brgy_location'];
        $no_purok = $_POST['no_purok'];
        $major_sources = $_POST['major_sources'];
        $brgy_classification = $_POST['brgy_classification'];
        $char_brgy = $_POST['char_brgy'];
        $male_tanod = $_POST['male_tanod'];
        $female_tanod = $_POST['female_tanod'];
        $male_health_worker = $_POST['male_health_worker'];
        $female_health_worker = $_POST['female_health_worker'];
        $male_nutrition_scholar = $_POST['male_nutrition_scholar'];
        $female_nutrition_scholar = $_POST['female_nutrition_scholar'];
        $male_purok_leaders = $_POST['male_purok_leaders'];
        $female_purok_leaders = $_POST['female_purok_leaders'];
        $male_librarian = $_POST['male_librarian'];
        $female_librarian = $_POST['female_librarian'];
        $male_day_care_worker = $_POST['male_day_care_worker'];
        $female_day_care_worker = $_POST['female_day_care_worker'];
        $male_utility_worker = $_POST['male_utility_worker'];
        $female_utility_worker = $_POST['female_utility_worker'];

        $stmt = mysqli_prepare($connection, "UPDATE brgydetails_tbl SET fullname=?, email=?, username=?, contact=?, gender=?, position=?, brgy_location=?, no_purok=?, major_sources=?, brgy_classification=?, char_brgy=?, male_tanod=?, female_tanod=?, male_health_worker=?, female_health_worker=?, male_nutrition_scholar=?, female_nutrition_scholar=?, male_purok_leaders=?, female_purok_leaders=?, male_librarian=?, female_librarian=?, male_day_care_worker=?, female_day_care_worker=?, male_utility_worker=?, female_utility_worker=? WHERE brgydetails_id = ?");

        mysqli_stmt_bind_param($stmt, 'sssssssisssiiiiiiiiiiiiiii', $fullname, $email, $username, $contact, $gender, $position, $brgy_location, $no_purok, $major_sources, $brgy_classification, $char_brgy, $male_tanod, $female_tanod, $male_health_worker, $female_health_worker, $male_nutrition_scholar, $female_nutrition_scholar, $male_purok_leaders, $female_purok_leaders, $male_librarian, $female_librarian, $male_day_care_worker, $female_day_care_worker, $male_utility_worker, $female_utility_worker, $brgydetails_id_post);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['update_success'] = "Barangay details updated successfully!";
        } else {
            $_SESSION['update_error'] = "Failed to update barangay details: " . mysqli_error($connection);
        }
        mysqli_stmt_close($stmt);

        header("Location: brgylist_table.php");
        exit();
    }
}

$brgydetails_id = $_GET['brgydetails_id'] ?? null;

if (!$brgydetails_id) {
    // Redirect or show an error if no ID is provided
    // This redirect is safe now because it's after the form processing block.
    header("Location: brgylist_table.php");
    exit();
}

// Fetch existing data
$stmt = mysqli_prepare($connection, "SELECT * FROM brgydetails_tbl WHERE brgydetails_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $brgydetails_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$data) {
    // Handle case where record is not found
    $_SESSION['update_error'] = "Barangay account not found.";
    header("Location: brgylist_table.php");
    exit();
}
?>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center mt-3 mb-3 border-bottom pb-2">
            <h2 class="text-secondary mb-0">
                <i class="fa fa-pencil-square-o me-2"></i> Edit Barangay Account
            </h2>
            <a href="brgylist_table.php" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-arrow-left me-1"></i> Back to Accounts
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="POST" action="edit_brgy.php?brgydetails_id=<?php echo htmlspecialchars($brgydetails_id); ?>" id="editBrgyForm">
                <input type="hidden" name="brgydetails_id" value="<?php echo htmlspecialchars($data['brgydetails_id']); ?>">

                <!-- Step 1: Official's Information -->
                <div class="mb-4">
                    <h5 class="text-primary border-bottom pb-2 mb-3">Official's Information</h5>
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Full Name</label><input type="text" name="fullname" class="form-control" value="<?php echo htmlspecialchars($data['fullname']); ?>" required></div>
                        <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($data['email']); ?>" required></div>
                        <div class="col-md-6"><label class="form-label">Username</label><input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($data['username']); ?>" required></div>
                        <div class="col-md-6"><label class="form-label">Contact</label><input type="text" name="contact" class="form-control" value="<?php echo htmlspecialchars($data['contact']); ?>" required></div>
                        <div class="col-md-6"><label class="form-label">Gender</label><select class="form-select" name="gender" required><option value="Male" <?php echo ($data['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option><option value="Female" <?php echo ($data['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option></select></div>
                        <div class="col-md-6"><label class="form-label">Position</label><select class="form-select" name="position" required><option value="Chairman" <?php echo ($data['position'] == 'Chairman') ? 'selected' : ''; ?>>Chairman</option><option value="Secretary" <?php echo ($data['position'] == 'Secretary') ? 'selected' : ''; ?>>Secretary</option></select></div>
                    </div>
                </div>

                <!-- Step 2: Barangay Profile -->
                <div class="mb-4">
                    <h5 class="text-primary border-bottom pb-2 mb-3">Barangay Profile</h5>
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Barangay Location</label><input type="text" name="brgy_location" class="form-control" value="<?php echo htmlspecialchars($data['brgy_location']); ?>" required></div>
                        <div class="col-md-6"><label class="form-label">Number of Purok/Sitios</label><input type="number" name="no_purok" class="form-control" value="<?php echo htmlspecialchars($data['no_purok']); ?>" required></div>
                        <div class="col-md-12"><label class="form-label">Major Source of Livelihood</label><input type="text" name="major_sources" class="form-control" value="<?php echo htmlspecialchars($data['major_sources']); ?>" required></div>
                        <div class="col-md-6"><label class="form-label">Barangay Classification</label><select class="form-select" name="brgy_classification" required><option value="Urban" <?php echo ($data['brgy_classification'] == 'Urban') ? 'selected' : ''; ?>>Urban</option><option value="Rural" <?php echo ($data['brgy_classification'] == 'Rural') ? 'selected' : ''; ?>>Rural</option></select></div>
                        <div class="col-md-6"><label class="form-label">Barangay Characteristic</label><select class="form-select" name="char_brgy" required><option value="Plain" <?php echo ($data['char_brgy'] == 'Plain') ? 'selected' : ''; ?>>Plain</option><option value="Upland" <?php echo ($data['char_brgy'] == 'Upland') ? 'selected' : ''; ?>>Upland</option><option value="Mountainious" <?php echo ($data['char_brgy'] == 'Mountainious') ? 'selected' : ''; ?>>Mountainious</option><option value="Coastal" <?php echo ($data['char_brgy'] == 'Coastal') ? 'selected' : ''; ?>>Coastal</option></select></div>
                    </div>
                </div>

                <!-- Step 3: Personnel Count -->
                <div>
                    <h5 class="text-primary border-bottom pb-2 mb-3">Personnel Count</h5>
                    <div class="row g-3">
                        <div class="col-md-3 col-6"><label class="form-label">Male Tanod</label><input type="number" name="male_tanod" class="form-control" value="<?php echo htmlspecialchars($data['male_tanod']); ?>" required></div>
                        <div class="col-md-3 col-6"><label class="form-label">Female Tanod</label><input type="number" name="female_tanod" class="form-control" value="<?php echo htmlspecialchars($data['female_tanod']); ?>" required></div>
                        <div class="col-md-3 col-6"><label class="form-label">Male Health Worker</label><input type="number" name="male_health_worker" class="form-control" value="<?php echo htmlspecialchars($data['male_health_worker']); ?>" required></div>
                        <div class="col-md-3 col-6"><label class="form-label">Female Health Worker</label><input type="number" name="female_health_worker" class="form-control" value="<?php echo htmlspecialchars($data['female_health_worker']); ?>" required></div>
                        <div class="col-md-3 col-6"><label class="form-label">Male Nutrition Scholar</label><input type="number" name="male_nutrition_scholar" class="form-control" value="<?php echo htmlspecialchars($data['male_nutrition_scholar']); ?>" required></div>
                        <div class="col-md-3 col-6"><label class="form-label">Female Nutrition Scholar</label><input type="number" name="female_nutrition_scholar" class="form-control" value="<?php echo htmlspecialchars($data['female_nutrition_scholar']); ?>" required></div>
                        <div class="col-md-3 col-6"><label class="form-label">Male Purok Leaders</label><input type="number" name="male_purok_leaders" class="form-control" value="<?php echo htmlspecialchars($data['male_purok_leaders']); ?>" required></div>
                        <div class="col-md-3 col-6"><label class="form-label">Female Purok Leaders</label><input type="number" name="female_purok_leaders" class="form-control" value="<?php echo htmlspecialchars($data['female_purok_leaders']); ?>" required></div>
                        <div class="col-md-3 col-6"><label class="form-label">Male Librarian</label><input type="number" name="male_librarian" class="form-control" value="<?php echo htmlspecialchars($data['male_librarian']); ?>" required></div>
                        <div class="col-md-3 col-6"><label class="form-label">Female Librarian</label><input type="number" name="female_librarian" class="form-control" value="<?php echo htmlspecialchars($data['female_librarian']); ?>" required></div>
                        <div class="col-md-3 col-6"><label class="form-label">Male Day Care Worker</label><input type="number" name="male_day_care_worker" class="form-control" value="<?php echo htmlspecialchars($data['male_day_care_worker']); ?>" required></div>
                        <div class="col-md-3 col-6"><label class="form-label">Female Day Care Worker</label><input type="number" name="female_day_care_worker" class="form-control" value="<?php echo htmlspecialchars($data['female_day_care_worker']); ?>" required></div>
                        <div class="col-md-6"><label class="form-label">Male Utility Worker</label><input type="number" name="male_utility_worker" class="form-control" value="<?php echo htmlspecialchars($data['male_utility_worker']); ?>" required></div>
                        <div class="col-md-6"><label class="form-label">Female Utility Worker</label><input type="number" name="female_utility_worker" class="form-control" value="<?php echo htmlspecialchars($data['female_utility_worker']); ?>" required></div>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" name="update_brgy" class="btn btn-primary btn-lg">
                        <i class="fa fa-check-circle me-2"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>