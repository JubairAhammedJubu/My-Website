<?php
include('db.php');

$show_password_form = false;
$student_id = "";

// Step 1: Verify user by student_id
if (isset($_POST['verify'])) {
    $student_id = trim($_POST['student_id']);

    if ($student_id == "") {
        echo "<script>alert('Please enter your student ID!');</script>";
    } else {
        // Verify the student_id
        $check = mysqli_query($conn, "SELECT * FROM students WHERE student_id='$student_id'");
        if (mysqli_num_rows($check) == 1) {
            $show_password_form = true;
        } else {
            echo "<script>alert('No account found with that student ID.');</script>";
        }
    }
}

// Step 2: Update password
if (isset($_POST['update'])) {
    $student_id = $_POST['student_id'];
    $newpass = $_POST['newpass'];
    $confirm = $_POST['confirm'];
    $show_password_form = true;

    if ($newpass == "" || $confirm == "") {
        echo "<script>alert('Please fill all password fields!');</script>";
    } elseif ($newpass != $confirm) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        // Update the password for the given student_id
        $sql = "UPDATE students SET password='$newpass' WHERE student_id='$student_id'";
        $result = mysqli_query($conn, $sql);
        
        //mysqli_affected_rows($conn)==1 will return 0 — because there was no actual change.
        if ($result && mysqli_affected_rows($conn) == 1) {
            echo "<script>alert('Password updated successfully! Now login...');window.location='login.php';</script>";
        } else {
            echo "<script>alert('Give another Password.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Student Login/Register</title>
    <link rel="icon" href="Images/techimage.jpg" type="image">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet" />

    <!-- CSS -->
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Jost', sans-serif;
            background: linear-gradient(to bottom, #00416A, #E4E5E6);
        }

        .main {
            width: 370px;
            height: 520px;
            overflow: hidden;
            background: #fff url("background.jpg") no-repeat center/cover;
            border-radius: 10px;
            box-shadow: 5px 20px 50px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        #chk {
            display: none;
        }

        .signup {
            position: relative;
            width: 100%;
            height: 100%;
        }

        label {
            color: #000;
            font-size: 1.5em;
            display: flex;
            justify-content: center;
            margin: 55px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.5s ease-in-out;
        }

        input {
            width: 60%;
            background: #e0dede;
            display: flex;
            justify-content: center;
            margin: 15px auto;
            padding: 10px;
            border: none;
            outline: none;
            border-radius: 5px;
        }

        select {
            width: 65%;
            background: #e0dede;
            justify-content: center;
            display: flex;
            margin: 10px auto;
            padding: 3px;
            border: none;
            outline: none;
            border-radius: 5px;
            color: #333;
            font-size: 13px;
            height: auto;
            min-height: 30px;
        }

        button {
            width: 50%;
            height: 40px;
            margin: 30px auto;
            display: block;
            color: #fff;
            background: #00416A;
            font-size: 1em;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s ease-in;
        }

        button:hover {
            background: #026AA7;
        }

        .home {
            height: 500px;
            background: #eee;
            border-radius: 60% / 10%;
            transform: translateY(-165px);
            transition: 0.6s ease-in-out;
        }

        .home a {
            text-decoration: none;
            font-size: 1.3em;
            color: #00416A;
            transform: scale(0.6);
        }

        .home a:hover {
            color: red;
            text-decoration: overline;
            cursor: pointer;
        }

        p {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="main">
        <!-- Login Section -->
        <div class="signup">
            <form method="POST" action="">
                <label for="chk" aria-hidden="true">Forgot Password</label>

                <!-- Step 1: Enter student_id -->
                <?php if (!$show_password_form && !isset($_POST['update'])) { ?>
                    <input type="text" name="student_id" placeholder="Enter Student ID" required>
                    <button type="submit" name="verify">Verify Account</button>
                <?php } ?>

                <!-- Step 2: Enter new password -->
                <?php if ($show_password_form) { ?>
                    <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">
                    <input type="password" name="newpass" placeholder="New Password" required>
                    <input type="password" name="confirm" placeholder="Confirm Password" required>
                    <button type="submit" name="update">Update</button>
                <?php } ?>
            </form>
        </div>

        <!-- Home Section -->
        <div class="home">
            <form method="POST" action="">
                <label for="chk" aria-hidden="true"><a href="login.php">Login</a></label>
            </form>
        </div>
    </div>
</body>

</html>
