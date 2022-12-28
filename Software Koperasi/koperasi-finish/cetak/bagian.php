<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
?>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">

<h2>LAPORAN DATA BAGIAN </h2>
<table class="table-list" width="600" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="23" height="23" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="55" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="506" bgcolor="#CCCCCC"><b>Nama Bagian </b></td>
  </tr>
  
	<?php
	// Skrip menampilkan data Bagian
	$mySql = "SELECT * FROM bagian ORDER BY kd_bagian";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error()); 
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_bagian']; ?></td>
    <td><?php echo $myData['nm_bagian']; ?></td>
  </tr>
  <?php } ?>
</table>
