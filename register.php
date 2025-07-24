<?php
session_start();
include 'config.php';

if (isset($_POST['register'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // بررسی یکتا بودن نام کاربری یا ایمیل
    $check = mysqli_query($conn, "SELECT * FROM users WHERE user='$username' OR email='$email'");
    if (mysqli_num_rows($check) > 0) {
        echo "<p style='color:red; text-align:center;'>❌ این نام کاربری یا ایمیل قبلاً ثبت شده است.</p>";
    } else {
        $query = "INSERT INTO `users` (`fname`,`lname`,`email`,`user`,`pass`) VALUES ('$fname','$lname','$email','$username','$password')";
        
        if (mysqli_query($conn, $query)) {
            $_SESSION['message'] = "✅ ثبت‌نام با موفقیت انجام شد.";
            header("Location: login.php");
            exit();
        } else {
            echo "<p style='color:red; text-align:center;'>❌ خطا در ثبت‌نام رخ داد.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ثبت‌نام نویسنده</title>
    <link href="ax/khabar1.png" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Vazirmatn', sans-serif;
            background: linear-gradient(to right, #36d1dc, #5b86e5);
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
            flex-direction: row;
            margin: 0;
            padding: 0;
        }
        
        .topmenu ul li {
            margin: 0 10px;
            display: flex;
            align-items: center;
        }
        
        .topmenu ul li a {
            text-decoration: none;
            color: #0072ff;
            font-weight: bold;
            font-size: 15px;
            max-width: 1100px;
        }
        
        .container {
            max-width: 500px;
            background-color: #fff;
            margin: 50px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        h3 {
            text-align: center;
            color: #0072ff;
            margin-bottom: 25px;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
        }

        form input[type="submit"] {
            width: 100%;
            background-color: #0072ff;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #005ed3;
        }

        .clear {
            clear: both;
        }

        .socialicons img {
            vertical-align: middle;
        }
    </style>
</head>
<body>

<div class="topmenu">
    <div class="container">
        <ul>
            <li><a href="index.php">صفحه اصلی</a></li>
            <?php
            if (!isset($_SESSION['islogin'])) {
                echo "<li><a href=\"login.php\">ورود</a></li>";
            } else {
                echo "<li><a href=\"logout.php\">خروج</a></li>";
            }
            ?>
            <li><a href=\"#\">درباره ما</a></li>
        </ul>
    </div>
</div>

<div class="container">
    <h3>فرم ثبت‌نام نویسنده</h3>
    <form method="post">
        <input name="fname" type="text" placeholder="نام شما" required>
        <input name="lname" type="text" placeholder="نام خانوادگی" required>
        <input name="email" type="email" placeholder="ایمیل" required>
        <input name="username" type="text" placeholder="نام کاربری" required>
        <input name="password" type="password" placeholder="رمز عبور" required>
        <input type="submit" name="register" value="ایجاد حساب کاربری">
    </form>
</div>

</body>
</html>
