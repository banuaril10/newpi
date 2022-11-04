<?php
date_default_timezone_set('Asia/Jakarta');
error_reporting(0);

// $options = array(
    // PDO::ATTR_ERRMODE    => PDO::ERRMODE_SILENT
// );
try {
    // $dbuser = 'postgres';
    // $dbpass = 'idm$$&!@#141';
    // $dbhost = '114.141.55.178';
    // $dbname='postgres';
    // $dbport='5432';
    // $dbport='5434';

	$dbuser = 'root';
    $dbpass = '';
    $dbhost = 'localhost';
    $dbname='poserp';
    $dbport='3306';


    $connec = new PDO("mysql:host=$dbhost;dbname=$dbname;port=$dbport", $dbuser, $dbpass);
  
} catch (PDOException $e) {
    // echo "Error : " . $e->getMessage() . "<br/>";
    // die();

}

?>