<?php

$html = $_POST['html'];


require __DIR__ . '/escpos-php/vendor/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

/**
 * Install the printer using USB printing support, and the "Generic / Text Only" driver,
 * then share it (you can use a firewall so that it can only be seen locally).
 *
 * Use a WindowsPrintConnector with the share name to print.
 *
 * Troubleshooting: Fire up a command prompt, and ensure that (if your printer is shared as
 * "Receipt Printer), the following commands work:
 *
 *  echo "Hello World" > testfile
 *  copy testfile "\\%COMPUTERNAME%\Receipt Printer"
 *  del testfile
 */
try {
    // Enter the share name for your USB printer here
    // $connector = null;
    // $connector = new WindowsPrintConnector("serial");
	$connector = new WindowsPrintConnector("pi");
	 //$connector = new WindowsPrintConnector("Receipt Printer");
	

    /* Print a "Hello world" receipt" */
    $printer = new Printer($connector);
    // $printer -> text("Test Print");
    // $printer -> text("Test Print");
    // $printer -> text("Test Print");
    // $printer -> text("Test Print");
    // $printer -> text("Test Print");
	$printer -> text($html);
    $printer -> cut();
    
    /* Close printer */
    $printer -> close();
	
	
	 echo "Proses Print\n";
} catch (Exception $e) {
    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}