<?php

$html = $_POST['html'];
// $html = "Test Print";
// $myfile = fopen("print_cashin.txt", "w") or die("Unable to open file!");
// $txt = $html;
// fwrite($myfile, $txt);
// fclose($myfile);
// $cmd='print_cash.bat'; //windows
// $child = shell_exec($cmd);
// $data = array("result"=>1, "msg"=>$child);
// $json_string = json_encode($data);	
// echo $json_string;

// $tmpdir = sys_get_temp_dir();   # ambil direktori temporary untuk simpan file.
// $file =  tempnam($tmpdir, 'ctk');  # nama file temporary yang akan dicetak
// $handle = fopen($file, 'w');

// fwrite($handle, $html);
// fclose($handle);
// copy($file, "//localhost/pi");  # Lakukan cetak
// unlink($file);



$tmpdir = sys_get_temp_dir();   # ambil direktori temporary untuk simpan file.
$file =  tempnam($tmpdir, 'ctk');  # nama file temporary yang akan dicetak
$handle = fopen($file, 'w');

fwrite($handle, $html);
fclose($handle);
copy($file, "//localhost/pi test");  # Lakukan cetak
unlink($file);
