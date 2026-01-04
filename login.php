<?php
session_start();

require_once 'db.php';

$login_msg = "";


// LOGIN
if (isset($_POST['login'])) {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if student exists
    $result = mysqli_query($conn, "SELECT * FROM students WHERE student_id='$student_id'");
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) == 1) {
        $student = mysqli_fetch_assoc($result);

        // Verify password
        if ($password == $student['password']) {
            $_SESSION['student_id'] = $student['student_id'];
            header("Location: dashboard.php");
            exit();
        } else {
            echo '<script>alert("Login failed: Invalid Password")</script>';
        }
    } else {
        $login_msg = "<p style='color:red; text-align:center;'>Student not found!</p>";
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
            font-size: 2em;
            display: flex;
            justify-content: center;
            margin: 40px;
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
            transition: 0.15s ease-in;
        }

        button:hover {
            background: #026AA7;
        }

        .home {
            height: 500px;
            background: #eee;
            border-radius: 60% / 10%;
            transform: translateY(-135px);
            transition: 0.6s ease-in-out;
        }

        .home a {
            text-decoration: none;
            color: #00416A;
            transform: scale(0.6);
            transition: 0.1s ease-in-out;
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

<!-- HTML -->

<body>
    <div class="main">


        <!-- Signup Section -->
        <div class="signup">
            <form method="POST" action="">
                <label for="chk" aria-hidden="true">Login</label>
                <input type="text" name="student_id" placeholder="Student_id" required />
                <input type="password" name="password" placeholder="Password" required />
                <button type="submit" name="login">Login</button>
                <?php echo $login_msg; ?>

                <div style="text-align: center; font-size: 0.9rem; margin-top: 15px;">
                    <p><a href="forgetpass.php">Forgot Password?</a></p>
                </div>
            </form>
        </div>


        <!-- Home Section -->
        <div class="home">
            <form method="POST" action="">
                <label for="chk" aria-hidden="true"><a href="index.html">Home</a></label>
            </form>
        </div>
    </div>
</body>

</html>