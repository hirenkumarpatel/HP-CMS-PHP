<?php
session_start();
if (isset($_SESSION['user'])) {
    //header("location:index.php");
}
include '../db/DBConfig.php';
$msg = "";
$connection = dbConnect();
if ($connection) {
    if ($_POST) {
        $userName = mysqli_real_escape_string($connection, $_POST['txtUserName']);
        $password = md5(mysqli_real_escape_string($connection, $_POST['txtPassword']));

        // validating login field data..

        if ($userName == "" or $password == "") {
            $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> Username and Password can not be empty.
                                        </div>";
        } else {
            $query = "select user_name,user_password from users where user_name='{$userName}' and user_password='{$password}'";
            $result = mysqli_query($connection, $query);
            if (mysqli_errno($connection)) {
                $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>SQL Error:</strong>" . mysqli_error($connection) . ".
                                        </div>";
            } else {
                if ($result) {
                    $row = mysqli_fetch_array($result);
                    if ($row > 0) {
                        $_SESSION['user'] = $row['user_name'];
                        header("location:index.php");
                    } else {
                        $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> Invalid Username or Password.
                                        </div>";
                    }
                }
            }
        }
    }
}

mysqli_close($connection);
?>
<!DOCTYPE html>
<html class=" ">
    <head>

        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>HP CMS : Login</title>
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

                    <div class="col-lg-8 col-md-12 col-xs-12 col-sm-12">
                        <section class="box ">
                            <header class="panel_header">
                                <center>
                                    <h2 class="title">HP CMS</h2>
                                </center>
                            </header>
                            <div >
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">

                                        <!-- START -->
                                        <div class="position-center ">
                                            <div class="text-center">


                                                <div class="modal-dialog">
                                                    <?php
                                                    echo "$msg";
                                                    ?>
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="">

                                                            <h4 class="modal-title">Sign In</h4>
                                                        </div>
                                                        <div class="modal-body">

                                                            <form class="form-horizontal" role="form" method="post">



                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <span class="arrow"></span>
                                                                        <i class="fa fa-user"></i>     
                                                                    </span>
                                                                    <input type="text" class="form-control" placeholder="Your User Name" id='inputEmail2' value='' name="txtUserName">
                                                                </div>
                                                                <br>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <span class="arrow"></span>
                                                                        <i class="fa fa-lock"></i>     
                                                                    </span>
                                                                    <input type="password" class="form-control" placeholder="Your Password" id='inputpw2' value='' name="txtPassword">
                                                                </div>

                                                                <br>
                                                                <div class="input-group">
                                                                    <label class="form-label">
                                                                        <input type="checkbox" checked="" class="iCheck" name="chkRememberMe"> <span>Remember me</span>
                                                                    </label>


                                                                </div>                                            
                                                                <br>

                                                                <div class="input-group">
                                                                    <div class="">
                                                                        <button type="submit" class="btn btn-primary ">Sign in</button>
                                                                    </div>
                                                                </div>
                                                            </form>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- END -->




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

    </body>
</html>

