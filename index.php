<?php
include 'config.php';
session_start();
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
            if (!isset($_SESSION['islogin'])) {
                echo "<li style=\"margin-top: 10px;\"><a href=\"login.php\" style=\"float: left;\">ورود</a></li>";
            } else {
                if ($_SESSION['username'] == 'admin') {
                    echo "<li style=\"margin-top: 10px;\"><a href=\"admin/index.php\" style=\"float: left;\">پنل مدیریت</a></li>";
                } else {
                    echo "<li style=\"margin-top: 10px;\"><a href=\"author/index.php\" style=\"float: left;\">خبرهای من</a></li>";
                    echo "<li style=\"margin-top: 10px;\"><a href=\"author/comments.php\" style=\"float: left;\">دیدگاه‌های من</a></li>";
                }
                echo "<li style=\"margin-top: 10px;\"><a href=\"logout.php\" style=\"float: left;\">خروج</a></li>";
}

            ?>
            <li style="margin-top: 10px;"><a href="#">درباره ما</a></li>
        </ul>
    </div>
    <div class="clear"></div>
</div>

<div class="section-mahsol"> 
        <div class="section-mahsol2">
            <a href="category.php?id=1">
               <img src="ax/a1.jpg"> 
            </a>
        </div> 
        <div class="section-mahsol2">
            <a href="category.php?id=2">
               <img src="ax/a2.jpg"> 
            </a>
        </div>
        <div class="section-mahsol2">
            <a href="category.php?id=3">
               <img src="ax/a3.jpg"> 
            </a>
        </div>
        <div class="section-mahsol2">
            <a href="category.php?id=07">
               <img src="ax/a4.jpg"> 
            </a>
        </div> 
        <div class="section-mahsol2">
            <a href="category.php?id=5">
               <img src="ax/a5.jpg"> 
            </a>
        </div> 
        <div class="section-mahsol2">
            <a href="category.php?id=6">
               <img src="ax/a6.jpg"> 
            </a>
        </div> 
    </div>
<div class="clear"></div>

<div class="container">
    <div class="titlezone" style="margin-top: 30px">
        <h3>سرخط خبرها</h3>
        <div class="mainmenus">
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
    <?php
    $sql = "SELECT * FROM news WHERE status = 'approved' ORDER BY id DESC LIMIT 4";
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

    <div class="titlezone">
        <?php 
            $randnum = rand(1, 6);
            $sql = "SELECT * FROM cats WHERE id=$randnum limit 4";
            $res = mysqli_query($conn , $sql);
            $row = mysqli_fetch_assoc($res);
            $title = $row['name'];
        ?>
        <h3><?php echo $title; ?></h3>
        <div class="clear"></div>
    </div>

    
    <?php
    $sql = "SELECT * FROM news WHERE catid = $randnum AND DATE(date) = CURDATE() AND status = 'approved' LIMIT 5";
    $res = mysqli_query($conn , $sql);
    while ($row = mysqli_fetch_assoc($res)){
    ?>
    <div class="postbox">
        <a href="show_news.php?id=<?php echo $row['id']; ?>"><img width="200" height="200" src="data:image/jpeg;base64,<?php echo base64_encode($row['pic']); ?>" title="<?php echo $row['title']; ?>"/></a>
        <a href="#"><h2><?php echo $row['title']; ?></h2></a>
        <div class="postmetas">
            <i class="fa fa-calendar-o"></i>
            <?php 
                echo $row['date']; 
            ?>
            <i class="fa fa-user"></i>
            <?php 
                echo $row['user']; 
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

    <div class="im" >
        <p style="padding: 20px">موضوع : پروژه درس مهندسی اینترنت</p>
    </div>

</div>
</body>
</html>