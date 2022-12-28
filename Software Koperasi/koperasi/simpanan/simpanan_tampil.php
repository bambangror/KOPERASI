<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.pilihan.php";

// Membaca nama form
$dataBulan 	= isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : date('m'); 
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : date('Y'); 

# Membuat Filter Bulan
if($dataTahun and $dataBulan) {
	$filterSQL = "WHERE LEFT(tgl_simpanan,4)='$dataTahun' AND MID(tgl_simpanan,6,2)='$dataBulan'"; 
}
else {
	$filterSQL = ""; 
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 1;
$infoSql= "SELECT * FROM simpanan $filterSQL"; 
$infoQry= mysql_query($infoSql, $koneksidb) or die ("error halaman: ".mysql_error());
$jumlah	= mysql_num_rows($infoQry);
$maks	= ceil($jumlah/$baris);
$mulai	= $baris * ($hal-1);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Data Pinjaman</title>
</head>

<body>
<h1> TAMPIL DATA SIMPANAN</h1>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table class="table-list"  width="800" border="0" cellspacing="2" cellpadding="3">
    <tr>
      <td width="157" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
      <td width="6">&nbsp;</td>
      <td width="611">&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Bulan &amp; Tahun </strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbBulan">
          <?php
	for($bulan = 1; $bulan <= 12; $bulan++) {
		// Skrip membuat angka 2 digit (1-9)
		if($bulan < 10) { $bln = "0".$bulan; } else { $bln = $bulan; }
		
		if ($bln == $dataBulan) { $cek=" selected"; } else { $cek = ""; }
		
		echo "<option value='$bln' $cek> $listBulan[$bln] </option>";
	}
	?>
        </select>
          <select name="cmbTahun">
            <?php
	$awal_th	= date('Y') - 3;
	for($tahun = $awal_th; $tahun <= date('Y'); $tahun++) {
	// Skrip tahun terpilih
	if ($tahun == $dataTahun) {  $cek=" selected"; } else { $cek = ""; }
	
	echo "<option value='$tahun' $cek> $tahun </option>";
	}
	?>
          </select>
          <input name="btnTampil" type="submit" id="btnTampil" value="Tampil">
      </td>
    </tr>
  </table>
</form>

<table class="table-list" width="800" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td width="29" bgcolor="#CCCCCC"><strong>No.</strong></td>
    <td width="95" bgcolor="#CCCCCC"><strong>Tgl. Simpanan </strong></td>
    <td width="95" bgcolor="#CCCCCC"><strong>No. Simpanan </strong></td>
    <td width="258" bgcolor="#CCCCCC"><strong>Nasabah</strong></td>
    <td width="110" bgcolor="#CCCCCC"><strong>Saldo (Rp.) </strong></td>
    <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  
<?php
// Skrip menampilkan data Transaksi Pinjaman
$mySql = "SELECT simpanan.*, nasabah.nm_nasabah FROM simpanan  
		LEFT JOIN nasabah ON simpanan.no_nasabah = nasabah.no_nasabah
		$filterSQL ORDER BY simpanan.no_simpanan DESC LIMIT $mulai, $baris";
$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : $mySql ".mysql_error());
$nomor = $mulai; 
while ($myData = mysql_fetch_array($myQry)) {
	$nomor++;
	$Kode = $myData['no_simpanan'];

	// Menghitng Total Saldo Simpanan Hasil Transaksi
	$my2Sql	= "SELECT SUM(debit) AS total_debit,  SUM(kredit) AS total_kredit FROM simpanan_transaksi WHERE no_simpanan='$Kode'";
	$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query salah 2 : ".mysql_error());
	$my2Data = mysql_fetch_array($my2Qry);
	
	// Mentotal Saldo Simpanan
	$totalSaldo	= $my2Data['total_kredit'] - $my2Data['total_debit'];
?>

  <tr>
    <td> <?php echo $nomor; ?> </td>
    <td> <?php echo IndonesiaTgl($myData['tgl_simpanan']); ?> </td>
    <td> <?php echo $myData['no_simpanan']; ?> </td>
    <td> <?php echo $myData['no_nasabah']."/ ".$myData['nm_nasabah']; ?>  </td>
    <td align="right"> <?php echo format_angka($totalSaldo); ?> </td>
    <td width="60"><a href="?open=Transaksi-Penarikan&Kode=<?php echo $Kode; ?>" target="_blank">Penarikan</a></td>
    <td width="47"><a href="?open=Transaksi-Setoran&Kode=<?php echo $Kode; ?>" target="_blank">Setoran</a></td>
    <td width="40"><a href="simpanan_cetak.php?Kode=<?php echo $Kode; ?>" target="_blank">Cetak</a></td>
  </tr>
  
<?php } ?>

  <tr>
    <td colspan="3"><strong>Jumlah Data : <?php echo $jumlah; ?> </strong></td>
    <td colspan="5" align="right"><strong>Halaman Ke : 
	<?php
	for ($h = 1; $h <= $maks; $h++) {
		echo " <a href='?open=Simpanan-Tampil&hal=$h'>$h</a> ";
	}
	?> </strong> </td>
  </tr>
</table>
</body>
</html>
