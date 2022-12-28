<?php
include_once "library/inc.library.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 1;
$infoSql= "SELECT * FROM nasabah"; 
$infoQry= mysql_query($infoSql, $koneksidb) or die ("error halaman: ".mysql_error());
$jumlah	= mysql_num_rows($infoQry);
$maks	= ceil($jumlah/$baris);
$mulai	= $baris * ($hal-1); 
?>
<h2>LAPORAN DATA NASABAH </h2>

<table class="table-list" width="750" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td width="22" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="45" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="201" bgcolor="#CCCCCC"><strong>Nama Nasabah </strong></td>
    <td width="28" bgcolor="#CCCCCC"><strong>L/ P </strong></td>
    <td width="256" bgcolor="#CCCCCC"><strong>Alamat</strong></td>
    <td width="100" bgcolor="#CCCCCC"><strong>No. Telepon </strong></td>
    <td width="40" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>

<?php
// Skrip menampilkan data Nasabah
$mySql 	= "SELECT * FROM nasabah ORDER BY no_nasabah ASC LIMIT $mulai, $baris";
$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
$nomor  = $mulai; 
while ($myData = mysql_fetch_array($myQry)) {
	$nomor++;
?>

  <tr>
	<td> <?php echo $nomor; ?> </td>
	<td> <?php echo $myData['no_nasabah']; ?> </td>
	<td> <?php echo $myData['nm_nasabah']; ?> </td>
	<td> <?php echo $myData['kelamin']; ?> </td>
	<td> <?php echo $myData['alamat']; ?> </td>
	<td> <?php echo $myData['no_telepon']; ?> </td>
    <td><a href="cetak/nasabah_cetak.php?Kode=<?php echo $myData['no_nasabah']; ?>" target="_blank">Cetak</a> </td>
  </tr>

<?php } ?> 

  <tr>
    <td colspan="3"><strong>Jumlah Data :</strong> <strong><?php echo $jumlah; ?></strong></td>
    <td colspan="4" align="right"><strong>Halaman Ke :
    <?php
	for ($h = 1; $h <= $maks; $h++) {
		echo " <a href='?open=Laporan-Nasabah&hal=$h'>$h</a> ";
	}
	?>
    </strong></td>
  </tr>
</table>
