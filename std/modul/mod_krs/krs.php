<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>KRS baru berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>KRS berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>KRS berhasil dihapus.</p>
	</div>
<?php
}
?>
<?php
switch($_GET['act']){
	default:
	$sql_mhs = $db->database_prepare("SELECT * FROM as_mahasiswa INNER JOIN mspst ON mspst.IDPSTMSPST=as_mahasiswa.kode_program_studi 
									INNER JOIN as_kelas_mahasiswa ON as_kelas_mahasiswa.id_mhs=as_mahasiswa.id_mhs
									INNER JOIN as_kelas ON as_kelas.kelas_id=as_kelas_mahasiswa.kelas_id
									WHERE NIM = ? AND status_mahasiswa = 'A' ORDER BY kelas_mhs_id DESC LIMIT 1")->execute($_SESSION['username']);
	$nums = $db->database_num_rows($sql_mhs);
	
	$data_mhs = $db->database_fetch_array($sql_mhs);
	if ($data_mhs['KDJENMSPST'] == 'A'){
		$kd_jenjang_studi = "S3";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'B'){
		$kd_jenjang_studi = "S2";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'C'){
		$kd_jenjang_studi = "S1";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'D'){
		$kd_jenjang_studi = "D4";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'E'){
		$kd_jenjang_studi = "D3";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'F'){
		$kd_jenjang_studi = "D2";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'G'){
		$kd_jenjang_studi = "D1";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'H'){
		$kd_jenjang_studi = "Sp-1";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'I'){
		$kd_jenjang_studi = "Sp-2";
	}
	else{
		$kd_jenjang_studi = "Profesi";
	}
	echo "<form method='POST' action='modul/mod_krs/aksi_krs.php?mod=krs&act=input'>
		<h5>Kartu Rencana Studi (KRS)</h5>
		<div class='box round first fullpage'>
		<div class='block '>
			<table class='form'>
				<tr>
					<td width='100'>NIM</td>
					<td><b>$data_mhs[NIM] <input type='hidden' name='id_mhs' value='$data_mhs[id_mhs]'></b></td>
				</tr>
				<tr>
					<td>Nama</td>
					<td><b>$data_mhs[nama_mahasiswa]</b></td>
				</tr>
				<tr>
					<td>Program Studi</td>
					<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST]</b></td>
				</tr>
				<tr>
					<td>Kelas</td>
					<td><b>$data_mhs[nama_kelas] - $data_mhs[semester] <input type='hidden' name='kelas_id' value='$data_mhs[kelas_id]'>
					<input type='hidden' name='semester' value='$data_mhs[semester_kelas]'></b></td>
				</tr>
			</table>
		</div></div>";
	
	echo "<table class='data display datatable' id='example'>
			<thead>
				<tr>
					<th width='30'>No</th>
					<th width='70'>Kode MK</th>
					<th width='130'>Nama MK</th>
					<th width='70'>Program</th>
					<th width='40'>SKS</th>
					<th width='40'>SMS</th>
					<th width='50'>Kelas</th>
					<th width='130'>Dosen</th>
					<th width='45'>Hari</th>
					<th width='70'>Jam Mulai</th>
					<th width='80'>Jam Selesai</th>
					<th width='45'>Ambil</th>
				</tr>
			</thead><tbody>";
	$i = 1;	
	$sql_krs = $db->database_prepare("SELECT * FROM as_jadwal_kuliah INNER JOIN as_makul ON as_makul.mata_kuliah_id=as_jadwal_kuliah.makul_id 
										INNER JOIN as_kelas ON as_kelas.kelas_id=as_jadwal_kuliah.kelas_id
										INNER JOIN msdos ON msdos.IDDOSMSDOS=as_jadwal_kuliah.dosen_id WHERE as_jadwal_kuliah.kelas_id = ?")->execute($data_mhs['kelas_id']);
	while ($data_krs = $db->database_fetch_array($sql_krs)){
		$nums = $db->database_num_rows($db->database_prepare("SELECT * FROM as_krs WHERE id_mhs=? AND jadwal_id=?")->execute($data_mhs["id_mhs"],$data_krs["jadwal_id"]));
		if ($data_krs['program'] == 'A'){
			$program = "Reguler";
		}
		else{
			$program = "Non-Reguler";
		}
		
		if ($data_krs['hari'] == 1){
			$hari = "Senin";
		}
		elseif ($data_krs['hari'] == 2){
			$hari = "Selasa";
		}
		elseif ($data_krs['hari'] == 3){
			$hari = "Rabu";
		}
		elseif ($data_krs['hari'] == 4){
			$hari = "Kamis";
		}
		elseif ($data_krs['hari'] == 5){
			$hari = "Jumat";
		}
		elseif ($data_krs['hari'] == 6){
			$hari = "Sabtu";
		}
		else{
			$hari = "Minggu";
		}
		if ($nums == 0){
			echo "<tr>
					<td>$i</td>
					<td>$data_krs[kode_mata_kuliah]</td>
					<td>$data_krs[nama_mata_kuliah_eng]</td>
					<td>$program</td>
					<td>$data_krs[sks_mata_kuliah]</td>
					<td>$data_krs[semester]</td>
					<td>$data_krs[nama_kelas]</td>
					<td>$data_krs[NMDOSMSDOS] $data_krs[GELARMSDOS]</td>
					<td>$hari</td>
					<td>$data_krs[jam_mulai]</td>
					<td>$data_krs[jam_selesai]</td>
					<td><input type='checkbox' name='ambil[]' value='$data_krs[jadwal_id]'></td>
				</tr>";
			}
		$i++;
	}
	echo "</tbody></table><p>&nbsp;</p><p>&nbsp;</p>";
	if ($nums == 0){
		echo "<button type='submit' class='btn btn-primary'>Ambil</button>";
	}
	echo "</form>";
	break;
	
	case "krs_detail":
	$sql_mhs = $db->database_prepare("SELECT * FROM as_mahasiswa INNER JOIN mspst ON mspst.IDPSTMSPST=as_mahasiswa.kode_program_studi 
									INNER JOIN as_kelas_mahasiswa ON as_kelas_mahasiswa.id_mhs=as_mahasiswa.id_mhs
									INNER JOIN as_kelas ON as_kelas.kelas_id=as_kelas_mahasiswa.kelas_id
									WHERE as_mahasiswa.id_mhs = ? AND status_mahasiswa = 'A' ORDER BY kelas_mhs_id DESC LIMIT 1")->execute($_GET['id_mhs']);
	$nums = $db->database_num_rows($sql_mhs);
	$data_mhs = $db->database_fetch_array($sql_mhs);
	if ($data_mhs['KDJENMSPST'] == 'A'){
		$kd_jenjang_studi = "S3";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'B'){
		$kd_jenjang_studi = "S2";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'C'){
		$kd_jenjang_studi = "S1";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'D'){
		$kd_jenjang_studi = "D4";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'E'){
		$kd_jenjang_studi = "D3";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'F'){
		$kd_jenjang_studi = "D2";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'G'){
		$kd_jenjang_studi = "D1";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'H'){
		$kd_jenjang_studi = "Sp-1";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'I'){
		$kd_jenjang_studi = "Sp-2";
	}
	else{
		$kd_jenjang_studi = "Profesi";
	}
	echo "
		<h5>Kartu Rencana Studi (KRS)</h5>
		<div class='box round first fullpage'>
		<div class='block '>
			<table class='form'>
				<tr>
					<td width='100'>NIM</td>
					<td><b>$data_mhs[NIM] </b></td>
				</tr>
				<tr>
					<td>Nama</td>
					<td><b>$data_mhs[nama_mahasiswa]</b></td>
				</tr>
				<tr>
					<td>Program Studi</td>
					<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST]</b></td>
				</tr>
				<tr>
					<td>Kelas</td>
					<td><b>$data_mhs[nama_kelas] - $data_mhs[semester_kelas] </b></td>
				</tr>
			</table>
		</div></div>";
	
	echo "<table class='data display datatable' id='example'>
			<thead>
				<tr>
					<th>No</th>
					<th>Kode MK</th>
					<th>Nama MK</th>
					<th>SKS</th>
					<th>SMS</th>
					<th>Kelas</th>
					<th>Dosen</th>
					<th>Hari</th>
					<th>Jam Mulai</th>
					<th>Jam Selesai</th>
					<th>Hapus</th>
				</tr>
			</thead><tbody>";
	$i = 1;	
	$sql_krs = $db->database_prepare("SELECT * FROM as_krs A INNER JOIN as_jadwal_kuliah B ON A.jadwal_id=B.jadwal_id
										INNER JOIN as_makul C ON C.mata_kuliah_id=B.makul_id 
										INNER JOIN as_kelas D ON D.kelas_id=B.kelas_id
										INNER JOIN msdos E ON E.IDDOSMSDOS=B.dosen_id 
										WHERE B.kelas_id = ? AND A.id_mhs = ? AND B.semester = ?")->execute($_GET["kelas_id"],$_GET["id_mhs"],$_GET["semester"]);
	while ($data_krs = $db->database_fetch_array($sql_krs)){
		if ($data_krs['program'] == 'A'){
			$program = "Reguler";
		}
		else{
			$program = "Non-Reguler";
		}
		
		if ($data_krs['hari'] == 1){
			$hari = "Senin";
		}
		elseif ($data_krs['hari'] == 2){
			$hari = "Selasa";
		}
		elseif ($data_krs['hari'] == 3){
			$hari = "Rabu";
		}
		elseif ($data_krs['hari'] == 4){
			$hari = "Kamis";
		}
		elseif ($data_krs['hari'] == 5){
			$hari = "Jumat";
		}
		elseif ($data_krs['hari'] == 6){
			$hari = "Sabtu";
		}
		else{
			$hari = "Minggu";
		}
		echo "<tr>
				<td>$i</td>
				<td>$data_krs[kode_mata_kuliah]</td>
				<td>$data_krs[nama_mata_kuliah_eng]</td>
				<td>$data_krs[sks_mata_kuliah]</td>
				<td>$data_krs[semester]</td>
				<td>$data_krs[nama_kelas]</td>
				<td>$data_krs[NMDOSMSDOS] $data_krs[GELARMSDOS]</td>
				<td>$hari</td>
				<td>$data_krs[jam_mulai]</td>
				<td>$data_krs[jam_selesai]</td>
				<td align=center>"; ?>
					<a title="Hapus/Batalkan" href="modul/mod_krs/aksi_krs.php?mod=krs&act=delete&id=<?php echo $data_krs[krs_id];?>&id_mhs=<?php echo $_GET['id_mhs']; ?>&kelas_id=<?php echo $_GET['kelas_id']; ?>&semester=<?php echo $_GET['semester']; ?>" onclick="return confirm('Anda Yakin ingin menghapus KRS MTK <?php echo $data_krs[nama_mata_kuliah_eng];?>?');"><img src='http://siakad.sekolahumarusman.com/images/delete.jpg' width='20'></a>
				<?php	
				echo "</td>
			</tr>";
		$i++;
	}
	echo "</tbody></table><p>&nbsp;</p><p>&nbsp;</p>";
	$tot_krs = $db->database_fetch_array($db->database_prepare("SELECT SUM(C.sks_mata_kuliah) as jumlah FROM as_krs A INNER JOIN as_jadwal_kuliah B ON A.jadwal_id=B.jadwal_id
										INNER JOIN as_makul C ON C.mata_kuliah_id=B.makul_id 
										INNER JOIN as_kelas D ON D.kelas_id=B.kelas_id
										INNER JOIN msdos E ON E.IDDOSMSDOS=B.dosen_id 
										WHERE B.kelas_id = ? AND A.id_mhs = ? AND B.semester = ?")->execute($_GET["kelas_id"],$_GET["id_mhs"],$_GET["semester"]));
	echo "<table class='form'>
		<tr>
			<td width='200'>TOTAL KESELURUHAN SKS AMBIL</td>
			<td><b>$tot_krs[jumlah] SKS</b></td>
		</tr>
	</table>
	
		<a href='modul/mod_krs/invoice.php?mod=krs&act=print&id_mhs=$_GET[id_mhs]&kelas_id=$_GET[kelas_id]&semester=$_GET[semester]' target='_blank'><button type='button' class='btn btn-primary'><i class='icon-print'></i> Cetak KRS</button></a>
		<a href='index.php?mod=krs'><button type='button' class='btn btn-primary'>Selesai/Keluar</button></a>";
	break;
}
?>