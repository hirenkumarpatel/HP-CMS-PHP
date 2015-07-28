<?php
if (isset($_GET['page'])) {

    $page['page_name'] = mysqli_real_escape_string($connection, $_GET['page']);
} else {
    $page['page_name'] = 'home';
}


?>
<nav>
    <div class="width">
        <ul>
            
            
                <?php
                if ($connection) {
                    $query = "select m.*,b.blog_name from menus m,blogs b where m.menu_blog_name=b.blog_name and b.blog_name='{$environment['blog_name']}'";
                    $result = mysqli_query($connection, $query);
                    if ($result) {
                        while ($row = mysqli_fetch_array($result)) {
                            
                           if($page['page_name']==$row['menu_name'])
                           {
                               $select="class='selected'";
                           }
                           else
                           {
                               $select="";
                           }
                            
                            echo "<li  {$select}><a href='{$row['menu_url']}'>{$row['menu_title']}</a></li>";
                        }
                    }
                }
                ?>

        </ul>
    </div>
</nav>
