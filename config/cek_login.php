<?php session_start();
include "koneksi.php";
$username = $_POST['user'];
$pwd = hash_hmac("sha256", $_POST['pwd'], 'marinuak');

$sql = "select userid, username, ad_org_id, name from m_pi_users where userid ='".$username."' 
and userpwd ='".$pwd."' and isactived = '1' group by userid,username,ad_org_id, name  limit 1";

$result = $connec->query($sql);

$rows = $result->rowCount();

$number_of_rows = $result->fetchColumn(); 
if($rows > 0){


$cmd_cash = ['CREATE TABLE cash_in (
    cashinid character varying(40) NOT NULL PRIMARY KEY,
    org_key character varying(45),
    userid character varying(45),
    nama_insert character varying(50),
    cash numeric DEFAULT 0 NOT NULL,
	insertdate datetime,
    status character varying(10),
	approvedby character varying(50),
	syncnewpos numeric DEFAULT 0 NOT NULL,
	setoran numeric DEFAULT 0 NOT NULL
);'];

$cmd_alter_cash = ['ALTER TABLE cash_in ADD COLUMN IF NOT EXISTS syncnewpos numeric DEFAULT 0 NOT NULL;','ALTER TABLE cash_in ADD COLUMN IF NOT EXISTS setoran numeric DEFAULT 0 NOT NULL;'];


$cmd = ['CREATE TABLE m_pi (
    m_pi_key character varying(40) NOT NULL PRIMARY KEY,
    ad_client_id character varying(45),
    ad_org_id character varying(45),
    isactived character varying(2),
    insertdate datetime,
    insertby character varying(50),
    m_locator_id character varying(45),
    inventorytype character varying(30),
    name character varying(50),
    description character varying(255),
    movementdate datetime,
    approvedby character varying(50),
    status character varying(20),
    issync boolean DEFAULT false,
    rack_name character varying(45),
    postby character varying(150),
    postdate datetime ,
    category numeric DEFAULT 1 NOT NULL,
	insertfrommobile character varying(15),
	insertfromweb character varying(15)
);','CREATE INDEX IF NOT EXISTS m_pi_m_pi_key_idx ON m_pi  (m_pi_key);','CREATE INDEX IF NOT EXISTS m_pi_name_idx ON m_pi  (name);'];

$cmd_alter = ['ALTER TABLE m_pi ADD COLUMN IF NOT EXISTS insertfrommobile varchar(15);','ALTER TABLE m_pi ADD COLUMN IF NOT EXISTS insertfromweb varchar(15);'];


$cmd2 = ['CREATE TABLE m_piline (
    m_piline_key character varying(40) NOT NULL PRIMARY KEY,
    m_pi_key character varying(40),
    ad_client_id character varying(45),
    ad_org_id character varying(45),
    isactived character varying(2),
    insertdate datetime ,
    insertby character varying(50),
    postby character varying(50),
    postdate datetime ,
    m_storage_id character varying(45),
    m_product_id character varying(45),
    sku character varying(50),
    qtyerp numeric,
    qtycount numeric DEFAULT 0,
    issync integer DEFAULT 0,
    status numeric DEFAULT 0,
    verifiedcount numeric DEFAULT 0,
    qtysales numeric DEFAULT 0,
    price numeric DEFAULT 0,
    status1 numeric DEFAULT 0,
    qtysalesout numeric DEFAULT 0,
	barcode varchar(30)
);','CREATE INDEX IF NOT EXISTS m_piline_insertdate_idx ON m_piline  (insertdate);',
'CREATE INDEX IF NOT EXISTS m_piline_m_pi_key_idx ON m_piline  (m_pi_key);',
'CREATE INDEX IF NOT EXISTS m_piline_sku_idx ON m_piline (sku);'
];


$cmd2_alter_piline = ['ALTER TABLE m_piline ADD COLUMN IF NOT EXISTS barcode varchar(30);'];

$cmd3 = ['CREATE TABLE m_pi_sales (
    tanggal datetime ,
    status_sales numeric DEFAULT 0
);'
];

$inv_temp = ['CREATE TABLE inv_temp (
	sku varchar(25),
	qty numeric DEFAULT 0,
	filename varchar(100),
	tanggal datetime,
	status numeric
);'
];

$inv_mproduct = ['CREATE TABLE inv_mproduct (
    inv_mproduct_key int NOT NULL primary key AUTO_INCREMENT,
    isactived character varying(2),
    insertdate datetime,
    insertby character varying(50),
    postby character varying(50),
    postdate datetime,
    ad_mclient_key character varying(45),
    ad_morg_key character varying(45),
    m_product_id character varying(45),
    m_product_category_id character varying(45),
    sku character varying(50),
    name character varying(255),
    description character varying(255),
    rack_name character varying(50),
    locator_name character varying(50),
    qty numeric,
    qtyerp numeric,
    m_locator_id character varying(32)
);','CREATE INDEX IF NOT EXISTS inv_idx ON inv_mproduct (sku);','CREATE INDEX IF NOT EXISTS inv_rackname ON inv_mproduct  (rack_name);'];

$inv_mproductcat = ['CREATE TABLE inv_mproductcategory (
    inv_mproductcategory_key int NOT NULL primary key AUTO_INCREMENT,
    ad_mclient_key character varying(45),
    ad_morg_key character varying(45),
    isactived character(1),
    insertdate datetime,
    insertby character varying(50),
    postby character varying(50),
    postdate datetime,
    m_product_category_id character varying(45),
    value character varying(50),
    name character varying(50),
    description character varying(255),
    parent_id character varying(45),
    issummary character varying(10)
);'];


$index = ['CREATE INDEX IF NOT EXISTS pos_mproduct_sku ON pos_mproduct (sku);','CREATE INDEX IF NOT EXISTS pos_mproduct_barcode ON pos_mproduct (barcode);','CREATE INDEX IF NOT EXISTS pos_mproduct_sc ON pos_mproduct (shortcut);',
'CREATE INDEX IF NOT EXISTS m_piline_barcode_idx ON m_piline (barcode);'];

foreach ($index as $r){

			$connec->exec($r);
	}

$cmd_stock = ['CREATE TABLE m_pi_stock (tanggal TIMESTAMP,
    status_sync_stok character varying(2));'];
	
	
	$result = $connec->query("SELECT 1 FROM information_schema.tables WHERE  table_name = 'm_pi_stock'" );
	if($result->rowCount() == 1) {
		
	}
	else {
	
		
		foreach ($cmd_stock as $r){
	
				$connec->exec($r);
		}
	
	
	}

//alter table 
$result_ci = $connec->query("SELECT 1 FROM information_schema.tables WHERE  table_name = 'cash_in'" );
if($result_ci->rowCount() == 1) {
	foreach ($cmd_alter_cash as $r){

			$connec->exec($r);
	}
	
}
else {

	
	foreach ($cmd_cash as $r){

			$connec->exec($r);
	}


}



$result = $connec->query("SELECT 1 FROM information_schema.tables WHERE  table_name = 'm_pi'" );
if($result->rowCount() == 1) {
	
	foreach ($cmd_alter as $r){

			$connec->exec($r);
	}
	
	
}
else {

	
	foreach ($cmd as $r){

			$connec->exec($r);
	}


}




$result1 = $connec->query("SELECT 1 FROM information_schema.tables WHERE  table_name = 'm_piline'" );
if($result1->rowCount() == 1) {
	foreach ($cmd2_alter_piline as $r1){

			$connec->exec($r1);
	}
}
else {

	foreach ($cmd2 as $r1){

			$connec->exec($r1);
	}


}

$result2 = $connec->query("SELECT 1 FROM information_schema.tables WHERE  table_name = 'm_pi_sales'" );
if($result2->rowCount() == 1) {
	
}
else {

	foreach ($cmd3 as $r2){

			$connec->exec($r2);
	}


}

$result_inv = $connec->query("SELECT 1 FROM information_schema.tables WHERE  table_name = 'inv_temp'" );
if($result_inv->rowCount() == 1) {
	
}
else {

	foreach ($inv_temp as $rr){

			$connec->exec($rr);
	}


}

$result_invm = $connec->query("SELECT 1 FROM information_schema.tables WHERE  table_name = 'inv_mproduct'" );
if($result_invm->rowCount() == 1) {
	
}
else {

	foreach ($inv_mproduct as $rr){

			$connec->exec($rr);
	}


}

$result_invmcat = $connec->query("SELECT 1 FROM information_schema.tables WHERE  table_name = 'inv_mproductcategory'" );
if($result_invmcat->rowCount() == 1) {
	
}
else {

	foreach ($inv_mproductcat as $rr){

			$connec->exec($rr);
	}


}



	foreach ($connec->query($sql) as $row) {
			$_SESSION['userid'] = $row["userid"];
			$_SESSION['username'] = $row["username"];
			$_SESSION['org_key'] = $row["ad_org_id"];
			$_SESSION['name'] = $row["name"];
			
			if($row["name"] == 'Audit'){
				
				$_SESSION['role'] = "Global";
			}else{
				$_SESSION['role'] = "Daily";
			}
			
			
			$sqll = "select storecode as value from m_profile";

			$results = $connec->query($sqll);
			
			
			foreach ($results as $r) {
				$_SESSION['kode_toko'] = $r["value"];
				
			}

			
			// echo $row["userid"];
		
			// setcookie("userid",$row["userid"],time() + (10 * 365 * 24 * 60 * 60));
			// setcookie("username",$row["username"],time() + (10 * 365 * 24 * 60 * 60));
			// setcookie("org_key",$row["ad_morg_key"],time() + (10 * 365 * 24 * 60 * 60));
			
			if($row["ad_org_id"] == '112233445566'){
				
				header("Location: ../cek_harga.php?".$_SESSION["username"]);
			}else if($row["name"] == 'Cashier'){
				header("Location: ../cashier.php?".$_SESSION["username"]);
				
			}else{
				
				header("Location: ../content.php?".$_SESSION["username"]);
			}
			
			
	}
	
}else{
	
	
			// echo $sql; 
			// echo $rows; 
			header("Location: ../index.php?pesan=Username/pass salah");
		}


	

?>