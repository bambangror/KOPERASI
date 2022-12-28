<?php
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";

# MEMBACA KASIR YANG LOGIN
$kodeUser	= $_SESSION['SES_LOGIN'];

# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca data Variabel from input
	$txtKode		= $_POST['txtKode'];
	$txtTanggal 	= InggrisTgl($_POST['txtTanggal']);
	$txtSetoranPokok= $_POST['txtSetoranPokok'];
	$txtSetoranBunga= $_POST['txtSetoranBunga'];
	$txtDenda		= $_POST['txtDenda'];
	$txtPokok		= $_POST['txtPokok'];
	$txtBunga		= $_POST['txtBunga'];
	$txtHutang		= $_POST['txtHutang'];
			
	# Validasi Form
	$pesanError = array();
	if(trim($txtKode)=="") {
		$pesanError[] = "Data <b>No. Nota Pinjaman</b> tidak terbaca, silahkan ulangi dari halaman Tampil Pinjaman !";		
	}
	if(trim($txtTanggal)=="--") {
		$pesanError[] = "Data <b>Tgl. Setoran</b> belum diisi, pilih pada Kalender !";		
	}
	
	if(trim($txtSetoranPokok)==""  or trim($txtSetoranPokok)=="0" or ! is_numeric(trim($txtSetoranPokok))) {
		$pesanError[] = "Data <b>Setoran Pokok (Rp)</b> belum diisi, harus berupa angka !";		
	}
	else {
		if(trim($txtSetoranPokok) != trim($txtPokok)) {
			$txtPokok	= format_angka($txtPokok);
			$pesanError[] = "Data <b>Setoran Pokok (Rp)</b> salah, yang harus dibayar <b> Rp. $txtPokok </b>!";	
		}
	}
		
	if(trim($txtSetoranBunga)==""  or trim($txtSetoranBunga)=="0" or ! is_numeric(trim($txtSetoranBunga))) {
		$pesanError[] = "Data <b>Setoran Bunga (Rp)</b> belum diisi, harus berupa angka !";		
	}
	else {
		if(trim($txtSetoranBunga) != trim($txtBunga)) {
			$txtBunga	= format_angka($txtBunga);
			$pesanError[] = "Data <b>Setoran Bunga (Rp)</b> salah, yang harus dibayar <b> Rp. $txtBunga </b>!";	
		}
	}
	
	if(trim($txtDenda)=="" or ! is_numeric(trim($txtDenda))) {
		$pesanError[] = "Data <b>Denda (Rp)</b> belum diisi, harus berupa angka atau diisi 0 !";
	}
	
	// Cek Status Bayar pada Transaksi Pinjaman
	$cekSql	= "SELECT * FROM pinjaman  WHERE no_pinjaman='$txtKode'";
	$cekQry = mysql_query($cekSql, $koneksidb)  or die ("Query salah cek : ".mysql_error());
	$cekData= mysql_fetch_array($cekQry);
	
	if($cekData['status'] == "Lunas") {
		$pesanError[] = "Data <b>Pinjaman Sudah Lunas</b> proses transaksi tidak dapat disimpan !";
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
		# SIMPAN DATA KE DATABASE
		# Jika jumlah error pesanError tidak ada, maka penyimpanan dilakukan. Data dari tmp dipindah ke tabel pinjaman dan pinjaman_item
		
		// Membuat Nomor Transaksi Baru
		$noTransaksi = buatKode("pinjaman_setoran", "BS");
		
		// Skrip menyimpan data Transaksi utama
		$mySql	= "INSERT INTO pinjaman_setoran (no_setoran, tgl_setoran, no_pinjaman, setoran_pokok, setoran_bunga, denda) 
					VALUES ('$noTransaksi', '$txtTanggal',  '$txtKode', '$txtSetoranPokok', '$txtSetoranBunga', '$txtDenda')";
		mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		
		// Status Bayar Hutang
		if(trim($txtSetoranPokok) >= trim($txtHutang)) {
			$status	= "Lunas";
			
			$editSql	= "UPDATE pinjaman SET status='Lunas' WHERE no_pinjaman='$txtKode'";
			mysql_query($editSql, $koneksidb) or die ("Gagal query edit status : ".mysql_error());
		}
		
		// Refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?open=Setoran-Baru&Kode=$txtKode'>";
		
		// Nota
		echo "<script>";
		echo "window.open('setoran_cetak.php?noSetoran=$noTransaksi', width=330,height=330,left=100, top=25)";
		echo "</script>";

	}	
}

# ====================================================================================
# MEMBACA KODE PEMINJAMAN
$Kode			= isset($_GET['Kode']) ? $_GET['Kode'] : '';
$nomorPinjam	= isset($_POST['txtKode']) ? $_POST['txtKode'] : $Kode;

# CEK APAKAH STATUS BAYAR MASIH HUTANG
$cekSql	= "SELECT status FROM pinjaman  WHERE no_pinjaman='$nomorPinjam'";
$cekQry = mysql_query($cekSql, $koneksidb)  or die ("Query salah cek : ".mysql_error());
$cekData= mysql_fetch_array($cekQry);
if($cekData['status'] =="Lunas") {
	echo "SUDAH LUNAS ";
	echo "<meta http-equiv='refresh' content='5; url=?open=Pinjaman-Tampil'>";
	
	exit;
}

# MENAMPILKAN DATA PEMINJAMAN
$mySql ="SELECT pinjaman.*, nasabah.nm_nasabah, jenis_pinjaman.nm_jpinjaman FROM pinjaman 
			LEFT JOIN nasabah ON pinjaman.no_nasabah = nasabah.no_nasabah
			LEFT JOIN jenis_pinjaman ON pinjaman.kd_jpinjaman = jenis_pinjaman.kd_jpinjaman
			WHERE pinjaman.no_pinjaman='$nomorPinjam'";
$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query ".mysql_error());
$myData= mysql_fetch_array($myQry);

# MENGHITUNG TOTAL SETORAN
$my2Sql	= "SELECT SUM(setoran_pokok) As total_pokok, COUNT(*) AS total_setor FROM pinjaman_setoran WHERE no_pinjaman='$nomorPinjam'";
$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query salah 2 : ".mysql_error());
$my2Data= mysql_fetch_array($my2Qry);

// Sisa hutang
$sisaHutang		= $myData['besar_pinjaman'] - $my2Data['total_pokok'];
$sisaAngsur		= $myData['lama_pinjaman'] - $my2Data['total_setor'];
		
# TAMPILKAN DATA KE FORM
$noTransaksi 		= buatKode("pinjaman_setoran", "BS");
$dataTanggal 		= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataSetoranPokok	= isset($_POST['txtSetoranPokok']) ? $_POST['txtSetoranPokok'] : $myData['angsuran_pokok'];
$dataSetoranBunga	= isset($_POST['txtSetoranBunga']) ? $_POST['txtSetoranBunga'] : $myData['angsuran_bunga'];
$dataDenda			= isset($_POST['txtDenda']) ? $_POST['txtDenda'] : '0';

?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT> 

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="800" cellpadding="3" cellspacing="1"  class="table-list">
    <tr>
      <td colspan="3"><h1>SETORAN ANGSURAN </h1></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>DATA PINJAMAN </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="26%"><strong>No. Pinjaman </strong></td>
      <td width="2%"><strong>:</strong></td>
      <td width="72%"> <?php echo $myData['no_pinjaman']; ?> <input name="txtKode" type="hidden" id="txtKode" value="<?php echo $myData['no_pinjaman']; ?>" /></td>
    </tr>
    <tr>
      <td><strong>Tgl. Pinjaman </strong></td>
      <td><strong>:</strong></td>
      <td> <?php echo IndonesiaTgl($myData['tgl_pinjaman']); ?> </td>
    </tr>
    <tr>
      <td><strong>Nasabah</strong></td>
      <td><strong>:</strong></td>
      <td> <?php echo $myData['no_nasabah']."/ ".$myData['nm_nasabah']; ?> </td>
    </tr>
    <tr>
      <td><strong>Jenis Pinjaman </strong></td>
      <td><strong>:</strong></td>
      <td> <?php echo $myData['nm_jpinjaman']; ?> </td>
    </tr>
    <tr>
      <td><strong>Keterangan</strong></td>
      <td><strong>:</strong></td>
      <td> <?php echo $myData['keterangan']; ?> </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>INFORMASI</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Besar Pinjaman  (Rp) </strong></td>
      <td><strong>:</strong></td>
      <td> <?php echo format_angka($myData['besar_pinjaman']); ?> </td>
    </tr>
    <tr>
      <td><strong>Total Angsuran  (Rp) </strong></td>
      <td><strong>:</strong></td>
      <td> <?php echo format_angka($my2Data['total_pokok']); ?> </td>
    </tr>
    <tr>
      <td><b>Sisa Hutang (Rp) </b></td>
      <td><b>:</b></td>
      <td><?php echo format_angka($sisaHutang); ?>
          <input name="txtHutang" type="hidden" value="<?php echo $sisaHutang; ?>" /></td>
    </tr>
    <tr>
      <td><strong>Total Setoran (x) </strong></td>
      <td><b>:</b></td>
      <td><?php echo format_angka($my2Data['total_setor']); ?> x</td>
    </tr>
    <tr>
      <td><strong>Sisa Setoran (x) </strong></td>
      <td><b>:</b></td>
      <td><?php echo format_angka($sisaAngsur); ?> x</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>SETORAN</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Tgl. Setoran </strong></td>
      <td><b>:</b></td>
      <td><input name="txtTanggal" type="text" class="tcal" value="<?php echo $dataTanggal; ?>" size="18" maxlength="20" /></td>
    </tr>
    <tr>
      <td><strong>Setoran Pokok (Rp) </strong></td>
      <td><b>:</b></td>
      <td><input name="txtSetoranPokok" value="<?php echo $dataSetoranPokok; ?>" size="20" maxlength="12"/>
          <input name="txtPokok" type="hidden" value="<?php echo $myData['angsuran_pokok']; ?>" /></td>
    </tr>
    <tr>
      <td><strong>Setoran Bunga (Rp) </strong></td>
      <td><b>:</b></td>
      <td><input name="txtSetoranBunga" value="<?php echo $dataSetoranBunga; ?>" size="20" maxlength="12"/>
          <input name="txtBunga" type="hidden" value="<?php echo $myData['angsuran_bunga']; ?>" /></td>
    </tr>
    <tr>
      <td><strong>Denda (Rp) </strong></td>
      <td><b>:</b></td>
      <td><input name="txtDenda" value="<?php echo $dataDenda; ?>" size="20" maxlength="12"/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnSimpan" type="submit" style="cursor:pointer;" value=" SIMPAN TRANSAKSI " /></td>
    </tr>
  </table>
  <br>
</form>
