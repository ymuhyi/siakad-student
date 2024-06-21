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
<script type='text/javascript' src='http://siakad.sekolahumarusman.com/js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	$(document).ready(function() {
		$('#frm_form').validate({
			rules:{
				semester: true
			},
			messages:{
				semester:{
					required: "Masukkan semester terlebih dahulu."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<h5>Cetak KRS</h5>
	<div class="box round first fullpage">
		<div class="block ">
		<form action="" method="GET" id="frm_form">
		<table class="form">
		<input type="hidden" name="mod" value="kartu_krs">
		<input type="hidden" name="act" value="detail">
			<tr valign="top">
				<td width="200"><label>Semester KRS</label></td>
				<td><input type="text" name="semester" size="40" maxlength="1" class="required"></td>
			</tr>
			<tr valign="top">
				<td></td>
				<td><button type="submit" class="btn btn-primary">Buka Data</button></td>
			</tr>
		</table>
	</form>
	</div></div>
</div>
<?php

	break;
	
	case "detail":
	$sql_mhs = $db->database_prepare("SELECT 	A.id_mhs,
												A.NIM,
												A.nama_mahasiswa,
												B.KDJENMSPST,
												B.NMPSTMSPST,
												D.nama_kelas,
												D.semester_kelas,
												F.semester as krs_semester
												
									FROM as_mahasiswa A INNER JOIN mspst B ON B.IDPSTMSPST=A.kode_program_studi
									INNER JOIN as_krs E ON E.id_mhs = A.id_mhs
									INNER JOIN as_jadwal_kuliah F ON F.jadwal_id = E.jadwal_id 
									INNER JOIN as_kelas_mahasiswa C ON C.id_mhs=A.id_mhs
									INNER JOIN as_kelas D ON D.kelas_id=C.kelas_id
									WHERE A.NIM = ? AND A.status_mahasiswa = 'A' ORDER BY C.kelas_mhs_id DESC LIMIT 1")->execute($_SESSION['username']);
	$nums = $db->database_num_rows($sql_mhs);
	$data_mhs = $db->database_fetch_array($sql_mhs);
	$sql_krs = $db->database_prepare("SELECT * FROM as_krs A INNER JOIN as_jadwal_kuliah B ON A.jadwal_id = B.jadwal_id
										INNER JOIN as_makul C ON C.mata_kuliah_id = B.makul_id
										INNER JOIN msdos D ON D.IDDOSMSDOS = B.dosen_id
										WHERE A.id_mhs = ? AND B.semester = ?")->execute($data_mhs['id_mhs'],$_GET['semester']);
	$nums2 = $db->database_num_rows($sql_krs);
	if ($nums == 0 || $nums2 == 0){
		echo "<div class='message success'>
				<p>NIM/NPM Mahasiswa tidak ditemukan atau KRS belum tersedia untuk semester ini. <br><a href='javascript:history.go(-1)'>Back</a></p>
			</div>";
	}
	else{
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
		echo "<a href='index.php?mod=kartu_krs'><img src='http://siakad.sekolahumarusman.com/images/back.png'></a>
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
						<td><b>$data_mhs[nama_kelas] - $data_mhs[semester_kelas] <input type='hidden' name='kelas_id' value='$data_mhs[kelas_id]'>
						<input type='hidden' name='semester' value='$data_mhs[semester_kelas]'></b></td>
					</tr>
					<tr>
						<td>KRS Semester</td>
						<td><b>$data_mhs[krs_semester]</b></td>
					</tr>
				</table>
			</div></div>";
		
		echo "<table class='data display datatable' id='example'>
				<thead>
					<tr>
						<th>No</th>
						<th>Kode MTK</th>
						<th>Nama MTK</th>
						<th>Program</th>
						<th>SKS</th>
						<th>Dosen</th>
						<th>Hari</th>
						<th>Jam Mulai</th>
						<th>Jam Selesai</th>
					</tr>
				</thead><tbody>";
		$i = 1; 
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
					<td>$program</td>
					<td>$data_krs[sks_mata_kuliah]</td>
					<td>$data_krs[NMDOSMSDOS] $data_krs[GELARMSDOS]</td>
					<td>$hari</td>
					<td>$data_krs[jam_mulai]</td>
					<td>$data_krs[jam_selesai]</td>
				</tr>";
			$i++;
		}
		echo "</tbody></table><p>&nbsp;</p><p>&nbsp;</p>
			<a href='modul/mod_krs/cetak_krs.php?act=export&act=pdf&id_mhs=$data_mhs[id_mhs]&semester=$_GET[semester]' target='_blank'><button type='button' class='btn btn-primary'>Export to PDF</button></a>
			";
	}
	break;
}
?>