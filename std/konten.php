<?php
error_reporting(0);
session_start();
date_default_timezone_set('Asia/Jakarta');
include "../config/class_database.php";
include "../config/serverconfig.php";
include "../config/debug.php";
include "../fungsi/timezone.php";
include "../fungsi/fungsi_combobox.php";
include "../fungsi/fungsi_date.php";
include "../fungsi/fungsi_rupiah.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])){
	echo "<meta http-equiv='refresh' content='0; url=../index.php?code=1'>";
}

else{
	if ($_GET['mod'] == 'krs'){
		include "modul/mod_krs/krs.php";
	}
	
	elseif ($_GET['mod'] == 'ubah_password'){
		include "modul/mod_user/password.php";
	}
	
	elseif ($_GET['mod'] == 'makul_prasyarat'){
		include "modul/mod_makul/prasyarat.php";
	}
	
	elseif ($_GET['mod'] == 'nilai'){
		include "modul/mod_nilai/data_nilai.php";
	}
	
	elseif ($_GET['mod'] == 'kartu_krs'){
		include "modul/mod_krs/kartu_krs.php";
	} 
	
	elseif ($_GET['mod'] == 'bahan_kuliah'){
		include "modul/mod_kuliah/bahan_kuliah.php";
	}
	
	elseif ($_GET['mod'] == 'transkip_nilai'){
		include "modul/mod_nilai/transkip_nilai.php";
	}
	
	elseif ($_GET['mod'] == 'khs'){
		include "modul/mod_nilai/khs.php";
	}
	
	elseif ($_GET['mod'] == 'registrasi'){
		include "modul/mod_registrasi/registrasi.php";
	} 
	
	else{
		if ($_GET['code'] == 1){
			echo "
				<div class='message success'>
					<h5>Success!</h5>
					<p>Anda berhasil Login.</p>
				</div>";
		}
		echo "<p><br><b>$_SESSION[nama_mahasiswa]</b>, Selamat datang di Sistem Informasi Kemahasiswaan, Anda dapat melakukan transaksi melalui menu di sisi kiri.<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
		Informasi Login:
		Tanggal : $_SESSION[last_login] <br>
		IP : $_SESSION[ip] 
		</p>";
	}
}
?>