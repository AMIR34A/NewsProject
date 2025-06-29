<?php
session_start();
include 'config.php';
if (isset($_POST['submit_comment']) && isset($_SESSION['userid']) && isset($_GET['id'])) {
    $comment = mysqli_real_escape_string($conn, $_POST['comment_text']);
    $userid = $_SESSION['userid'];
    $newsid = $_GET['id'];

    $sql = "INSERT INTO comments (news_id, user_id, comment_text, status) VALUES ('$newsid', '$userid', '$comment', 'pending')";
    mysqli_query($conn, $sql);
}
if (isset($_POST['delete_comment']) && isset($_SESSION['username']) && $_SESSION['username'] === 'admin') {
    $comment_id = intval($_POST['comment_id']);
    mysqli_query($conn, "DELETE FROM comments WHERE id = $comment_id");
}
?>

<html>
<head>
    <title>تاج نیوز</title>
    <link rel="stylesheet" href="css/site1.css">
    <meta charset="utf-8">
    <link href="ax/khabar1.png" rel="icon">
    <meta name="keywords" content="خبر، اخبار فوری، اقتصادی، سیاسی، ورزشی، هنری، حوادث">
    <meta name="description" content="وبسایت تاج نیوز: درج جدیدترین اخبار در حوزه های مختلف ">
    <meta name="author" content="H.Ebrahimi">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/owl.theme.css">
    <link rel="stylesheet" href="style4.css">
    <script src="js/jquery-1.9.1.min.js"></script>
    <script src="js/owl.carousel.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/fs.js"></script>

    <style>
        .comment-form, .comments-section {
        background-color: #ffffff;
        padding: 25px;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.08);
    margin-top: 40px;
    font-family: 'Vazirmatn', sans-serif;
}

.comment-form h3, .comments-section h3 {
    margin-bottom: 20px;
    color: #0072ff;
}

.comment-form textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 10px;
    resize: vertical;
    font-size: 15px;
    direction: rtl;
}

.comment-form input[type="submit"] {
    background-color: #0072ff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 10px;
    font-size: 15px;
    cursor: pointer;
    margin-top: 10px;
}

.comment-form input[type="submit"]:hover {
    background-color: #005ed3;
}

.comments-section .comment-item {
    border-bottom: 1px solid #ddd;
    padding: 15px 0;
}

.comments-section .comment-author {
    font-weight: bold;
    color: #333;
}

.comments-section .comment-time {
    color: #777;
    font-size: 13px;
    margin-right: 10px;
}

.comments-section .comment-text {
    margin-top: 8px;
    line-height: 1.7;
    white-space: pre-wrap;
    direction: rtl;
}

    </style>
</head>
<body >
<div class="topmenu">
    <div class="container">
        <div class="socialicons fbicon">
            <img src="ax/tajnews2.png" width="158" height="58" alt="خبر">
        </div>
        <ul>
            <li style="margin-top: 5px;"><img src="ax/tajnews1.png" width="158" height="58" alt="خبر"></li>
            <li style="margin-top: 10px;"><a href="index.php">صفحه اصلی</a></li>
            <?php
            if(!isset($_SESSION['islogin'])){
                echo "<li style=\"margin-top: 10px;\"><a href=\"login.php\" style=\"float: left;\">ورود</a></li>";
            } else {
                if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin') {
                    echo "<li style=\"margin-top: 10px;\"><a href=\"admin/index.php\" style=\"float: left;\">پنل مدیریت</a></li>";
                } else {
                    echo "<li style=\"margin-top: 10px;\"><a href=\"author/index.php\" style=\"float: left;\">خبرهای من</a></li>";
                }
                echo "<li style=\"margin-top: 10px;\"><a href=\"logout.php\" style=\"float: left;\">خروج</a></li>";
            }
?>
            <li style="margin-top: 10px;"><a href="#">درباره ما</a></li>
        </ul>
    </div>
    <div class="clear"></div>
</div>

<div class="mainmenus">
    <div class="container">
        <ul>
            <?php
            $sql = "SELECT * FROM cats";
            $res = mysqli_query($conn , $sql);
            while ($row = mysqli_fetch_assoc($res)){
                ?>
                <li><a href="category.php?id=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></li>
            <?php } ?>
        </ul>
    </div>
    <div class="clear"></div>
</div>

<div class="container">
    <?php
    if(isset($_GET['id'])){
    $sql = "SELECT * FROM news where id=".$_GET['id'];
    $res = mysqli_query($conn , $sql);
    $row = mysqli_fetch_assoc($res);
    ?>
    <div class="titlezone" style="margin-top: 30px">
        <h3><?php echo $row['title']; ?></h3>
        <div class="clear"></div>
    </div>

        <div class="postbox">
            <a href="show_news.php?id=<?php echo $row['id']; ?>"><img width="430" height="430" src="data:image/jpeg;base64,<?php echo base64_encode($row['pic']); ?>" title="<?php echo $row['title']; ?>"/></a>
            <div class="postmetas">
            <i class="fa fa-calendar-o"></i>
            <?php 
                echo $row['date']; 
            ?>
            <i class="fa fa-user"></i>
            <?php 
                if (isset($row['userid'])) {
                    $userid = $row['userid'];
                    $user_query = "SELECT fname, lname FROM users WHERE id = $userid";
                    $user_result = mysqli_query($conn, $user_query);
                    if ($user_result && mysqli_num_rows($user_result) > 0) {
                        $user_row = mysqli_fetch_assoc($user_result);
                        echo $user_row['fname'] . ' ' . $user_row['lname'];
                    } else {
                        echo "کاربر نامشخص";
                    }
                } else {
                    echo "کاربر نامشخص";
                }
            ?>
            <i class="fa fa-newspaper-o"></i>
            <?php 
                $cat_id = $row['catid'];
                $sql = "SELECT * FROM cats where id = '$cat_id'";
                $rez = mysqli_query($conn , $sql);
                $roz = mysqli_fetch_assoc($rez);
                echo $roz['name'];
            ?>
        </div>
            <P><?php echo $row['matn']; ?></P>
            <div class="clear"></div>
        </div>
    <?php } ?>

    <?php if (isset($_SESSION['userid'])): ?>
        <div class="comment-form">
            <h3>ارسال دیدگاه</h3>
            <form method="post">
                <textarea name="comment_text" rows="5" placeholder="دیدگاه خود را بنویسید..." required></textarea>
                <input type="submit" name="submit_comment" value="ارسال دیدگاه">
            </form>
        </div>
    <?php else: ?>
        <p style="margin-top: 40px; color: red;">برای ارسال دیدگاه ابتدا <a href="login.php" style="color: #000; text-decoration: underline;">وارد شوید</a>.</p>
    <?php endif; ?>


    <?php
        if (isset($_GET['id'])) {
            $newsid = $_GET['id'];
            $sql = "SELECT c.id, c.comment_text, c.created_at, u.fname, u.lname 
                FROM comments c
                JOIN users u ON c.user_id = u.id
                WHERE c.news_id = $newsid AND c.status = 'approved'
                ORDER BY c.created_at DESC";
            $res = mysqli_query($conn, $sql);

            echo "<div class='comments-section'>";
            echo "<h3>دیدگاه‌ها</h3>";
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    echo "<div class='comment-item'>";
                    echo "<div><span class='comment-author'>" . htmlspecialchars($row['fname'] . ' ' . $row['lname']) . "</span>";
                    echo "<span class='comment-time'>" . htmlspecialchars($row['created_at']) . "</span></div>";
                    echo "<div class='comment-text'>" . htmlspecialchars($row['comment_text']) . "</div>";
                    if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin') {
                        echo "<form method='post' style='display:inline'>";
                        echo "<input type='hidden' name='comment_id' value='" . $row['id'] . "'>";
                        echo "<button type='submit' name='delete_comment' style='background:none; border:none; color:red; cursor:pointer; font-size:13px;'>🗑 حذف</button>";
                        echo "</form>";
                    }
                    echo "</div>";
                }
            } else {
                echo "<p>هنوز دیدگاهی ثبت نشده است.</p>";
            }
            echo "</div>";
        }
    ?>

    <div class="titlezone">
        <h3>تبلیغات</h3>
        <div class="clear"></div>
    </div>
    <div class="tabliq" style="padding: 20px">
        <li style="margin-top: 10px"><a href="#">جذابیت بیت کوین صد هزار دلاری در کوینکس</a> </li>
        <li style="margin-top: 20px"><a href="#">فلای تودی، خرید بلیط هواپیما از 900 ایرلاین</a></li>
        <li style="margin-top: 20px"><a href="#">خرید قسطی، تحویل فوری، با تپسی شاپ </a> </li>
        <li style="margin-top: 20px"><a href="#">خرید بلیط اتوبوس با 50% تخفیف</a></li>
        <li style="margin: 20px 0px"><a href="#">زبان انگلیسی رو مثل آب خوردن یاد بگیر!!! اینجا کلیک کن...</a> </li>
    </div>
    <div class="im" >
        <p style="padding: 20px">موضوع : پروژه درس مهندسی اینترنت</p>
    </div>

</div>
</div>
</body>
</html>