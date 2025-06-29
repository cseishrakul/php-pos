<?php
define('DB_SERVER','localhost');
define('DB_USERNAME','root');
define('DB_PASSEWORD','');
define('DB_DATABASE','pos-class');

$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSEWORD,DB_DATABASE);

if(!$conn){
    die('Connection Failed'.mysqli_connect_error());
}
?>