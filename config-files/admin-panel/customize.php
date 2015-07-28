<?php
//session_start();
include '../blog-config.php';
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
if ($connection) {
    $query = "select * from users u,blogs b where u.user_blog_id=b.blog_id and b.blog_name='{$environment['blog_name']}'";
    $result = mysqli_query($connection, $query);
    if (mysqli_errno($connection)) {
        echo "SQL Error:" . mysqli_error($connection);
    } else {
        if ($result) {
            $row = mysqli_fetch_array($result);
            if ($row > 0) {
                $userName = $row['user_name'];
                $userEmail = $row['user_email'];
                $blogTitle = $row['blog_title'];
                $blogSubtitle = $row['blog_subtitle'];
                $userPassword = $row['user_password'];
                $userProfilePicture = $row['user_profile'];
            }
        }
    }
}

if ($_POST) {
    if ($connection) {
        if (isset($_POST['lblUserForm'])) {
            $userName = mysqli_real_escape_string($connection, $_POST['txtUserName']);
            $userEmail = mysqli_real_escape_string($connection, $_POST['txtUserEmail']);
            $userPassword = mysqli_real_escape_string($connection, $_POST['txtUserPassword']);
            $userConPassword = mysqli_real_escape_string($connection, $_POST['txtUserConPassword']);
            $userOldPassword = mysqli_real_escape_string($connection, $_POST['lblUserPassword']);
            $userOldProfile = mysqli_real_escape_string($connection, $_POST['lblUserProfile']);
            //$userForm = mysqli_real_escape_string($connection, );
            $userProfilePicture = $_FILES['fileProfilePicture']['name'];
            $userOldName = mysqli_real_escape_string($connection, $_POST['lblUserName']);

            if ($userPassword != "" and $userPassword == $userConPassword) {
               $userPassword=  md5($userPassword);
                $query = "update users set user_password='{$userPassword}'where user_name='{$userOldName}'";
                $result = mysqli_query($connection, $query);
            }
            if ($userProfilePicture != "") {
                $userProfilePicture = rand() . "-" . $userProfilePicture;
                $userProfilePath = "data/profile/" . $userProfilePicture;
                $query = "update users set user_profile='{$userProfilePath}' where user_name='{$userOldName}'";
                $result = mysqli_query($connection, $query);
                if (mysqli_affected_rows($connection) > 0) {

                    if (!move_uploaded_file($_FILES["fileProfilePicture"]["tmp_name"], $userProfilePath)) {
                        echo "Error in Uploading Profile picture";
                    }
                    else
                    {
                        unlink($userOldProfile);
                    }
                }
            }
            if ($userName != "" and $userEmail != "") {
                $query = "update users set user_name='{$userName}',user_email='{$userEmail}' where user_name='{$userOldName}'";
                $result = mysqli_query($connection, $query);
            }
        }
        else
        {
             $blogTitle = mysqli_real_escape_string($connection, $_POST['txtBlogTitle']);
            $blogSubtitle = mysqli_real_escape_string($connection, $_POST['txtBlogSubtitle']);
            
            if ($blogTitle != "") {
                $query = "update blogs set blog_title='{$blogTitle}',blog_subtitle='{$blogSubtitle}' where blog_name='{$environment['blog_name']}'";
                $result = mysqli_query($connection, $query);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html class=" ">
    <?php
    include './theme-part/header-library.php';
    ?>
    <!-- BEGIN BODY -->
    <body class=" ">
        <!-- START TOPBAR -->
        <?php include './theme-part/header.php'; ?>
        <!-- END TOPBAR -->
        <!-- START CONTAINER -->
        <div class="page-container row-fluid">

            <!-- SIDEBAR - START -->
            <?php include './theme-part/sidebar.php'; ?>
            <!--  SIDEBAR - END -->
            <!-- START CONTENT -->
            <section id="main-content" class=" ">
                <section class="wrapper" style='margin-top:60px;display:inline-block;width:100%;padding:15px 0 0 15px;'>

                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                        <div class="page-title">

                            <div class="pull-left">
                                <h1 class="title">Customize</h1>          
                            </div>


                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                        <section class="box ">
                            <header class="panel_header">
                                <h2 class="title pull-left">User Information</h2>

                            </header>
                            <div class="content-body">
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-10 col-sm-9 col-xs-10">

                                            <div class="form-group">
                                                <label class="form-label" for="field-1">UserName</label>

                                                <div class="controls">
                                                    <input type="text" class="form-control" id="field-1" name="txtUserName" value="<?php echo $userName; ?>" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="field-1">Email Address</label>

                                                <div class="controls">
                                                    <input type="text" class="form-control" id="field-1" name="txtUserEmail" value="<?php echo $userEmail; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="field-1">Password</label>

                                                <div class="controls">
                                                    <input type="text" class="form-control" id="field-1" name="txtUserPassword" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="field-1">Confirm Password</label>

                                                <div class="controls">
                                                    <input type="text" class="form-control" id="field-1" name="txtUserConPassword">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="field-1" style="width:100%;">Profile Picture</label>
                                                <div class="form-controls" >
                                                    <img src="<?php echo $userProfilePicture; ?>" style="height:100px;width:100px;float: left;">
                                                    <input type="file" name="fileProfilePicture"  class="btn btn-primary"  >
                                                </div>
                                            </div>
                                            <input type="hidden" name="lblUserPassword" value="<?php echo $userPassword; ?>">
                                            <input type="hidden" name="lblUserName" value="<?php echo $userName; ?>">
                                            <input type="hidden" name="lblUserProfile" value="<?php echo $userOldProfilePicture; ?>">
                                            <input type="hidden" name="lblUserForm" value="userform">
                                            <div class="form-group">

                                                <button type="submit" class="btn btn-purple  pull-right">Update Information</button>
                                            </div>


                                        </div>
                                    </div>

                                </form>
                            </div>
                        </section>


                        <section class="box ">
                            <header class="panel_header">
                                <h2 class="title pull-left">Blog Information</h2>

                            </header>
                            <div class="content-body">
                                <form method="post" action="" >
                                    <div class="row">
                                        <div class="col-md-10 col-sm-9 col-xs-10">

                                            <div class="form-group">
                                                <label class="form-label" for="field-1">Blog Header Name</label>

                                                <div class="controls">
                                                    <input type="text" class="form-control" id="field-1" name="txtBlogTitle" value="<?php echo $blogTitle; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="field-1">Blog Subtitle</label>

                                                <div class="controls">
                                                    <input type="text" class="form-control" id="field-1" name="txtBlogSubtitle" value="<?php echo $blogSubtitle; ?>">
                                                </div>
                                            </div>


                                            <div class="form-group">

                                                <button type="submit" class="btn btn-purple  pull-right">Update Information</button>
                                            </div>




                                        </div>
                                    </div>

                                </form>
                            </div>
                        </section>
                    </div>


                </section>
            </section>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->
        <?php include './theme-part/footer-library.php';
        ?>
        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
        <script src="assets/plugins/autosize/autosize.min.js" type="text/javascript"></script><script src="assets/plugins/icheck/icheck.min.js" type="text/javascript"></script><!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 

    </body>
</html>

