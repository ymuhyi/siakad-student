<script type='text/javascript' src='http://siakad.sekolahumarusman.com/js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	$(document).ready(function() {
		$('#frm_khs').validate({
			rules:{
				semester: true
			},
			messages:{
				semester:{
					required: "Masukkan semester KHS."
				}
			}
		});
	});
</script>
<?php
switch($_GET['act']){
	default:
?>
	<h5>Kartu Hasil Studi</h5>
	<div class="box round first fullpage">
		<div class="block ">
		<form action="" method="GET" id="frm_khs">
			<table class="form">
				<input type="hidden" name="mod" value="khs">
				<input type="hidden" name="act" value="data">
				<tr valign="top">
					<td width="150"><label>Semester</label></td>
					<td><input type="text" name="semester" class="required" maxlength="1"></td>
				</tr>
				<tr valign="top">
					<td></td>
					<td><button type='submit' class='btn btn-primary'>Lanjutkan</button></td>
				</tr>
			</table>
		</form>
	</div></div>
<?php

	break;
	
	case "data":
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
	echo "<a href='index.php?mod=khs'><img src='http://siakad.sekolahumarusman.com/images/back.png'></a>
		<h5>Kartu Hasil Studi</h5>
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
			</table>
			</div></div>
			<table class='data display datatable' id='example'>
				<thead>
					<tr>
						<th width='30'>No.</th>
						<th width='85'>Kode MK</th>
						<th width='200'>Mata Kuliah</th>
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
			$sql_data = $db->database_prepare("SELECT B.sks_mata_kuliah, B.kode_mata_kuliah, B.nama_mata_kuliah_eng, C.semester, A.uts, A.uas, A.total, A.mutu, A.bobot 
												FROM as_nilai_semester_mhs A INNER JOIN as_makul B ON B.mata_kuliah_id=A.makul_id
												INNER JOIN as_jadwal_kuliah C ON C.makul_id=B.mata_kuliah_id WHERE A.id_mhs = ?
												AND A.semester_nilai = ?
												GROUP BY A.makul_id")->execute($data_mhs['id_mhs'],$_GET["semester"]);
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
					<td width=200>Total SKS</td>
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
	echo "<a target='_blank' href='modul/mod_nilai/export_khs.php?id=$data_mhs[id_mhs]&semester=$_GET[semester]'><button type='button' class='btn btn-primary'>Export KHS</button></a>";
	break;
}
?>