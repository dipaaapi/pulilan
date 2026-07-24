<?php
require_once __DIR__ . '/../pulilan_db_connect.php';
include __DIR__ . '/navbar.php';

if (isset($_POST['submit'])) {
    $fullname = $_POST['fullname'] ?? '';
    $position = $_POST['position'] ?? '';
    $email = $_POST['email'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $brgy_location = $_POST['brgy_location'] ?? '';
    $type = 'official';

    // Use prepared statements to prevent SQL injection
    $stmt = mysqli_prepare($connection, "INSERT INTO brgydetails_tbl(fullname, position, email, gender, contact, brgy_location, type) VALUES(?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'sssssss', $fullname, $position, $email, $gender, $contact, $brgy_location, $type);

    if (mysqli_stmt_execute($stmt)) {
        echo '<script>alert("Successfully Added!"); window.location.href="brgylist_table.php";</script>';
    } else {
        echo '<script>alert("Error: ' . addslashes(mysqli_error($connection)) . '");</script>';
    }
}
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Add Barangay Official</h1>
    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h5 class="card-title mb-0">Barangay Official's Information</h5>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Full Name</label><input type="text" name="fullname" class="form-control" placeholder="Enter Full Name" required></div>
                    <div class="col-md-6">
                        <label class="form-label">Position</label>
                        <select name="position" class="form-select" required>
                            <option value="" disabled selected>- Select Position -</option>
                            <option value="Chairman">Chairman</option>
                            <option value="Secretary">Secretary</option>
                        </select>
                    </div>
                    <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" placeholder="Enter Email" required></div>
                    <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select" required>
                            <option value="" disabled selected>- Select Gender -</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="col-md-6"><label class="form-label">Contact Number</label><input type="text" name="contact" class="form-control" placeholder="Enter Contact Number" required></div>
                    <div class="col-md-6">
                        <label class="form-label">Barangay Location</label>
                        <select class="form-select" name="brgy_location" required>
                            <option value="" selected disabled>- Choose Barangay Location -</option>
                            <option value="Balatong A">Balatong - A</option>
                            <option value="Balatong B">Balatong - B</option>
                            <option value="Cut-Cot">Cut-Cot</option>
                            <option value="Dampol 1st">Dampol 1st</option>
                            <option value="Dampol 2nd A">Dampol 2nd A</option>
                            <option value="Dampol 2nd B">Dampol 2nd B</option>
                            <option value="Dulong Malabon">Dulong Malabon</option>
                            <option value="Inaon">Inaon</option>
                            <option value="Longos">Longos</option>
                            <option value="Lumbac">Lumbac</option>
                            <option value="Paltao">Paltao</option>
                            <option value="Peñabatan">Peñabatan</option>
                            <option value="Poblacion">Poblacion</option>
                            <option value="Sta. Peregrina">Sta. Peregrina</option>
                            <option value="Sto. Cristo">Sto. Cristo</option>
                            <option value="Taal">Taal</option>
                            <option value="Tabon">Tabon</option>
                            <option value="Tenejero">Tenejero</option>
                            <option value="Tibag">Tibag</option>
                        </select>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" name="submit" class="btn btn-primary">Add Information</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include __DIR__ . '/footer.php'; ?>