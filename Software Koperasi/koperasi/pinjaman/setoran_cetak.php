<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

# Baca noNota dari URL
if(isset($_GET['noSetoran'])){
	# SKRIP PROGRAM
	// Membaca Kode/ Nomor Setoran
	$noSetoran = $_GET['noSetoran'];

	// Perintah untuk mendapatkan data Setoran
	$mySql = "SELECT * FROM pinjaman_setoran WHERE no_setoran='$noSetoran'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$myData= mysql_fetch_array($myQry);
	$kodePinjam	= $myData['no_pinjaman'];
	
	// Perintah untuk mendapatkan data dari tabel pinjaman
	$my2Sql = "SELECT pinjaman.*, nasabah.nm_nasabah, jenis_pinjaman.nm_jpinjaman FROM pinjaman
				LEFT JOIN nasabah ON pinjaman.no_nasabah = nasabah.no_nasabah
				LEFT JOIN jenis_pinjaman ON pinjaman.kd_jpinjaman = jenis_pinjaman.kd_jpinjaman
				WHERE pinjaman.no_pinjaman='$kodePinjam'";
	$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
	$my2Data= mysql_fetch_array($my2Qry);
	
	
	// Menghitung Total Jumlah Setoran
	$my3Sql	= "SELECT SUM(setoran_pokok) AS total_setoran FROM pinjaman_setoran WHERE no_pinjaman='$kodePinjam'";
	$my3Qry = mysql_query($my3Sql, $koneksidb)  or die ("Query 3 salah : ".mysql_error());
	$my3Data= mysql_fetch_array($my3Qry);
	
	// Mendapatkan Sisa Seotarn (X)
	$jumlahSetoran 	= $my3Data['total_setoran'] / $my2Data['angsuran_pokok'];
	$sisaSetoran	= $my2Data['lama_pinjaman'] - $jumlahSetoran;
	$sisaHutang		= $sisaSetoran * $my2Data['angsuran_pokok'];
}
else {
	echo "Nomor Setoran (Kode) tidak ditemukan";
	exit;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cetak Nota Setoran</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body >
<H2> CETAK SETORAN/ ANGSURAN </H2>
<table class="table-list" width="600" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td bgcolor="#F5F5F5"><strong>TRANSAKSI</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="158"><strong>No. Pinjaman </strong></td>
    <td width="13">:</td>
    <td width="417"> <?php echo $my2Data['no_pinjaman']; ?> </td>
  </tr>
  <tr>
    <td><strong>Tgl. Pinjaman </strong></td>
    <td>:</td>
    <td> <?php echo IndonesiaTgl($my2Data['tgl_pinjaman']); ?> </td>
  </tr>
  <tr>
    <td>Jenis Pinjaman </td>
    <td>:</td>
    <td> <?php echo $my2Data['nm_jpinjaman']; ?> </td>
  </tr>
  <tr>
    <td><strong>Nasabah</strong></td>
    <td>:</td>
    <td> <?php echo $my2Data['no_nasabah']."/ ".$my2Data['nm_nasabah']; ?> </td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td>:</td>
    <td><?php echo $my2Data['keterangan']; ?></td>
  </tr>
  <tr>
    <td bgcolor="#F5F5F5"><strong>SETORAN</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td> Angsuran Pokok (Rp)</td>
    <td>:</td>
    <td> <?php echo format_angka($myData['setoran_pokok']); ?> </td>
  </tr>
  <tr>
    <td> Angsuran Bunga (Rp) </td>
    <td>:</td>
    <td> <?php echo format_angka($myData['setoran_bunga']); ?> </td>
  </tr>
  <tr>
    <td>Denda (Rp) </td>
    <td>:</td>
    <td> <?php echo format_angka($myData['denda']); ?> </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Total Setoran (Rp) </td>
    <td>:</td>
    <td> <?php echo format_angka($my3Data['total_setoran']); ?> </td>
  </tr>
  <tr>
    <td>Sisa Setoran (x) </td>
    <td>:</td>
    <td> <?php echo $sisaSetoran; 
				echo " (".format_angka($sisaHutang).")"; ?> </td>
  </tr>
</table>
</body>
</html>
