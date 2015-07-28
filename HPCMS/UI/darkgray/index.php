<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $environment['blog_title'] ?></title>

        <?php
        include $environment['theme_path'] . 'header-library.php';
        ?>

        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
    </head>
    <body>
        <div id="container">

            <?php include $environment['theme_path'] . 'header.php'; ?>
            <?php include $environment['theme_path'] . 'menu.php'; ?>

            <div id="body" class="width">


                <aside class="sidebar small-sidebar left-sidebar">
                    <?php
                    include $environment['theme_path'] . 'sidebar.php';
                    ?>


                </aside>

                <section id="content" class="two-column">
                    <article>
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
                                        echo "<p style='float:right'>Posted on {$row['post_reg_date']}</p><br>";
                                        echo "<p>$postContent</p>";
                                    }
                                }
                            }
                        }

                        //page content ends over here..
                        ?>




                    </article>



                </section>


                <div class="clear"></div>
            </div>
            <?php
            $environment['theme_path'] . 'footer.php';
            ?>
        </div>
    </body>
</html>