<?php
include "../config/koneksi.php";
$cek_ver = "FLUSH HOSTS";
$aksi = $connec->query($cek_ver);
if($aksi){
	echo "berhasil";
	
}else{
	
	echo "gagal";
}
// execPrint('php update.php');