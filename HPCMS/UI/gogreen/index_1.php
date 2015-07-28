<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <?php
        include $environment['theme_path'].'header-library.php';
        ?>
        <title><?php echo $environment['blog_title'] ?></title>
    </head>
    <body>

        <div id="wrap">

            <?php require_once $environment['theme_path'].'header.php'; ?>

            <?php include_once $environment['theme_path'].'menu.php'; ?>


            <div id="menubottom"> </div>

            <div id="content">

                <div class="left">

                   <?php
                   // here actual page content starts
                   $page=array();
                   $page['page_name']="";
                   $page['page_content']="";
                   if($connection)
                    {
                        
                       if(isset($_GET['page']))
                        {
                            
                            $page['page_name']=  mysqli_real_escape_string($connection,$_GET['page']);
                        }
                        else
                        {
                            $page['page_name']='home';
                        }
                       
                       $query="select * from pages where page_name='{$page['page_name']}'";
                        $result=  mysqli_query($connection, $query);
                        if($result)
                        {
                            $row=  mysqli_fetch_array($result);
                            if($row>0)
                            {
                                $page['page_content']=$row['page_content'];
                            }
                        }
                    }
                   echo $page['page_content'];
                   //page content ends over here..
                   ?>

                </div>

                 <!--sidebar starts here      -->
                <div class="right">
                    <?php
                    include $environment['theme_path'] . 'sidebar.php';
                    ?>
                </div>

                <!-- sidebar ends here -->      


                <div style="clear: both;"> </div>

            </div>

            <?php
            include $environment['theme_path'].'footer.php';
            ?>

        </div>

    </body>
</html>
