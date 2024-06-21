<div class="row-fluid">
	<?php 
	if ($_GET['code'] == 1){
	?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">×</button>
		Data Mata kuliah berhasil disimpan.
	</div>
	<?php
	}
	if ($_GET['code'] == 2){
	?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">×</button>
		Data Mata kuliah berhasil diubah.
	</div>
	<?php
	}
	if ($_GET['code'] == 3){
	?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">×</button>
		Data Mata kuliah berhasil dihapus.
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
	$(document).ready(function() {
		$('#frm_makul').validate({
			rules:{
				nama_mata_kuliah_ind: true,
				nama_mata_kuliah_eng: true,
				prodi_id: true,
				status_mata_kuliah: true
			},
			messages:{
				nama_mata_kuliah_ind:{
					required: "Nama mata kuliah dalam bahasa Indonesia Wajib Diisi."
				},
				nama_mata_kuliah_eng:{
					required: "Nama mata kuliah dalam bahasa Inggris Wajib Diisi."
				},
				prodi_id:{
					required: "Program studi mata kuliah wajib diisi."
				},
				status_mata_kuliah:{
					required: "Status mata kuliah wajib diisi."
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
<div>
	<a href="?mod=makul&act=add"><button type="button" class="btn btn-primary">+ Tambah Mata Kuliah</button></a>
</div>
		<br>		
<table id="example" class="display">
	<thead>
		<tr>
			<th>No</th>
			<th>Kode</th>
			<th>Nama MK (Eng)</th>
			<th>Program Studi</th>
			<!--<th>Jenis MK</th>-->
			<th>SKS Tatap Muka</th>
			<th>SKS Praktikum</th>
			<th>SKS Praktek Lapangan</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$no = 1;
	$sql_makul = $db->database_prepare("SELECT * FROM as_makul LEFT JOIN mspst ON mspst.IDPSTMSPST=as_makul.prodi_id ORDER BY prodi_id,nama_mata_kuliah_ind ASC")->execute();
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
			
		
		if ($data_makul['KDJENMSPST'] == 'A'){
			$kd_jenjang_studi = "S3";
		}
		elseif ($data_makul['KDJENMSPST'] == 'B'){
			$kd_jenjang_studi = "S2";
		}
		elseif ($data_makul['KDJENMSPST'] == 'C'){
			$kd_jenjang_studi = "S1";
		}
		elseif ($data_makul['KDJENMSPST'] == 'D'){
			$kd_jenjang_studi = "D4";
		}
		elseif ($data_makul['KDJENMSPST'] == 'E'){
			$kd_jenjang_studi = "D3";
		}
		elseif ($data_makul['KDJENMSPST'] == 'F'){
			$kd_jenjang_studi = "D2";
		}
		elseif ($data_makul['KDJENMSPST'] == 'G'){
			$kd_jenjang_studi = "D1";
		}
		elseif ($data_makul['KDJENMSPST'] == 'H'){
			$kd_jenjang_studi = "Sp-1";
		}
		elseif ($data_makul['KDJENMSPST'] == 'I'){
			$kd_jenjang_studi = "Sp-2";
		}
		elseif ($data_makul['KDJENMSPST'] == 'J'){
			$kd_jenjang_studi = "Profesi";
		}
		echo "
		<tr>
			<td>$no</td>
			<td>$data_makul[kode_mata_kuliah]</td>
			<td>$data_makul[nama_mata_kuliah_eng]</td>
			<td>$kd_jenjang_studi $data_makul[NMPSTMSPST]</td>
			
			<td align=center>$data_makul[sks_tatap_muka]</td>
			<td align=center>$data_makul[sks_praktikum]</td>
			<td align=center>$data_makul[sks_praktek_lapangan]</td>
			<td><a href='?mod=makul&act=edit&id=$data_makul[mata_kuliah_id]'><img src='../images/edit.jpg' width='20'></a>";
			?>
				<a href="modul/mod_makul/aksi_makul.php?mod=makul&act=delete&id=<?php echo $data_makul[mata_kuliah_id];?>" onclick="return confirm('Anda Yakin ingin menghapus mata kuliah <?php echo $data_makul[nama_mata_kuliah_ind];?>?');"><img src='../images/delete.jpg' width='20'></a>
			<?php
			echo "</td>
		</tr>";
		$no++;
	} 
	?>
	</tbody>
</table>
<?php

	break;
	
	case "add":
	$sql_urut = $db->database_prepare("SELECT kode_mata_kuliah FROM as_makul ORDER BY mata_kuliah_id DESC LIMIT 1")->execute();
	$num_urut = $db->database_num_rows($sql_urut);
	
	$data_urut = $db->database_fetch_array($sql_urut);
	$awal = substr($data_urut['kode_mata_kuliah'],0-4);
	$next = $awal + 1;
	$jnim = strlen($next);
	
	if (!$data_urut['kode_mata_kuliah']){
		$no = "0001";
	}
	elseif($jnim == 1){
		$no = "000";
	} 
	elseif($jnim == 2){
		$no = "00";
	}
	elseif($jnim == 3){
		$no = "0";
	}
	elseif($jnim == 4){
		$no = "";
	}
	if ($num_urut == 0){
		$npm = "MK".$no;
	}
	else{
		$npm = "MK".$no.$next;
	}	
		
?>
	<p>&nbsp;</p>
	<p><a href="?mod=makul"><img src="../images/back.png"></a></p>
	<h4>Tambah Mata Kuliah</h4>
	<div class="well">
		<form id="frm_makul" action="modul/mod_makul/aksi_makul.php?mod=makul&act=input" method="POST">
			<label>Kode Mata Kuliah <i>Kode mata kuliah</i></label>
				<input type="text" name="kode_mata_kuliah" size="40" maxlength="10" value="<?php echo $npm; ?>" DISABLED>
				<input type="hidden" name="kode_mata_kuliah" size="40" maxlength="10" value="<?php echo $npm; ?>">
			<label>Nama Mata Kuliah (Ind) <font color="red">*</font> <i>Nama mata kuliah dalam bahasa Indonesia</i></label>
				<input type="text" name="nama_mata_kuliah_ind" class="required" size="40" maxlength="40">
			<label>Nama Mata Kuliah (Eng) <font color="red">*</font> <i>Nama mata kuliah dalam bahasa Inggris</i></label>
				<input type="text" name="nama_mata_kuliah_eng" class="required" size="40" maxlength="40">
			<label>Program Studi <font color="red">*</font> <i>Sebagai referensi program studi pengampu</i></label>
				<select name="prodi_id" class="required">
					<option value=""></option>
					<?php
					$sql_prodi = $db->database_prepare("SELECT * FROM mspst WHERE STATUMSPST = 'A' ORDER BY KDJENMSPST,NMPSTMSPST ASC")->execute();
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
						echo "<option value=$data_prodi[IDPSTMSPST]>$kd_jenjang_studi $data_prodi[NMPSTMSPST]</option>";
						//echo "<input type='checkbox' name='prodi_id[]' value='$data_prodi[IDPSTMSPST]'> $kd_jenjang_studi $data_prodi[NMPSTMSPST]<br>";
					}
					?></select><br>
			<label>SKS Kurikulum <i>SKS sesuai dengan kurikulum, untuk keperluan DIKTI</i></label>
				<input type="text" name="sks_kurikulum" size="40" maxlength="1" value="0">
			<label>SKS Tatap Muka <i>Jumlah SKS tatap muka di kelas</i></label>
				<input type="text" name="sks_tatap_muka" size="40" maxlength="1" value="0">
			<label>SKS Praktikum <i>Jumlah SKS praktikum di lab</i></label>
				<input type="text" name="sks_praktikum" size="40" maxlength="1" value="0">
			<label>SKS Praktik Lapangan <i>Jumlah SKS praktik di lapangan</i></label>
				<input type="text" name="sks_praktek_lapangan" size="40" maxlength="1" value="0">
			
			<label>Dosen Pengampu</label>
				<select name="dosen_pengampu">
					<option value=""></option>	
				<?php
				$sql_dosen = $db->database_prepare("SELECT * FROM msdos WHERE STDOSMSDOS = 'A' ORDER BY NMDOSMSDOS ASC")->execute();
				while ($data_dosen = $db->database_fetch_array($sql_dosen)){
					echo "<option value=$data_dosen[IDDOSMSDOS]>$data_dosen[NODOSMSDOS] - $data_dosen[NMDOSMSDOS] $data_dosen[GELARMSDOS]</option>";
				} 
				?>	
				</select>
			<label>Jenis Mata Kuliah</label>
				<select name="jenis_mata_kuliah">
					<option value=""></option>
					<option value="A">Wajib</option>
					<option value="B">Pilihan</option>
					<option value="C">Wajib Peminatan</option>
					<option value="D">Pilihan Peminatan</option>
					<option value="S">TA/Skripsi/Tesis/Disertasi</option>
				</select>		
			<label>Kelompok Mata Kuliah </label>
				<select name="kelompok_mata_kuliah">
					<option value=""></option>
					<option value="A">MPK-Pengembangan Kepribadian</option>
					<option value="B">MKK-Keilmuan dan Ketrampilan</option>
					<option value="C">MKB-Keahlian Berkarya</option>
					<option value="D">MPB-Perilaku Berkarya</option>
					<option value="E">MBB-Berkehidupan Bermasyarakat</option>
					<option value="F">MKU/MKDU</option>
					<option value="G">MKDK</option>
					<option value="H">MKK</option>
				</select>
			<label>Jenis Kurikulum</label>
				<select name="jenis_kurikulum">
					<option value=""></option>
					<option value="A">INTI</option>
					<option value="B">INSTITUSI</option>
				</select>
			<label>Status Mata Kuliah</label>
				<select name="status_mata_kuliah" class="required">
					<option value=""></option>
					<option value="A">Aktif</option>
					<option value="B">Non-Aktif</option>
					<option value="C">Hapus</option>
				</select>
			<label>Silabus</label>
				<select name="silabus">
					<option value=""></option>
					<option value="A">Ada</option>
					<option value="T">Tidak Ada</option>
				</select>
			<label>SAP</label>
				<select name="sap">
					<option value=""></option>
					<option value="1">Mempunyai SAP</option>
					<option value="0">Tidak Mempunyai SAP</option>
				</select>
		<br><br>	
		<div>
			<button type="submit" class="btn btn-primary"><i class="icon-save"></i> Simpan</button>
		</div>
		</form>
	</div>
	<?php
	break;
	
	case "edit":
	$data_makul = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_makul WHERE mata_kuliah_id = ?")->execute($_GET["id"]));
	
?>
	<p>&nbsp;</p>
	<p><a href="?mod=makul"><img src="../images/back.png"></a></p>
	<h4>Ubah Mata Kuliah</h4>
	<div class="well">
		<form id="frm_makul" action="modul/mod_makul/aksi_makul.php?mod=makul&act=update" method="POST">
			<input type="hidden" name="id" value="<?php echo $data_makul['mata_kuliah_id']; ?>">
			<label>Kode Mata Kuliah <i>Kode mata kuliah</i></label>
				<input type="text" name="kode_mata_kuliah" size="40" maxlength="10" value="<?php echo $data_makul['kode_mata_kuliah']; ?>" DISABLED>
				<input type="hidden" name="kode_mata_kuliah" size="40" maxlength="10" value="<?php echo $data_makul['kode_mata_kuliah']; ?>">
			<label>Nama Mata Kuliah (Ind) <font color="red">*</font> <i>Nama mata kuliah dalam bahasa Indonesia</i></label>
				<input type="text" name="nama_mata_kuliah_ind" class="required" size="40" maxlength="40" value="<?php echo $data_makul['nama_mata_kuliah_ind']; ?>">
			<label>Nama Mata Kuliah (Eng) <font color="red">*</font>  <i>Nama mata kuliah dalam bahasa Inggris</i></label>
				<input type="text" name="nama_mata_kuliah_eng" class="required" size="40" maxlength="40" value="<?php echo $data_makul['nama_mata_kuliah_eng']; ?>">
			<label>Program Studi <font color="red">*</font> <i>Sebagai referensi program studi pengampu</i></label>
				<select name="prodi_id" class="required">
					<option value=""></option>
					<?php
					$sql_prodi = $db->database_prepare("SELECT * FROM mspst WHERE STATUMSPST = 'A' ORDER BY KDJENMSPST,NMPSTMSPST ASC")->execute();
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
						if ($data_makul['prodi_id'] == $data_prodi['IDPSTMSPST']){
							echo "<option value=$data_prodi[IDPSTMSPST] SELECTED>$kd_jenjang_studi $data_prodi[NMPSTMSPST]</option>";
						}
						else{
							echo "<option value=$data_prodi[IDPSTMSPST]>$kd_jenjang_studi $data_prodi[NMPSTMSPST]</option>";
						}
						
					}
					?>
				</select>
			<label>SKS Kurikulum <i>SKS sesuai dengan kurikulum, untuk keperluan DIKTI</i></label>
				<input type="text" name="sks_kurikulum" size="40" maxlength="1" value="<?php echo $data_makul['sks_mata_kuliah']; ?>">
			<label>SKS Tatap Muka <i>Jumlah SKS tatap muka di kelas</i></label>
				<input type="text" name="sks_tatap_muka" size="40" maxlength="1" value="<?php echo $data_makul['sks_tatap_muka']; ?>">
			<label>SKS Praktikum <i>Jumlah SKS praktikum di lab</i></label>
				<input type="text" name="sks_praktikum" size="40" maxlength="1" value="<?php echo $data_makul['sks_praktikum']; ?>">
			<label>SKS Praktik Lapangan <i>Jumlah SKS praktik di lapangan</i></label>
				<input type="text" name="sks_praktek_lapangan" size="40" maxlength="1" value="<?php echo $data_makul['sks_praktek_lapangan']; ?>">
			
			<label>Dosen Pengampu</label>
				<select name="dosen_pengampu">
					<option value=""></option>	
				<?php
				$sql_dosen = $db->database_prepare("SELECT * FROM msdos WHERE STDOSMSDOS = 'A' ORDER BY NMDOSMSDOS ASC")->execute();
				while ($data_dosen = $db->database_fetch_array($sql_dosen)){
					if ($data_makul['nidn'] == $data_dosen['IDDOSMSDOS']){
						echo "<option value=$data_dosen[IDDOSMSDOS] SELECTED>$data_dosen[NODOSMSDOS] - $data_dosen[NMDOSMSDOS] $data_dosen[GELARMSDOS]</option>";
					}
					else{
						echo "<option value=$data_dosen[IDDOSMSDOS]>$data_dosen[NODOSMSDOS] - $data_dosen[NMDOSMSDOS] $data_dosen[GELARMSDOS]</option>";
					}
				} 
				?>	
				</select>
			<label>Jenis Mata Kuliah</label>
				<select name="jenis_mata_kuliah">
					<option value=""></option>
					<option value="A" <?php if ($data_makul['jenis_mata_kuliah'] == 'A'){ echo "SELECTED"; } ?>>Wajib</option>
					<option value="B" <?php if ($data_makul['jenis_mata_kuliah'] == 'B'){ echo "SELECTED"; } ?>>Pilihan</option>
					<option value="C" <?php if ($data_makul['jenis_mata_kuliah'] == 'C'){ echo "SELECTED"; } ?>>Wajib Peminatan</option>
					<option value="D" <?php if ($data_makul['jenis_mata_kuliah'] == 'D'){ echo "SELECTED"; } ?>>Pilihan Peminatan</option>
					<option value="S" <?php if ($data_makul['jenis_mata_kuliah'] == 'S'){ echo "SELECTED"; } ?>>TA/Skripsi/Tesis/Disertasi</option>
				</select>		
			<label>Kelompok Mata Kuliah </label>
				<select name="kelompok_mata_kuliah">
					<option value=""></option>
					<option value="A" <?php if ($data_makul['kelompok_mata_kuliah'] == 'A'){ echo "SELECTED"; } ?>>MPK-Pengembangan Kepribadian</option>
					<option value="B" <?php if ($data_makul['kelompok_mata_kuliah'] == 'B'){ echo "SELECTED"; } ?>>MKK-Keilmuan dan Ketrampilan</option>
					<option value="C" <?php if ($data_makul['kelompok_mata_kuliah'] == 'C'){ echo "SELECTED"; } ?>>MKB-Keahlian Berkarya</option>
					<option value="D" <?php if ($data_makul['kelompok_mata_kuliah'] == 'D'){ echo "SELECTED"; } ?>>MPB-Perilaku Berkarya</option>
					<option value="E" <?php if ($data_makul['kelompok_mata_kuliah'] == 'E'){ echo "SELECTED"; } ?>>MBB-Berkehidupan Bermasyarakat</option>
					<option value="F" <?php if ($data_makul['kelompok_mata_kuliah'] == 'F'){ echo "SELECTED"; } ?>>MKU/MKDU</option>
					<option value="G" <?php if ($data_makul['kelompok_mata_kuliah'] == 'G'){ echo "SELECTED"; } ?>>MKDK</option>
					<option value="H" <?php if ($data_makul['kelompok_mata_kuliah'] == 'H'){ echo "SELECTED"; } ?>>MKK</option>
				</select>
			<label>Jenis Kurikulum</label>
				<select name="jenis_kurikulum">
					<option value=""></option>
					<option value="A" <?php if ($data_makul['jenis_kurikulum'] == 'A'){ echo "SELECTED"; } ?>>INTI</option>
					<option value="B" <?php if ($data_makul['jenis_kurikulum'] == 'B'){ echo "SELECTED"; } ?>>INSTITUSI</option>
				</select>
			<label>Status Mata Kuliah</label>
				<select name="status_mata_kuliah" class="required">
					<option value=""></option>
					<option value="A" <?php if ($data_makul['status_mata_kuliah'] == 'A'){ echo "SELECTED"; } ?>>Aktif</option>
					<option value="B" <?php if ($data_makul['status_mata_kuliah'] == 'B'){ echo "SELECTED"; } ?>>Non-Aktif</option>
					<option value="C" <?php if ($data_makul['status_mata_kuliah'] == 'C'){ echo "SELECTED"; } ?>>Hapus</option>
				</select>
			<label>Silabus</label>
				<select name="silabus">
					<option value=""></option>
					<option value="A" <?php if ($data_makul['silabus'] == 'A'){ echo "SELECTED"; } ?>>Ada</option>
					<option value="T" <?php if ($data_makul['silabus'] == 'T'){ echo "SELECTED"; } ?>>Tidak Ada</option>
				</select>
			<label>SAP</label>
				<select name="sap">
					<option value=""></option>
					<option value="1" <?php if ($data_makul['sap'] == '1'){ echo "SELECTED"; } ?>>Mempunyai SAP</option>
					<option value="0" <?php if ($data_makul['sap'] == '0'){ echo "SELECTED"; } ?>>Tidak Mempunyai SAP</option>
				</select>
			<br><br>	
			<div>
				<button type="submit" class="btn btn-primary"><i class="icon-save"></i> Simpan Perubahan</button>
			</div>
		</form>
	</div>
	<?php
	break;
}
?>