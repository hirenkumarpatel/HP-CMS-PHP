
<?php
include '../blog-config.php';
$msg = "";
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}

$mediaName = "";
    $mediaPath = "";



    if ($_FILES["fileUploader"]["name"] == "") {

        $mediaName = "";
    } else {

        $mediaName = rand() . "-" . $_FILES["fileUploader"]["name"];
        $mediaPath = "media/" . $mediaName;
    }


    $fileExtention = pathinfo($mediaName, PATHINFO_EXTENSION);



    $allowedExtentions = array("jpg", "png", "gif");

    if (!in_array($fileExtention, $allowedExtentions)) {

        $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> Invalid file Format..(jpg,png,gif)
                                        </div>";
    } else if ($_FILES["fileUploader"]["size"] > (2 * 1024 * 1024)) {
        $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> File is too big to upload please upload image not more than 2 mib..
                                        </div>";
    } else {


        if ($connection) {
            $query = "insert into media (media_name,media_url)values('{$mediaName}','{$mediaPath}');";

            $result = mysqli_query($connection, $query);


            if (mysqli_errno($connection)) {

                $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> " . mysqli_error($connection) . ".
                                        </div>";
            } else {
                if ($result) {
                    if (mysqli_affected_rows($connection) > 0) {
                        if(!move_uploaded_file($_FILES["fileUploader"]["tmp_name"], $mediaPath))
                        {
                            $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> Failed to move uploaded file: Check permissions
                                        </div>";
                        } else {
                            copy($mediaPath, "../".$mediaPath);
    
                            $msg = "<div class='alert alert-success alert-dismissible fade in'>
                                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                                <strong>Success:</strong> Well done! You successfully Uploaded new File.</div>";
                        }
                    } else {
                        $msg = "<div class='alert alert-error alert-dismissible fade in'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                            <strong>Error:</strong> No file uploaded..
                                        </div>";
                    }header("location:media.php?msg={$msg}");
                    header("location:media.php?msg={$msg}");
                   
                }
            }
        }
    }
?>