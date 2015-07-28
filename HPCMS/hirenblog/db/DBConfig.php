<?php

define("HOST", "127.0.0.1");
define("USER", "root");
define("PASSWORD", "");
define("DATABASE", "hpcms");

function dbConnect() {

    $connect = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    if (mysqli_connect_errno($connect)) {

        return "Error in Database connection:" . mysqli_connect_error();
    } else {
        return $connect;
    }
}


?>