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

        $query = "delete from posts where post_blog_name='{$environment['blog_name']}' and post_name='{$postName}'";

        $result = mysqli_query($connection, $query);
        if (mysqli_errno($connection)) {
            $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> " . mysqli_error($connection) . ".
                                        </div>";
        } else {
            if (mysqli_affected_rows($connection) < 1) {
                $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong>No such post found.
                                        </div>";
            } else {
                $msg = "<div class='alert alert-success alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong>Postsuccessfully deleted..
                                        </div>";
            }
        }
        header("location:post-list.php?msg={$msg}");
    }
}

