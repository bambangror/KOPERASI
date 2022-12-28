<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

if(isset($_GET['Kode'])) {
	# TAMPILKAN DATA DARI DATABASE, Untuk ditampilkan ke halaman
	$Kode= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
	// Perintah untuk mendapatkan data dari tabel pinjaman
	$mySql = "SELECT pinjaman.*, nasabah.nm_nasabah, jenis_pinjaman.nm_jpinjaman FROM pinjaman
				LEFT JOIN nasabah ON pinjaman.no_nasabah = nasabah.no_nasabah
				LEFT JOIN jenis_pinjaman ON pinjaman.kd_jpinjaman = jenis_pinjaman.kd_jpinjaman
				WHERE no_pinjaman='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$myData= mysql_fetch_array($myQry);
}
else {
	echo "Nomor pinjaman tidak terbaca";
	exit;
}// Penutup GET
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>View Pinjaman</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body >
<table width="800" class="table-list" border="0" cellspacing="1" cellpadding="4">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><h1>PINJAMAN NASABAH</h1></td>
  </tr>
  <tr>
    <td width="141"><strong>No. Pinjaman </strong></td>
    <td width="5">:</td>
    <td width="526"><?php echo $myData['no_pinjaman']; ?> </td>
  </tr>
  <tr>
    <td><strong>Tgl. Pinjaman </strong></td>
    <td>:</td>
    <td><?php echo IndonesiaTgl($myData['tgl_pinjaman']); ?> </td>
  </tr>
  <tr>
    <td><strong>Nasabah</strong></td>
    <td>:</td>
    <td><?php echo $myData['no_nasabah']."/ ".$myData['nm_nasabah']; ?> </td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td>:</td>
    <td><?php echo $myData['keterangan']; ?></td>
  </tr>
  <tr>
    <td>Jenis Pinjaman </td>
    <td>:</td>
    <td><?php echo $myData['nm_jpinjaman']; ?> </td>
  </tr>
  <tr>
    <td>Lama Pinjaman </td>
    <td>:</td>
    <td><?php echo $myData['lama_pinjaman']; ?> x angsuran</td>
  </tr>
  <tr>
    <td>Besar Pinjaman (Rp)</td>
    <td>:</td>
    <td><?php echo format_angka($myData['besar_pinjaman']); ?></td>
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
  
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><strong>TRANSAKSI SETORAN </strong></td>
  </tr>
</table>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <th width="108"><strong>Bulan Ke-# </strong></th>
    <th width="161"><strong>Tanggal</strong></th>
    <th width="151" align="right"><strong>Angsuran (Rp.) </strong></th>
    <th width="142" align="right"><strong>Bunga (Rp.) </strong></th>
    <th width="141" align="right"><strong>Denda (Rp.) </strong></th>
    <th width="66">Tools</th>
  </tr>
  <?php
  	# MENAMPILKAN DATA SETORAN
	$my3Sql = "SELECT * FROM pinjaman_setoran WHERE no_pinjaman='$Kode'";
	$my3Qry = mysql_query($my3Sql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = 0; 
	while ($my3Data = mysql_fetch_array($my3Qry)) {
		$nomor++;
		$Kode = $my3Data['no_setoran'];
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($my3Data['tgl_setoran']); ?></td>
    <td align="right"><?php echo format_angka($my3Data['setoran_pokok']); ?></td>
    <td align="right"><?php echo format_angka($my3Data['setoran_bunga']); ?></td>
    <td align="right"><?php echo  format_angka($my3Data['denda']); ?></td>
    <td><a href="setoran_cetak.php?noSetoran=<?php echo $Kode; ?>" target="_blank">Cetak</a></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>
