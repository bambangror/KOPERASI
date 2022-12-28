<?php
include_once "../library/inc.seslogin.php"; 
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php"; 

// Membaca User yang Login
$userLogin	= $_SESSION['SES_LOGIN'];

# ========================================================================================================
# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if(isset($_POST['btnSimpan'])){
	// Baca variabel data form
	$txtTanggal 		= InggrisTgl($_POST['txtTanggal']);
	$txtKodeNas			= $_POST['txtKodeNas'];
	$cmbJenis			= $_POST['cmbJenis'];
	$txtKeterangan		= $_POST['txtKeterangan'];
	$txtBesarSimpanan	= $_POST['txtBesarSimpanan'];
	
	// Skrip Validasi form
	$pesanError = array();
	if (trim($txtTanggal)=="--") {
		$pesanError[] = "Data <b>Tanggal Simpanan</b> belum diisi, silahkan pilih pada kalender !";		
	}
	if (trim($txtKodeNas)=="") {
	$pesanError[] = "Data <b>Nasabah</b> belum dipilih, silahkan pilih dari Pencarian !";			
	}
	if (trim($cmbJenis)=="Kosong") {
	$pesanError[] = "Data <b>Jenis Simpanan</b> belum dipilih, silahkan pilih pada Combo !";		
	}
	if (trim($txtBesarSimpanan)=="" or ! is_numeric(trim($txtBesarSimpanan))) {
	$pesanError[] = "Data <b>Besar Simpanan (Rp)</b> masih kosong, harus diisi angka !";
	}
			
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# SIMPAN KE DATABASE
		// Jika jumlah error pesanError tidak ada, maka proses Penyimpanan akan dikalkukan
		
	// Membuat kode Transaksi baru
	$kodeSimpanan = buatKode("simpanan", "SN");
					
	// Skrip menyimpan data ke tabel Simpanan 
	$mySql	= "INSERT INTO simpanan(no_simpanan, tgl_simpanan, no_nasabah, kd_jsimpanan,  keterangan, kd_pegawai) 
				VALUES ('$kodeSimpanan', '$txtTanggal',  '$txtKodeNas', '$cmbJenis',  '$txtKeterangan', '$userLogin')";
	$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query simpanan 1 ".mysql_error());
	if($myQry) {
		$kodeTransaksi = buatKode("simpanan_transaksi", "ST");
		// Skrip menyimpan data ke tabel transaksi utama
		// Jika ada Nasabah menabung, berarti Bank (Koperasi) mendapatkan Dana Kredit, maka masuk ke dalam kolom nilai_kredit
		// Jika ada Nasabah mengambil uang tabungannya, maka Bank melakukan pengurangan Debit, maka masuk ke dalam nilai_debit
		$my2Sql	= "INSERT INTO simpanan_transaksi(no_transaksi, tgl_transaksi, no_simpanan, debit, kredit, keterangan, kd_pegawai) 
					VALUES ('$kodeTransaksi', '$txtTanggal',  '$kodeSimpanan', '0', '$txtBesarSimpanan', 'Tabungan pertama', '$userLogin')";
		mysql_query($my2Sql, $koneksidb) or die ("Gagal query simpanan 2 ".mysql_error());
	}
		
	// Refresh halaman
	echo "<meta http-equiv='refresh' content='0; url=?open=Simpanan-Baru'>";
	
	// Cetak nota simpanan
	echo "<script>";
	echo "window.open('simpanan_cetak.php?Kode=$kodeSimpanan')";
	echo "</script>";
	}	
}

# VARIABEL DATA DARI & UNTUK FORM
$noTransaksi 	= buatKode("simpanan", "SN");
$dataTanggal 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataJenis		= isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : '';
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';

$dataKodeNas	= isset($_POST['txtKodeNas']) ? $_POST['txtKodeNas'] : '';

$dataBesarSimpanan	= isset($_POST['txtBesarSimpanan']) ? $_POST['txtBesarSimpanan'] : '';

# JIKA TOMBOL CARI NASABAH DIKLIK
$dataNamaNas	= "";
$my2Sql	= "SELECT * FROM nasabah WHERE no_nasabah='$dataKodeNas'";
$my2Qry	= mysql_query($my2Sql, $koneksidb) or die ("Gagal query $my2Sql".mysql_error());
if(mysql_num_rows($my2Qry) >=1) {
	$my2Data		= mysql_fetch_array($my2Qry);
	$dataNamaNas	= $my2Data['nm_nasabah'];
}
else {
	$dataNamaNas	= "";
}
?>

<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT> 

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
<h1> PEMBUKAAN SIMPANAN BARU </h1>
  <table width="800" cellspacing="1"  class="table-list">
    <tr>
      <td bgcolor="#CCCCCC"><strong>DATA SIMPANAN </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="19%"><strong>No. Simpanan </strong></td>
      <td width="1%"><strong>:</strong></td>
      <td width="80%"><input name="txtNomor" value="<?php echo $noTransaksi; ?>" size="23" maxlength="20" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><strong>Tgl.  Simpanan </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTanggal" type="text" class="tcal" value="<?php echo $dataTanggal; ?>" size="23" maxlength="23" /></td>
    </tr>
    <tr>
      <td><strong>Nasabah</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKodeNas" id="txtKodeNas" size="20" maxlength="6" value="<?php echo $dataKodeNas; ?>" onchange="javascript:submitform();" />
        <input name="btnCari" type="submit" id="btnCari" value="Cari" />
        <a href="javaScript: void(0)" onclick="popup('nasabah_cari.php')" target="_self"> <b>Cari</b></a> </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><strong>:</strong></td>
      <td><input  type="text" size="80" id="txtNamaNas"   maxlength="100" value="<?php echo $dataNamaNas; ?>" disabled="disabled"/></td>
    </tr>
    <tr>
      <td><strong> Keterangan </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="80" maxlength="100" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>TRANSAKSI</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Jenis Simpanan </strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbJenis" onchange="javascript:submitform();" >
          <option value="Kosong">....</option>
          <?php
		  // Skrip menampilkan data Jenis ke ComboBox (ListMenu)
	  $bacaSql = "SELECT * FROM jenis_simpanan ORDER BY kd_jsimpanan";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['kd_jsimpanan'] == $dataJenis) {
			$cek = " selected";
		} else { $cek=""; }
		
		echo "<option value='$bacaData[kd_jsimpanan]' $cek> $bacaData[nm_jsimpanan]</option>";
	  }
	  ?>
        </select>      </td>
    </tr>
    <tr>
      <td><strong>Besar Simpanan (Rp) </strong></td>
      <td><strong>:</strong></td>
      <td><b>
        <input name="txtBesarSimpanan" value="<?php echo $dataBesarSimpanan; ?>" size="20" maxlength="12"/>
      </b></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnSimpan" type="submit" style="cursor:pointer;" value=" SIMPAN TRANSAKSI " /></td>
    </tr>
  </table>
  <br>
</form>