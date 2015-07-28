<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title><?php echo $environment['blog_title'] ?></title>
        <?php
        include $environment['theme_path'] . 'header-library.php';
        ?>
    </head>
    <body>
        <div id="menu-wrapper">
            <?php include $environment['theme_path'] . 'menu.php'; ?>
        </div>
        <div id="header-wrapper">
            <?php include $environment['theme_path'] . 'header.php'; ?>
        </div>
        <div id="wrapper"> 
            <!-- end #header -->
            <div id="page-bgtop"></div>
            <div id="page">
                <div><img src="<?php echo $environment['theme_path'] . 'images/pics01.jpg' ?>" width="920" height="300" alt="" /></div>
                <div id="content">
                    <div class="post">

                        <?php
                        // here actual page content starts
                        $page = array();
                        $page['page_name'] = "";
                        $page['page_content'] = "";
                        $page['category'] = "0";
                        if ($connection) {

                            if (isset($_GET['page'])) {

                                $page['page_name'] = mysqli_real_escape_string($connection, $_GET['page']);
                                $query = "select * from pages where page_name='{$page['page_name']}'";
                                $result = mysqli_query($connection, $query);
                                if ($result) {
                                    $row = mysqli_fetch_array($result);
                                    if ($row > 0) {
                                        $pageTitle = $row['page_title'];
                                        echo "<h3 class='title'>$pageTitle</h3>";
                                        echo "<div style='clear: both;'>&nbsp;</div>";
                                        echo "<div class='entry'>";
                                        $page['page_content'] = $row['page_content'];
                                        echo "</div>";
                                    }
                                }
                                echo $page['page_content'];
                            } elseif (isset($_GET['category'])) {

                                $page['category'] = mysqli_real_escape_string($connection, $_GET['category']);
                                $query = "select * from posts where post_category_id='{$page['category']}' and post_blog_name='{$environment['blog_name']}'";
                                $result = mysqli_query($connection, $query);
                                if ($result) {
                                    while ($row = mysqli_fetch_array($result)) {

                                        $postTitle = $row['post_title'];
                                        $postContent = truncate($row['post_content'], 100);
                                        echo "<h3 class='title'>$postTitle</h3>";
                                        echo "<div style='clear: both;'>&nbsp;</div>";
                                        echo "<div class='entry'>";
                                        echo "<p style='margin-top:40px;'>$postContent</p>";
                                        echo "</div>";
                                        echo "<br><a href='index.php?post-detail={$row['post_id']}' style='float:right;'>Read more..</a><br>";
                                    }
                                }
                            } elseif (isset($_GET['post-detail'])) {

                                $page['post_id'] = mysqli_real_escape_string($connection, $_GET['post-detail']);
                                $query = "select * from posts where post_id='{$page['post_id']}' and post_blog_name='{$environment['blog_name']}'";
                                $result = mysqli_query($connection, $query);
                                if ($result) {
                                    $row = mysqli_fetch_array($result);
                                    if ($row > 0) {
                                        $postTitle = $row['post_title'];
                                        $postContent = $row['post_content'];
                                        echo "<h3 class='title'>$postTitle</h3>";
                                        echo "<div style='clear: both;'>&nbsp;</div>";
                                        echo "<div class='entry'>";
                                        echo "<p style='float:right;'>Posted on {$row['post_reg_date']}</p><br>";
                                        echo "<p style='margin-top:40px;'>$postContent</p>";
                                        echo "</div>";
                                    }
                                }
                            }
                        }

                        //page content ends over here..
                        ?>

                       <!-- echo "<p class='meta'><span class='date'>June 04, 2012</span><span class='posted'>Posted by <a href='#'>Someone</a></span></p> -->



                    </div>

                    <div style="clear: both;">&nbsp;</div>
                </div>
                <!-- end #content -->
                <?php
                include $environment['theme_path'] . 'sidebar.php';
                ?>
                <!-- end #sidebar -->
                <div style="clear: both;">&nbsp;</div>
            </div>
            <div id="page-bgbtm"></div>
            <!-- end #page --> 
        </div>
        <?php
        $environment['theme_path'] . 'footer.php';
        ?>
        <!-- end #footer -->
    </body>
</html>
