<?php

mysqli_report(MYSQLI_REPORT_ERROR );


define('DB_SERVER', 'classmysql.engr.oregonstate.edu');
define('DB_USERNAME', 'cs340_lyant');
define('DB_PASSWORD', '0050');
define('DB_NAME', 'cs340_lyant');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>