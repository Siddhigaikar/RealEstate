<?php
$servername="localhost";
$username="root";
$password="";
$db_name="real_estate";
$conn=new mysqli($servername,$username,$password,$db_name);
if(!$conn){
    echo "Database not connected";
}


?>