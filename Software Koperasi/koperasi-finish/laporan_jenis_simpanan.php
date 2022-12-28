<?php
include_once "library/inc.library.php";
?>
<h2>LAPORAN JENIS SIMPANAN </h2>
<table class="table-list" width="600" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td width="25" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="56" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="404" bgcolor="#CCCCCC"><strong>Jenis Simpanan </strong></td>
    <td width="81" bgcolor="#CCCCCC"><strong>Bunga (%) </strong></td>
  </tr>

	<?php
	// Skrip menampilkan data Jenis Simpanan
	$mySql 	= "SELECT * FROM jenis_simpanan ORDER BY kd_jsimpanan ASC";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>

  <tr>
	<td> <?php echo $nomor; ?> </td>
	<td> <?php echo $myData['kd_jsimpanan']; ?> </td>
	<td> <?php echo $myData['nm_jsimpanan']; ?> </td>
	<td> <?php echo $myData['bunga']; ?> % </td>
  </tr>
  
	<?php } ?>
</table>
