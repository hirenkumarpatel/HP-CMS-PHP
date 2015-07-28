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

        $pageName = mysqli_real_escape_string($connection, $_GET['page']);

        $query = "delete from pages where page_blog_name='{$environment['blog_name']}' and page_name='{$pageName}'";

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
                                            <strong>Error:</strong>No such page found.
                                        </div>";
            } else {
                $query = "delete from menus where menu_name='{$pageName}' and menu_blog_name='{$environment['blog_name']}'";

                $result = mysqli_query($connection, $query);
                if (mysqli_errno($connection)) {
                    $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> " . mysqli_error($connection) . ".
                                        </div>";
                } else {
                    if ($result) {
                        if (mysqli_affected_rows($connection) > 0) {
                            $msg = "<div class='alert alert-success alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Success:</strong> Well done! You successfully removed page and Menu.</div>";
                        } else {
                            $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong>No such menu found.
                                        </div>";
                        }
                    }
                }
            }
        }
        header("location:page-list.php?msg={$msg}");
    }
}

