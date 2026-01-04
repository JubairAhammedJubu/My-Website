<?php
session_start();
require_once 'db.php';


$login_msg = "";
$show_login = false;

// REGISTER (Signup)
if (isset($_POST['register'])) {
    $register_id = mysqli_real_escape_string($conn, $_POST['register_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cnfpassword = mysqli_real_escape_string($conn, $_POST['cnfpassword']);
    $show_login = false;

    if (empty($register_id) || empty($name) || empty($email) || empty($password) || empty($cnfpassword)) {
        echo '<script>alert("Please fill in all fields");</script>';
    } elseif ($password != $cnfpassword) {
        echo '<script>alert("Passwords do not match");</script>';
    } else {
        // Check if register_id or email already exists
        $check = mysqli_query($conn, "SELECT * FROM registerrl WHERE register_id='$register_id' OR email='$email'");
        if (mysqli_num_rows($check) > 0) {
            echo '<script> alert("Email alradey exists") </script>';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            // Insert new record
            $insert = "INSERT INTO registerrl (register_id, name, email, password) VALUES ('$register_id', '$name', '$email', '$hashed')";

            if (mysqli_query($conn, $insert)) {
                echo '<script>alert("Registration successful! You can now log in")</script>';
            } else {
                echo '<script>alert("Error: ' . mysqli_error($conn) . '")</script>';
            }
        }
    }
}

// LOGIN
if (isset($_POST['login'])) {
    $register_id = mysqli_real_escape_string($conn, $_POST['register_id']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if user exists
    $result = mysqli_query($conn, "SELECT * FROM registerrl WHERE register_id='$register_id'");
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) == 1) {
        $register = mysqli_fetch_assoc($result);

        // Verify hashed password
        if (password_verify($password, $register['password'])) {
            $_SESSION['register_id'] = $register['register_id'];
            header("Location: RegisterProfile.php");
            exit();
        } else {
            $login_msg = "<p style='color:red; text-align:center;'>Incorrect password!</p>";
        }
    } else {
        $login_msg = "<p style='color:red; text-align:center;'>User not found!</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Login/Register</title>
    <link rel="icon" href="Images/techimage.jpg" type="image">

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
            margin: 20px auto;
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

        .login {
            height: 500px;
            background: #eee;
            border-radius: 60% / 10%;
            transform: translateY(-135px);
            transition: 0.6s ease-in-out;
        }

        .login label {
            color: #00416A;
            transform: scale(0.6);
            transition: 0.15s ease-in-out;
        }

        .login label:hover {
            color: #026AA7;
            text-decoration: overline;
            cursor: pointer;
        }

        #chk:checked~.login {
            transform: translateY(-500px);
        }

        #chk:checked~.login label {
            transform: scale(1);
        }

        #chk:checked~.signup label {
            transform: scale(0.6);
        }

        p {
            text-align: center;
        }

        .home-btn {
            position: absolute;
            top: 5px;
            left: 5px;
            color: red;
            text-decoration: none;
            font-weight: bold;
            background: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            border: 1px solid red;
            transition: 0.4s;
        }

        .home-btn:hover {
            background: red;
            color: white;
        }
    </style>
</head>

<body>

    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true" <?php echo ($show_login) ? 'checked' : ''; ?> />
        <a href="index.html" class="home-btn">Home</a>
        <!-- Signup Section -->
        <div class="signup">
            <form method="POST" action="">
                <label for="chk" aria-hidden="true">Register</label>
                <input type="text" name="register_id" placeholder="Register ID" required />
                <input type="text" name="name" placeholder="Name" required />
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <input type="password" name="cnfpassword" placeholder="Confirm Password" required />
                <button type="submit" name="register">Register</button>
            </form>
        </div>

        <!-- Login Section -->
        <div class="login">
            <form method="POST" action="">
                <label for="chk" aria-hidden="true">Login</label>
                <input type="text" name="register_id" placeholder="Register ID" required />
                <input type="password" name="password" placeholder="Password" required />
                <button type="submit" name="login">Login</button>
                <?php echo $login_msg; ?>
            </form>
        </div>
    </div>
</body>

</html>