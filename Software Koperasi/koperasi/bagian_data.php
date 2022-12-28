<?php
// Membaca session Login
include_once "library/inc.seslogin.php";

// Koneksi ke database MySQL
include_once "library/inc.connection.php";
?> 
<table width="650" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td width="789" colspan="2"><h1><b>DATA BAGIAN  </b></h1></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><a href="?open=Bagian-Add" target="_self"><img src="images/btn_add_data.png" height="30" border="0"  /></a></td>
  </tr>
  <tr>
    <td colspan="2">
	<table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="5%" bgcolor="#CCCCCC"><strong>No</strong></td>
        <td width="10%" bgcolor="#CCCCCC"><strong>Kode</strong></td>
        <td width="67%" bgcolor="#CCCCCC"><strong>Nama Bagian </strong></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
        </tr>
		
	<?php
	// Skrip menampilkan data Bagian
	$mySql 	= "SELECT * FROM bagian ORDER BY kd_bagian ASC";
	$myQry 	= mysql_query($mySql, $koneksidb) or die ("Query  salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_bagian'];
	?>
	
      <tr>
        <td> <?php echo $nomor; ?> </td>
        <td> <?php echo $myData['kd_bagian']; ?> </td>
        <td> <?php echo $myData['nm_bagian']; ?> </td>
        <td width="9%" align="center"><a href="?open=Bagian-Delete&Kode=<?php echo $Kode; ?>" target="_self" 
			onclick="return confirm('YAKIN INGIN MENGHAPUS DATA BAGIAN INI ... ?')">Delete</a></td>
        <td width="9%" align="center"><a href="?open=Bagian-Edit&Kode=<?php echo $Kode; ?>" target="_self">Edit</a></td>
      </tr>
	  
<?php } ?> 
 
    </table>
	</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>

 