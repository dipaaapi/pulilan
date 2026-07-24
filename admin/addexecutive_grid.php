<?php
include __DIR__ . '/navbar.php';

if (isset($_POST['submit'])) {
    $fullname = $_POST['fullname'] ?? '';
    $position = $_POST['position'] ?? '';
    $email = $_POST['email'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $brgy_location = $_POST['brgy_location'] ?? '';
    $type = 'executive';

    // Use prepared statements to prevent SQL injection
    $stmt = mysqli_prepare($connection, "INSERT INTO mainuser_acc(name, position, email, gender, contact, brgy_location, type) VALUES(?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'sssssss', $fullname, $position, $email, $gender, $contact, $brgy_location, $type);

    if (mysqli_stmt_execute($stmt)) {
        echo '<script>';
        echo 'alert("Successfully Added!");';
        echo 'window.location.href="addexecutive_grid.php";';
        echo '</script>';
    } else {
        echo 'Error: ' . mysqli_error($connection);
    }
}
?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Add Executive Official</h1>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Full Name</label><input class="form-control" type="text" name="fullname" placeholder="Enter Full Name" required></div>
                    <div class="col-md-6"><label class="form-label">Position</label><input class="form-control" type="text" name="position" placeholder="Enter Position" required></div>
                    <div class="col-md-6"><label class="form-label">Email</label><input class="form-control" type="email" name="email" placeholder="Enter Email" required></div>
                    <div class="col-md-6"><label class="form-label">Gender</label><input class="form-control" type="text" name="gender" placeholder="Enter Gender" required></div>
                    <div class="col-md-6"><label class="form-label">Contact Number</label><input class="form-control" type="text" name="contact" placeholder="Enter Contact Number" required></div>
                    <div class="col-md-6"><label class="form-label">Department</label><input class="form-control" type="text" name="brgy_location" placeholder="Enter Department" required></div>
                    <div class="col-12 text-end">
                        <button type="submit" name="submit" class="btn btn-primary">Add Information</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include __DIR__ . '/footer.php'; ?>