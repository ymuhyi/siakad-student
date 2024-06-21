<?php
error_reporting(0);
session_start();
include "../../../config/class_database.php";
include "../../../config/serverconfig.php";
include "../../../config/debug.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])){
	header("Location: ../../../index.php?code=2");
}

else{
	if ($_GET['mod'] == 'ubah_password'){
		$created_date = date('Y-m-d H:i:s');
		$pass_lama = md5($_POST['pass_lama']);
		$pass_baru = md5($_POST['pass_baru']);
		$pass_baru2= md5($_POST['pass_baru2']);
		
		$sql_user = $db->database_prepare("SELECT password FROM as_mahasiswa WHERE id_mhs = ?")->execute($_SESSION["userid"]);
		
		$data_user = $db->database_fetch_array($sql_user);
		
		if ($pass_lama != $data_user['password']){
			header("Location: ../../index.php?mod=ubah_password&code=1");
		}
		else{
			if ($pass_baru != $pass_baru2){
				header("Location: ../../index.php?mod=ubah_password&code=2");
			}
			else{
				$db->database_prepare("UPDATE as_mahasiswa SET password = ? WHERE id_mhs = ?")->execute($pass_baru,$_SESSION["userid"]);
				
				header("Location: ../../index.php?mod=ubah_password&code=3");
			}
		}
	}
}
?>