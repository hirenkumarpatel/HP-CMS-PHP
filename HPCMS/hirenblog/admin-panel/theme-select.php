<?php

include '../blog-config.php';
$msg = "";
$pageTitle = "";
$pageContent = "";
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}

if ($_GET) {
    if ($connection) {

        $themeName = mysqli_real_escape_string($connection, $_GET['name']);

        $query = "update blogs set blog_theme_name='{$themeName}' where blog_name='{$environment['blog_name']}'";

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
                                            <strong>Error:</strong>No such theme found.
                                        </div>";
            } else {

                $msg = "<div class='alert alert-success alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Success:</strong> Well done! You successfully changed theme..</div>";
            }
        }
    }

    header("location:theme.php?msg={$msg}");
}


