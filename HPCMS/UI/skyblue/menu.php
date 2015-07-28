<div class="menu">
<ul>
  <?php
if($connection)
{
    $query = "select m.*,b.blog_name from menus m,blogs b where m.menu_blog_name=b.blog_name and b.blog_name='{$environment['blog_name']}'";
    $result=  mysqli_query($connection, $query);
    if($result)
    {
        while ($row = mysqli_fetch_array($result)) {
            echo "<li><a href='{$row['menu_url']}'>{$row['menu_title']}</a></li>";
        }
    }
}
?>
</ul>
</div>