<div class="row-fluid">
	<?php 
	if ($_GET['code'] == 1){
	?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">×</button>
		Data Nilai berhasil disimpan.
	</div>
	<?php
	}
	if ($_GET['code'] == 2){
	?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">×</button>
		Data Nilai berhasil diubah.
	</div>
	<?php
	}
	if ($_GET['code'] == 3){
	?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">×</button>
		Data Nilai berhasil dihapus.
	</div>
	<?php
	}
	?>
</div>
<style>

	.error {
		font-size:small; 
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		border-radius: 4px;
  		border-color: #eed3d7;
  		color: #b94a48; 
	}
</style>
<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	var htmlobjek;
	$(document).ready(function() {
		$("#prodi").change(function(){
			var prodi = $("#prodi").val();
			$.ajax({
				url: "modul/mod_nilai/ambilkelas.php",
				data: "prodi="+prodi,
				cache: false,
				success: function(msg){
					$("#kelas").html(msg);
				}
			});
		});
		
		$("#kelas").change(function(){
			var kelas = $("#kelas").val();
			$.ajax({
				url: "modul/mod_nilai/ambilmakul.php",
				data: "kelas="+kelas,
				cache: false,
				success: function(msg){
					$("#makul").html(msg);
				}
			});
		});
		
		$("#prodi2").change(function(){
			var prodi2 = $("#prodi2").val();
			$.ajax({
				url: "modul/mod_nilai/ambilkelas2.php",
				data: "prodi2="+prodi2,
				cache: false,
				success: function(msg){
					$("#kelas2").html(msg);
				}
			});
		});
		
		$("#kelas2").change(function(){
			var kelas2 = $("#kelas2").val();
			$.ajax({
				url: "modul/mod_nilai/ambilmakul2.php",
				data: "kelas2="+kelas2,
				cache: false,
				success: function(msg){
					$("#makul2").html(msg);
				}
			});
		});
		
		$('#frm_nilai').validate({
			rules:{
				prodi: true
			},
			messages:{
				prodi:{
					required: "Program studi wajib diisi."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	
	<p>&nbsp;</p>
	<h4>Nilai Semester</h4>
	<div class="well">
		<ul class='nav nav-tabs'>
			<li class='active'><a href='#nilai' data-toggle='tab'>Entri Nilai</a></li>
			<li><a href='#buka-nilai' data-toggle='tab'>Buka/Update Nilai</a></li>
	    </ul>
	    
	    <div id='myTabContent' class='tab-content'>
	    	<div class='tab-pane active in' id='nilai'>
				<form action="" method="GET" id="nilai">
					<input type="hidden" name="mod" value="nilai_semester">
					<input type="hidden" name="act" value="form">
					<label>Program Studi</label>
					<select name='prodi' id='prodi' class="required">
						<option value=''></option>
						<?php
							$sql_prodi = $db->database_prepare("SELECT KDJENMSPST,IDPSTMSPST,NMPSTMSPST FROM mspst WHERE STATUMSPST = 'A'")->execute();
							while ($data_prodi = $db->database_fetch_array($sql_prodi)){
								if ($data_prodi['KDJENMSPST'] == 'A'){
									$kd_jenjang_studi = "S3";
								}
								elseif ($data_prodi['KDJENMSPST'] == 'B'){
									$kd_jenjang_studi = "S2";
								}
								elseif ($data_prodi['KDJENMSPST'] == 'C'){
									$kd_jenjang_studi = "S1";
								}
								elseif ($data_prodi['KDJENMSPST'] == 'D'){
									$kd_jenjang_studi = "D4";
								}
								elseif ($data_prodi['KDJENMSPST'] == 'E'){
									$kd_jenjang_studi = "D3";
								}
								elseif ($data_prodi['KDJENMSPST'] == 'F'){
									$kd_jenjang_studi = "D2";
								}
								elseif ($data_prodi['KDJENMSPST'] == 'G'){
									$kd_jenjang_studi = "D1";
								}
								elseif ($data_prodi['KDJENMSPST'] == 'H'){
									$kd_jenjang_studi = "Sp-1";
								}
								elseif ($data_prodi['KDJENMSPST'] == 'I'){
									$kd_jenjang_studi = "Sp-2";
								}
								elseif ($data_prodi['KDJENMSPST'] == 'J'){
									$kd_jenjang_studi = "Profesi";
								}
								echo "<option value=$data_prodi[IDPSTMSPST]>$kd_jenjang_studi - $data_prodi[NMPSTMSPST]</option>";
							}
					echo "</select>
						<label>Kelas</label>
						<select name='kelas' id='kelas'>
							<option value=''></option>
						</select>
						<label>Mata Kuliah</label>
						<select id='makul' name='makul'>
							<option value=''></option>
						</select><br><br>
						<div>
							<button type='submit' class='btn btn-primary'><i class='icon-print'></i> Lanjutkan</button>
						</div>";
						?>
				</form>
			</div>
			
			<div class='tab-pane fade' id='buka-nilai'>
				<form action="" method="GET" id="nilai">
					<input type="hidden" name="mod" value="nilai_semester">
					<input type="hidden" name="act" value="update_nilai">
					<label>Program Studi</label>
					<select name='prodi' id='prodi2' class="required">
						<option value=''></option>
						<?php
							$sql_prodi = $db->database_prepare("SELECT KDJENMSPST,IDPSTMSPST,NMPSTMSPST FROM mspst WHERE STATUMSPST = 'A'")->execute();
							while ($data_prodi = $db->database_fetch_array($sql_prodi)){
								if ($data_prodi['KDJENMSPST'] == 'A'){
									$kd_jenjang_studi = "S3";
								}
								elseif ($data_prodi['KDJENMSPST'] == 'B'){
									$kd_jenjang_studi = "S2";
								}
								elseif ($data_prodi['KDJENMSPST'] == 'C'){
									$kd_jenjang_studi = "S1";
								}
								elseif ($data_prodi['KDJENMSPST'] == 'D'){
									$kd_jenjang_studi = "D4";
								}
								elseif ($data_prodi['KDJENMSPST'] == 'E'){
									$kd_jenjang_studi = "D3";
								}
								elseif ($data_prodi['KDJENMSPST'] == 'F'){
									$kd_jenjang_studi = "D2";
								}
								elseif ($data_prodi['KDJENMSPST'] == 'G'){
									$kd_jenjang_studi = "D1";
								}
								elseif ($data_prodi['KDJENMSPST'] == 'H'){
									$kd_jenjang_studi = "Sp-1";
								}
								elseif ($data_prodi['KDJENMSPST'] == 'I'){
									$kd_jenjang_studi = "Sp-2";
								}
								elseif ($data_prodi['KDJENMSPST'] == 'J'){
									$kd_jenjang_studi = "Profesi";
								}
								echo "<option value=$data_prodi[IDPSTMSPST]>$kd_jenjang_studi - $data_prodi[NMPSTMSPST]</option>";
							}
					echo "</select>
						<label>Kelas</label>
						<select name='kelas' id='kelas2'>
							<option value=''></option>
						</select>
						<label>Mata Kuliah</label>
						<select id='makul2' name='makul'>
							<option value=''></option>
						</select><br><br>
						<div>
							<button type='submit' class='btn btn-primary'><i class='icon-print'></i> Lanjutkan</button>
						</div>";
						?>
				</form>
			</div>
		</div>
	</div>
<?php

	break;
	
	case "form":
	$kelas = explode("%", $_GET['kelas']);
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_jadwal_kuliah A INNER JOIN as_kelas B ON A.kelas_id=B.kelas_id
														INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id 
														INNER JOIN mspst D ON D.IDPSTMSPST=B.prodi_id
														INNER JOIN msdos E ON E.IDDOSMSDOS=A.dosen_id
														INNER JOIN as_ruang F ON F.ruang_id=A.ruang_id
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																B.angkatan_id = ? LIMIT 1")->execute($_GET['makul'],$kelas[0],$kelas[2]));
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
	elseif ($data_mhs['KDJENMSPST'] == 'J'){
		$kd_jenjang_studi = "Profesi";
	}
	echo "<p>&nbsp;</p><a href='index.php?mod=nilai_semester'><img src='../images/back.png'></a>
		<h4>Entri Data Nilai Semester</h4>
		<form method='POST' action='modul/mod_nilai/aksi_nilai.php?mod=nilai_semester&act=input'>
		<div class='well'>
			<table>
				<tr>
					<td width='100'>Program Studi</td>
					<td width='5'>:</td>
					<td><b><input type='hidden' name='sms' value='$data_mhs[semester]'> $kd_jenjang_studi - $data_mhs[NMPSTMSPST] <input type='hidden' name='kelas' value='$_GET[kelas]'><input type='hidden' name='prodi' value='$_GET[prodi]'><input type='hidden' name='makul' value='$_GET[makul]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Kelas/Semester</td>
					<td>:</td>
					<td><b>$data_mhs[nama_kelas] - $data_mhs[semester] <input type='hidden' name='kelas_id' value='$data_mhs[kelas_id]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Dosen</td>
					<td>:</td>
					<td><b>$data_mhs[NMDOSMSDOS] $data_mhs[GELARMSDOS]</b></td>
				</tr>
				<tr valign='top'>
					<td>Ruang</td>
					<td>:</td>
					<td><b>$data_mhs[nama_ruang]</b></td>
				</tr>
			</table>
			<br>
			<table>
				<tr bgcolor='#B7D577'>
					<th width='25'>No.</th>
					<th align='center' width='140'>NIM</th>
					<th align='center' width='300'>Nama Mahasiswa</th>
					<th align='left' width='60'>UTS</th>
					<th align='left' width='60'>UAS</th>
					<th align='left' width='60'>Total</th>
					<th width='120' align='left'>Huruf Mutu</th>
				</tr>";
				$i = 1;
			$sql_data = $db->database_prepare("SELECT * FROM as_jadwal_kuliah A INNER JOIN as_krs B ON B.jadwal_id=A.jadwal_id
														INNER JOIN as_kelas C ON C.kelas_id=A.kelas_id
														INNER JOIN as_angkatan D ON C.angkatan_id=C.angkatan_id
														INNER JOIN as_mahasiswa E ON E.id_mhs=B.id_mhs
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																C.angkatan_id = ?")->execute($_GET['makul'],$kelas[0],$kelas[2]);
			while ($data_data = $db->database_fetch_array($sql_data)){
				$nums = $db->database_num_rows($db->database_prepare("SELECT * FROM as_nilai_semester_mhs WHERE id_mhs = ? AND makul_id = ?")->execute($data_data["id_mhs"],$_GET["makul"]));
				if ($i % 2 == 1){
					$bg = "#CCCCCC";
				}
				else{
					$bg = "#FFFFFF";
				}
				
				if ($nums == 0){
					echo "<tr>
							<td bgcolor=$bg>$i</td>
							<td bgcolor=$bg>$data_data[NIM] <input type='hidden' name='id_mhs[]' value='$data_data[id_mhs]'></td>
							<td bgcolor=$bg>$data_data[nama_mahasiswa]</td>
							<td class='kecil' bgcolor=$bg><input type='text' name='uts[]' value='0'></td>
							<td class='kecil' bgcolor=$bg><input type='text' name='uas[]' value='0'></td>
							<td class='kecil' bgcolor=$bg><input type='text' name='total[]' value='0'></td>
							<td bgcolor=$bg><select name='mutu[]'>
								<option value=''>- none -</option>
								<option value='A'>A</option>
								<option value='B'>B</option>
								<option value='C'>C</option>
								<option value='D'>D</option>
								<option value='E'>E</option>
							</select></td>
						</tr>";
				}
				$i++;
			}
		echo "</thead></table></div>
				<div>
					<button type='submit' class='btn btn-primary'><i class='icon-save'></i> Simpan Nilai</button>
				</div>
		</form>
	";
	break;
	
	case "preview":
	$kelas = explode("%", $_GET['kelas']);
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_jadwal_kuliah A INNER JOIN as_kelas B ON A.kelas_id=B.kelas_id
														INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id 
														INNER JOIN mspst D ON D.IDPSTMSPST=B.prodi_id
														INNER JOIN msdos E ON E.IDDOSMSDOS=A.dosen_id
														INNER JOIN as_ruang F ON F.ruang_id=A.ruang_id
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																B.angkatan_id = ? LIMIT 1")->execute($_GET['makul'],$kelas[0],$kelas[2]));
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
	elseif ($data_mhs['KDJENMSPST'] == 'J'){
		$kd_jenjang_studi = "Profesi";
	}
	echo "<p>&nbsp;</p><a href='index.php?mod=nilai_semester'><img src='../images/back.png'></a>
		<h4>Hasil Entri Data Nilai Semester</h4>
		<div class='well'>
			<table>
				<tr>
					<td width='100'>Program Studi</td>
					<td width='5'>:</td>
					<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST] <input type='hidden' name='kelas' value='$_GET[kelas]'><input type='hidden' name='prodi' value='$_GET[prodi]'><input type='hidden' name='makul' value='$_GET[makul]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Kelas/Semester</td>
					<td>:</td>
					<td><b>$data_mhs[nama_kelas] - $data_mhs[semester] <input type='hidden' name='kelas_id' value='$data_mhs[kelas_id]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Dosen</td>
					<td>:</td>
					<td><b>$data_mhs[NMDOSMSDOS] $data_mhs[GELARMSDOS]</b></td>
				</tr>
				<tr valign='top'>
					<td>Ruang</td>
					<td>:</td>
					<td><b>$data_mhs[nama_ruang]</b></td>
				</tr>
			</table>
			<br>
			<table>
				<tr bgcolor='#B7D577'>
					<th width='25'>No.</th>
					<th align='center' width='140'>NIM</th>
					<th align='center' width='300'>Nama Mahasiswa</th>
					<th align='center' width='60'>UTS</th>
					<th align='center' width='60'>UAS</th>
					<th align='center' width='60'>Total</th>
					<th width='120' align='center'>Huruf Mutu</th>
				</tr>";
				$i = 1;
			$sql_data = $db->database_prepare("SELECT * FROM as_nilai_semester_mhs A 
														INNER JOIN as_kelas B ON B.kelas_id=A.kelas_id
														INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id
														INNER JOIN as_mahasiswa D ON D.id_mhs=A.id_mhs
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																C.angkatan_id = ?")->execute($_GET['makul'],$kelas[0],$kelas[2]);
			while ($data_data = $db->database_fetch_array($sql_data)){
				if ($i % 2 == 1){
					$bg = "#CCCCCC";
				}
				else{
					$bg = "#FFFFFF";
				}
				
				if ($data_data['mutu'] == ''){
					$mutu = "-";
				}
				else{
					$mutu = $data_data['mutu'];
				}
				
				echo "<tr>
						<td bgcolor=$bg>$i</td>
						<td bgcolor=$bg>$data_data[NIM]</td>
						<td bgcolor=$bg>$data_data[nama_mahasiswa]</td>
						<td align='center' bgcolor=$bg>$data_data[uts]</td>
						<td align='center' bgcolor=$bg>$data_data[uas]</td>
						<td align='center' bgcolor=$bg>$data_data[total]</td>
						<td align='center' bgcolor=$bg>$mutu</td>
					</tr>";
				$i++;
			}
		echo "</thead></table></div>
		<div>
			<a href='index.php?mod=nilai_semester'><button type='button' class='btn btn-primary'>Keluar / Selesai</button></a>
		</div>
	";
	break;
	
	case "update_nilai":
	$kelas = explode("%", $_GET['kelas']);
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_jadwal_kuliah A INNER JOIN as_kelas B ON A.kelas_id=B.kelas_id
														INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id 
														INNER JOIN mspst D ON D.IDPSTMSPST=B.prodi_id
														INNER JOIN msdos E ON E.IDDOSMSDOS=A.dosen_id
														INNER JOIN as_ruang F ON F.ruang_id=A.ruang_id
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																B.angkatan_id = ? LIMIT 1")->execute($_GET['makul'],$kelas[0],$kelas[2]));
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
	elseif ($data_mhs['KDJENMSPST'] == 'J'){
		$kd_jenjang_studi = "Profesi";
	}
	echo "<p>&nbsp;</p><a href='index.php?mod=nilai_semester'><img src='../images/back.png'></a>
		<h4>Data Nilai Semester</h4>
		<form method='POST' action='modul/mod_nilai/aksi_nilai.php?mod=nilai_semester&act=update'>
		<div class='well'>
			<table>
				<tr>
					<td width='100'>Program Studi</td>
					<td width='5'>:</td>
					<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST] <input type='hidden' name='kelas' value='$_GET[kelas]'><input type='hidden' name='prodi' value='$_GET[prodi]'><input type='hidden' name='makul' value='$_GET[makul]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Kelas/Semester</td>
					<td>:</td>
					<td><b>$data_mhs[nama_kelas] - $data_mhs[semester] <input type='hidden' name='kelas_id' value='$data_mhs[kelas_id]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Dosen</td>
					<td>:</td>
					<td><b>$data_mhs[NMDOSMSDOS] $data_mhs[GELARMSDOS]</b></td>
				</tr>
				<tr valign='top'>
					<td>Ruang</td>
					<td>:</td>
					<td><b>$data_mhs[nama_ruang]</b></td>
				</tr>
			</table>
			<br>
			<table>
				<tr bgcolor='#B7D577'>
					<th width='25'>No.</th>
					<th align='center' width='140'>NIM</th>
					<th align='center' width='300'>Nama Mahasiswa</th>
					<th align='center' width='60'>UTS</th>
					<th align='center' width='60'>UAS</th>
					<th align='center' width='60'>Total</th>
					<th width='120' align='center'>Huruf Mutu</th>
				</tr>";
				$i = 1;
			$sql_data = $db->database_prepare("SELECT * FROM as_nilai_semester_mhs A 
														INNER JOIN as_kelas B ON B.kelas_id=A.kelas_id
														INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id
														INNER JOIN as_mahasiswa D ON D.id_mhs=A.id_mhs
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																C.angkatan_id = ?")->execute($_GET['makul'],$kelas[0],$kelas[2]);
			while ($data_data = $db->database_fetch_array($sql_data)){
				if ($i % 2 == 1){
					$bg = "#CCCCCC";
				}
				else{
					$bg = "#FFFFFF";
				}
				
				if ($data_data['mutu'] == 'A'){
					$mutuA = "SELECTED";
				}
				else{
					$mutuA = "";
				}
				
				if ($data_data['mutu'] == 'B'){
					$mutuB = "SELECTED";
				}
				else{
					$mutuB = "";
				}
				
				if ($data_data['mutu'] == 'C'){
					$mutuC = "SELECTED";
				}
				else{
					$mutuC = "";
				}
				
				if ($data_data['mutu'] == 'D'){
					$mutuD = "SELECTED";
				}
				else{
					$mutuD = "";
				}
				
				if ($data_data['mutu'] == 'E'){
					$mutuE = "SELECTED";
				}
				else{
					$mutuE = "";
				}
				
				echo "<tr>
						<td bgcolor=$bg>$i <input type='hidden' name='nilai_id[]' value='$data_data[nilai_id]'></td>
						<td bgcolor=$bg>$data_data[NIM]</td>
						<td bgcolor=$bg>$data_data[nama_mahasiswa]</td>
						<td class='kecil' align='center' bgcolor=$bg><input type='text' name='uts[]' value='$data_data[uts]'></td>
						<td class='kecil' align='center' bgcolor=$bg><input type='text' name='uas[]' value='$data_data[uas]'></td>
						<td class='kecil' align='center' bgcolor=$bg><input type='text' name='total[]' value='$data_data[total]'></td>
						<td align='center' bgcolor=$bg>
							<select name='mutu[]'>
								<option value=''>- none -</option>
								<option value='A' $mutuA>A</option>
								<option value='B' $mutuB>B</option>
								<option value='C' $mutuC>C</option>
								<option value='D' $mutuD>D</option>
								<option value='E' $mutuE>E</option>
							</select>
						</td>
					</tr>";
				$i++;
			}
		echo "</thead></table></div>
		<div>
			<button type='submit' class='btn btn-primary'><i class='icon-save'></i> Simpan Perubahan</button>
		</div>
		</form>
	";
	break;
}
?>