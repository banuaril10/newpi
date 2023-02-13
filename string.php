<?php
function clean($string) {
   return preg_replace('/[^A-Za-z0-9 ]/','',$string); // Removes special chars.
}


echo clean("F/ Kayu Pinus�Bunga�20x30");