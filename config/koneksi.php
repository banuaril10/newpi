<?php
date_default_timezone_set('Asia/Jakarta');
error_reporting(0);

try {
	$dbuser = 'adminpos';
    $dbpass = 'pwdposadmin';
    $dbhost = 'localhost';
    // $dbhost = '10.0.44.2';
    $dbname='poserp';
    $dbport='3306';


    $connec = new PDO("mysql:host=$dbhost;dbname=$dbname;port=$dbport", $dbuser, $dbpass);
  
} catch (PDOException $e) {

}

?>