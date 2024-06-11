<?php

mysqli_report(MYSQLI_REPORT_ERROR );

// defining our variables for using our database
define('DB_SERVER', 'classmysql.engr.oregonstate.edu');
define('DB_USERNAME', 'cs340_lyant');
define('DB_PASSWORD', '0050');
define('DB_NAME', 'cs340_lyant');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME); // getting the link

if($link === false){ // checking that the link is active
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>