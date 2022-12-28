<?php
// Periksa Login
include_once "library/inc.seslogin.php"; 

// Koneksi ke database MySQL
include_once "library/inc.connection.php";
// Membaca file library
include_once "library/inc.library.php";

# SKRIP TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	// Baca Data dari Form Input
	$txtNama		= $_POST['txtNama'];
	$txtNIP			= $_POST['txtNIP'];
	$cmbKelamin		= $_POST['cmbKelamin'];
	$cmbAgama		= $_POST['cmbAgama'];
	$txtAlamat		= $_POST['txtAlamat'];
	$txtNoTelepon	= $_POST['txtNoTelepon'];
	$cmbBagian		= $_POST['cmbBagian'];
	$txtUsername	= $_POST['txtUsername'];
	$txtPassword	= $_POST['txtPassword'];
	$cmbLevel		= $_POST['cmbLevel'];
		
	$txtTempatLhr	= $_POST['txtTempatLhr'];
	$cmbTanggalLhr	= $_POST['cmbTanggalLhr'];
	$cmbBulanLhr	= $_POST['cmbBulanLhr'];
	$cmbTahunLhr	= $_POST['cmbTahunLhr'];
	
	// Validasi Form Input
	$pesanError = array();
	if (trim($txtNIP)=="") {
		$pesanError[] = "Data <b>NIP</b> tidak boleh kosong !";		
	}
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Pegawai</b> tidak boleh kosong !";		
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
	if (trim($cmbBagian)=="Kosong") {
		$pesanError[] = "Data <b>Bagian</b> belum ada yang dipilih !";
	}
	if (trim($txtUsername)=="") {
		$pesanError[] = "Data <b>Username</b> tidak boleh kosong !";		
	}
	if (trim($txtPassword)=="") {
		$pesanError[] = "Data <b>Password</b> tidak boleh kosong !";		
	}
	
	// Menampilkan Pesan Error dari Form
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
		// Skrip Simpan data ke Database
		$kodeBaru	= buatKode("pegawai", "P");
		
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
			copy($_FILES['txtNamaFile']['tmp_name'],"foto/pegawai/".$nama_file);
		}
		else {
			// Jika file foto tidak dipilih, maka simpan data kosong
			$nama_file = "";
		}

		// Skrip simpan data ke database
		$mySql	= "INSERT INTO pegawai (kd_pegawai, nm_pegawai, nip, kelamin, agama,
				 tempat_lahir, tanggal_lahir, alamat, no_telepon, foto, kd_bagian, login_username, login_password, login_level) 
		VALUES ('$kodeBaru', '$txtNama', '$txtNIP', '$cmbKelamin', '$cmbAgama', 
			'$txtTempatLhr', '$tanggalLahir', '$txtAlamat', '$txtNoTelepon', '$nama_file', '$cmbBagian', '$txtUsername', MD5('$txtPassword'), '$cmbLevel')";

		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Pegawai-Add'>";
		}
		exit;	
	}	
}
 
// Membuat variabel isi ke form
$dataKode 		= buatKode("pegawai", "P");
$dataNIP 		= isset($_POST['txtNIP']) ? $_POST['txtNIP'] : '';
$dataNama 		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataKelamin	= isset($_POST['cmbKelamin']) ? $_POST['cmbKelamin'] : '';
$dataAgama		= isset($_POST['cmbAgama']) ? $_POST['cmbAgama'] : '';
$dataTempatLhr 	= isset($_POST['txtTempatLhr']) ? $_POST['txtTempatLhr'] : '';
$dataTanggalLhr	= isset($_POST['cmbTanggalLhr']) ? $_POST['cmbTanggalLhr'] : '';
$dataBulanLhr	= isset($_POST['cmbBulanLhr']) ? $_POST['cmbBulanLhr'] : '';
$dataTahunLhr	= isset($_POST['cmbTahunLhr']) ? $_POST['cmbTahunLhr'] : '';
$dataAlamat 	= isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : '';
$dataNoTelepon 	= isset($_POST['txtNoTelepon']) ? $_POST['txtNoTelepon'] : '';
$dataBagian 	= isset($_POST['cmbBagian']) ? $_POST['cmbBagian'] : '';
$dataUsername	= isset($_POST['txtUsername']) ? $_POST['txtUsername'] : '';
$dataLevel		= isset($_POST['cmbLevel']) ? $_POST['cmbLevel'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="form1" target="_self" id="form1">
  <table class="table-list" width="700" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td bgcolor="#CCCCCC"><strong>TAMBAH DATA PEGAWAI </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="198"><strong>Kode</strong></td>
      <td width="6"><strong>:</strong></td>
      <td width="475"><input name="textfield" type="text" value="<?php echo $dataKode; ?>" size="10" maxlength="4" /></td>
    </tr>
    <tr>
      <td><strong>NIP</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNIP" type="text" id="txtNIP" value="<?php echo $dataNIP; ?>" size="10" maxlength="10" /></td>
    </tr>
    <tr>
      <td><strong>Nama Pegawai </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNama" type="text" id="txtNama" value="<?php echo $dataNama; ?>" size="60" maxlength="100" /></td>
    </tr>
    <tr>
      <td><strong>Kelamin</strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbKelamin">
	  <option value="Kosong">....</option>
	  <?php
	  $pilihan = array("L"=> "Laki-laki (L)", "P" => "Perempuan (P)");
	  foreach ($pilihan as  $indeks => $nilai) {
		if ($dataKelamin==$indeks) {
			$cek=" selected";
		} else { $cek = ""; }
		echo "<option value='$indeks' $cek>$nilai</option>";
	  }
	  ?>
	</select>      </td>
    </tr>
    <tr>
      <td><strong>Agama</strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbAgama">
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
	</select>	</td>
    </tr>
    <tr>
      <td><strong>Tempat &amp; Tgl. Lahir </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTempatLhr" type="text" id="txtTempatLhr" value="<?php echo $dataTempatLhr; ?>" size="30" maxlength="100" /> , 
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
	</select> -
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
	- 
	<select name="cmbTahunLhr">
	  <option value="Kosong">....</option>
	  <?php
		$thmuda	= date('Y') - 45;
		$thtua	= date('Y') - 10;
	  for($tahun = $thmuda; $tahun <= $thtua; $tahun++) {
		// Skrip tahun terpilih
		if ($tahun == $dataTahunLhr) {  $cek=" selected"; } else { $cek = ""; }
		
		echo "<option value='$tahun' $cek> $tahun </option>";
	  }
	  ?>
	</select> </td>
    </tr>
    <tr>
      <td><strong>Alamat</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtAlamat" type="text" id="txtAlamat" value="<?php echo $dataAlamat; ?>" size="60" maxlength="100" /></td>
    </tr>
    <tr>
      <td><strong>No. Telepon </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNoTelepon" type="text" id="txtNoTelepon" value="<?php echo $dataNoTelepon; ?>" size="25" maxlength="20" /></td>
    </tr>
    <tr>
      <td><strong>Foto</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNamaFile" type="file" id="txtNamaFile" size="40" maxlength="200" /></td>
    </tr>
    <tr>
      <td><strong>Bagian</strong></td>
      <td>:</td>
      <td><select name="cmbBagian">
          <option value="Kosong">....</option>
          <?php
		// Skrip menampilkan data Bagian ke dalam List/Menu 
		$bacaSql = "SELECT * FROM bagian ORDER BY kd_bagian";
		$bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
		while ($bacaData = mysql_fetch_array($bacaQry)) {
			if ($bacaData['kd_bagian'] == $dataBagian) {
				$cek = " selected";
			} else { $cek=""; }
			
			echo "<option value='$bacaData[kd_bagian]' $cek> $bacaData[nm_bagian] </option>";
		}
		?>
		 </select> </td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>LOGIN</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Username</strong></td>
      <td>:</td>
      <td><input name="txtUsername" type="text" id="txtUsername" value="<?php echo $dataUsername; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td><strong>Password</strong></td>
      <td>:</td>
      <td><input name="txtPassword" type="password" id="txtPassword" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td><strong>Level</strong></td>
      <td>:</td>
      <td><select name="cmbLevel">
          <?php
	  $pilihan	= array("Kasir", "Admin");
	  foreach ($pilihan as  $nilai) {
		if ($dataLevel == $nilai) {
			$cek=" selected";
		} else { $cek = ""; }
		echo "<option value='$nilai' $cek> $nilai</option>";
	  }
	  ?>
        </select>      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnSimpan" type="submit" id="btnSimpan" value="Simpan" /></td>
    </tr>
  </table>
</form>
