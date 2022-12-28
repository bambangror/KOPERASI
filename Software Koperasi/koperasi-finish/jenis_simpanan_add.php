<?php
// Periksa Login
include_once "library/inc.seslogin.php"; 

// Koneksi ke database MySQL
include_once "library/inc.connection.php";

// Membaca file library
include_once "library/inc.library.php";

// Variabel Kode Otomatis dari database
$dataKode 	= buatKode("jenis_simpanan", "JS");

// Variabel Form
$dataNama 	= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataBunga	= isset($_POST['txtBunga']) ? $_POST['txtBunga'] : '';

# SKRIP TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	// Baca Data dari Form Input
	$txtNama		= $_POST['txtNama'];
	$txtBunga		= $_POST['txtBunga'];

	// Validasi Form Inputs
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b> Jenis Simpanan</b> tidak boleh kosong !";		
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
		$kodeBaru	= buatKode("jenis_simpanan", "JS");
		$mySql	= "INSERT INTO jenis_simpanan (kd_jsimpanan, nm_jsimpanan, bunga) 
						 VALUES('$kodeBaru', '$txtNama', '$txtBunga')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Jenis-Simpanan-Data'>";
		}
		exit;	

	}	
}

# VARIABEL DATA FORM
// Variabel Kode Otomatis dari database
$dataKode 	= buatKode("jenis_simpanan", "JS");

// Variabel Form
$dataNama 	= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataBunga	= isset($_POST['txtBunga']) ? $_POST['txtBunga'] : '';
?>

<html>
<head>
<title>Tambah Data Jenis Simpanan</title>
</head>
<body>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table class="table-list" width="650" border="0" cellspacing="2" cellpadding="3">
    <tr>
      <td bgcolor="#CCCCCC"> <strong>TAMBAH  JENIS SIMPANAN</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="183"><strong>Kode</strong></td>
      <td width="6"><strong>:</strong></td>
      <td width="435"><input name="txtKode" type="text"  value="<?php echo $dataKode; ?>" size="10" maxlength="4" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><strong>Jenis Simpanan </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNama" type="text" value="<?php echo $dataNama; ?>" size="70" maxlength="100"></td>
    </tr>
    <tr>
      <td><strong>Bunga (%) </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtBunga" type="text" value="<?php echo $dataBunga; ?>" size="4" maxlength="4"></td>
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
