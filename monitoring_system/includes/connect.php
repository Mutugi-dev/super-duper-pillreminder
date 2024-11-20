<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$con=mysqli_connect('localhost','root','','monitoring_system_db');
if(!$con){
    echo "connection succesful";
}else{
    die(mysqli_error($con));
}

?>