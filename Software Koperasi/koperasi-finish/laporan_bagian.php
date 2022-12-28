<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";
?>
<h2>LAPORAN DATA BAGIAN </h2>
<table class="table-list" width="600" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td width="24" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="52" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="498" bgcolor="#CCCCCC"><strong>Nama Bagian </strong></td>
  </tr>
  
	<?php
	// Skrip menampilkan data Bagian
	$mySql = "SELECT * FROM bagian ORDER BY kd_bagian";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error()); 
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
	
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_bagian']; ?></td>
    <td><?php echo $myData['nm_bagian']; ?></td>
  </tr>
  
  <?php } ?>
  
</table>
<br />
<a href="cetak/bagian.php" target="_blank"> Cetak</a>