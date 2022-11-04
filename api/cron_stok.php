<?php include "../config/koneksi.php";

function get_data_stock_all($a, $b){
			
	$postData = array(
		"org_id" => $a,
		"sdate" => $b,
	
    );				    
	// $fields_string = http_build_query($postData);
	$curl = curl_init();

	curl_setopt_array($curl, array(
	CURLOPT_URL => 'http://m.pi.idolmartidolaku.com/api/action.php?modul=inventory&act=sync_pos_cron',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => 'POST',
	CURLOPT_POSTFIELDS => $postData,
	));
	
	$response = curl_exec($curl);
	
	curl_close($curl);
	return $response;
					
					
}

		$cmd = ['CREATE TABLE poserp.m_pi_stock (tanggal TIMESTAMP,
    status_sync_stok character varying(2));'];
	
	
	$result = $connec->query("SELECT 1 FROM information_schema.tables WHERE table_schema = 'poserp' AND table_name = 'm_pi_stock'" );
	if($result->rowCount() == 1) {
		
	}
	else {
	
		
		foreach ($cmd as $r){
	
				$connec->exec($r);
		}
	
	
	}
		
		$jum = 0;
		$cekdate = "select count(*) jum from m_pi_stock where date(tanggal) = date(now())";
		$cds = $connec->query($cekdate);
		foreach ($cds as $rr) {
			$jum = $rr["jum"];	
		}
		
		
		
		
		
		// $sku = "8151000000129";
		
		$sqll = "select storeid as ad_morg_key from m_profile";
		$results = $connec->query($sqll);
		foreach ($results as $r) {
			$org_key = $r["ad_morg_key"];	
		}
		
		if($jum > 0){
			
				$data = array("result"=>1, "msg"=>"Sudah sync");

		}else{
			
			
			
			$date = '0'; //belum ada
			$hasil = get_data_stock_all($org_key, $date);
			$j_hasil = json_decode($hasil, true);
			$jum11 = count($j_hasil);
			
			// var_dump($hasil);
			
			
			if($jum11 > 0){
				
				$sqll = "insert into m_pi_stock (tanggal, status_sync_stok) VALUES ('".date('Y-m-d H:i:s')."', '1')";
				$results = $connec->query($sqll);
			}
			
			
			
			
		$no = 0;	
		foreach($j_hasil as $r) {
			
			
			$stock_sales = 0;
			$stoc_lok = 0;
			$ceksales = $connec->query("select sku, sum(qty) as jj from pos_dsalesline where sku = '".$r['sku']."' and date(insertdate) = date(now()) group by sku");
			foreach ($ceksales as $rs) {
				
					$stock_sales = $rs['jj'];
				}
			
			$cekitems = $connec->query("select count(m_product_id) as jum, stockqty from pos_mproduct where m_product_id = '".$r['m_product_id']."' group by m_product_id, stockqty");
			foreach ($cekitems as $ra) {
				
					$haha = $ra['jum'];
					$stoc_lok = $ra['stockqty'];
				}
			
			$totqty = $r['stockqty'] - $stock_sales;
			// $totqty = $r['stockqty'];
				
				
			// if($totqty != $stoc_lok){
			if($haha > 0){
				
				$sqlll = "update pos_mproduct set stockqty='".$totqty."', description = '".$r['stockqty']."' where m_product_id='".$r['m_product_id']."'";
				
				$upcount = $connec->query($sqlll);
				
			}else{
				
				$sqlll = "insert into pos_mproduct (
ad_mclient_key,
ad_morg_key,
isactived,
insertdate,
insertby,
postby,
postdate,
m_product_id,
m_product_category_id,
c_uom_id,
sku,
name,
price,
stockqty,
m_locator_id,
locator_name,
description) VALUES (
				'".$r['ad_client_id']."',
				'".$r['ad_mor_key']."',
				'".$r['isactive']."',
				'".$r['insertdate']."',
				'".$r['insertby']."',
				'".$r['postby']."',
				'".$r['postdate']."',
				'".$r['m_product_id']."',
				'".$r['m_product_category_id']."',
				'".$r['c_uom_id']."',
				'".$r['sku']."',
				'".substr($r['namaitem'], 0, 49)."',
				'".$r['price']."',
				'".$r['stockqty']."',
				'".$r['m_locator_id']."',
				'".$r['locator_name']."',
				'".$r['stockqty']."'
)";
				$upcount = $connec->query($sqlll);
				
				// echo $sql;
				
			}
			
			
			
			
			
			
			
			if($upcount){
				$no = $no + 1;
				
			}
				
				
			// echo $sqlll;	
				
				
			// }	

		}
			
			
			
			$data = array("result"=>1, "msg"=>"Berhasil sync ".$no." data");
			
		}
		
		$json_string = json_encode($data);	
		echo $json_string;
		// echo $sql;
		
	