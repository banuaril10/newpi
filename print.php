<?php

$html = $_POST['html'];
$myfile = fopen("print_cashin.txt", "w") or die("Unable to open file!");
$txt = $html;
fwrite($myfile, $txt);
fclose($myfile);
$cmd='print_cash.bat'; //windows
$child = shell_exec($cmd);
$data = array("result"=>1, "msg"=>$child);
$json_string = json_encode($data);	
echo $json_string;