<?php
include_once '../../configuration/db/DBConfig.php';
$connection=  dbConnect();
if (isset($connection)) {
    if (isset($_GET['post'])) {
        $postId = mysqli_real_escape_string($connection, $_GET['post']);
        $query = "select * from posts where post_id='{$postId}'";
        
        $result=  mysqli_query($connection, $query);
        ;
        if ($result) {
            $row = mysqli_fetch_array($result);
            $postTitle = $row['post_title'];
            $postContent = $row['post_content'];
            echo "<h3>$postTitle</h3>";
           
            echo "<p>$postContent</p>";
        }
    }
}
?>

