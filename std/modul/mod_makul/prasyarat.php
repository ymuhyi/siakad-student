<?php
switch($_GET['act']){
	default:
?>
	<p>&nbsp;</p>
	<h4>Mata Kuliah Prasyarat</h4><br>
<table id="example" class="display">
	<thead>
		<tr>
			<td colspan="4" align="center" bgcolor="#999"><b>Mata Kuliah</b></td>
			<td colspan="6" align="center" bgcolor="#ccc"><b>Mata Kuliah Prasyarat</b></td>
		</tr>
		<tr>
			<th>No</th>
			<th>Kode</th>
			<th>Nama MK (Eng)</th>
			<th>Sifat</th>
			<!--<th>Jenis MK</th>-->
			<th>Kode</th>
			<th>Nama MK (Eng)</th>
			<th>Sifat</th>
			<th>Bobot Minimal</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$no = 1;
	$sql_makul = $db->database_prepare("SELECT * FROM as_makul_prasyarat A INNER JOIN as_makul B ON B.mata_kuliah_id=A.makul_id ORDER BY B.nama_mata_kuliah_eng ASC")->execute();
	while ($data_makul = $db->database_fetch_array($sql_makul)){
		if ($data_makul['jenis_mata_kuliah'] == 'A'){
			$jenis_mk = "Wajib";
		}
		elseif ($data_makul['jenis_mata_kuliah'] == 'B'){
			$jenis_mk = "Pilihan";
		}
		elseif ($data_makul['jenis_mata_kuliah'] == 'C'){
			$jenis_mk = "Wajib Peminatan";
		}
		elseif ($data_makul['jenis_mata_kuliah'] == 'S'){
			$jenis_mk = "TA/Skripsi/Tesis/Disertasi";
		}
		
		if ($data_makul['status'] == 'A'){
			$status = "Aktif";
		}
		else{
			$status = "Non-aktif";
		}
		
		$data_prasyarat = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_makul_prasyarat A INNER JOIN as_makul B ON B.mata_kuliah_id=A.makul_id_prasyarat WHERE A.makul_id_prasyarat = ?")->execute($data_makul['makul_id_prasyarat']));
			
		echo "
		<tr>
			<td>$no</td>
			<td>$data_makul[kode_mata_kuliah]</td>
			<td>$data_makul[nama_mata_kuliah_eng]</td>
			<td>$jenis_mk</td>
			
			<td>$data_prasyarat[kode_mata_kuliah]</td>
			<td>$data_prasyarat[nama_mata_kuliah_eng]</td>
			<td align=center>$jenis_pr</td>
			<td align=center>$data_prasyarat[bobot_minimal]</td>
			<td align=center>$status</td>
		</tr>";
		$no++;
	} 
	?>
	</tbody>
</table>
<?php
	break;
}
?>