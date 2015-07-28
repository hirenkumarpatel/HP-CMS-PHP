<?php
include '../blog-config.php';
$msg = "";
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
if(isset($_GET['msg']))
{
    $msg=$_GET['msg'];
}
?>
<!DOCTYPE html>
<html class=" ">
    <?php
    include 'theme-part/header-library.php';
    ?>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class=" "><!-- START TOPBAR -->

        <?php include './theme-part/header.php'; ?>

        <!-- END TOPBAR -->
        <!-- START CONTAINER -->
        <div class="post-container row-fluid">

            <!-- SIDEBAR - START -->
            <?php include './theme-part/sidebar.php'; ?>
            <!--  SIDEBAR - END -->
            <!-- START CONTENT -->
            <section id="main-content" class=" ">
                <section class="wrapper" style='margin-top:60px;display:inline-block;width:100%;padding:15px 0 0 15px;'>

                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                        <div class="post-title">

                            <div class="pull-left">
                                <h1 class="title">Posts</h1>
                            </div>


                        </div>
                    </div>
                    <div class="clearfix"></div>



                    <div class="col-lg-12">
                        <section class="box ">
                            <?php echo $msg;?>
                            <header class="panel_header">
                                <h2 class="title pull-left">All Posts</h2>

                            </header>
                            <div class="content-body">    <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th> Category</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($connection)) {
                                                    $query = "select p.*,c.category_title from posts p,categories c where p.post_blog_name=c.category_blog_name and p.post_category_id=c.category_id and  p.post_blog_name='{$environment['blog_name']}'";
                                                    $result = mysqli_query($connection, $query);
                                                    if (mysqli_errno($connection)) {
                                                        $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                                            <strong>Danger:</strong> Error:" . mysqli_error($connection) . ".
                                                        </div>";
                                                    } else {
                                                        if ($result) {
                                                            $i = 1;
                                                            while ($row = mysqli_fetch_array($result)) {


                                                                echo"<tr>
                                                                <th scope='row'>{$i}</th>
                                                                <td width='40%'>{$row['post_title']}</td>
                                                                <td width='20%'>{$row['category_title']}</td>
                                                                <td width='20%'>{$row['post_reg_date']}</td>
                                                                <td width='20%'>
                                                                <a href='post-edit.php?post={$row['post_name']}' class='btn btn-purple btn-icon bottom5 right5'>
                                                                <i class='fa fa-edit'></i> &nbsp; <span>Edit</span>
                                                                </a>
                                                                
                                                                <a href='post-delete.php?post={$row['post_name']}' class='btn btn-danger btn-icon bottom5 right5'>
                                                                <i class='fa fa-close'></i> &nbsp; <span>Trase</span>
                                                                </a>
                                                                </td>
                                                            </tr>";
                                                                $i++;
                                                            }
                                                        }
                                                    }
                                                }
                                                ?>




                                            </tbody>
                                        </table>

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


        <!-- CORE JS FRAMEWORK - START --> 
        <script src="assets/js/jquery-1.11.2.min.js" type="text/javascript"></script> 
        <script src="assets/js/jquery.easing.min.js" type="text/javascript"></script> 
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
        <script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>  
        <script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js" type="text/javascript"></script> 
        <script src="assets/plugins/viewport/viewportchecker.js" type="text/javascript"></script>  
        <!-- CORE JS FRAMEWORK - END --> 


        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE TEMPLATE JS - START --> 
        <script src="assets/js/scripts.js" type="text/javascript"></script> 
        <!-- END CORE TEMPLATE JS - END --> 

        <!-- Sidebar Graph - START --> 
        <script src="assets/plugins/sparkline-chart/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="assets/js/chart-sparkline.js" type="text/javascript"></script>
        <!-- Sidebar Graph - END --> 













        <!-- General section box modal start -->
        <div class="modal" id="section-settings" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
            <div class="modal-dialog animated bounceInDown">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Section Settings</h4>
                    </div>
                    <div class="modal-body">

                        Body goes here...

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                        <button class="btn btn-success" type="button">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal end -->
    </body>
</html>
