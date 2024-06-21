<div class="row-fluid">
	<?php 
	if ($_GET['code'] == 1){
	?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">×</button>
		Data Pengguna Baru berhasil disimpan.
	</div>
	<?php
	}
	if ($_GET['code'] == 2){
	?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">×</button>
		Data Pengguna berhasil diubah.
	</div>
	<?php
	}
	if ($_GET['code'] == 3){
	?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">×</button>
		Data Pengguna berhasil dihapus.
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
		$('#frm_user').validate({
			rules:{
				nip: true,
				nama_lengkap: true,
				level: true,
				level_jabatan: true,
				email: true,
				aktif: true,
				blokir: true
			},
			messages:{
				nip:{
					required: "Nomor Induk Pegawai Wajib Diisi."
				},
				nama_lengkap:{
					required: "Nama Lengkap Wajib Diisi."
				},
				level:{
					required: "Level Pengguna Wajib Diisi."
				},
				level_jabatan:{
					required: "Level Jabatan Pengguna di Divisi Wajib Diisi."
				},
				email:{
					required: "Email Pengguna Wajib Diisi."
				},
				aktif:{
					required: "Status Pengguna Wajib Diisi."
				},
				blokir:{
					required: "Status Blokir Wajib Diisi."
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
	<a href="?mod=user&act=add"><button type="button" class="btn btn-primary">+ Tambah Pengguna</button></a>
</div>
		<br>		
<table id="example" class="display">
	<thead>
		<tr>
			<th>No</th>
			<th>NIP</th>
			<th>Nama Lengkap</th>
			<th>Level</th>
			<th>Email</th>
			<th>Status</th>
			<th>Blokir</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$no = 1;
	$sql_user = $db->database_prepare("SELECT * FROM as_users A WHERE user_id != 1 ORDER BY nip,nama_lengkap ASC")->execute();
	while ($data_user = $db->database_fetch_array($sql_user)){
		if ($data_user['level'] == 1){
			$level2 = "Administrator";
		}
		elseif ($data_user['level'] == 2){
			$level2 = "Keuangan";
		}
		elseif ($data_user['level'] == 3){
			$level2 = "Perpustakaan";
		}
		elseif ($data_user['level'] == 4){
			$level2 = "BAAK";
		}
		else{
			$level2 = "Owner";
		}
		echo "
		<tr>
			<td>$no</td>
			<td>$data_user[nip]</td>
			<td>$data_user[nama_lengkap]</td>
			<td>$level2</td>
			<td>$data_user[email]</td>
			<td>$data_user[aktif]</td>
			<td>$data_user[blokir]</td>
			<td><a href='?mod=user&act=edit&id=$data_user[user_id]'><img src='../images/edit.jpg' width='20'></a>";
			?>
				<a href="modul/mod_user/aksi_user.php?mod=user&act=delete&id=<?php echo $data_user[user_id];?>" onclick="return confirm('Anda Yakin ingin menghapus pengguna <?php echo $data_user[nama_lengkap];?>?');"><img src='../images/delete.jpg' width='20'></a>
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
?>
	<p>&nbsp;</p>
	<p><a href="?mod=user"><img src="../images/back.png"></a></p>
	<h4>Tambah Pengguna</h4>
	<div class="well">
		<form id="frm_user" action="modul/mod_user/aksi_user.php?mod=user&act=input" method="POST">
		<table width="100%">
			<tr valign="top">
				<td width="50%">
					<label>NIP <font color="red">*</font> <i>Nomor Induk Pegawai</i></label>
						<input type="text" class="required" name="nip" size="40" maxlength="15">
					<label>Nama Lengkap <font color="red">*</font> <i>Nama lengkap pengguna</i></label>
						<input type="text" class="required" name="nama_lengkap" size="40" maxlength="40">
					<label>Nama Panggilan <i>Nama panggilan pengguna</i></label>
						<input type="text" name="nama_panggil" size="40" maxlength="40">
					<label>Alamat</label>
						<textarea name="alamat" cols="40" rows="3"></textarea>
					<label>Jenis Kelamin</label>
						<select name="jenis_kelamin">
							<option value=""></option>
							<option value="L">Laki-Laki</option>
							<option value="P">Perempuan</option>
						</select>
					<label>Email <font color="red">*</font> <i>Akan digunakan sebagai username</i></label>
						<input type="text" name="email" size="40" maxlength="40">
				</td>
				<td>
					<label>Level Divisi Pengguna</label>
						<select name="level" class="required">
							<option value=""></option>
							<option value="1">Administrator</option>
							<option value="2">Keuangan</option>
							<option value="3">Perpustakaan</option>
							<option value="4">Staff BAAK</option>
							<option value="5">Owner</option>
						</select>
					<label>Level Pengguna di Divisi</label>
						<select name="level_jabatan" class="required">
							<option value=""></option>
							<option value="1">Administrator</option>
							<option value="2">Staff</option>
						</select>
					<label>Telepon</label>
						<input type="text" name="telepon" size="40" maxlength="20">
					<label>Handphone</label>
						<input type="text" name="hp" size="40" maxlength="20">
					<label>Aktif</label>
						<select name="aktif">
							<option value=""></option>
							<option value="Y" SELECTED>Aktif</option>
							<option value="N">Tidak Aktif</option>
						</select>
					<label>Blokir</label>
						<select name="blokir">
							<option value=""></option>
							<option value="Y">Ya</option>
							<option value="N" SELECTED>Tidak</option>
						</select>		
				</td>
			</tr>
		</table>
		<br><br>	
		<div>
			<button type="submit" class="btn btn-primary"><i class="icon-save"></i> Simpan</button>
		</div>
		</form>
	</div>
	<?php
	break;
	
	case "edit":
	$data_user = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_users WHERE user_id = ?")->execute($_GET["id"]));
?>	
	<p>&nbsp;</p>
	<p><a href="?mod=user"><img src="../images/back.png"></a></p>
	<h4>Ubah Data Pengguna</h4>
	<div class="well">
		<form id="frm_user" action="modul/mod_user/aksi_user.php?mod=user&act=update" method="POST">
			<input type="hidden" name="id" value="<?php echo $data_user['user_id']; ?>">
			<table width="100%">
				<tr valign="top">
					<td width="50%">
						<label>NIP <font color="red">*</font> <i>Nomor Induk Pegawai</i></label>
							<input type="text" class="required" name="nip" size="40" maxlength="15" value="<?php echo $data_user['nip']; ?>">
						<label>Nama Lengkap <font color="red">*</font> <i>Nama lengkap pengguna</i></label>
							<input type="text" class="required" name="nama_lengkap" size="40" maxlength="40" value="<?php echo $data_user['nama_lengkap']; ?>">
						<label>Nama Panggilan <i>Nama panggilan pengguna</i></label>
							<input type="text" name="nama_panggil" size="40" maxlength="40" value="<?php echo $data_user['nama_panggil']; ?>">
						<label>Alamat</label>
							<textarea name="alamat" cols="40" rows="3"><?php echo $data_user['alamat']; ?></textarea>
						<label>Jenis Kelamin</label>
							<select name="jenis_kelamin">
								<option value=""></option>
								<option value="L" <?php if($data_user['jenis_kelamin'] == 'L'){ echo "SELECTED"; } ?>>Laki-Laki</option>
								<option value="P" <?php if($data_user['jenis_kelamin'] == 'P'){ echo "SELECTED"; } ?>>Perempuan</option>
							</select>
						<label>Email <font color="red">*</font> <i>Akan digunakan sebagai username</i></label>
							<input type="text" name="email" size="40" maxlength="40" value="<?php echo $data_user['email']; ?>">
					</td>
					<td>
						<label>Level Pengguna</label>
							<select name="level" class="required">
								<option value=""></option>
								<option value="1" <?php if($data_user['level'] == '1'){ echo "SELECTED"; } ?>>Administrator</option>
								<option value="2" <?php if($data_user['level'] == '2'){ echo "SELECTED"; } ?>>Keuangan</option>
								<option value="3" <?php if($data_user['level'] == '3'){ echo "SELECTED"; } ?>>Perpustakaan</option>
								<option value="4" <?php if($data_user['level'] == '4'){ echo "SELECTED"; } ?>>Staff BAAK</option>
								<option value="5" <?php if($data_user['level'] == '5'){ echo "SELECTED"; } ?>>Owner</option>
							</select>
						<label>Level Pengguna di Divisi</label>
							<select name="level_jabatan" class="required">
								<option value=""></option>
								<option value="1" <?php if($data_user['level_jabatan'] == '1'){ echo "SELECTED"; } ?>>Administrator</option>
								<option value="2" <?php if($data_user['level_jabatan'] == '2'){ echo "SELECTED"; } ?>>Staff</option>
							</select>
						<label>Telepon</label>
							<input type="text" name="telepon" size="40" maxlength="20" value="<?php echo $data_user['telepon']; ?>">
						<label>Handphone</label>
							<input type="text" name="hp" size="40" maxlength="20" value="<?php echo $data_user['hp']; ?>">
						<label>Aktif</label>
							<select name="aktif">
								<option value=""></option>
								<option value="Y" <?php if($data_user['aktif'] == 'Y'){ echo "SELECTED"; } ?>>Aktif</option>
								<option value="N" <?php if($data_user['aktif'] == 'N'){ echo "SELECTED"; } ?>>Tidak Aktif</option>
							</select>
						<label>Blokir</label>
							<select name="blokir">
								<option value=""></option>
								<option value="Y" <?php if($data_user['blokir'] == 'Y'){ echo "SELECTED"; } ?>>Ya</option>
								<option value="N" <?php if($data_user['blokir'] == 'N'){ echo "SELECTED"; } ?>>Tidak</option>
							</select>				
					</td>
				</tr>
			</table>
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