<?php
include_once "library/inc.library.php";
?>
<h2>LAPORAN JENIS PINJAMAN </h2>
<table class="table-list" width="700" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td width="24" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="51" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="201" bgcolor="#CCCCCC"><strong>Jenis Pinjaman </strong></td>
    <td width="304" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td width="78" bgcolor="#CCCCCC"><strong>Bunga (%) </strong></td>
  </tr>
 
<?php
// Skrip menampilkan data Jenis Pinjaman
$mySql 	= "SELECT * FROM jenis_pinjaman ORDER BY kd_jpinjaman ASC";
$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
$nomor  = 0; 
while ($myData = mysql_fetch_array($myQry)) {
	$nomor++;
?> 

  <tr>
	<td> <?php echo $nomor; ?> </td>
	<td> <?php echo $myData['kd_jpinjaman']; ?> </td>
	<td> <?php echo $myData['nm_jpinjaman']; ?> </td>
	<td> <?php echo $myData['keterangan']; ?> </td>
	<td> <?php echo $myData['bunga']; ?> %</td>
  </tr>
 
 <?php } ?> 
</table>
