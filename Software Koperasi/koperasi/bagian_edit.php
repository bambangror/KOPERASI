<?php
// Koneksi ke database MySQL
include_once "library/inc.connection.php";
// Membaca file library
include_once "library/inc.library.php";

# SKRIP TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	// Baca Data dari Form Input
	$txtNama	= $_POST['txtNama'];
	  
	// Validasi Form Input
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
	   
		$txtKode= $_POST['txtKode'];
		$mySql  = "UPDATE bagian SET nm_bagian='$txtNama' WHERE kd_bagian ='$txtKode'";

		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Bagian-Data'>"; 
		}
		exit;	
	}
}

# MEMBACA DATA DARI DATABASE UNTUK DIEDIT
$Kode	 = $_GET['Kode']; 
$mySql	 = "SELECT * FROM bagian WHERE kd_bagian='$Kode'";
$myQry	 = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
$myData	 = mysql_fetch_array($myQry); 

	// Membuat variabel isi ke form
	$dataKode	= $myData['kd_bagian'];
	$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_bagian'];
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
  <table class="table-list" width="650" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td bgcolor="#CCCCCC"><strong>UBAH  DATA BAGIAN </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="183"><strong>Kode</strong></td>
      <td width="6"><strong>:</strong></td>
      <td width="439"><input name="textfield" type="text" value="<?php echo $dataKode; ?>" size="10" maxlength="4" />
      <input name="txtKode" type="hidden" id="txtKode" value="<?php echo $dataKode; ?>" /></td>
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
