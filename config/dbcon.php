<?php
$conn = mysqli_connect("localhost","root","","inventory_system");
if(!$conn){
    die("Connection Failed" . mysqli_connect_error());
}