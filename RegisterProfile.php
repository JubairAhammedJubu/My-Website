<?php
session_start();
include('db.php');

if (!isset($_SESSION['register_id'])) {
  header("Location: registerRL.php");
  exit();
}

$register_id = $_SESSION['register_id'];
$query = "SELECT * FROM registerrl WHERE register_id = '$register_id'";
$result = $conn->query($query);
$data = $result->fetch_assoc();

// Get total number of students from studentprofile
$student_count_result = $conn->query("SELECT COUNT(*) AS total_students FROM students");
$student_count_data = $student_count_result->fetch_assoc();
$total_students = $student_count_data['total_students'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="icon" href="Images/techimage.jpg" type="image">


  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #e0f7ff, #f0faff);
      overflow-x: hidden;
      transition: background 2s ease;
    }

    /* ===== Header ===== */
    .top-bar {
      position: fixed;
      top: 0;
      left: 0;
      width: 96%;
      height: 70px;
      background: linear-gradient(90deg, #007CF0, #00DFD8, #007CF0);
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 30px;
      z-index: 1000;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
      border-bottom: 2px solid rgba(255, 255, 255, 0.2);
    }

    .top-bar .logo {
      display: flex;
      align-items: center;
    }

    .top-bar .logo img {
      height: 50px;
      margin-right: 10px;
      border-radius: 10px;
    }

    .top-bar .title h1 {
      font-size: 18px;
      margin: 0;
    }

    .top-bar .user-info {
      text-align: right;
      margin-right: 10px;
    }

    .top-bar .user-info .logout {
      color: #fff;
      font-size: 13px;
      text-decoration: none;
    }

    .top-bar .user-info .logout:hover {
      color: #F87171;
    }

    /* ===== Footer ===== */
    footer {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 50px;
      background: linear-gradient(90deg, #00DFD8, #5D0EFF);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.2);
      z-index: 1000;
    }

    /* ===== Sidebar ===== */
    nav {
      position: fixed;
      top: 90px;
      bottom: 70px;
      left: 0;
      width: 200px;
      background: linear-gradient(180deg, #5D0EFF, #00E0FF, #5D0EFF);
      padding: 10px;
      border-radius: 0 15px 15px 0;
      overflow-y: auto;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
    }

    nav .menu-items {
      margin-top: 30px;
    }

    nav label {
      display: flex;
      align-items: center;
      height: 50px;
      padding-left: 10px;
      color: #fff;
      font-size: 18px;
      cursor: pointer;
      transition: 0.3s;
    }

    nav label:hover {
      background: rgba(255, 255, 255, 0.15);
      box-shadow: inset 0 0 10px rgba(255, 255, 255, 0.2);
      border-top-left-radius: 25px;
      border-bottom-left-radius: 25px;
    }

    /* Hide radio buttons */
    input[type="radio"] {
      display: none;
    }

    /* Active tab styling */
    #dashboard:checked~nav label[for="dashboard"],
    #content:checked~nav label[for="content"],
    #analytics:checked~nav label[for="analytics"],
    #likes:checked~nav label[for="likes"],
    #comments:checked~nav label[for="comments"] {
      background: rgba(255, 255, 255, 0.3);
      color: #fff;
      border-top-left-radius: 25px;
      border-bottom-left-radius: 25px;
    }

    /* ===== Main Section ===== */
    main {
      margin-left: 200px;
      padding: 100px 30px 80px 30px;
      min-height: 100vh;
    }

    .data-table {
      display: none;
    }

    #dashboard:checked~main .dashboard-section,
    #content:checked~main .content-section,
    #analytics:checked~main .analytics-section,
    #likes:checked~main .likes-section,
    #comments:checked~main .comments-section {
      display: block;
    }

    /* ===== Boxes ===== */
    .boxes {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
    }

    .box {
      flex: 1;
      min-width: 150px;
      text-align: center;
      padding: 15px;
      border-radius: 10px;
      color: #fff;
      font-weight: 500;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
      background: linear-gradient(135deg, var(--box-start), var(--box-end));
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .box:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
    }

    /* === Individual Box Colors === */
    .box1 {
      --box-start: #F472B6;
      --box-end: #EC4899;
    }

    .box2 {
      --box-start: #34D399;
      --box-end: #059669;
    }

    .box3 {
      --box-start: #60A5FA;
      --box-end: #2563EB;
    }

    .box4 {
      --box-start: #FBBF24;
      --box-end: #F59E0B;
    }

    .box .number {
      font-size: 35px;
      font-weight: 600;
    }

    .title {
      display: flex;
      align-items: center;
      margin: 20px 0;
    }

    .title .text {
      margin-left: 10px;
      font-size: 22px;
      color: #002960;
    }

    /* ===== Welcome Section ===== */
    .container {
      padding: 10px 40px;
      min-width: 96%;
    }

    .welcome-section {
      background: linear-gradient(135deg, #6EE7B7, #3B82F6, #9333EA);
      color: white;
      padding: 30px;
      border-radius: 10px;
      margin-bottom: 25px;
    }

    /* === Buttons === */
    button {
      background: linear-gradient(135deg, #2563EB, #3B82F6);
      color: white;
      border: none;
      padding: 10px 18px;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    button:hover {
      background: linear-gradient(135deg, #3B82F6, #9333EA);
      transform: scale(1.05);
    }
  </style>
</head>

<body>

  <!-- Header -->
  <header class="top-bar">
    <div class="logo">
      <img src="../Web_Project/Images/techimage.jpg" alt="UITS Logo">
      <div class="title">
        <h1>TechNexus University</h1>
      </div>
    </div>
    <div class="user-info">
      <span><?php echo $data['name']; ?></span><br>
      <a href="logoutR.php" class="logout">Logout</a>
    </div>
  </header>

  <!-- Radio Inputs -->
  <input type="radio" name="menu" id="dashboard" checked>
  <input type="radio" name="menu" id="content">
  <input type="radio" name="menu" id="analytics">
  <input type="radio" name="menu" id="likes">
  <input type="radio" name="menu" id="comments">

  <!-- Sidebar -->
  <nav>
    <div class="menu-items">
      <label for="dashboard"><span>Dashboard</span></label>
      <label for="content"><span>Students Overview</span></label>
      <label for="analytics"><span>Department</span></label>
      <label for="likes"><span>Analytics</span></label>
      <label for="comments"><span>Accounce</span></label>

    </div>
  </nav>

  <!-- Main Content -->
  <main>
    <div class="container">
      <div class="welcome-section">
        <h2>Welcome Back, <?php echo $data['name']; ?>!</h2>
        <p>Ready to continue your job journey? Access all your information from here.</p>

        <div class="student-info">
          <p><strong>Register ID:</strong> <?php echo $data['register_id']; ?></p>
        </div>
      </div>

      <!-- Dashboard Section -->
      <div class="data-table dashboard-section">
        <div class="title"><span class="text">Dashboard</span></div>
        <div class="boxes">
          <div class="box box1">
            <div>Total Students</div>
            <div class="number"><?php echo $total_students; ?></div>
          </div>

          <div class="box box2">
            <div>Active Student</div>
            <div class="number"><?php echo $total_students; ?></div>
          </div>
          <div class="box box3">
            <div>Total Faculty</div>
            <div class="number">12</div>
          </div>
          <div class="box box4">
            <div>Total Vehicles</div>
            <div class="number">3</div>
          </div>
        </div>
      </div>



      <!-- overview Section -->
      <div class="data-table content-section">
        <div class="title"><span class="text">Students Overview</span></div>

        <!-- Button to show/hide Add Form -->
        <button id="add-student-btn">Add New Student</button>
        <br><br>

        <!-- Add Student Form -->
        <div id="add-student-form" style="display:none; margin-bottom:20px;">
          <form method="POST" action="">
            <table>
              <tr>
                <td>Student ID:</td>
                <td><input type="text" name="student_id" required></td>
              </tr>
              <tr>
                <td>Name:</td>
                <td><input type="text" name="name" required></td>
              </tr>
              <tr>
                <td>Email:</td>
                <td><input type="email" name="email" required></td>
              </tr>
              <tr>
                <td>Password:</td>
                <td><input type="password" name="password" required></td>
              </tr>
              <tr>
                <td>Program:</td>
                <td><input type="text" name="program" required></td>
              </tr>
              <tr>
                <td>Batch:</td>
                <td><input type="text" name="batch" required></td>
              </tr>
              <tr>
                <td>Semester:</td>
                <td><input type="text" name="semester" required></td>
              </tr>
              <tr>
                <td>Enrolled Courses:</td>
                <td><input type="number" name="enrolled_courses" required></td>
              </tr>
              <tr>
                <td>CGPA:</td>
                <td><input type="number" step="0.01" name="cgpa" required></td>
              </tr>
              <tr>
                <td>Pending Fees:</td>
                <td><input type="number" name="pending_fees" required></td>
              </tr>
              <tr>
                <td>Credits Earned:</td>
                <td><input type="number" step="0.1" name="credits_earned" required></td>
              </tr>
              <tr>
                <td>Credits Attempted:</td>
                <td><input type="number" step="0.1" name="credits_attempted" required></td>
              </tr>
              <tr>
                <td>Total Required:</td>
                <td><input type="number" step="0.1" name="total_required" required></td>
              </tr>
              <tr>
                <td colspan="2" style="text-align:center;"><button type="submit" name="add_student">Add Student</button></td>
              </tr>
            </table>
          </form>
        </div>

        <?php
        // Handle Add Student Form submission
        if (isset($_POST['add_student'])) {
          $student_id = $_POST['student_id'];
          $name = $_POST['name'];
          $email = $_POST['email'];
          $password = $_POST['password'];
          $program = $_POST['program'];
          $batch = $_POST['batch'];
          $semester = $_POST['semester'];
          $enrolled_courses = $_POST['enrolled_courses'];
          $cgpa = $_POST['cgpa'];
          $pending_fees = $_POST['pending_fees'];
          $credits_earned = $_POST['credits_earned'];
          $credits_attempted = $_POST['credits_attempted'];
          $total_required = $_POST['total_required'];

          $insert = "INSERT INTO students 
        (student_id, name, email, password, program, batch, semester, enrolled_courses, cgpa, pending_fees, credits_earned, credits_attempted, total_required)
        VALUES 
        ('$student_id', '$name', '$email', '$password', '$program', '$batch', '$semester', '$enrolled_courses', '$cgpa', '$pending_fees', '$credits_earned', '$credits_attempted', '$total_required')";

          if (mysqli_query($conn, $insert)) {
            echo "<p style='color:green;'> Student added successfully!</p>";
          } else {
            echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
          }
        }
        ?>

        <!-- Show All Students -->
        <h3>All Students</h3>
        <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:20px;">
          <?php
          $result = mysqli_query($conn, "SELECT * FROM students");
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo "
        <div style='background:#ddf0ffff; border:1px solid #2d44c5ff; border-radius:10px; padding:15px; width:250px; box-shadow:0 2px 5px rgba(0,0,0,0.1);'>
            <h4 style='margin:0;text-align: center;color:#047857;'>{$row['name']}</h4>
            <p><strong>ID:</strong> {$row['student_id']}</p>
            <p><strong>Email:</strong> {$row['email']}</p>
            <p><strong>Program:</strong> {$row['program']}</p>
            <p><strong>Batch:</strong> {$row['batch']}</p>
            <p><strong>semester:</strong> {$row['semester']}</p>
            <p><strong>Enrolled courses:</strong> {$row['enrolled_courses']}</p>
            <p><strong>CGPA:</strong> {$row['cgpa']}</p>
            <p><strong>Fees:</strong> {$row['pending_fees']}</p>
            <p><strong>Credits Earned:</strong> {$row['credits_earned']} from {$row['total_required']}</p>
            <a href='delete_student.php?id={$row['id']}' style='color:red; text-decoration:none;    display:block; text-align:center;'>Delete</a>
        </div>";
            }
          } else {
            echo "<p>No students found</p>";
          }
          ?>
        </div>

        </table>
      </div>


      <!-- Add JS to toggle form -->
      <script>
        document.getElementById('add-student-btn').addEventListener('click', function() {
          var form = document.getElementById('add-student-form');
          if (form.style.display == 'none') {
            form.style.display = 'block';
          } else {
            form.style.display = 'none';
          }
        });
      </script>



      <!-- department Section -->
      <div class="data-table analytics-section">
        <div class="title"><span class="text"> Department</span></div>
        <p>View analytics charts and performance metrics.</p>
      </div>

      <!-- analytics Section -->
      <div class="data-table likes-section">
        <div class="title"><span class="text">Analytics</span></div>
        <p>View and manage likes data here.</p>
      </div>

      <!-- accounce Section -->
      <div class="data-table comments-section">
        <div class="title"><span class="text">Accounce</span></div>
        <p>Monitor recent comments from users.</p>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer>
    Copyright  © <?php echo date("Y"); ?> TechNexus University Ltd.
  </footer>

</body>

</html>