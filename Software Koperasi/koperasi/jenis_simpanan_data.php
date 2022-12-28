<?php
// Koneksi ke database MySQL
include_once "library/inc.connection.php";
?> 
<table width="650" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td width="789" colspan="2"><h1><b>DATA JENIS SIMPANAN </b></h1></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><a href="?open=Jenis-Simpanan-Add" target="_self"><img src="images/btn_add_data.png" height="30" border="0"  /></a></td>
  </tr>
  <tr>
    <td colspan="2"><table width="650" border="0" cellspacing="2" cellpadding="3" class="table-list">
      <tr>
        <td width="21" bgcolor="#CCCCCC"><strong>No</strong></td>
        <td width="52" bgcolor="#CCCCCC"><strong>Kode</strong></td>
        <td width="303" bgcolor="#CCCCCC"><strong>Jenis Simpanan </strong></td>
        <td width="130" bgcolor="#CCCCCC"><strong>Bunga (%) </strong></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
        </tr>

<?php
// Skrip menampilkan data Jenis Simpanan
$mySql 	= "SELECT * FROM jenis_simpanan ORDER BY kd_jsimpanan ASC";
$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
$nomor  = 0; 
while ($myData = mysql_fetch_array($myQry)) {
	$nomor++;
	$Kode = $myData['kd_jsimpanan'];
?>

      <tr>
        <td> <?php echo $nomor; ?> </td>
        <td> <?php echo $myData['kd_jsimpanan']; ?> </td>
        <td> <?php echo $myData['nm_jsimpanan']; ?> </td>
        <td> <?php echo $myData['bunga']; ?> %</td>
        <td width="47"><a href="?open=Jenis-Simpanan-Delete&amp;Kode=<?php echo $Kode; ?>" target="_blank">Delete</a></td>
        <td width="47"><a href="?open=Jenis-Simpanan-Edit&amp;Kode=<?php echo $Kode; ?>" target="_blank">Edit</a></td>
      </tr>
	  
<?php } ?>

    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>

 