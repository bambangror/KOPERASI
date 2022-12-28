<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

if(isset($_GET['Kode'])) {
	# TAMPILKAN DATA DARI DATABASE, Untuk ditampilkan ke halaman
	$Kode= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
	$mySql = "SELECT pinjaman.*, nasabah.nm_nasabah FROM pinjaman, nasabah 
			  WHERE pinjaman.kd_nasabah=nasabah.kd_nasabah AND pinjaman.no_pinjaman='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
	$kolomData = mysql_fetch_array($myQry);
	
	$angsuran	= $kolomData['jumlah_pinjaman'] / $kolomData['lama_pinjaman'];
	$bunga		= $kolomData['jumlah_pinjaman'] * ( $kolomData['bunga'] / 100 );
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
    <td colspan="3" bgcolor="#F5F5F5"><strong>AGUNAN (JIKA ADA) </strong></td>
  </tr>
</table>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <th width="102"><strong>Bulan Ke-# </strong></th>
    <th width="118"><strong>Angsuran Ke-# </strong></th>
    <th width="111"><strong>Tanggal</strong></th>
    <th width="142"><strong>Angsuran (Rp) </strong></th>
    <th width="122"><strong>Bunga (Rp) </strong></th>
    <th width="123"><strong>Status</strong></th>
    <th width="46">Tools</th>
  </tr>
  <?php
	$my3Sql = "SELECT * FROM pinjaman_angsuran WHERE no_pinjaman='$Kode'";
	$my3Qry = mysql_query($my3Sql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = 0; 
	while ($kolom3Data = mysql_fetch_array($my3Qry)) {
		$nomor++;
		$Kode = $kolom3Data['no_angsuran'];
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td><?php echo $nomor; ?></td>
    <td><?php echo $kolom3Data['angsuran_ke']; ?></td>
    <td><?php echo IndonesiaTgl($kolom3Data['tgl_angsuran']); ?></td>
    <td><?php echo format_angka($kolom3Data['besar_angsuran']); ?></td>
    <td><?php echo format_angka($kolom3Data['besar_bunga']); ?></td>
    <td><?php echo $kolom3Data['status_angsuran']; ?></td>
    <td align="center" bgcolor="<?php echo $warna; ?>"><a href="angsuran_nota.php?noAngsuran=<?php echo $Kode; ?>" target="_blank"><img src="../images/btn_print2.png" height="22" border="0"  title="CETA NOTA ANGSURAN"/></a></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>
