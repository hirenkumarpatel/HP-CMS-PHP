<?php
include_once './db/DBConfig.php';
$connection=dbConnect();
$msg = "";

 //check for Form Post to get data
if ($_POST) {


    // connect to database
    $connection = dbConnect();
    if ($connection) {

        // accepting filterized data
        $blogName = mysqli_real_escape_string($connection, $_POST['txtBlogName']);
        $userName = mysqli_real_escape_string($connection, $_POST['txtUserName']);
        $userEmail = mysqli_real_escape_string($connection, $_POST['txtEmailAddress']);
        $password = md5(mysqli_real_escape_string($connection, $_POST['txtPassword']));
        $conPassword = md5(mysqli_real_escape_string($connection, $_POST['txtConPassword']));

        if ($blogName == "" or $userName == "" or $userEmail == "" or $password == "" or $conPassword == "") {
            $msg = "<div class='alert alert-warning alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Warning:</strong> Null data can not be accepted.Please enter all data..
                                        </div>";
        } else {



            // check for entered blog name is already exists or not
            $query = "select * from blogs where blog_name='{$blogName}'";

            $result = mysqli_query($connection, $query);
            if (mysqli_errno($connection)) {
                $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> SQL Error: " . mysqli_error($connection) . ".
                                        </div>";
            }
            if ($result) {
                if (mysqli_affected_rows($connection) > 0) {
                    $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> Blog Name is not available.
                                        </div>";
                } else {


                    // check for valid username and email address..
                    $query = "select * from users where user_name='{$userName}' or user_email='{$userEmail}'";

                    $result = mysqli_query($connection, $query);
                    if (mysqli_errno($connection)) {
                        $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> SQL Error: " . mysqli_error($connection) . ".
                                        </div>";
                    }
                    if ($result) {

                        if (mysqli_affected_rows($connection) > 0) {
                            $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> User Name or Email is already taken please try other.
                                        </div>";
                        } else {
                            // check for Password matching

                            if ($password !== $conPassword) {
                                $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> Your Password does not match to Confirm Password.
                                        </div>";
                            } else {
                                $query = "insert into users(user_name,user_email,user_password)values('{$userName}','{$userEmail}','{$password}');";
                                $result = mysqli_query($connection, $query);

                                // check for error
                                if ($result) {

                                    if (mysqli_affected_rows($connection) < 1) {
                                        $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> SQL Error:" . mysqli_error($connection) . ".
                                        </div>";
                                    } else {
                                        $query = "insert into blogs(blog_name,blog_user_name)values('{$blogName}','{$userName}');";
                                        $result = mysqli_query($connection, $query);

                                        // check for error
                                        if ($result) {
                                            /*$msg = "<div class='alert alert-success alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Success:</strong> Your Blog has been registered.
                                        </div>";
                                             * */
                                            header("location:configure-step2.php?blog={$blogName}");
                                        }
                                    }
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
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="" name="description" />
        <meta content="" name="author" />

        <?php
        include './theme-part/header-library.php';
        ?>

        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
        <link href="assets/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" media="screen"/>        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class=" ">

        <!-- START CONTAINER -->
        <div class="page-container row-fluid">


            <!-- START CONTENT -->
            <section id="main-content" class=" ">
                <section class="wrapper" style='margin-top:60px;display:inline-block;width:100%;padding:15px 0 0 15px;'>


                    <div class="clearfix"></div>
                    <div class=" col-lg-8 col-md-12 col-xs-12 col-sm-12">
                        <section class="box ">
                            <header class="panel_header">
                                <h2 class="title pull-left">HP CMS - Blog Configuration</h2>

                            </header>
                            <div class="content-body">    <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">

                                        <?php echo "$msg"; ?>
                                        <form id="commentForm" method="post">

                                            <div id="pills"class='wizardpills' >
                                                <ul class="form-wizard">
                                                    <li><a href="#pills-tab1" data-toggle="tab"><span>User</span></a></li>
                                                    <li><a href="#pills-tab2" data-toggle="tab"><span>Blog</span></a></li>
                                                    <li><a href="#pills-tab3" data-toggle="tab"><span>Finish</span></a></li>

                                                </ul>
                                                <div id="bar" class="progress active">
                                                    <div class="progress-bar progress-bar-primary " role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                                </div>
                                                <div class="tab-content">
                                                    <div class="tab-pane" id="pills-tab1">

                                                        <h4>User Information</h4><br>
                                                        <div class="form-group">
                                                            <label class="form-label" for="field-1">Blog Name</label>
                                                            <div class="controls">
                                                                <input type="text" placeholder="Blog Name" class="form-control" name="txtBlogName" id="txtBlogName">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="form-label" for="field-1">User Name</label>
                                                            <div class="controls">
                                                                <input type="text" placeholder="User Name" class="form-control" name="txtUserName" id="txtUserName">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="form-label" for="field-1">Email Address</label>
                                                            <div class="controls">
                                                                <input type="text" placeholder="Email Address" class="form-control" name="txtEmailAddress" id="txtEmail">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label" for="field-1">Password</label>
                                                            <div class="controls">
                                                                <input type="password" placeholder="password" class="form-control" name="txtPassword" id="txtPassword">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label" for="field-1">Confirm Password</label>
                                                            <div class="controls">
                                                                <input type="password" placeholder="Confirm Password" class="form-control" name="txtConPassword" id="txtConPassword">
                                                            </div>
                                                        </div>

                                                    </div>
                                                   
                                                    <div class="clearfix"></div>

                                                    <ul class="pager wizard">

                                                        <input type="submit" class="btn btn-corner btn-primary  " style="float: right;" value="Next Step">
                                                        
                                                    </ul>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </section></div>

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
        <script src="assets/plugins/autosize/autosize.min.js" type="text/javascript"></script><script src="assets/plugins/icheck/icheck.min.js" type="text/javascript"></script><!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 
        <script src="assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script> <script src="assets/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js" type="text/javascript"></script> <script src="assets/js/form-validation.js" type="text/javascript"></script> <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 

    </body>
</html>

