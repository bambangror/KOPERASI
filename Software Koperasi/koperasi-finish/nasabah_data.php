<?php
// Periksa Login
include_once "library/inc.seslogin.php"; 

// Koneksi database
include_once "library/inc.connection.php";

# TOMBOL CARI
if(isset($_POST['btnCari'])) {
	$txtKataKunci	= $_POST['txtKataKunci'];
	$filterSQL 		= "WHERE nm_nasabah LIKE '%$txtKataKunci%' OR no_nasabah ='$txtKataKunci'";
}
else {
	$filterSQL 	= "";
}

// Variabel pada form cari
$dataKataKunci	= isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : '';

// Untuk pembagian halaman data (Paging)
$baris	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 1;


$infoSql= "SELECT * FROM nasabah $filterSQL";
$infoQry= mysql_query($infoSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumlah	= mysql_num_rows($infoQry);
$maks	= ceil($jumlah/$baris); 
$mulai	= $baris * ($hal-1);
?>
<html>
<head>
<title>Data Nasabah</title>
</head>
<body>

<table class="table-common" width="700" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td colspan="2"><strong><h1>DATA NASABAH </h1></strong></td>
  </tr>
  <tr>
    <td colspan="2">

  <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
    <table width="100%" border="0" cellspacing="2" cellpadding="3">
      <tr>
        <td width="24%" bgcolor="#CCCCCC"><strong>PENCARIAN</strong></td>
        <td width="1%">&nbsp;</td>
        <td width="75%">&nbsp;</td>
      </tr>
      <tr>
        <td><strong>No. / Nama Nasabah </strong></td>
        <td>:</td>
        <td><input name="txtKataKunci" type="text" id="txtKataKunci" value="<?php echo $dataKataKunci; ?>" size="40" maxlength="100">
          <input name="btnCari" type="submit" id="btnCari" value="Cari"></td>
      </tr>
    </table>
  </form>
	
	</td>
  </tr>
  <tr>
    <td colspan="2" align="right"><a href="?open=Nasabah-Add" target="_self"><img src="images/btn_add_data.png" width="140" height="34" border="0"></a></td>
  </tr>
  <tr>
    <td colspan="2"><table class="table-list" width="100%" border="0" cellspacing="2" cellpadding="3">
      <tr>
        <td width="5%" bgcolor="#CCCCCC"><strong>No</strong></td>
        <td width="10%" bgcolor="#CCCCCC"><strong>Kode</strong></td>
        <td width="60%" bgcolor="#CCCCCC"><strong>Nama Nasabah </strong></td>
        <td width="8%" bgcolor="#CCCCCC"><strong>L/ P </strong></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
        </tr>
	  
<?php
// Skrip menampilkan data Nasabah
$mySql 	= "SELECT * FROM nasabah $filterSQL ORDER BY no_nasabah ASC LIMIT $mulai, $baris";
$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah: ".mysql_error());
$nomor  = $mulai; 
while ($myData = mysql_fetch_array($myQry)) {
	$nomor++;
	$Kode = $myData['no_nasabah'];
?>	

      <tr>
        <td> <?php echo $nomor; ?> </td>
        <td> <?php echo $myData['no_nasabah']; ?> </td>
        <td> <?php echo $myData['nm_nasabah']; ?> </td>
        <td> <?php echo $myData['kelamin']; ?> </td>
        <td width="9%" align="center"><a href="?open=Nasabah-Delete&Kode=<?php echo $Kode; ?>" target="_blank">Delete</a></td>
        <td width="8%" align="center"><a href="?open=Nasabah-Edit&Kode=<?php echo $Kode; ?>" target="_blank">Edit</a></td>
      </tr>

<?php } ?> 
   
    </table></td>
  </tr>
  <tr>
    <td width="309"><strong>Jumlah Data : </strong>  <?php echo $jumlah; ?>  </td>
    <td width="373" align="right"><strong>Halaman Ke : </strong>

	<?php
	for ($h = 1; $h <= $maks; $h++) {
		echo " <a href='?open=Nasabah-Data&hal=$h'>$h</a> ";
	}
	?> 

</td>
  </tr>
</table>
</body>
</html>
