<?php
include_once "../library/inc.seslogin.php"; 
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php"; 

// Membaca User Login
$userLogin	= $_SESSION['SES_LOGIN'];

# ========================================================================================================
# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if(isset($_POST['btnSimpan'])){
	// Baca variabel data form
	$txtKode			= $_POST['txtKode'];
	$txtTanggal 		= InggrisTgl($_POST['txtTanggal']);
	$txtNilaiTransaksi	= $_POST['txtNilaiTransaksi'];
	$txtKeterangan		= $_POST['txtKeterangan'];
	
	// Skrip Validasi form
	$pesanError = array();
	if (trim($txtKode)=="") {
		$pesanError[] = "Data <b>Kode</b> tidak terbaca, silahkan ulangi lagi !";		
	}
	if (trim($txtTanggal)=="--") {
		$pesanError[] = "Data <b>Tgl. Transaksi</b> belum diisi, silahkan pilih pada kalender !";		
	}
	if (trim($txtNilaiTransaksi)=="" or ! is_numeric(trim($txtNilaiTransaksi))) {
		$pesanError[] = "Data <b>Penarikan Simpanan (Rp)</b> masih kosong, harus diisi angka !";
	}
	else {
		if (trim($txtNilaiTransaksi)< 5000 ) {
			$pesanError[] = "Data <b>Jumlah Penarikan (Rp)</b> masih kurang, minimal adalah <b> Rp. 5000 </b> !";
		}
	}
	if (trim($txtKeterangan)=="") {
		$pesanError[] = "Data <b>Keterangan</b> belum diisi, silahkan dilengkapi !";		
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
		$kodeTransaksi = buatKode("simpanan_transaksi", "ST");

		// Jika ada Nasabah menabung(melakukan Setoran), berarti Bank (Koperasi) mendapatkan Dana Kredit, maka masuk ke dalam kolom nilai_kredit
		// Jika ada Nasabah mengambil uang tabungannya, maka Bank melakukan pengurangan Debit, maka masuk ke dalam nilai_debit
				
		// Skrip menyimpan data ke tabel Simpanan 
		$mySql	= "INSERT INTO simpanan_transaksi (no_transaksi, tgl_transaksi, no_simpanan, debit, kredit, keterangan, kd_pegawai) 
					VALUES ('$kodeTransaksi', '$txtTanggal',  '$txtKode', '$txtNilaiTransaksi', '0', '$txtKeterangan', '$userLogin')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query simpanan 1 ".mysql_error());
		if($myQry) {
			// Refresh halaman
			echo "<meta http-equiv='refresh' content='0; url=?open=Transaksi-Penarikan&Kode=$txtKode'>";		
		}
		
		// Cetak nota simpanan
		echo "<script>";
		echo "window.open('penarikan_nota.php?Kode=$kodeTransaksi')";
		echo "</script>";
	}	
}

# TAMPILKAN DATA SIMPANAN (UTAMA)
$Kode	 = $_GET['Kode']; 
$mySql	 = "SELECT simpanan.*, nasabah.nm_nasabah FROM simpanan
			LEFT JOIN nasabah ON simpanan.no_nasabah = nasabah.no_nasabah 
			WHERE simpanan.no_simpanan='$Kode'";
$myQry	 = mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
$myData	 = mysql_fetch_array($myQry);

# VARIABEL DATA DARI & UNTUK FORM
$noTransaksi 		= buatKode("simpanan_transaksi", "ST");
$dataTanggal 		= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataNilaiTransaksi	= isset($_POST['txtNilaiTransaksi']) ? $_POST['txtNilaiTransaksi'] : '';
$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="800" cellspacing="1"  class="table-list">
    <tr>
      <td colspan="3"><h1> PENARIKAN TUNAI </h1></td>
    </tr>
    <tr>
      <td width="23%" bgcolor="#CCCCCC"><strong>DATA SIMPANAN </strong></td>
      <td width="1%">&nbsp;</td>
      <td width="76%">&nbsp;</td>
    </tr>
    <tr>
      <td><strong>No. Simpanan </strong></td>
      <td><strong>:</strong></td>
      <td><?php echo $myData['no_simpanan']; ?></td>
    </tr>
    <tr>
      <td><strong>Nasabah</strong></td>
      <td><strong>:</strong></td>
      <td><?php echo $myData['no_nasabah']."/ ".$myData['nm_nasabah']; ?></td>
    </tr>
    <tr>
      <td><strong>Keterangan</strong></td>
      <td><strong>:</strong></td>
      <td><?php echo $myData['keterangan']; ?></td>
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
      <td><strong>No. Transaksi </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNomor" value="<?php echo $noTransaksi; ?>" size="23" maxlength="20" disabled="disabled"/>
      <input name="txtKode" type="hidden" value="<?php echo $myData['no_simpanan']; ?>" /></td>
    </tr>
    <tr>
      <td><strong>Tgl.  Transaksi </strong></td>
      <td><strong>:</strong></td>
      <td><input type="text" name="txtTanggal" class="tcal" value="<?php echo $dataTanggal; ?>" /></td>
    </tr>
    <tr>
      <td><strong>Jumlah Penarikan  (Rp.) </strong></td>
      <td><strong>:</strong></td>
      <td><b>
        <input name="txtNilaiTransaksi" value="<?php echo $dataNilaiTransaksi; ?>" size="23" maxlength="12"/>
      </b></td>
    </tr>
    <tr>
      <td><strong> Keterangan </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="80" maxlength="100" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnSimpan" type="submit" style="cursor:pointer;" value=" SIMPAN TRANSAKSI " /></td>
    </tr>
  </table>
  <br>
</form>