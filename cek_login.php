<?php
error_reporting(0);
include "config/class_database.php";
include "config/serverconfig.php";
include "config/debug.php";

$username = $_POST['username'];
$password = md5($_POST['password']);

$sql = $db->database_prepare("SELECT * FROM as_mahasiswa WHERE NIM = ? AND password = ? AND status_mahasiswa = 'A'")->execute($username,$password);

$nums = $db->database_num_rows($sql);

$data = $db->database_fetch_array($sql);

if ($nums > 0){
	session_start();
	$last_login = date('Y-m-d H:i:s');
	
	$_SESSION['username'] = $data['NIM'];
	$_SESSION['password'] = $data['password'];
	$_SESSION['userid'] = $data['id_mhs'];
	$_SESSION['nama_mahasiswa'] = $data['nama_mahasiswa'];
	$_SESSION['kode_program_studi'] = $data['kode_program_studi'];
	$_SESSION['last_login'] = date('Y-m-d H:i:s');
	$_SESSION['ip'] = $_SERVER["REMOTE_ADDR"];
	$db->database_prepare("UPDATE as_mahasiswa SET last_login = ?, ip = ? WHERE id_mhs = ?")->execute($last_login,$_SERVER["REMOTE_ADDR"],$data["id_mhs"]);
	
	header("Location: std/index.php?code=1");
}
else{
	header("Location: index.php?code=1");
}
?>