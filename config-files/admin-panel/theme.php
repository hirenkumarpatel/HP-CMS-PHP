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
    include './theme-part/header-library.php';
    ?>
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
    <link href="assets/plugins/prettyphoto/prettyPhoto.css" rel="stylesheet" type="text/css" media="screen"/>  
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class=" "><!-- START TOPBAR -->


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
                                <h1 class="title">Appearance</h1>
                            </div>



                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-lg-12">
                        <section class="box ">
                            <?php echo $msg; ?>
                            <header class="panel_header">
                                <h2 class="title pull-left">Theme</h2>

                            </header>
                            <div class="content-body"> 
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">

                                        <!-- start -->
                                        <div id='portfolio' class="">

                                            <?php
                                            if ($connection) {
                                                $query = "select * from themes";
                                                $result = mysqli_query($connection, $query);
                                                if (mysqli_errno($connection)) {
                                                    $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                                                                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                                                                        <strong>Error:</strong> " . mysqli_error($connection) . ".
                                                                                    </div>";
                                                } else {
                                                    if ($result) {
                                                        if (mysqli_affected_rows($connection) < 1) {

                                                            echo "<div class='well'>
                                                            No theme file found!
                                                        </div>";
                                                        } else {
                                                            while ($row = mysqli_fetch_array($result)) {

                                                                echo "<div class='portfolio-items'>
                                                                <div class='portfolio-item col-md-4 col-sm-6 col-xs-12  creative'>
                                                                    <div class='portfolio-item-inner'>
                                                                        <img class='img-responsive' src='../../{$row['theme_path']}skin.png' alt='{$row['theme_title']}' style='height:273px;width:390px;border:2px solid black;'>
                                                                        <div class='portfolio-info animated fadeInUp animated-duration-600ms'>
                                                                            <h3>{$row['theme_title']} <a href='theme-select.php?name={$row['theme_name']}' class='btn btn-success pull-right'><i class='fa fa-check'></i></a></h3>
                                                                               
                                                                        </div>
                                                                    </div>
                                                                </div>";
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            ?>




                                            <!-- end -->

                                        </div>
                                    </div>



                                </div>
                            </div>

                        </section>
                        
                    </div>

                </section></div>


    </section>
</section>
<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->
<?php include './theme-part/footer-library.php';
?>

<!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 



</body>
</html>
