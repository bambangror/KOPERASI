<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

# Baca noNota dari URL
if(isset($_GET['Kode'])){
	$Kode = $_GET['Kode'];
	
	// Perintah untuk mendapatkan data dari tabel simpanan
	$mySql = "SELECT simpanan.*, nasabah.nm_nasabah, jenis_simpanan.nm_jsimpanan FROM simpanan
				LEFT JOIN nasabah ON simpanan.no_nasabah = nasabah.no_nasabah
				LEFT JOIN jenis_simpanan ON simpanan.kd_jsimpanan = jenis_simpanan.kd_jsimpanan
				WHERE no_simpanan='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$myData= mysql_fetch_array($myQry);
}
else {
	echo "Nomor Simpanan (Kode) tidak ditemukan";
	exit;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cetak Simpanan</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body >
<table class="table-list"  width="700" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td width="155"><strong>No. Simpanan </strong></td>
    <td width="10"><strong>:</strong></td>
    <td width="540"> <?php echo $myData['no_simpanan']; ?> </td>
  </tr>
  <tr>
    <td><strong>Tgl. Simpanan </strong></td>
    <td><strong>:</strong></td>
    <td> <?php echo IndonesiaTgl($myData['tgl_simpanan']); ?> </td>
  </tr>
  <tr>
    <td><strong>Jenis Simpanan </strong></td>
    <td><strong>:</strong></td>
    <td> <?php echo $myData['nm_jsimpanan']; ?> </td>
  </tr>
  <tr>
    <td><strong>Nasabah</strong></td>
    <td><strong>:</strong></td>
    <td> <?php echo $myData['no_nasabah']."/ ".$myData['nm_nasabah']; ?> </td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td><strong>:</strong></td>
    <td> <?php echo $myData['keterangan']; ?> </td>
  </tr>
</table>
<br>
<table class="table-list"  width="700" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td width="20" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="95" bgcolor="#CCCCCC"><strong>No. Trans </strong></td>
    <td width="100" bgcolor="#CCCCCC"><strong>Tgl. Trans </strong></td>
    <td width="118" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td width="100" align="right" bgcolor="#CCCCCC"><strong>Debit(Rp)</strong></td>
    <td width="105" align="right" bgcolor="#CCCCCC"><strong>Kredit(Rp)</strong></td>
    <td width="104" align="right" bgcolor="#CCCCCC"><strong>Saldo (Rp) </strong></td>
  </tr>
  
<?php
# SKRIP TAMPILKAN DATA 
// Variabel
$saldoAkhir	= 0;

  // Skrip menampilkan data Simpanan
$mySql = "SELECT simpanan_transaksi.*, nasabah.no_nasabah, nasabah.nm_nasabah FROM simpanan_transaksi 
			LEFT JOIN simpanan ON simpanan_transaksi.no_simpanan = simpanan.no_simpanan
			LEFT JOIN nasabah ON simpanan.no_nasabah = nasabah.no_nasabah
			WHERE simpanan.no_simpanan='$Kode' ORDER BY simpanan_transaksi.no_transaksi ASC";
$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
$nomor = 0; 
while ($myData = mysql_fetch_array($myQry)) {
	$nomor++;
	$Kode = $myData['no_transaksi'];
	$saldoAkhir	= $saldoAkhir + ($myData['kredit'] - $myData['debit']);
?>
<tr>
    <td> <?php echo $nomor; ?> </td>
    <td> <?php echo $myData['no_transaksi']; ?> </td>
    <td> <?php echo IndonesiaTgl($myData['tgl_transaksi']); ?> </td>
    <td width="214"> <?php echo $myData['keterangan']; ?> </td>
    <td align="right"> <?php echo format_angka($myData['debit']); ?> </td>
    <td align="right"> <?php echo format_angka($myData['kredit']); ?> </td>
    <td align="right"> <?php echo format_angka($saldoAkhir); ?> </td>
  </tr>
  
<?php  } ?>

</table>
</body>
</html>
