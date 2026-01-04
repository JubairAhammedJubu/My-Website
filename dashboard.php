<?php
session_start();
include('db.php');

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$query = "SELECT * FROM students WHERE student_id = '$student_id'";
$result = $conn->query($query);
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="icon" href="Images/techimage.jpg" type="image">
    
</head>

<!-- CSS -->
<style>
    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        background-color: #f9fafb;
    }

    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #047857;
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

    .user-info {
        text-align: right;
    }

    .user-info .logout {
        color: #fff;
        font-size: 13px;
        text-decoration: none;
    }

    .user-info .logout:hover {
        color: #F87171;
        cursor: pointer;
    }

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
        cursor: pointer;
    }

    .container {
        padding: 20px 40px;
    }

    .welcome-section {
        background: linear-gradient(135deg, #10B981, #047857); 
        color: white;
        padding: 30px;
        border-radius: 10px;
        margin-bottom: 25px;
    }

    .cards {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .card {
        background: white;
        flex: 1;
        min-width: 200px;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .card.sem {
        border-top: 5px solid #047857; 
    }

    .card.enr {
        border-top: 5px solid #2563EB; 
    }

    .card.CG {
        border-top: 5px solid #F59E0B; 
    }

    .card.fee {
        border-top: 5px solid #EF4444; 
    }

    .card h3 {
        color: #6b7280;
        font-size: 14px;
        margin: 0;
    }

    .card .value {
        font-size: 22px;
        font-weight: bold;
        margin-top: 10px;
        color: #1f2937;
    }

    .progress-section {
        margin-top: 30px;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .h {
        margin-top: 5px;
        color: #1f2937;
    }

    .progress-boxes {
        display: flex;
        justify-content: space-around;
        text-align: center;
        margin-top: 15px;
    }

    .progress-item .big {
        font-size: 24px;
        color: #10B981; /* Bright green accent */
        margin: 5px 0;
        font-weight: 600;
    }

    .progress-item span {
        color: #6b7280;
    }

    footer {
        background-color: #047857;
        font-size: 14px;
        color: white;
        text-align: center;
        padding: 15px;
        margin-top: 30px;
    }
</style>

<body>

    <header class="top-bar">
        <div class="logo">
            <img src="../Web_Project/Images/techimage.jpg" alt="UITS Logo">
            <div class="title">
                <h1>TechNexus University</h1>
            </div>
        </div>
        <div class="user-info">
            <span><?php echo $data['name']; ?></span><br>
            <a href="logout.php" class="logout">Logout</a>
        </div>
    </header>

    <nav class="navbar">
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="profile.php">Student</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="welcome-section">
            <h2>Welcome Back, <?php echo $data['name']; ?>!</h2>
            <p>Ready to continue your academic journey? Access all your student information from here.</p>

            <div class="student-info">
                <p><strong>Student ID:</strong> <?php echo $data['student_id']; ?></p>
                <p><strong>Program:</strong> <?php echo $data['program']; ?></p>
                <p><strong>Batch:</strong> <?php echo $data['batch']; ?></p>
            </div>
        </div>

        <div class="cards">
            <div class="card sem">
                <h3>Current Semester</h3>
                <p class="value"><?php echo $data['semester']; ?></p>
            </div>
            <div class="card enr">
                <h3>Enrolled Courses</h3>
                <p class="value"><?php echo $data['enrolled_courses']; ?></p>
            </div>
            <div class="card CG">
                <h3>CGPA</h3>
                <p class="value"><?php echo $data['cgpa']; ?></p>
            </div>
            <div class="card fee">
                <h3>Pending Fees</h3>
                <p class="value">৳<?php echo number_format($data['pending_fees']); ?></p>
            </div>
        </div>

        <div class="progress-section">
            <h3 class="h">Academic Progress</h3>
            <div class="progress-boxes">
                <div class="progress-item">
                    <p class="big"><?php echo $data['credits_earned']; ?></p>
                    <span>Credits Earned</span>
                </div>
                <div class="progress-item">
                    <p class="big"><?php echo $data['credits_attempted']; ?></p>
                    <span>Credits Attempted</span>
                </div>
                <div class="progress-item">
                    <p class="big"><?php echo $data['total_required']; ?></p>
                    <span>Total Required</span>
                </div>
            </div>
        </div>
    </div>

  <footer>
    Copyright  © <?php echo date("Y"); ?> TechNexus University Ltd.
  </footer>

</body>

</html>