<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

# MEMBACA DATA DARI DATABASE 
$Kode	 = isset($_GET['Kode']) ? $_GET['Kode'] : ''; 
$mySql	 = "SELECT * FROM nasabah WHERE no_nasabah ='$Kode'";
$myQry	 = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
$myData	 = mysql_fetch_array($myQry);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Data Nasabah</title></head>
<body>
<strong>
<h2> DATA NASABAH </h2>
</strong>
<table class="table-list" width="700" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td width="209"><strong>Kode</strong></td>
    <td width="6">:</td>
    <td width="459"> <?php echo $myData['no_nasabah']; ?> </td>
  </tr>
  <tr>
    <td><strong>Nama Pegawai </strong></td>
    <td>:</td>
    <td> <?php echo $myData['nm_nasabah']; ?>  </td>
  </tr>
  <tr>
    <td><strong>Kelamin</strong></td>
    <td>:</td>
    <td> <?php echo $myData['kelamin']; ?> </td>
  </tr>
  <tr>
    <td><strong>Agama</strong></td>
    <td>:</td>
    <td> <?php echo $myData['agama']; ?> </td>
  </tr>
  <tr>
    <td><strong>Tempat &amp; Tgl. Lahir </strong></td>
    <td>:</td>
    <td> <?php echo $myData['tempat_lahir']; 
			  echo ", ";
			  echo IndonesiaTgl($myData['tanggal_lahir']); ?> </td>
  </tr>
  <tr>
    <td><strong>Alamat</strong></td>
    <td>:</td>
    <td> <?php echo $myData['alamat']; ?></td>
  </tr>
  <tr>
    <td><strong>No. Telepon </strong></td>
    <td>:</td>
    <td> <?php echo $myData['no_telepon']; ?> </td>
  </tr>
  <tr>
    <td><strong>Status Kawin </strong></td>
    <td>:</td>
    <td> <?php echo $myData['status_kawin']; ?> </td>
  </tr>
  <tr>
    <td><strong>Nama Pasangan </strong></td>
    <td>:</td>
    <td> <?php echo $myData['nama_pasangan']; ?> </td>
  </tr>
  <tr>
    <td><strong>Jenis Pekerjaan </strong></td>
    <td>:</td>
    <td> <?php echo $myData['jenis_pekerjaan']; ?></td>
  </tr>
</table>
</body>
</html>
