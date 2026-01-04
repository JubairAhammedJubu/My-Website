<?php
session_start();
include('db.php');

// Check login
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$message = "";

// When form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $dob = $_POST['dob'];
    $blood_group = $_POST['blood_group'];
    $gender = $_POST['gender'];
    $marital_status = $_POST['marital_status'];
    $religion = $_POST['religion'];
    $nationality = $_POST['nationality'];
    $identity_type = $_POST['identity_type'];
    $identity_number = $_POST['identity_number'];
    $visa_number = $_POST['visa_number'];
    $visa_expiry_date = $_POST['visa_expiry_date'];

    // Update query
    $query = "UPDATE stdprofile SET 
        full_name='$full_name',
        dob='$dob',
        blood_group='$blood_group',
        gender='$gender',
        marital_status='$marital_status',
        religion='$religion',
        nationality='$nationality',
        identity_type='$identity_type',
        identity_number='$identity_number',
        visa_number='$visa_number',
        visa_expiry_date='$visa_expiry_date'
        WHERE student_id='$student_id'";

    mysqli_query($conn, $query) or die(mysqli_error($conn));
    $message = " Profile updated successfully!";
}

// Get student info
$result = mysqli_query($conn, "SELECT * FROM stdprofile WHERE student_id='$student_id'");
$data = mysqli_fetch_assoc($result);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Info</title>
    <link rel="icon" href="Images/techimage.jpg" type="image">
    <style>
/* Full-page layout */
html, body {
    height: 100%;
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background-color: #f8f9fa;
    display: flex;
    flex-direction: column;
}

/* Main content will push footer down */
main {
    flex: 1;
}

/* Top Bar */
.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #047857; /* Main teal theme */
    color: white;
    padding: 10px 30px;
}

.top-bar .logo {
    display: flex;
    align-items: center;
}

.top-bar .logo img {
    height: 50px;
    margin-right: 10px;
    border-radius: 15px;
}

.top-bar .title h1 {
    font-size: 18px;
    margin: 0;
}

.top-bar .user-info {
    text-align: right;
}

.top-bar .user-info .logout {
    color: #fff;
    font-size: 13px;
    text-decoration: none;
}

.top-bar .user-info .logout:hover {
    color: #F87171;
}

/* Navbar */
.navbar {
    background-color: #edfffbff;
    padding: 10px 40px;
    border-bottom: 1px solid #dee2e6;
}

.navbar ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
}

.navbar li {
    margin-right: 20px;
}

.navbar a {
    text-decoration: none;
    color: #374151;
    font-weight: 500;
}

.navbar a:hover {
    color: #10B981;
}

/* Tabs */
.tabs {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 20px 40px 10px 40px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.tab-item {
    flex: 1;
    text-align: center;
}

.tab-link {
    display: block;
    padding: 10px;
    text-decoration: none;
    font-weight: 500;
    color: #374151;
    background-color: #bdffe7ff;
    transition: 0.3s;
}

.tab-link.active {
    background: #10B981; 
    color: white;
}

/* Profile Card */
.profile {
    max-width:90%;
    margin: 20px auto;
    background: white;
    padding: 25px 30px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}

.profile h2 {
    margin-top: 0;
    color: #047857;
}

.message.success {
    background: #d1fae5;
    color: #065f46;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 15px;
    border: 1px solid #a7f3d0;
}

/* Form Fields */
.form-field {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: 500;
    margin-bottom: 5px;
    color: #374151;
}

.form-input {
    width: 95%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #d1d5db;
    background: #f9fafb;
    transition: 0.3s;
}

.form-input:focus {
    border-color: #10B981;
    outline: none;
    box-shadow: 0 0 5px rgba(16,185,129,0.3);
}

/* Flex rows */
.row {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.col-half {
    flex: 1 1 45%;
}

/* Submit button */
.submit-btn {
    text-align: center;
    margin-top: 20px;
}

.btn-submit {
    background: #10B981;
    color: white;
    border: none;
    padding: 12px 25px;
    font-weight: 500;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.3s;
}

.btn-submit:hover {
    background: #047857;
}

/* Footer */
footer {
    background-color: #047857;
    color: white;
    text-align: center;
    padding: 15px;
    margin-top: 30px;
}

    </style>

</head>

<body>

    <!-- header -->
    <header class="top-bar">
        <div class="logo">
            <img src="../Web_Project/Images/techimage.jpg" alt="UITS Logo">
            <div class="title">
                <h1>TechNexus University</h1>
            </div>
        </div>
        <div class="user-info">
            <span><?php echo $data['full_name']; ?></span><br>
            <a href="logout.php" class="logout">Logout</a>
        </div>
    </header>

    <main>
        <nav class="navbar">
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="profile.php">Student</a></li>
            </ul>
        </nav>

        <!-- Navigation Tabs2 -->
        <div>
            <ul class="tabs">
                <li class="tab-item"><a class="tab-link " href="#">Basic Information</a></li>
                <li class="tab-item"><a class="tab-link active" href="Tuition_Calculate.php">Tuition Fees Info</a></li>
            </ul>

            <div class="profile">
                <h2>Student Profile</h2>

                <?php if (!empty($message)): ?>
                    <div class="message success"><?php echo $message; ?></div>
                <?php endif; ?>


                <?php if ($data): ?>
                    <form method="POST">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-half">
                                <div class="form-field">
                                    <label>Full Name</label>
                                    <input type="text" name="full_name" value="<?php echo htmlspecialchars($data['full_name']); ?>" class="form-input">
                                </div>

                                <div class="form-field">
                                    <label>Date of Birth</label>
                                    <input type="text" name="dob" value="<?php echo htmlspecialchars($data['dob']); ?>" class="form-input">
                                </div>

                                <div class="form-field">
                                    <label>Blood Group</label>
                                    <input type="text" name="blood_group" value="<?php echo htmlspecialchars($data['blood_group']); ?>" class="form-input">
                                </div>

                                <div class="form-field">
                                    <label>Gender</label>
                                    <input type="text" name="gender" value="<?php echo htmlspecialchars($data['gender']); ?>" class="form-input">
                                </div>

                                <div class="form-field">
                                    <label>Marital Status</label>
                                    <input type="text" name="marital_status" value="<?php echo htmlspecialchars($data['marital_status']); ?>" class="form-input">
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-half">
                                <div class="form-field">
                                    <label>Religion</label>
                                    <input type="text" name="religion" value="<?php echo htmlspecialchars($data['religion']); ?>" class="form-input">
                                </div>

                                <div class="form-field">
                                    <label>Nationality</label>
                                    <input type="text" name="nationality" value="<?php echo htmlspecialchars($data['nationality']); ?>" class="form-input">
                                </div>

                                <div class="form-field">
                                    <label>Identity Type</label>
                                    <input type="text" name="identity_type" value="<?php echo htmlspecialchars($data['identity_type']); ?>" class="form-input">
                                </div>

                                <div class="form-field">
                                    <label>Identity Number</label>
                                    <input type="text" name="identity_number" value="<?php echo htmlspecialchars($data['identity_number']); ?>" class="form-input">
                                </div>

                                <div class="form-field">
                                    <label>Visa Number</label>
                                    <input type="text" name="visa_number" value="<?php echo htmlspecialchars($data['visa_number']); ?>" class="form-input">
                                </div>

                                <div class="form-field">
                                    <label>Visa Expiry Date</label>
                                    <input type="text" name="visa_expiry_date" value="<?php echo htmlspecialchars($data['visa_expiry_date']); ?>" class="form-input">
                                </div>
                            </div>
                        </div>

                        <div class="submit-btn">
                            <button type="submit" class="btn-submit">Save Student Information</button>
                        </div>
                    </form>
                <?php else: ?>
                    <p>No profile found for this student.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>


    <footer>
        © <?php echo date("Y"); ?> TechNexus University
    </footer>
</body>

</html>