<?php
switch($_GET['act']){
	default:
	$sql_mhs = $db->database_prepare("SELECT * FROM as_mahasiswa A INNER JOIN mspst B ON A.kode_program_studi=B.IDPSTMSPST
										INNER JOIN as_kelas_mahasiswa C ON C.id_mhs=A.id_mhs
										INNER JOIN as_kelas D ON D.kelas_id=C.kelas_id
										WHERE A.NIM = ?")->execute($_SESSION["username"]);
	$nums_mhs = $db->database_num_rows($sql_mhs);
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
	echo "<h5>Data Nilai Mahasiswa</h5>
		<div class='box round first fullpage'>
		<div class='block '>
			<table class='form'>
				<tr>
					<td width='100'>Program Studi</td>
					<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST]</b></td>
				</tr>
				<tr valign='top'>
					<td>Kelas/Semester</td>
					<td><b>$data_mhs[nama_kelas] - $data_mhs[semester] <input type='hidden' name='kelas_id' value='$data_mhs[kelas_id]'></b></td>
				</tr>
				<tr valign='top'>
					<td>NIM</td>
					<td><b>$data_mhs[NIM]</b></td>
				</tr>
				<tr valign='top'>
					<td>Nama</td>
					<td><b>$data_mhs[nama_mahasiswa]</b></td>
				</tr>
			</table>
		</div></div>
			<table class='data display datatable' id='example'>
				<thead>
					<tr>
						<th width='30'>No</th>
						<th width='85'>Kode MK</th>
						<th width='220'>Mata Kuliah</th>
						<th width='50'>Sms</th>
						<th width='50'>SKS</th>
						<th width='50'>UTS</th>
						<th width='50'>UAS</th>
						<th width='60'>Total</th>
						<th width='100'>Mutu</th>
						<th width='100'>Bobot</th>
						<th width='100'>Total Bobot</th>
					</tr>
				</thead><tbody>";
				$i = 1;
			$sql_data = $db->database_prepare("SELECT B.sks_mata_kuliah, B.kode_mata_kuliah, B.nama_mata_kuliah_eng, A.uts, A.uas, A.total, A.mutu, A.bobot 
												FROM as_nilai_semester_mhs A INNER JOIN as_makul B ON B.mata_kuliah_id=A.makul_id
												INNER JOIN as_jadwal_kuliah C ON C.makul_id = A.makul_id
												WHERE A.id_mhs = ? GROUP BY A.makul_id")->execute($data_mhs['id_mhs']);
			while ($data_data = $db->database_fetch_array($sql_data)){
				$total_bobot = $data_data['sks_mata_kuliah'] * $data_data['bobot'];
				
				echo "<tr>
						<td>$i</td>
						<td>$data_data[kode_mata_kuliah]</td>
						<td>$data_data[nama_mata_kuliah_eng]</td>
						<td align='center'>$data_data[semester]</td>
						<td align='center'>$data_data[sks_mata_kuliah]</td>
						<td align='center'>$data_data[uts]</td>
						<td align='center'>$data_data[uas]</td>
						<td align='center'>$data_data[total]</td>
						<td align='center'>$data_data[mutu]</td>
						<td align='center'>$data_data[bobot]</td>
						<td align='center'>$total_bobot</td>
					</tr>";
				$total_sks += $data_data['sks_mata_kuliah'];
				$bobot += $data_data['bobot'];
				$bobot_total += $total_bobot;
				$i++;
			}
		echo "</tbody></table></div>";
		
		$ipk = number_format($bobot_total / $total_sks,2);
		echo "
		<div class='box round first fullpage'>
		<div class='block '>
			<table class='form'>
				<tr>
					<td width=150>Total SKS</td>
					<td>: <b>$total_sks</b> SKS</td>
				</tr>
				<tr>
					<td>Total Bobot Kumulatif </td>
					<td>: <b>$bobot_total</b></td>
				</tr>
				<tr>
					<td>IP Kumulatif</td>
					<td>: <b>$ipk</b></td>
				</tr>
			</table>
		</div></div>
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