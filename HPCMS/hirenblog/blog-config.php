<?php
session_start();

$environment=array();

$environment['blog_name']="";
$environment['blog_title']="";
$environment['blog_subtitle']="";
$environment['theme_path']="";
$environment['blog_header_image']="";
$environment['blog_user']="";

//including database file and connection

include_once  'db/DBConfig.php';


//checking for connection

$connection=  dbConnect();

// geting parent blog details

$root_path= __DIR__;

// separating path into different folders
$parent_directory= explode(DIRECTORY_SEPARATOR, $root_path);

//getting current blog name from root directory
$environment['blog_name']=$parent_directory[count($parent_directory)-1];



if($environment['blog_name']!="")
{
    if($connection)
    {
        $query="select * from blogs b,themes t,users u where b.blog_name='{$environment['blog_name']}' and b.blog_theme_name=t.theme_name and b.blog_user_name=u.user_name";
        $result=  mysqli_query($connection, $query);
        if($result)
        {
            $row=  mysqli_fetch_array($result);
            
            if($row>0)
            {
                $environment['blog_title']=$row['blog_title'];
                $environment['blog_subtitle']=$row['blog_subtitle'];
                $environment['theme_path']="../".$row['theme_path'];
                $environment['blog_header_image']=$row['blog_image'];
                $environment['blog_user']=$row['user_name'];
            }
           

        }
    }
}



?>