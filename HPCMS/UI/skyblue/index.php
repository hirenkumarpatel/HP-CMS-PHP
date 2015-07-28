<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo $environment['blog_title'] ?></title>
        <meta name="description" content="">
            <meta name="keywords" content="">
                <meta http-equiv="Content-Type"
                      content="text/html; charset=iso-8859-1">
                          <?php
                          include $environment['theme_path'] . 'header-library.php';
                          ?>
                    </head>
                    <body>
                        <div class="main">
                            <div class="page">
                                <div class="header">
                                    <?php include $environment['theme_path'] . 'header.php'; ?>

                                    <?php include $environment['theme_path'] . 'menu.php'; ?>


                                </div>
                                <div class="content">
                                    <div class="left-panel">
                                        <div class="left-panel-in">

                                            <!--  Content area starts here -->


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
                                    $page['page_content'] = $row['page_content'];
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
                                    echo "<h3>$postTitle</h3>";
                                    echo "<p>$postContent</p>";
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
                                    echo "<h3>$postTitle</h3>";
                                    echo "<p class='right'>Posted on {$row['post_reg_date']}</p><br>";
                                    echo "<p>$postContent</p>";
                                    
                                }
                            }
                        }
                    }

                    //page content ends over here..
                    ?>

                                            <!-- Content area ends here-->
                                                                                      
                                            
                                           
                                            
                                        </div>
                                    </div>
                                    <div class="right-panel">
                                        <div class="right-panel-in">
                                            <p><img src="../UI/skyblue/images/rightimg.jpg" alt="" height="85" width="250"></p>
                                           <?php include $environment['theme_path'] . 'sidebar.php'; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <?php include $environment['theme_path'] . 'footer.php'; ?>
                                </div>
                            </div>
                        </div>
                    </body>
                    </html>
