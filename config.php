<?php
$dbhost= 'localhost';
$dbuser= 'root';
$dbpass='iti';
$dbname='iti_blog';
// open connection
$mysqli = new mysqli($dbhost, $dbuser,$dbpass);
$mysqli->select_db($dbname);
 ?>
