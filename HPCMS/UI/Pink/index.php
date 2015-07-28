<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $environment['blog_title'] ?></title>
        <?php
        include $environment['theme_path'] . 'header-library.php';
        ?>


        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
    </head>

    <body>

        <?php include $environment['theme_path'] . 'header.php'; ?>
        <?php include $environment['theme_path'] . 'menu.php'; ?>

        <section id="body" class="width clear">
            <aside id="sidebar" class="column-left">
                <?php
                include $environment['theme_path'] . 'sidebar.php';
                ?>
            </aside>
            <section id="content" class="column-right">
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
                
        <!--  <article>


                    <h2>Introduction to cleansed</h2>
                    <div class="article-info">Posted on <time datetime="2013-05-14">14 May</time> by <a href="#" rel="author">Joe Bloggs</a></div>

                    <p>Welcome to cleansed, a free premium valid CSS3 &amp; HTML5 web template from <a href="http://zypopwebtemplates.com/" title="ZyPOP">ZyPOP</a>. This template is completely <strong>free</strong> to use permitting a link remains back to  <a href="http://zypopwebtemplates.com/" title="ZyPOP">http://zypopwebtemplates.com/</a>.</p>

                    <p>Should you wish to use this template unbranded you can buy a template license from our website for 8.00 GBP, this will allow you remove all branding related to our site, for more information about this see below.</p>	

                    <p>This template has been tested in:</p>


                    <ul class="styledlist">
                        <li>Firefox</li>
                        <li>Opera</li>
                        <li>IE</li>
                        <li>Safari</li>
                        <li>Chrome</li>
                    </ul>

                    <a href="#" class="button">Read more</a>
                    <a href="#" class="button button-reversed">Comments</a>



                </article>-->



            
            </section>

        </section>

        <?php
        $environment['theme_path'] . 'footer.php';
        ?>
    </body>
</html>
