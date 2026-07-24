<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

include('navbar.php');
?>
<style>
    .stepper-wrapper {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2rem;
    }
    .stepper-item {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
    }
    .stepper-item::before {
        position: absolute;
        content: "";
        border-bottom: 2px solid #e0e0e0;
        width: 100%;
        top: 20px;
        left: -50%;
        z-index: 2;
    }
    .stepper-item::after {
        position: absolute;
        content: "";
        border-bottom: 2px solid #e0e0e0;
        width: 100%;
        top: 20px;
        left: 50%;
        z-index: 2;
    }
    .stepper-item .step-counter {
        position: relative;
        z-index: 5;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e0e0e0;
        color: #fff;
        margin-bottom: 6px;
        font-weight: bold;
    }
    .stepper-item.active .step-counter {
        background-color: #3b82f6;
    }
    .stepper-item.completed .step-counter {
        background-color: #10b981;
    }
    .stepper-item.completed::after {
        position: absolute;
        content: "";
        border-bottom: 2px solid #10b981;
        width: 100%;
        top: 20px;
        left: 50%;
        z-index: 3;
    }
    .stepper-item:first-child::before {
        content: none;
    }
    .stepper-item:last-child::after {
        content: none;
    }
    .step-name {
        font-size: 0.85rem;
        font-weight: 500;
        color: #6b7280;
    }
    .stepper-item.active .step-name {
        color: #3b82f6;
        font-weight: 700;
    }
    .stepper-item.completed .step-name {
        color: #111827;
    }
    .form-step {
        display: none;
        animation: fadeIn 0.5s;
    }
    .form-step-active {
        display: block;
    }
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center mt-3 mb-3 border-bottom pb-2">
            <h2 class="text-secondary mb-0">
                <i class="fa fa-plus me-2"></i> Add Barangay Details
            </h2>
            <a href="index.php" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-arrow-left me-1"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <!-- Stepper Progress -->
            <div class="stepper-wrapper">
                <div class="stepper-item active">
                    <div class="step-counter">1</div>
                    <div class="step-name">Official's Info</div>
                </div>
                <div class="stepper-item">
                    <div class="step-counter">2</div>
                    <div class="step-name">Barangay Profile</div>
                </div>
                <div class="stepper-item">
                    <div class="step-counter">3</div>
                    <div class="step-name">Personnel Count</div>
                </div>
            </div>

            <form method="POST" id="brgyForm">
                <!-- Step 1: Barangay Official's Information -->
                <div class="form-step form-step-active">
                    <div class="text-center border-bottom pb-2 mb-4">
                        <h5 class="text-primary">Step 1: Official's Information</h5>
                    </div>

                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Full Name" required >
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Enter Username" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted">Contact Number</label>
                            <input type="text" name="contact" class="form-control" placeholder="Enter Contact Number" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted">Gender</label>
                            <select class="form-select" name="gender" required>
                                <option value="" selected disabled>- Select Gender -</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted">Position</label>
                            <select class="form-select" name="position" required>
                                <option value="" selected disabled>- Select Position -</option>
                                <option value="Chairman">Chairman</option>
                                <option value="Secretary">Secretary</option>
                            </select>
                        </div>
                    </div>
                </div>
                    <div class="text-end mt-3">
                        <button type="button" class="btn btn-primary btn-next">Next <i class="fa fa-arrow-right ms-1"></i></button>
                    </div>
                </div>

                <!-- Step 2: Barangay Profile -->
                <div class="form-step">
                    <div class="text-center border-bottom pb-2 mb-4">
                        <h5 class="text-primary">Step 2: Barangay Profile</h5>
                    </div>

                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Barangay Location</label>
                            <input type="text" name="brgy_location" class="form-control" placeholder="Enter Barangay Location" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Number of Purok/Sitios</label>
                            <input type="number" name="no_purok" class="form-control" placeholder="Enter Number of Purok/Sitios" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted">Major Source of Livelihood</label>
                            <input type="text" name="major_sources" class="form-control" placeholder="e.g. Farming, Fishing" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Barangay Classification</label>
                            <select class="form-select" name="brgy_classification" required>
                                <option value="" selected disabled>- Select Classification -</option>
                                <option value="Urban">Urban</option>
                                <option value="Rural">Rural</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Barangay Characteristic</label>
                            <select class="form-select" name="char_brgy" required>
                                <option value="" selected disabled>- Select Characteristic -</option>
                                <option value="Plain">Plain</option>
                                <option value="Upland">Upland</option>
                                <option value="Mountainious">Mountainious</option>
                                <option value="Coastal">Coastal</option>
                            </select>
                        </div>
                    </div>
                </div>
                    <div class="text-end mt-3">
                        <button type="button" class="btn btn-outline-secondary btn-prev"><i class="fa fa-arrow-left me-1"></i> Previous</button>
                        <button type="button" class="btn btn-primary btn-next">Next <i class="fa fa-arrow-right ms-1"></i></button>
                    </div>
                </div>

                <!-- Step 3: Barangay Personnel -->
                <div class="form-step">
                    <div class="text-center border-bottom pb-2 mb-4">
                        <h5 class="text-primary">Step 3: Personnel Count</h5>
                    </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-3 col-6"><label class="form-label text-muted">Male Tanod</label><input type="number" name="male_tanod" class="form-control" placeholder="0" required></div>
                        <div class="col-md-3 col-6"><label class="form-label text-muted">Female Tanod</label><input type="number" name="female_tanod" class="form-control" placeholder="0" required></div>
                        <div class="col-md-3 col-6"><label class="form-label text-muted">Male Health Worker</label><input type="number" name="male_health_worker" class="form-control" placeholder="0" required></div>
                        <div class="col-md-3 col-6"><label class="form-label text-muted">Female Health Worker</label><input type="number" name="female_health_worker" class="form-control" placeholder="0" required></div>
                        <div class="col-md-3 col-6"><label class="form-label text-muted">Male Nutrition Scholar</label><input type="number" name="male_nutrition_scholar" class="form-control" placeholder="0" required></div>
                        <div class="col-md-3 col-6"><label class="form-label text-muted">Female Nutrition Scholar</label><input type="number" name="female_nutrition_scholar" class="form-control" placeholder="0" required></div>
                        <div class="col-md-3 col-6"><label class="form-label text-muted">Male Purok Leaders</label><input type="number" name="male_purok_leaders" class="form-control" placeholder="0" required></div>
                        <div class="col-md-3 col-6"><label class="form-label text-muted">Female Purok Leaders</label><input type="number" name="female_purok_leaders" class="form-control" placeholder="0" required></div>
                        <div class="col-md-3 col-6"><label class="form-label text-muted">Male Librarian</label><input type="number" name="male_librarian" class="form-control" placeholder="0" required></div>
                        <div class="col-md-3 col-6"><label class="form-label text-muted">Female Librarian</label><input type="number" name="female_librarian" class="form-control" placeholder="0" required></div>
                        <div class="col-md-3 col-6"><label class="form-label text-muted">Male Day Care Worker</label><input type="number" name="male_day_care_worker" class="form-control" placeholder="0" required></div>
                        <div class="col-md-3 col-6"><label class="form-label text-muted">Female Day Care Worker</label><input type="number" name="female_day_care_worker" class="form-control" placeholder="0" required></div>
                        <div class="col-md-6"><label class="form-label text-muted">Male Utility Worker</label><input type="number" name="male_utility_worker" class="form-control" placeholder="0" required></div>
                        <div class="col-md-6"><label class="form-label text-muted">Female Utility Worker</label><input type="number" name="female_utility_worker" class="form-control" placeholder="0" required></div>
                    </div>
                </div>
                    <div class="text-end mt-3">
                        <button type="button" class="btn btn-outline-secondary btn-prev"><i class="fa fa-arrow-left me-1"></i> Previous</button>
                        <button type="submit" name="submit" class="btn btn-success btn-lg"><i class="fa fa-check-circle me-2"></i> Add Barangay Information</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const prevBtns = document.querySelectorAll(".btn-prev");
    const nextBtns = document.querySelectorAll(".btn-next");
    const formSteps = document.querySelectorAll(".form-step");
    const stepperItems = document.querySelectorAll(".stepper-item");

    let formStepsNum = 0;

    nextBtns.forEach((btn) => {
        btn.addEventListener("click", (e) => {
            e.preventDefault(); // Prevent form submission
            if (validateStep(formStepsNum)) {
                formStepsNum++;
                updateFormSteps();
                updateStepper();
            }
        });
    });

    prevBtns.forEach((btn) => {
        btn.addEventListener("click", (e) => {
            e.preventDefault(); // Prevent form submission
            formStepsNum--;
            updateFormSteps();
            updateStepper();
        });
    });

    function updateFormSteps() {
        formSteps.forEach((formStep) => {
            formStep.classList.remove("form-step-active");
        });
        formSteps[formStepsNum].classList.add("form-step-active");
    }

    function updateStepper() {
        stepperItems.forEach((step, idx) => {
            step.classList.remove("active", "completed");
            if (idx < formStepsNum) {
                step.classList.add("completed");
            } else if (idx === formStepsNum) {
                step.classList.add("active");
            }
        });
    }

    function validateStep(stepIndex) {
        const currentStep = formSteps[stepIndex];
        const inputs = currentStep.querySelectorAll("input[required], select[required]");
        let isValid = true;
        for (const input of inputs) {
            if (!input.value.trim()) {
                // Add a visual indication of error
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        }
        if (!isValid) {
            alert("Please fill out all required fields before proceeding.");
        }
        return isValid;
    }
});
</script>