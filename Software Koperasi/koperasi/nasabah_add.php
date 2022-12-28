<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

# SKRIP TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Data dari Form Input
	$txtNama		= $_POST['txtNama'];
	$cmbKelamin		= $_POST['cmbKelamin'];
	$cmbAgama		= $_POST['cmbAgama'];
	$txtAlamat		= $_POST['txtAlamat'];
	$txtNoTelepon	= $_POST['txtNoTelepon'];
	$cmbStatus		= $_POST['cmbStatus'];
	$txtNmPasangan	= $_POST['txtNmPasangan'];
	$txtNmPekerjaan	= $_POST['txtNmPekerjaan'];
	
	$txtTempatLhr	= $_POST['txtTempatLhr'];
	$cmbTanggalLhr	= $_POST['cmbTanggalLhr'];
	$cmbBulanLhr	= $_POST['cmbBulanLhr'];
	$cmbTahunLhr	= $_POST['cmbTahunLhr'];
 
   # Validasi Form Input 
	// Validasi Form Input
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Nasabah</b> tidak boleh kosong !";		
	}
	if (trim($cmbKelamin)=="Kosong") {
		$pesanError[] = "Data <b>Kelamin</b> belum ada yang dipilih !";		
	}
	if (trim($cmbAgama)=="Kosong") {
		$pesanError[] = "Data <b>Agama</b> belum ada yang dipilih !";		
	}
	if (trim($txtTempatLhr)=="") {
		$pesanError[] = "Data <b>Tempat Lahir</b> tidak boleh kosong !";		
	}
	if (trim($cmbTanggalLhr)=="Kosong") {
		$pesanError[] = "Data <b>Tanggal. Lahir</b> belum ada yang dipilih !";		
	}
	if (trim($cmbBulanLhr)=="Kosong") {
		$pesanError[] = "Data <b>Bulan. Lahir</b> belum ada yang dipilih !";		
	}
	if (trim($cmbTahunLhr)=="Kosong") {
		$pesanError[] = "Data <b>Tahun. Lahir</b> belum ada yang dipilih !";		
	}
	if (trim($txtAlamat)=="") {
		$pesanError[] = "Data <b>Alamat</b> tidak boleh kosong !";	
	}
	if (trim($txtNoTelepon)=="") {
		$pesanError[] = "Data <b>No. Telepon</b> tidak boleh kosong!";
	}
	if (trim($cmbStatus)=="Kosong") {
		$pesanError[] = "Data <b>Status Kawin</b> tidak boleh kosong!";
	}
	if (trim($txtNmPasangan)=="") {
		$pesanError[] = "Data <b>Nama Pasangan (Suami/ Istri)</b> tidak boleh kosong !";	
	}
	if (trim($txtNmPekerjaan)=="") {
		$pesanError[] = "Data <b>Jenis Pekerjaan</b> tidak boleh kosong !";	
	}
	
	
	#// Menampilkan Pesan Error dari Form
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		// SKRIP SIMPAN DATA KE DATABASE
		$kodeBaru	= buatKode("nasabah", "NS");
		
		// Menyusun Tanggal (Y-m-d)
		$tanggalLahir	= $cmbTahunLhr."-".$cmbBulanLhr."-".$cmbTanggalLhr;
		
		# Skrip Upload file gambar
		if (! empty($_FILES['txtNamaFile']['tmp_name'])) {
			// Jika file foto tidak kosong (ada foto yang dipilih)
			$nama_file = $_FILES['txtNamaFile']['name'];
			$nama_file = stripslashes($nama_file);
			$nama_file = str_replace("'","",$nama_file);
			
			// Proses kopi foto (menyimpan) ke folder
			$nama_file = $kodeBaru.".".$nama_file;
			copy($_FILES['txtNamaFile']['tmp_name'],"foto/nasabah/ ".$nama_file);
		}
		else {
			// Jika file foto tidak dipilih, maka simpan data kosong
			$nama_file = "";
		}

		// Skrip simpan data ke database
		$mySql	= "INSERT INTO nasabah (no_nasabah, nm_nasabah, kelamin, agama,
				 tempat_lahir, tanggal_lahir, alamat, no_telepon, foto, status_kawin, nama_pasangan, jenis_pekerjaan) 
		VALUES ('$kodeBaru', '$txtNama', '$cmbKelamin', '$cmbAgama', 
			'$txtTempatLhr', '$tanggalLahir', '$txtAlamat', '$txtNoTelepon', '$nama_file', '$cmbStatus', '$txtNmPasangan', '$txtNmPekerjaan')";

		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Nasabah-Add'>";
		}
		exit;	
	}	
}


// Membuat variabel isi ke form
$dataKode 		= buatKode("nasabah", "NS");
$dataNama 		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataKelamin	= isset($_POST['cmbKelamin']) ? $_POST['cmbKelamin'] : '';
$dataAgama		= isset($_POST['cmbAgama']) ? $_POST['cmbAgama'] : '';
$dataTempatLhr  = isset($_POST['txtTempatLhr']) ? $_POST['txtTempatLhr'] : '';
$dataTanggalLhr = isset($_POST['cmbTanggalLhr']) ? $_POST['cmbTanggalLhr'] : '';
$dataBulanLhr	= isset($_POST['cmbBulanLhr']) ? $_POST['cmbBulanLhr'] : '';
$dataTahunLhr	= isset($_POST['cmbTahunLhr']) ? $_POST['cmbTahunLhr'] : '';
$dataAlamat 	= isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : '';
$dataNoTelepon 	= isset($_POST['txtNoTelepon']) ? $_POST['txtNoTelepon'] : '';

$dataStatus		= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : '';
$dataPasangan	= isset($_POST['txtNmPasangan']) ? $_POST['txtNmPasangan'] : '';
$dataPekerjaan	= isset($_POST['txtNmPekerjaan']) ? $_POST['txtNmPekerjaan'] : '';
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="form1" target="_self">
  <table class="table-list" width="700" border="0" cellspacing="2" cellpadding="3">
    <tr>
      <td width="212" bgcolor="#CCCCCC"><strong>TAMBAH DATA NASABAH </strong></td>
      <td width="6">&nbsp;</td>
      <td width="456">&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Kode</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKode" type="text" id="txtKode" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly="readonly" ></td>
    </tr>
    <tr>
      <td><strong>Nama Nasabah </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNama" type="text" id="txtNama" value="<?php echo $dataNama; ?>" size="60" maxlength="100"></td>
    </tr>
    <tr>
      <td><strong>Kelamin (L/P) </strong></td>
      <td><strong>:</strong></td>
      <td> 
	  
	    <select name="cmbKelamin">
		<option value="Kosong">....</option>
		<?php
		$pilihan = array("L"=> "Laki-laki(L)", "P" => "Perempuan(P)");
		foreach ($pilihan as  $indeks => $nilai) {
		if ($dataKelamin==$indeks) {
			$cek=" selected";
		} else { $cek = ""; }
		echo "<option value='$indeks' $cek>$nilai</option>";
		}
		?>
	  </select> </td>
    </tr>
    <tr>
      <td><strong>Agama</strong></td>
      <td><strong>:</strong></td>
      <td>
	  <select name="cmbAgama">
		<option value="Kosong">....</option>
		<?php
		  $pilihan = array("Islam", "Kristen", "Katolik", "Hindu", "Budha");
		  foreach ($pilihan as  $nilai) {
			if ($dataAgama==$nilai) {
				$cek=" selected";
			} else { $cek = ""; }
			echo "<option value='$nilai' $cek> $nilai</option>";
		  }
		  ?>
		</select></td>
    </tr>
    <tr>
      <td><strong>Tempat &amp; Tanggal Lahir </strong></td>
      <td><strong>:</strong></td>
      <td><label>
        <input name="txtTempatLhr" type="text" id="txtTempatLhr" value="<?php echo $dataTempatLhr; ?>" size="30" maxlength="100">, 
		<select name="cmbTanggalLhr">
		  <option value="Kosong">....</option>
		  <?php
		  for($tanggal = 1; $tanggal <= 31; $tanggal++) {
			// Skrip membuat angka 2 digit (1-9)
			if($tanggal < 10) { $tggl = "0".$tanggal;} else { $tggl = $tanggal; }
			
			// Skrip tanggal terpilih
			if($tggl == $dataTanggalLhr) { $cek=" selected"; } else { $cek = ""; }
			
			echo "<option value='$tggl' $cek> $tggl </option>";
		  }
		  ?>
		</select>

        <select name="cmbBulanLhr">
		<option value="Kosong">....</option>
		<?php
		for($bulan = 1; $bulan <= 12; $bulan++) {
		// Skrip membuat angka 2 digit (1-9)
		if($bulan < 10) { $bln = "0".$bulan; } else { $bln = $bulan; }
		
		if ($bln == $dataBulanLhr) { $cek=" selected"; } else { $cek = ""; }
		
		echo "<option value='$bln' $cek> $listBulan[$bln] </option>";
		}
		?>
		</select>

		<select name="cmbTahunLhr">
		  <option value="Kosong">....</option>
		  <?php
			$thmuda	= date('Y') - 60;
			$thtua	= date('Y') - 10;
		  for($tahun = $thmuda; $tahun <= $thtua; $tahun++) {
			// Skrip tahun terpilih
			if ($tahun == $dataTahunLhr) {  $cek=" selected"; } else { $cek = ""; }
			
			echo "<option value='$tahun' $cek> $tahun </option>";
		  }
		  ?>
		</select>

</label></td>
    </tr>
    <tr>
      <td><strong>Alamat</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtAlamat" type="text" id="txtAlamat" value="<?php echo $dataAlamat; ?>" size="60" maxlength="100"></td>
    </tr>
    <tr>
      <td><strong>No. Telepon </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNoTelepon" type="text" id="txtNoTelepon" value="<?php echo $dataNoTelepon; ?>" size="25" maxlength="20"></td>
    </tr>
    <tr>
      <td><strong>Foto</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNamaFile" type="file" id="txtNamaFile" size="60" maxlength="200"></td>
    </tr>
    <tr>
      <td><strong>Status Kawin </strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbStatus" id="cmbStatus">
        <option value="Kosong">....</option>
        <?php
		  $pilihan = array("Kawin", "Belum Kawin");
		  foreach ($pilihan as  $nilai) {
			if ($dataStatus==$nilai) {
				$cek=" selected";
			} else { $cek = ""; }
			echo "<option value='$nilai' $cek> $nilai</option>";
		  }
		  ?>
      </select></td>
    </tr>
    <tr>
      <td><strong>Nama Pasangan (Suami/ Istri) </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNmPasangan" type="text" id="txtNmPasangan" value="<?php echo $dataPasangan; ?>" size="60" maxlength="100"></td>
    </tr>
    <tr>
      <td><strong>Jenis/ Nama Pekerjaan </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNmPekerjaan" type="text" id="txtNmPekerjaan" value="<?php echo $dataPekerjaan; ?>" size="60" maxlength="100"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnSimpan" type="submit" id="btnSimpan" value=" Simpan "></td>
    </tr>
  </table>
</form>
