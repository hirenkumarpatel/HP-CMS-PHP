
<?php

include '../blog-config.php';
$msg = "";
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
if ($connection) {
    if (isset($_GET['name'])) {
        $mediaName = mysqli_real_escape_string($connection, $_GET['name']);

        $query = "select media_url from media where media_name='{$mediaName}'";
        $result = mysqli_query($connection, $query);
        if (mysqli_errno($connection)) {
            $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> " . mysqli_error($connection) . ".
                                        </div>";
        }
        else {
            if ($result) {
                $row = mysqli_fetch_array($result);
                if ($row) {
                    $mediaPath = $row['media_url'];
                }
            }
        }
        
        
        // deleting record from database..
        
        $query = "delete from media where media_name='{$mediaName}'";
        $result = mysqli_query($connection, $query);
        if (mysqli_errno($connection)) {
            $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> " . mysqli_error($connection) . ".
                                        </div>";
        }
        else
        {
            if(unlink($mediaPath)and unlink("../".$mediaPath))
            {
                $msg = "<div class='alert alert-success alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Success:</strong> Well done! You successfully removed  File.</div>";
            }
            else
            {
                $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> Unable to remove selected file..
                                        </div>";
            }
            
            
        }
        
    }
    header("location:media.php?msg={$msg}");
}
?>