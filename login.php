<?php
session_start();
include 'config.php';

$err = '';

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if ($user === 'admin' && $pass === 'admin') {
        $_SESSION['islogin'] = true;
        $_SESSION['username'] = 'admin';
        $_SESSION['userid'] = $row['id'];
        header("Location: admin/index.php");
        exit();
    }

    $sql = "SELECT * FROM users WHERE user='$user' AND pass='$pass'";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $_SESSION['islogin'] = true;
        $_SESSION['username'] = $row['user'];
        $_SESSION['fname'] = $row['fname'];
        $_SESSION['lname'] = $row['lname'];
        $_SESSION['userid'] = $row['id'];
        header("Location: index.php");
        exit();
    } else {
        $err = "نام کاربری یا رمز عبور اشتباه است";
    }
}
?>


<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ورود به سیستم</title>
    <link href="ax/khabar1.png" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Vazirmatn', sans-serif;
            background: linear-gradient(to right, #00c6ff, #0072ff);
            margin: 0;
            padding: 0;
        }

        .topmenu {
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
            direction: rtl;
        }

        .topmenu .container {
            width: 90%;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-direction: row-reverse;
        }

        .topmenu ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        .topmenu ul li {
            margin: 0 10px;
        }

        .topmenu ul li a {
            text-decoration: none;
            color: #0072ff;
            font-weight: bold;
            font-size: 15px;
        }

        .login-container {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin: 50px auto;
        }

        .login-container h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #0072ff;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 15px;
            direction: rtl;
        }

        .login-container input[type="submit"] {
            width: 100%;
            background-color: #0072ff;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
        }

        .login-container input[type="submit"]:hover {
            background-color: #005ed3;
        }

        .login-container .error {
            margin-top: 10px;
            color: red;
            text-align: center;
        }

        .register-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #0072ff;
            text-decoration: none;
        }

        .register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="topmenu">
    <div class="container">
        <ul>
            <li><a href="index.php">صفحه اصلی</a></li>
            <li><a href="register.php">ثبت‌نام نویسنده</a></li>
            <li><a href="#">درباره ما</a></li>
        </ul>
    </div>
</div>

<div class="login-container">
    <h1>ورود به سیستم</h1>
    <form method="post">
        <input type="text" name="username" placeholder="نام کاربری" required>
        <input type="password" name="password" placeholder="رمز عبور" required>
        <input type="submit" name="login" value="ورود">
        <?php if ($err != ''): ?>
            <div class="error"><?php echo $err; ?></div>
        <?php endif; ?>
    </form>
    <a class="register-link" href="register.php">هنوز ثبت‌نام نکرده‌اید؟ کلیک کنید</a>
</div>

</body>
</html>

