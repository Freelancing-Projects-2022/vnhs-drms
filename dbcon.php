<?php
$conn = mysqli_connect("localhost","root","","vnhs_drms");

if(!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}

?>