<?php
error_reporting(0);
session_start();
include "../../../config/class_database.php";
include "../../../config/serverconfig.php";
include "../../../config/debug.php";
include "../../../fungsi/fungsi_date.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])){
	header("Location: ../../../login.php?code=2");
}

else{
	require ("../../../fungsi/html2pdf/html2pdf.class.php");
	$filename="khs.pdf";
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	$date_now = tgl_indo($now);
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_mahasiswa A INNER JOIN mspst B ON A.kode_program_studi=B.IDPSTMSPST
										INNER JOIN as_kelas_mahasiswa C ON C.id_mhs=A.id_mhs
										INNER JOIN as_kelas D ON D.kelas_id=C.kelas_id
										WHERE A.id_mhs = ?")->execute($_GET['id']));
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
	
	$tanggal_lahir = tgl_indo($data_mhs['tanggal_lahir']);
	$content = "
				<table>
					<tr valign='top'>
						<td><img src='http://siakad.sekolahumarusman.com/logo-umar-usman.jpg' height='50'></td>
						<td width='10'></td>
						<td>
							<b>Sekolah Tinggi Umar Usman</b><br>
							Philanthropy Building<br>
							Jl. Buncit Raya Ujung No. 18 Jakarta Selatan - Indonesia 12540<br>
							Telp. (021) 7884 5924/25, 085 888 53 8899, Fax. (021) 7884 5926
						</td>
					</tr>
					<tr>
						<td colspan='3'><hr></td>
					</tr>
					<tr>
						<td colspan='3' align='center'><br><p><b><u>Kartu Hasil Studi (KHS)</u></b></p></td>
					</tr>
					<tr>
						<td colspan='3'><p>&nbsp;</p></td>
					</tr>
				</table>
				<table>
					<tr>
						<td width='50'>NIM</td>
						<td width='5'>:</td>
						<td><b>$data_mhs[NIM]</b></td>
					</tr>
					<tr>
						<td>Nama Mahasiswa</td>
						<td>:</td>
						<td><b>$data_mhs[nama_mahasiswa]</b></td>
					</tr>
					<tr>
						<td>Tempat/Tanggal Lahir</td>
						<td>:</td>
						<td><b>$data_mhs[tempat_lahir], $tanggal_lahir</b></td>
					</tr>
					<tr>
						<td>Program Studi</td>
						<td>:</td>
						<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST]</b></td>
					</tr>
					<tr>
						<td>Kelas/Semester</td>
						<td>:</td>
						<td><b>$data_mhs[nama_kelas] - $data_mhs[semester] / $_GET[semester]</b></td>
					</tr>
				</table>	<br>
				<table cellpadding=0 border='0' cellspacing=0>
					<tr>
						<th width='15' rowspan='2' style='border: 1px solid #000; padding: 5px;font-size: 11.5px; background-color:#9CCC68;'>No.</th>
						<th rowspan='2' align='center' width='100' style='border: 1px solid #000; padding: 5px;font-size: 11.5px; background-color:#9CCC68;'>Kode Matakuliah</th>
						<th rowspan='2' align='center' width='200' style='border: 1px solid #000; padding: 5px;font-size: 11.5px; background-color:#9CCC68;'>Mata Kuliah</th>
						<th rowspan='2' align='center' width='40' style='border: 1px solid #000; padding: 5px;font-size: 11.5px; background-color:#9CCC68;'>SKS</th>
						<th colspan='2' style='border: 1px solid #000; padding: 5px;font-size: 11.5px; background-color:#9CCC68;' align='center'>NILAI</th>
						<th width='50' align='center' rowspan='2' style='border: 1px solid #000; padding: 5px;font-size: 11.5px; background-color:#9CCC68;'>Jumlah</th>
					</tr>
					<tr>
						<th align='center' width='50' style='border: 1px solid #000; padding: 5px;font-size: 11.5px; background-color:#9CCC68;'>Huruf</th>
						<th align='center' width='50' style='border: 1px solid #000; padding: 5px;font-size: 11.5px; background-color:#9CCC68;'>Bobot</th>
					</tr>
			";
			$i = 1;
			$sql_sql = $db->database_prepare("SELECT B.sks_mata_kuliah, B.kode_mata_kuliah, B.nama_mata_kuliah_eng, C.semester, A.uts, A.uas, A.total, A.mutu, A.bobot 
													FROM as_nilai_semester_mhs A INNER JOIN as_makul B ON B.mata_kuliah_id=A.makul_id
													INNER JOIN as_jadwal_kuliah C ON C.makul_id=B.mata_kuliah_id WHERE A.id_mhs = ?
													AND A.semester_nilai = ?
													GROUP BY A.makul_id")->execute($_GET["id"],$_GET["semester"]);
			while ($data_nilai = $db->database_fetch_array($sql_sql)){
				$total_bobot = $data_nilai['sks_mata_kuliah'] * $data_data['bobot'];
				$content .= "<tr>
							<td style='border: 1px solid #000;padding: 5px; font-size: 11.5px;'>$i</td>
							<td style='border: 1px solid #000;padding: 5px; font-size: 11.5px;'>$data_nilai[kode_mata_kuliah]</td>
							<td style='border: 1px solid #000;padding: 5px; font-size: 11.5px;'>$data_nilai[nama_mata_kuliah_eng]</td>
							<td style='border: 1px solid #000;padding: 5px; font-size: 11.5px;' align='center'>$data_nilai[sks_mata_kuliah]</td>
							<td style='border: 1px solid #000;padding: 5px; font-size: 11.5px;' align='center'>$data_nilai[mutu]</td>
							<td style='border: 1px solid #000;padding: 5px; font-size: 11.5px;' align='center'>$data_data[bobot]</td>
							<td style='border: 1px solid #000;padding: 5px; font-size: 11.5px;' align='center'>$total_bobot</td>
						</tr>";
				$grand_sks += $data_nilai['sks_mata_kuliah'];
				$grand_bobot += $total_bobot;
				$i++;
			}				
			$ipk = number_format($grand_bobot / $grand_sks, 2);
			$content .= "
					</table>
					<br>
					<table>
						<tr>
							<td width='160'>Jumlah SKS</td>
							<td>: <b>$grand_sks SKS</b></td>
						</tr>
						<tr>
							<td>Jumlah (SKS x Nilai)</td>
							<td>: <b>$grand_bobot</b></td>
						</tr>
						<tr>
							<td>Indeks prestasi kumulatif</td>
							<td>: <b>$ipk</b></td>
						</tr>
					</table>
					<table>
						<tr>
							<td width='400'></td>
							<td align='center'>Jakarta, $date_now<br><br>
							Sekolah Tinggi Umar Usman<br>
							Wakil Ketua Akademik<br>
								<p>&nbsp;</p><p>&nbsp;</p>
								Akhmad Basori, S.E., M.Si.
							</td>
						</tr>
					</table>
					";	
			
			
	// conversion HTML => PDF
	try
	{
		$html2pdf = new HTML2PDF('P','A4','fr', false, 'ISO-8859-15',array(10, 10, 10, 10)); //setting ukuran kertas dan margin pada dokumen anda
		// $html2pdf->setModeDebug();
		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output($filename);
	}
	catch(HTML2PDF_exception $e) { echo $e; }
}
?>