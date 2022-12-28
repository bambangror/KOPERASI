<?php
// Koneksi ke database MySQL
include_once "library/inc.connection.php";
// Membaca file library
include_once "library/inc.library.php";

 
# SKRIP TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	// Baca Data dari Form Input
	$txtNama		= $_POST['txtNama'];
	$txtKeterangan	= $_POST['txtKeterangan'];
	$txtBunga		= $_POST['txtBunga'];

	// Validasi Form Inputs
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Jenis Pinjaman</b> tidak boleh kosong !";		
	}
	if (trim($txtKeterangan)=="") {
		$pesanError[] = "Data <b>Keterangan</b> tidak boleh kosong !";		
	}
	if (trim($txtBunga)=="" or ! is_numeric(trim($txtBunga))) {
		$pesanError[] = "Data <b>Bunga (%) </b> tidak boleh kosong, harus diisi angka!";		
	}

	# MENAMPILKAN PESAN ERROR
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
	   # // Skrip Simpan data ke Database 
		$kodeBaru	= buatKode("jenis_pinjaman", "JP");
		$mySql	= "INSERT INTO jenis_pinjaman (kd_jpinjaman, nm_jpinjaman, keterangan, bunga) 
					 VALUES('$kodeBaru', '$txtNama', '$txtKeterangan', '$txtBunga')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Jenis-Pinjaman-Data'>";
		}
		exit;	
	}
}

# VARIABEL DATA FORM
// Variabel Kode Otomatis dari database
$dataKode 	= buatKode("jenis_pinjaman", "JP");

// Variabel Form
$dataNama 	= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataBunga	= isset($_POST['txtBunga']) ? $_POST['txtBunga'] : '';

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Tambah Jenis Pinjaman</title>
</head>

<body>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table  class="table-list" width="650" border="0" cellspacing="2" cellpadding="3">
    <tr>
      <td colspan="3"><strong>TAMBAH JENIS PINJAMAN </strong></td>
    </tr>
    <tr>
      <td width="132"><strong>Kode</strong></td>
      <td width="3"><strong>:</strong></td>
      <td width="489"><input name="txtKode" type="text" id="txtKode" value="<?php echo $dataKode; ?>" size="6" maxlength="6"></td>
    </tr>
    <tr>
      <td><strong>Jenis Pinjaman </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNama" type="text" id="txtNama" value="<?php echo $dataNama; ?>" size="70" maxlength="80"></td>
    </tr>
    <tr>
      <td><strong>Keterangan</strong></td>
      <td><strong>:</strong></td>
      <td><textarea name="txtKeterangan" cols="50" rows="2" id="txtKeterangan"><?php echo $dataKeterangan; ?></textarea></td>
    </tr>
    <tr>
      <td><strong>Bunga (%) </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtBunga" type="text" id="txtBunga" value="<?php echo $dataBunga; ?>" size="6" maxlength="4"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnSimpan" type="submit" id="btnSimpan" value="Simpan"></td>
    </tr>
  </table>
</form>
</body>
</html>
