<?php
session_start();
include('db.php');

// Check login
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Get student info
$result = mysqli_query($conn, "SELECT * FROM stdprofile WHERE student_id='$student_id'");
$data = mysqli_fetch_assoc($result);

$total_fees = null;

// Tuition calculator class
class TuitionCalculator
{
    public $credits, $cost, $other, $waiver;

    public function __construct($credits = 0, $cost = 0, $other = 0, $waiver = 0)
    {
        $this->credits = $credits;
        $this->cost = $cost;
        $this->other = $other;
        $this->waiver = $waiver;
    }

    public function calculateTotal()
    {
        $main = $this->credits * $this->cost;
        $discount = ($main * $this->waiver) / 100;
        $total = $main - $discount + $this->other;
        return $total;
    }
}

// When form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $credits = $_POST["credits"];
    $cost = $_POST["cost"];
    $other = $_POST["other"];
    $waiver = $_POST["waiver"];

    $obj = new TuitionCalculator($credits, $cost, $other, $waiver);
    $total_fees = $obj->calculateTotal();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Tuition</title>
    <link rel="icon" href="Images/techimage.jpg" type="image">
    <style>
        /* Full-page layout */
        html,
        body {
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
            background-color: #047857;
            /* Main teal theme */
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
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
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
            box-shadow: 0 0 5px rgba(16, 185, 129, 0.3);
        }


        /* Footer */
        footer {
            background-color: #047857;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 30px;
        }

        /* Tuition Fees Section */
        .fee-section {
            max-width: 90%;
            margin: 20px auto;
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            background-image: url('../Web_Project/Images/calculatepage4.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            overflow: hidden;
        }

        .fee-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 15px;
            z-index: 0;
        }

        .fee-section * {
            position: relative;
            z-index: 1;
        }


        .fee-section h2 {
            color: #047857;
        }

        .fee-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .fee-col {
            flex: 1 1 45%;
        }

        /* Submit button */
        .submit-btn {
            text-align: center;
            margin-top: 20px;
        }

        .calculate-btn {
            background: #10B981;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .calculate-btn:hover {
            background: #047857;
        }

        .result-box {
            background: #ECFDF5;
            border: 1px solid #A7F3D0;
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
            color: #065F46;
            font-weight: 600;
        }
    </style>
</head>

<body>

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

        <!-- Tabs -->
        <ul class="tabs">
            <li class="tab-item"><a class="tab-link active" href="profile.php">Basic Information</a></li>
            <li class="tab-item"><a class="tab-link " href="#">Tuition Fees Info</a></li>
        </ul>

        <!-- Tuition Calculator -->
        <div class="fee-section">
            <h2>Tuition Fees Calculator</h2>
            <p>Use this calculator to estimate your total tuition fees.</p>

            <form method="POST">
                <div class="fee-row">
                    <div class="fee-col">
                        <div class="form-field">
                            <label>Number of Credits</label>
                            <input type="number" step="any"name="credits" class="form-input" required>
                        </div>
                        <div class="form-field">
                            <label>Other Fee (৳)</label>
                            <input type="number" name="other" class="form-input" required>
                        </div>

                    </div>

                    <div class="fee-col">
                        <div class="form-field">
                            <label>Cost Per Credit (৳)</label>
                            <input type="number" name="cost" class="form-input" required>
                        </div>
                        <div class="form-field">
                            <label>Waiver (%)</label>
                            <input type="number" name="waiver" class="form-input" required>
                        </div>
                    </div>
                </div>

                <div class="submit-btn">
                    <button class="calculate-btn" type="submit">Calculate Total</button>
                </div>
            </form>

            <?php if ($total_fees !== null): ?>
                <div class="result-box">
                    Estimated Total Tuition Fees: ৳ <?php echo number_format($total_fees); ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        © <?php echo date("Y"); ?> TechNexus University
    </footer>

</body>

</html>