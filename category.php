<?php
session_start();
include 'config.php';
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
    <div class="titlezone" style="margin-top: 30px">
    <?php
        $sql = "SELECT * FROM cats where  id=".$_GET['id'];
        $res = mysqli_query($conn , $sql);
        $row = mysqli_fetch_assoc($res);
        $title = $row['name'];
    ?>
        <h3><?php echo $title; ?></h3>
        <div class="clear"></div>
    </div>
    <?php
    $sql = "SELECT * FROM news WHERE catid = ".$_GET['id']." AND status = 'approved'";
    $res = mysqli_query($conn , $sql);
    while ($row = mysqli_fetch_assoc($res)){
        ?>
        <div class="postbox">
            <a href="show_news.php?id=<?php echo $row['id']; ?>"><img width="200" height="200" src="data:image/jpeg;base64,<?php echo base64_encode($row['pic']); ?>" title="<?php echo $row['title']; ?>"/></a>
            <a href="show_news.php?id=<?php echo $row['id']; ?>"><h2><?php echo $row['title']; ?></h2></a>
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

    <div class="clear"></div>

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