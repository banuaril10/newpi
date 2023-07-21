<?php
include "../config/koneksi.php";
$cek_ver = "delete from pos_close where tanggal = date(now())";
$aksi = $connec->query($cek_ver);
if($aksi){
	echo "berhasil";
	
}else{
	
	echo "gagal";
}
// execPrint('php update.php');