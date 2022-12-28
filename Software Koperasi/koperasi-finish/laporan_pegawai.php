<?php
include_once "library/inc.library.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 1;
$infoSql= "SELECT * FROM pegawai"; 
$infoQry= mysql_query($infoSql, $koneksidb) or die ("error halaman: ".mysql_error());
$jumlah	= mysql_num_rows($infoQry);
$maks	= ceil($jumlah/$baris);
$mulai	= $baris * ($hal-1); 

?>
<h2>LAPORAN DATA PEGAWAI </h2>
<table class="table-list"  width="750" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td width="22" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="45" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="216" bgcolor="#CCCCCC"><strong>Nama Pegawai </strong></td>
    <td width="34" bgcolor="#CCCCCC"><strong>L/ P </strong></td>
    <td width="138" bgcolor="#CCCCCC"><strong>No. Telepon </strong></td>
    <td width="115" bgcolor="#CCCCCC"><strong>Username</strong></td>
    <td width="70" bgcolor="#CCCCCC"><strong>Level</strong></td>
    <td width="44" bgcolor="#CCCCCC"><strong>Tools</strong></td> 
  </tr>
  
<?php
// Skrip menampilkan data Pegawai
$mySql 	= "SELECT * FROM pegawai ORDER BY kd_pegawai ASC LIMIT $mulai, $baris";
$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
$nomor  = $mulai; 
while ($myData = mysql_fetch_array($myQry)) {
	$nomor++;
?>

  <tr>
	<td> <?php echo $nomor; ?> </td>
	<td> <?php echo $myData['kd_pegawai']; ?> </td>
	<td> <?php echo $myData['nm_pegawai']; ?> </td>
	<td> <?php echo $myData['kelamin']; ?> </td>
	<td> <?php echo $myData['no_telepon']; ?> </td>
	<td> <?php echo $myData['login_username']; ?> </td>
	<td> <?php echo $myData['login_level']; ?> </td>
    <td> <a href="cetak/pegawai_cetak.php?Kode=<?php echo $myData['kd_pegawai']; ?>" target="_blank">Cetak</a> </td>
  </tr>
  
<?php } ?>

  <tr>
    <td colspan="3"><strong>Jumlah Data :  <?php echo $jumlah; ?> </strong></td>
    <td colspan="5" align="right"> <strong>Halaman Ke : <?php
	for ($h = 1; $h <= $maks; $h++) {
		echo " <a href='?open=Laporan-Pegawai&hal=$h'>$h</a> ";
	}
	?>
	</strong></td>
  </tr>
</table>
