<?php
// Koneksi ke database MySQL
include_once "library/inc.connection.php";
?> 
<table width="650" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td width="789" colspan="2"><h1><b>DATA JENIS PINJAMAN </b></h1></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><a href="?open=Jenis-Pinjaman-Add" target="_self"><img src="images/btn_add_data.png" height="30" border="0"  /></a></td>
  </tr>
  <tr>
    <td colspan="2"><table class="table-list" width="100%" border="0" cellspacing="2" cellpadding="3">
      <tr>
        <td width="4%" bgcolor="#CCCCCC"><strong>No</strong></td>
        <td width="8%" bgcolor="#CCCCCC"><strong>Kode</strong></td>
        <td width="22%" bgcolor="#CCCCCC"><strong>Jenis Pinjaman </strong></td>
        <td width="36%" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
        <td width="13%" bgcolor="#CCCCCC"><strong>Bunga (%) </strong></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
        </tr>
	  <?php
	// Skrip menampilkan data Jenis Pinjaman
	$mySql 	= "SELECT * FROM jenis_pinjaman ORDER BY kd_jpinjaman ASC";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_jpinjaman']; 
	?>

      <tr>
        <td> <?php echo $nomor; ?> </td>
        <td> <?php echo $myData['kd_jpinjaman']; ?> </td>
        <td> <?php echo $myData['nm_jpinjaman']; ?> </td>
        <td> <?php echo $myData['keterangan']; ?> </td>
        <td> <?php echo $myData['bunga']; ?> % </td> 
        <td width="9%"><a href="?open=Jenis-Pinjaman-Delete&amp;Kode=<?php echo $Kode; ?>" target="_blank">Delete</a></td>
        <td width="8%"><a href="?open=Jenis-Pinjaman-Edit&amp;Kode=<?php echo $Kode; ?>" target="_blank">Edit</a></td>
      </tr>
	  <?php } ?> 
	  
    </table>
	</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>

 