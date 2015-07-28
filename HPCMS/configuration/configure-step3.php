<?php
include_once './db/DBConfig.php';
$connection = dbConnect();
$msg = "";
$blogName = "";
$commandResult = array();
if ($_GET) {
    if (isset($_GET['blog'])) {
        $blogName = $_GET['blog'];
        if ($connection) {
            // check for entered blog name is already exists or not
            $query = "select blog_name from blogs where blog_name='{$blogName}'";

            $result = mysqli_query($connection, $query);

            if (mysqli_errno($connection)) {
                $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> SQL Error: " . mysqli_error($connection) . ".Query: $query 
                                        </div>";
            }
            if ($result) {
                if (mysqli_affected_rows($connection) < 1) {
                    $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> No such blog found!
                                        </div>";
                    header("location:configure-step1.php?msg={$msg}");
                }
            }
        }
    }
}
// check for Form Post to get data
if ($_POST) {

    // Configuration starts here..

    if ($connection) {

        // accepting filterized data
        chmod('../../HPCMS', 0777);

        $blogName = mysqli_real_escape_string($connection, $_POST['lblBlogName']);
        chdir("../");
        $result = exec("tar -xvf config-files.tar", $commandResult, $return);

        echo "<pre>";
        print_r($commandResult);
        echo "</pre>";
        echo "<pre>";
        print_r($result);
        echo "</pre>";
        echo "<pre>";
        print_r($return);
        echo "</pre>";

        if(is_dir('config-files'))
        {
            chmod('config-files', 0777);
            $result = rename("config-files", "$blogName");
        }

        


        if ($result) {
            $query = "update blogs set blog_theme_name='gogreen' where blog_name='{$blogName}'";
            $result = mysqli_query($connection, $query);
            if (mysqli_errno($connection)) {
                $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> SQL Error: " . mysqli_error($connection) . ".Query: $query 
                                        </div>";
            }
            if ($result) {
                if (mysqli_affected_rows($connection) < 1) {
                    $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> No such blog found!
                                        </div>";
                }
            }


            // creating first page for user..

            $pageTitle = "Home";
            $pageContent = "Welcome to new Blog..";
            $titles = "home";
            $pageName = "home";
            $pageUrl = "index.php?page=home";

            
            $query = "insert into pages values(null,'{$pageName}','{$pageContent}',null,'{$pageUrl}','{$pageTitle}','{$blogName}');";

            $result = mysqli_query($connection, $query);
            if (mysqli_errno($connection)) {
                $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> " . mysqli_error($connection) . ".
                                        </div>";
            }
            if ($result) {

                //inserting menu item to blog for new inserted page.
                $query = "insert into menus values(null,'{$pageName}','{$pageUrl}',0,'{$environment['blog_name']}','{$pageTitle}');";
                $result = mysqli_query($connection, $query);
                if (mysqli_errno($connection)) {
                    $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Danger:</strong> Error:" . mysqli_error($connection) . ".
                                        </div>";
                }
                if ($result) {

                    $msg = "<div class='alert alert-success alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Success:</strong> Well done! You successfully added new page and Menu.</div>";
                    header("location:../../{$blogName}/index.php?page=home");
                }
            }
        }
    }
} else {
    ?>
    <!DOCTYPE html>
    <html class=" ">
        <head>

            <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
            <meta charset="utf-8" />
            <title>HP CMS : Configuration</title>
            <meta name="viewport"
                  content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
            <meta content="" name="description" />
            <meta content="" name="author" />

    <?php
    include './theme-part/header-library.php';
    ?>

            <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->
            <link href="assets/plugins/icheck/skins/all.css" rel="stylesheet"
                  type="text/css" media="screen" />
            <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->


        </head>
        <!-- END HEAD -->

        <!-- BEGIN BODY -->
        <body class=" ">

            <!-- START CONTAINER -->
            <div class="page-container row-fluid">

                <!-- START CONTENT -->
                <section id="main-content" class=" ">
                    <section class="wrapper"
                             style='margin-top: 60px; display: inline-block; width: 100%; padding: 15px 0 0 15px;'>


                        <div class="clearfix"></div>




                        <div class=" col-lg-8 col-md-12 col-xs-12 col-sm-12">
                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title pull-left">HP CMS - Blog Configuration</h2>

                                </header>
                                <div class="content-body">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">

    <?php echo "$msg"; ?>
                                            <form id="commentForm" method="post">

                                                <div id="pills" class='wizardpills'>
                                                    <ul class="form-wizard">
                                                        <li class="complete"><a href="#pills-tab1" data-toggle="tab"
                                                                                area-expanded="true"><span>User</span></a></li>
                                                        <li class="complete"><a href="#pills-tab2" data-toggle="tab"><span>Blog</span></a></li>
                                                        <li class="active"><a href="#pills-tab3" data-toggle="tab"><span>Finish</span></a></li>

                                                    </ul>
                                                    <div id="bar" class="progress active">
                                                        <div class="progress-bar progress-bar-primary "
                                                             role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                             aria-valuemax="100" style="width: 0%;"></div>
                                                    </div>
                                                    <div class="tab-content">


                                                        <div class="tab-pane active" id="pills-tab3">
                                                            <h4>Confirmation</h4>
                                                            <br>
                                                            <p>We are going to configure blog you just created.</p>
                                                            <p>This may take a minute or two. please wait..</p>

                                                        </div>



                                                        <div class="clearfix"></div>

                                                        <ul class="pager wizard">
                                                            <input type="hidden" name="lblBlogName"
                                                                   value="<?php echo $blogName; ?>">
                                                            <input type="submit" class="btn btn-corner btn-primary  "
                                                                   style="float: right;" value="Finish">

                                                        </ul>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>

                    </section>
                </section>
                <!-- END CONTENT -->
            </div>
            <!-- END CONTAINER -->
            <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->
    <?php
    include './theme-part/footer-library.php';
    ?>
            <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->
            <script src="assets/plugins/autosize/autosize.min.js"
            type="text/javascript"></script>
            <script src="assets/plugins/icheck/icheck.min.js"
            type="text/javascript"></script>
            <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->
            <script
                src="assets/plugins/jquery-validation/js/jquery.validate.min.js"
            type="text/javascript"></script>
            <script
                src="assets/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"
            type="text/javascript"></script>
            <script src="assets/js/form-validation.js" type="text/javascript"></script>
            <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->

        </body>
    </html>

    <?php
}
?>