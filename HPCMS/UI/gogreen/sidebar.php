<h3>Posts</h3>
<ul>
<?php
if($connection)
{
    $query="select * from categories where category_blog_name='{$environment['blog_name']}'";
    $result=  mysqli_query($connection, $query);
    $category="";
    if($result)
    {
        while ($row = mysqli_fetch_array($result)) {
            echo "<li><a href='index.php?category={$row['category_id']}'>{$row['category_title']}</a></li>";
        } 
    }
}
?>




</ul>