<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

# Baca Kode dari alamat URL
if(isset($_GET['Kode'])){
	$Kode = $_GET['Kode'];
	
	// Perintah untuk mendapatkan data dari tabel pinjaman
	$mySql = "SELECT pinjaman.*, nasabah.nm_nasabah, jenis_pinjaman.nm_jpinjaman FROM pinjaman
				LEFT JOIN nasabah ON pinjaman.no_nasabah = nasabah.no_nasabah
				LEFT JOIN jenis_pinjaman ON pinjaman.kd_jpinjaman = jenis_pinjaman.kd_jpinjaman
				WHERE no_pinjaman='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$myData= mysql_fetch_array($myQry);
}
else {
	echo "Nomor Pinjaman (Kode) tidak ditemukan";
	exit;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cetak Pinjaman</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body >
<table class="table-list" width="600" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td height="87" colspan="3">
		 <h2> DATA PINJAMAN </h2> </td>
  </tr>
  
  <tr>
    <td width="158"><strong>No. Pinjaman </strong></td>
    <td width="13">:</td>
    <td width="417"> <?php echo $myData['no_pinjaman']; ?> </td>
  </tr>
  <tr>
    <td><strong>Tgl. Pinjaman </strong></td>
    <td>:</td>
    <td> <?php echo IndonesiaTgl($myData['tgl_pinjaman']); ?> </td>
  </tr>
  <tr>
    <td><strong>Nasabah</strong></td>
    <td>:</td>
    <td> <?php echo $myData['no_nasabah']."/ ".$myData['nm_nasabah']; ?> </td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td>:</td>
    <td> <?php echo $myData['keterangan']; ?></td>
  </tr>
  <tr>
    <td>Jenis Pinjaman </td>
    <td>:</td>
    <td> <?php echo $myData['nm_jpinjaman']; ?> </td>
  </tr>
  <tr>
    <td>Lama Pinjaman  </td>
    <td>:</td>
    <td> <?php echo $myData['lama_pinjaman']; ?> x angsuran</td>
  </tr>
  <tr>
    <td>Besar Pinjaman (Rp)</td>
    <td>:</td>
    <td> <?php echo format_angka($myData['besar_pinjaman']); ?></td>
  </tr>
  <tr>
    <td>Angsuran Pokok (Rp)</td>
    <td>:</td>
    <td><?php echo format_angka($myData['angsuran_pokok']); ?></td>
  </tr>
  <tr>
    <td>Angsuran Bunga (Rp) </td>
    <td>:</td>
    <td><?php echo format_angka($myData['angsuran_bunga'])."(".$myData['bunga']." %)"; ?></td>
  </tr>
  <tr>
    <td>Administrasi (Rp) </td>
    <td>:</td>
    <td><?php echo format_angka($myData['administrasi']); ?></td>
  </tr>
</table>
</body>
</html>
