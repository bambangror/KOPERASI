<?php
// Koneksi ke database MySQL
include_once "library/inc.connection.php";

// Untuk pembagian halaman data (Paging)
$baris	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 1;
$infoSql= "SELECT * FROM pegawai";
$infoQry= mysql_query($infoSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumlah	= mysql_num_rows($infoQry);
$maks	= ceil($jumlah/$baris); 
$mulai	= $baris * ($hal-1); 
?> 
<table width="700" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2"><h1><b>DATA PEGAWAI  </b></h1></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><a href="?open=Pegawai-Add" target="_self"><img src="images/btn_add_data.png" height="30" border="0"  /></a></td>
  </tr>
  <tr>
    <td colspan="2">
	<table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="5%" bgcolor="#CCCCCC"><strong>No</strong></td>
        <td width="8%" bgcolor="#CCCCCC"><strong>Kode</strong></td>
        <td width="11%" bgcolor="#CCCCCC"><strong>NIP</strong></td>
        <td width="36%" bgcolor="#CCCCCC"><strong>Nama Pegawai </strong></td>
        <td width="4%" bgcolor="#CCCCCC"><strong>L/P</strong></td>
        <td width="22%" bgcolor="#CCCCCC"><strong>Bagian</strong></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
        </tr>
<?php
// Skrip menampilkan data Pegawai
$mySql 	= "SELECT pegawai.*, bagian.nm_bagian FROM pegawai 
			LEFT JOIN bagian ON pegawai.kd_bagian = bagian.kd_bagian 
			ORDER BY kd_pegawai ASC LIMIT $mulai, $baris";
$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah: ".mysql_error());
$nomor  = $mulai; 
while ($myData = mysql_fetch_array($myQry)) {
	$nomor++;
	$Kode = $myData['kd_pegawai'];
?>
  <tr>
	<td> <?php echo $nomor; ?> </td>
	<td> <?php echo $myData['kd_pegawai']; ?> </td>
	<td> <?php echo $myData['nip']; ?> </td>
	<td> <?php echo $myData['nm_pegawai']; ?> </td>
	<td> <?php echo $myData['kelamin']; ?> </td>
	<td> <?php echo $myData['nm_bagian']; ?> </td>
	<td width="7%"><a href="?open=Pegawai-Delete&Kode=<?php echo $Kode; ?>" target="_self" onclick="return confirm('YAKIN INGIN MENGHAPUS DATA PEGAWAI INI ... ?')">Delete</a></td>
	<td width="7%"><a href="?open=Pegawai-Edit&Kode=<?php echo $Kode; ?>" target="_self">Edit</a></td>
  </tr>
<?php } ?>
    </table></td>
  </tr>
  <tr>
    <td width="394"> <strong>Jumlah Data:</strong> <?php echo $jumlah; ?> </td>
    <td width="245" align="right"> <strong>Halaman Ke : </strong>
	<?php
	for ($h = 1; $h <= $maks; $h++) {
		echo " <a href='?open=Pegawai-Data&hal=$h'>$h</a> ";
	}
	?>	</td>
  </tr>
</table>

