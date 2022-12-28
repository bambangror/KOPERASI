<?php
// Koneksi ke database MySQL
include_once "library/inc.connection.php";
// Membaca file library
include_once "library/inc.library.php";

# SKRIP TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	// Baca Data dari Form Input
	$txtNama	= $_POST['txtNama'];
	
	// Validasi Form Inputs
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Bagian</b> tidak boleh kosong !";		
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
		$kodeBaru	= buatKode("bagian", "B");
		$mySql	= "INSERT INTO bagian (kd_bagian, nm_bagian)  VALUES('$kodeBaru', '$txtNama')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Bagian-Add'>";
		}
		exit;	
	}
}

// Membuat variabel isi ke form
$dataKode = buatKode("bagian", "B");
$dataNama = isset($_POST['txtNama']) ? $_POST['txtNama'] : ''; 
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
  <table class="table-list"  width="650" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td width="200" bgcolor="#CCCCCC"><strong>TAMBAH DATA BAGIAN</strong> </td>
      <td width="6">&nbsp;</td>
      <td width="425">&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Kode</strong></td>
      <td><strong>:</strong></td>
      <td><input name="textfield" type="text" value="<?php echo $dataKode; ?>" size="10" maxlength="4" /></td>
    </tr>
    <tr>
      <td><strong>Nama Bagian </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNama" type="text" id="txtNama" value="<?php echo $dataNama; ?>" size="60" maxlength="100" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnSimpan" type="submit" id="btnSimpan" value="Simpan" /></td>
    </tr>
  </table>
</form>
