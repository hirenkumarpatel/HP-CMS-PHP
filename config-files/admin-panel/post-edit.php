<?php
include '../blog-config.php';
$msg = "";
$postTitle = "";
$postContent = "";
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}

if ($_GET) {
    if ($connection) {

        $postName = mysqli_real_escape_string($connection, $_GET['post']);

        $query = "select * from posts where post_blog_name='{$environment['blog_name']}' and post_name='{$postName}'";

        $result = mysqli_query($connection, $query);
        if (mysqli_errno($connection)) {
            $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> " . mysqli_error($connection) . ".
                                        </div>";
        } else {
            if ($result) {
                $row = mysqli_fetch_array($result);
                if ($row) {
                    $postTitle = $row['post_title'];
                    $postContent = $row['post_content'];
                    $postCategoryId = $row['category_id'];
                }
               
            } else {
                $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> No such data found in database.
                                        </div>";
            }
        }
    }
}



if ($_POST) {

    if ($connection) {
        $oldPostName = mysqli_real_escape_string($connection, $_POST['lblOldPostName']);
        $postTitle = mysqli_real_escape_string($connection, $_POST['txtPostTitle']);
        $postContent = mysqli_real_escape_string($connection, $_POST['txtPostContent']);
        $titles = explode(" ", $postTitle);
        $postName = "";
        foreach ($titles as $key) {
            $postName = $postName . '-' . $key;
        }
        $postCategoryId = $_POST['sltCategoryId'];
        ;

        if ($postTitle == "") {
            $postTitle = "Untitled Post";
        }
        $query = "update posts set post_name='{$postName}',post_title='{$postTitle}', post_content='{$postContent}',post_category_id='{$postCategoryId}' where post_name='{$oldPostName}' and post_blog_name='{$environment['blog_name']}';";

        $result = mysqli_query($connection, $query);
        if (mysqli_errno($connection)) {
            $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> " . mysqli_error($connection) . ".
                                        </div>";
        }
        if ($result) {



            $msg = "<div class='alert alert-success alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Success:</strong> Well done! You successfully added new post and Menu.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html class=" ">
    <?php
    include './theme-part/header-library.php';
    ?>

    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
    <link href="assets/plugins/bootstrap3-wysihtml5/css/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="assets/plugins/uikit/css/uikit.min.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="assets/plugins/uikit/vendor/codemirror/codemirror.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/uikit/css/components/htmleditor.css" rel="stylesheet" type="text/css" media="screen"/>     

    <!-- OTHER SCRIPTS for messanger --> 
    <link href="assets/plugins/messenger/css/messenger.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/messenger/css/messenger-theme-future.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/messenger/css/messenger-theme-flat.css" rel="stylesheet" type="text/css" media="screen"/>     
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 

    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class=" ">
        <!-- START TOPBAR -->
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


                    <form method="post" action="">
                        <div class="col-lg-9">
                            <?php
// for displaying message..
                            echo $msg;
                            ?>
                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title pull-left">Edit Post</h2>

                                </header>
                                <div class="content-body">    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">


                                            <div class="form-group">

                                                <div class="controls">
                                                    <input type="text" class="form-control" id="field-1" placeholder="Enter your title here.." name="txtPostTitle" value="<?php echo $postTitle; ?>">
                                                </div>
                                            </div>
                                            <textarea class="ckeditor" cols="80" id="editor1"  rows="10" placeholder="Enter post content here.." name="txtPostContent">
                                                <?php echo $postContent; ?>
                                            </textarea>
                                            <input type="hidden" name="lblOldPostName" value="<?php echo $postName; ?>">
                                            <div class="form-group">

                                                <button type="submit" class="btn btn-purple  pull-right" style="margin-top: 20px;">Publish Post</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </section>





                        </div>


                        <!--For category -->

                        <div class="col-lg-3">

                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title pull-left">Category</h2>

                                </header>

                                <div class="content-body">    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">


                                            <div class="form-group">

                                                <div class="controls">

                                                    <label>Select Category:</label>
                                                    <select name="sltCategoryId">
                                                        <?php
                                                        if (isset($connection)) {
                                                            $query = "select * from categories where category_blog_name='{$environment['blog_name']}'";
                                                            $result = mysqli_query($connection, $query);
                                                            if (mysqli_errno($connection)) {
                                                                $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                                                <strong>Danger:</strong> Error:" . mysqli_error($connection) . ".
                                                                </div>";
                                                            } else {
                                                                if ($result) {
                                                                    while ($row = mysqli_fetch_array($result)) {

                                                                        
                                                                        if ($postCategoryId == $row['post_category_id']) {
                                                                            $select = "selected='selected'";
                                                                        } else {
                                                                            $select = "";
                                                                        }
                                                                        echo "<option $select value='{$row['category_id']}'>{$row['category_title']}</option>";
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </select>


                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </section></div>
                    </form>



                </section>
            </section>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->
        <?php include './theme-part/footer-library.php';
        ?>

        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
        <script src="assets/plugins/bootstrap3-wysihtml5/js/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script><script src="assets/plugins/ckeditor/ckeditor.js" type="text/javascript"></script><script src="assets/plugins/uikit/js/uikit.min.js" type="text/javascript"></script><script src="assets/plugins/uikit/vendor/codemirror/codemirror.js" type="text/javascript"></script><script src="assets/plugins/uikit/vendor/codemirror/codemirror.js" type="text/javascript"></script><script src="assets/plugins/uikit/vendor/codemirror/mode/markdown/markdown.js"></script><script src="assets/plugins/uikit/vendor/codemirror/addon/mode/overlay.js"></script><script src="assets/plugins/uikit/vendor/codemirror/mode/xml/xml.js"></script><script src="assets/plugins/uikit/vendor/codemirror/mode/gfm/gfm.js"></script><script src="assets/plugins/uikit/vendor/marked/marked.min.js" type="text/javascript"></script><script src="assets/plugins/uikit/js/components/htmleditor.js" type="text/javascript"></script><!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 
        <!-- OTHER SCRIPTS for messanger - START --> 
        <script src="assets/plugins/messenger/js/messenger.min.js" type="text/javascript"></script><script src="assets/plugins/messenger/js/messenger-theme-future.js" type="text/javascript"></script><script src="assets/plugins/messenger/js/messenger-theme-flat.js" type="text/javascript"></script><script src="assets/js/messenger.js" type="text/javascript"></script><!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


    </body>
</html>
