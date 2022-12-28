<?php
include_once "../library/inc.seslogin.php"; 
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php"; 

// Skrip membaca Akun yang Login
$userLogin	= $_SESSION['SES_LOGIN'];

# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if(isset($_POST['btnSimpan'])){
	// Baca variabel data form
	$txtTanggal 		= InggrisTgl($_POST['txtTanggal']);
	$cmbNasabah			= $_POST['cmbNasabah'];
	$txtKeterangan		= $_POST['txtKeterangan'];
	$cmbJenis			= $_POST['cmbJenis'];
	$txtLamaPinjam		= $_POST['txtLamaPinjam'];
	$txtBesarPinjam		= $_POST['txtBesarPinjam'];
	$txtAngsuranPokok	= $_POST['txtAngsuranPokok'];
	$txtAngsuranBunga	= $_POST['txtAngsuranBunga'];
	$txtBunga			= $_POST['txtBunga'];
	$txtJasaAdmin		= $_POST['txtJasaAdmin'];
	
	// Skrip Validasi form
	$pesanError = array();
	if (trim($txtTanggal)=="--") {
		$pesanError[] = "Data <b>Tanggal Pinjam</b> belum diisi, silahkan pilih pada kalender !";		
	}
	if (trim($cmbNasabah)=="Kosong") {
		$pesanError[] = "Data <b>Nasabah</b> belum dipilih, silahkan pilih pada Combo !";		
	}
	if (trim($cmbJenis)=="Kosong") {
		$pesanError[] = "Data <b>Jenis Pinjaman</b> belum dipilih, silahkan pilih pada Combo !";		
	}
	if (trim($txtLamaPinjam)=="" or ! is_numeric(trim($txtLamaPinjam))) {
		$pesanError[] = "Data <b>Lama Pinjam (tenor)</b> masih kosong, harus diisi angka !";
	}
	if (trim($txtBesarPinjam)=="" or ! is_numeric(trim($txtBesarPinjam))) {
		$pesanError[] = "Data <b>Besar Pinjaman (Rp)</b> masih kosong, harus diisi angka !";
	}
	if (trim($txtAngsuranPokok)=="" or ! is_numeric(trim($txtAngsuranPokok))) {
		$pesanError[] = "Data <b>Angsuran Pokok (Rp)</b> masih kosong, harus diisi angka !";
	}
	if (trim($txtBunga)=="" or ! is_numeric(trim($txtBunga))) {
		$pesanError[] = "Data <b>Bunga (%)</b> masih kosong, harus diisi angka !";
	}
	if (trim($txtAngsuranBunga)=="" or ! is_numeric(trim($txtAngsuranBunga))) {
		$pesanError[] = "Data <b>Angsuran Bunga (Rp)</b> masih kosong, harus diisi angka !";
	}
	if (trim($txtJasaAdmin)=="" or ! is_numeric(trim($txtJasaAdmin))) {
		$pesanError[] = "Data <b>Jasa Administrasi (Rp)</b> masih kosong, harus diisi angka !";
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
		$kodePinjam = buatKode("pinjaman", "PJ");
				
		// Skrip menyimpan data ke tabel transaksi utama
		$mySql	= "INSERT INTO pinjaman(no_pinjaman, tgl_pinjaman, keterangan, no_nasabah, kd_jpinjaman, lama_pinjaman, 
								besar_pinjaman, angsuran_pokok, angsuran_bunga, bunga, administrasi, kd_pegawai) 
					VALUES ('$kodePinjam', '$txtTanggal',  '$txtKeterangan', '$cmbNasabah', '$cmbJenis', '$txtLamaPinjam', 
							'$txtBesarPinjam', '$txtAngsuranPokok', '$txtAngsuranBunga', '$txtBunga', '$txtJasaAdmin', '$userLogin')";
		mysql_query($mySql, $koneksidb) or die ("Gagal query pinjaman ".mysql_error());
		
		// Refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?open=Setoran-Bayar&Kode=$kodePinjam'>";
		
		// Cetak nota pinjaman
		echo "<script>";
		echo "window.open('pinjaman_cetak.php?Kode=$kodePinjam')";
		echo "</script>";
	}	
}

# VARIABEL DATA DARI & UNTUK FORM
$noTransaksi 	= buatKode("pinjaman", "PJ");
$dataTanggal 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataNasabah	= isset($_POST['cmbNasabah']) ? $_POST['cmbNasabah'] : '';
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';

$dataJenis			= isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : '';
$dataLamaPinjam		= isset($_POST['txtLamaPinjam']) ? $_POST['txtLamaPinjam'] : '10';
$dataBesarPinjam	= isset($_POST['txtBesarPinjam']) ? $_POST['txtBesarPinjam'] : '';
$dataAngsuranPokok	= isset($_POST['txtAngsuranPokok']) ? $_POST['txtAngsuranPokok'] : '';
$dataJasaAdmin		= isset($_POST['txtJasaAdmin']) ? $_POST['txtJasaAdmin'] : '';

# MEMBACA DATA BUNGA DARI JENIS PINJAMAN
$bacaSql	= "SELECT * FROM jenis_pinjaman WHERE kd_jpinjaman='$dataJenis'";
$bacaQry	= mysql_query($bacaSql, $koneksidb)  or die ("Query salah : ".mysql_error());
$bacaData	= mysql_fetch_array($bacaQry); 

$dataBunga	=  $bacaData['bunga'];

$nilaiBunga = ( $dataBesarPinjam * $dataBunga )/ 100 ;

$dataAngsuranBunga	= $nilaiBunga / $dataLamaPinjam;
?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT> 

<h1> PINJAMAN NASABAH </h1>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
<table width="900" cellspacing="1"  class="table-list">
  
  <tr>
    <td bgcolor="#CCCCCC"><strong>DATA TRANSAKSI </strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="19%"><strong>No. Pinjaman </strong></td>
    <td width="1%"><strong>:</strong></td>
    <td width="80%"><input name="txtNomor" value="<?php echo $noTransaksi; ?>" size="23" maxlength="20"  disabled="disabled"/></td>
  </tr>
  <tr>
    <td><strong>Tgl.  Pinjaman </strong></td>
    <td><strong>:</strong></td>
    <td><input name="txtTanggal" type="text" class="tcal" value="<?php echo $dataTanggal; ?>" size="23" /></td>
  </tr>
  <tr>
    <td><strong>Nasabah</strong></td>
    <td><strong>:</strong></td>
    <td><select name="cmbNasabah">
      <option value="Kosong">....</option>
      <?php
		  // Skrip menampilkan data Nasabah ke ComboBo (ListMenu)
	  $bacaSql = "SELECT * FROM nasabah ORDER BY no_nasabah";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['no_nasabah'] == $dataNasabah) {
			$cek = " selected";
		} else { $cek=""; }
		
		echo "<option value='$bacaData[no_nasabah]' $cek> $bacaData[no_nasabah] - $bacaData[nm_nasabah]</option>";
	  }
	  ?>
    </select>    </td>
  </tr>
  <tr>
    <td><strong> Keterangan </strong></td>
    <td><strong>:</strong></td>
    <td><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="70" maxlength="100" /></td>
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
    <td><strong>Jenis Pinjaman</strong></td>
    <td><strong>:</strong></td>
    <td><select name="cmbJenis" onchange="javascript:submitform();" >
      <option value="Kosong">....</option>
      <?php
		  // Skrip menampilkan data Jenis ke ComboBox (ListMenu)
	  $bacaSql = "SELECT * FROM jenis_pinjaman ORDER BY kd_jpinjaman";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['kd_jpinjaman'] == $dataJenis) {
			$cek = " selected";
		} else { $cek=""; }
		
		echo "<option value='$bacaData[kd_jpinjaman]' $cek> $bacaData[nm_jpinjaman]</option>";
	  }
	  ?>
    </select>    </td>
  </tr>
  <tr>
    <td><strong>Lama Pinjaman (Tenor) </strong></td>
    <td><strong>:</strong></td>
    <td><b>
      <input name="txtLamaPinjam" size="4" maxlength="4" value="<?php echo $dataLamaPinjam; ?>"/>
      x angsuran</b></td>
  </tr>
  <tr>
    <td><strong>Besar Pinjaman (Rp.) </strong></td>
    <td><strong>:</strong></td>
    <td><b>
      <input name="txtBesarPinjam" value="<?php echo $dataBesarPinjam; ?>" size="20" maxlength="12"/>
    </b></td>
  </tr>
  <tr>
    <td><strong>Angsuran Pokok (Rp.) </strong></td>
    <td><strong>:</strong></td>
    <td><b>
      <input name="txtAngsuranPokok" id="txtAngsuranPokok" value="<?php echo $dataAngsuranPokok; ?>" size="20" maxlength="12"/>
    </b></td>
  </tr>
  <tr>
    <td><strong>Angsuran Bunga (Rp.) </strong></td>
    <td><strong>:</strong></td>
    <td><b>
      <input name="txtBunga" id="txtBunga" value="<?php echo $dataBunga; ?>" size="4" maxlength="4"/>
      <input name="txtAngsuranBunga" id="txtAngsuranBunga" value="<?php echo $dataAngsuranBunga; ?>" size="20" maxlength="12"/>
    </b></td>
  </tr>
  <tr>
    <td><strong>Jasa Administrasi (Rp. </strong></td>
    <td><strong>:</strong></td>
    <td><b>
      <input name="txtJasaAdmin" id="txtJasaAdmin" value="<?php echo $dataJasaAdmin; ?>" size="20" maxlength="12"/>
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