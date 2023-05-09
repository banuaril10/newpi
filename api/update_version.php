<?php
function execPrint($command) {
    $result = array();
    exec($command, $result);
    print("<pre>");
    foreach ($result as $line) {
        print($line . "\n");
    }
    print("</pre>");
}
// Print the exec output inside of a pre element
execPrint('D: && cd /xampp/htdocs/pi_mysql && git config --global --add safe.directory /xampp/htdocs/pi_mysql && git config --global user.email "banuaril100@gmail.com" && git stash && git pull && php update.php');