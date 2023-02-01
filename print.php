<?php


$condensed = Chr(27) . Chr(33) . Chr(4);
$bold1 = Chr(27) . Chr(69);
$bold0 = Chr(27) . Chr(70);
$initialized = chr(27).chr(64);
$condensed1 = chr(15);
$condensed0 = chr(18);
$corte = Chr(27) . Chr(109);
$Data  = $initialized;
$Data .= $condensed1;
$Data .= "==========================\n";
$Data .= "|     ".$bold1."TEST TEST TEST".$bold0."      |\n";
$Data .= "==========================\n";
$Data .= "TESSTT\n";
$Data .= "--------------------------\n";
$Data .= $corte;


// $html = $_POST['html'];

$myfile = fopen("print_cashin.txt", "w") or die("Unable to open file!");
$txt = $Data;



fwrite($myfile, $txt);
fclose($myfile);





$cmd='print_cash.bat'; //windows



	
	
	
    $child = shell_exec($cmd); 
	
	
	
	$data = array("result"=>1, "msg"=>$child);
		
		$json_string = json_encode($data);	
		echo $json_string;