<?php
include_once './db/DBConfig.php';
$connection=  dbConnect();
$msg = "";
$blogName = "";

if ($_GET) {
    if (isset($_GET['blog'])) {
        $blogName = $_GET['blog'];

        // check for entered blog name is already exists or not
        $query = "select blog_name from blogs where blog_name='{$blogName}'";

        $result = mysqli_query($connection, $query);



        if (mysqli_errno($connection)) {
            $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> SQL Error: " . mysqli_error($connection) . ".
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

// check for Form Post to get data
    if ($_POST) {



        // connect to database
        $connection = dbConnect();
        if ($connection) {

            // accepting filterized data
            $blogTitle = mysqli_real_escape_string($connection, $_POST['txtBlogTitle']);
            $blogSubtitle = mysqli_real_escape_string($connection, $_POST['txtBlogSubtitle']);
            $blogName = mysqli_real_escape_string($connection, $_POST['lblBlogName']);
            if ($blogTitle == "") {
                $msg = "<div class='alert alert-warning alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Warning:</strong> Please enter title of Your Blog.
                                        </div>";
            } else {



                // check for entered blog name is already exists or not
                $query = "update blogs set blog_title='{$blogTitle}', blog_subtitle='{$blogSubtitle}' where blog_name='{$blogName}'";

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
                                            <strong>Error:</strong> SQL Error: " . mysqli_error($connection) . ".Query: $query
                                        </div>";
                    } else {

                        $activationKey = md5(uniqid("HPCMS"));


                        $query = "select u.user_name ,u.user_email,b.blog_name from users u, blogs b where b.blog_name='{$blogName}' and b.blog_user_name=u.user_name ";

                        $result = mysqli_query($connection, $query);
                        if (mysqli_errno($connection)) {
                            $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> SQL Error:in fetcching email " . mysqli_error($connection) . ".
                                        </div>";
                        } else {
                            if ($result) {
                                $row = mysqli_fetch_array($result);
                                if ($row > 0) {
                                    $userEmail = $row['user_email'];
                                    $userName = $row['user_name'];


                                    $query = "update users set user_activation_key='{$activationKey}' where user_name='{$userName}'";

                                    $result = mysqli_query($connection, $query);



                                    if (mysqli_errno($connection)) {
                                        $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> SQL Error: " . mysqli_error($connection) . ".Query: $query
                                        </div>";
                                    } else {

                                        header("location:configure-step3.php?blog={$blogName}");
                                    }
                                }
                            }
                        }
                    }
                } else {
                    
                }
            }
        }
    }
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
                                            <form id="commentForm"
                                                  method="post">

                                                <div id="pills" class='wizardpills'>
                                                    <ul class="form-wizard">
                                                        <li class="complete"><a href="#pills-tab1" data-toggle="tab"
                                                                                area-expanded="true"><span>User</span></a></li>
                                                        <li class="active"><a href="#pills-tab2" data-toggle="tab"><span>Blog</span></a></li>
                                                        <li><a href="#pills-tab3" data-toggle="tab"><span>Finish</span></a></li>

                                                    </ul>
                                                    <div id="bar" class="progress active">
                                                        <div class="progress-bar progress-bar-primary "
                                                             role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                             aria-valuemax="100" style="width: 0%;"></div>
                                                    </div>
                                                    <div class="tab-content">

                                                        <div class="tab-pane active" id="pills-tab2">

                                                            <h4>Blog Information</h4>
                                                            <br>
                                                            <div class="form-group">
                                                                <label class="form-label" for="field-1">Blog Display Name</label>
                                                                <div class="controls">
                                                                    <input type="text" placeholder="Blog Display Name"
                                                                           class="form-control" name="txtBlogTitle"
                                                                           id="txtFullName">
                                                                </div>
                                                            </div>



                                                            <div class="form-group">
                                                                <label class="form-label" for="field-1">Subtitle</label>
                                                                <div class="controls">
                                                                    <input type="text" placeholder="Enter Tagline"
                                                                           class="form-control" name="txtBlogSubtitle"
                                                                           id="txtSubtitle">
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="lblBlogName"
                                                                   value="<?php echo $blogName; ?>">

                                                        </div>

                                                        <div class="clearfix"></div>

                                                        <ul class="pager wizard">

                                                            <input type="submit" class="btn btn-corner btn-primary  "
                                                                   style="float: right;" value="Next Step">
                                                            <!--<li class="previous"><a href="javascript:;">Previous</a></li>
            <li class="next"><a href="javascript:;">Next</a></li>
            <li class="finish"><a href="javascript:;">Finish</a></li>
                                                            -->
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

