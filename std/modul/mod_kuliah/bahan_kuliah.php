<?php
switch($_GET['act']){
	default:
?>
	<h5>Bahan Kuliah dan Tugas Kuliah</h5>
		<br>		
	<table class="data display datatable" id="example">
	<thead>
		<tr>
			<th width='30'>No</th>
			<th width='220'>Judul</th>
			<th width='220'>Dosen</th>
			<th width='220'>Makul</th>
			<th width='100'>Jenis</th>
			<th width='80'>Status</th>
			<th align='left'>Aksi</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$no = 1;
	$sql_bahan = $db->database_prepare("SELECT * FROM as_bahan_kuliah A 
										INNER JOIN as_makul B ON B.mata_kuliah_id = A.makul_id
										INNER JOIN as_jadwal_kuliah C ON C.makul_id = A.makul_id
										INNER JOIN msdos D ON D.IDDOSMSDOS = C.dosen_id 
										GROUP BY A.bahan_id DESC")->execute();
	while ($data_bahan = $db->database_fetch_array($sql_bahan)){
		if ($data_bahan['status'] == 'A'){
			$status_bahan = "Aktif";
		}
		else{
			$status_bahan = "Non-Aktif";
		}
		
		if ($data_bahan['jenis'] == 'B'){
			$jenis = "Bahan Kuliah";
		}
		else{
			$jenis = "Tugas Kuliah";
		}
		echo "
		<tr>
			<td>$no</td>
			<td>$data_bahan[judul]</td>
			<td>$data_bahan[NMDOSMSDOS] $data_bahan[GELARMSDOS]</td>
			<td>$data_bahan[kode_mata_kuliah] - $data_bahan[nama_mata_kuliah_eng]</td>
			<td>$jenis</td>
			<td>$status_bahan</td>
			<td>
			<a href='modul/mod_kuliah/download.php?id=$data_bahan[bahan_id]' title='Download'><img src='http://siakad.sekolahumarusman.com/images/download.png' width='20'></a></td>
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