<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

# MEMBACA DATA DARI DATABASE 
$Kode	 = isset($_GET['Kode']) ? $_GET['Kode'] : ''; 
$mySql	 = "SELECT pegawai.*, bagian.nm_bagian FROM pegawai 
			LEFT JOIN bagian ON pegawai.kd_bagian = bagian.kd_bagian
			WHERE pegawai.kd_pegawai='$Kode'";
$myQry	 = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
$myData	 = mysql_fetch_array($myQry);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Data Pegawai</title>
</head>
<body>
<strong><h2> DATA PEGAWAI </h2></strong>
<table class="table-list" width="700" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td bgcolor="#CCCCCC" class="table-list"><strong> DATA PEGAWAI </strong></td>
    <td width="6">&nbsp;</td>
    <td width="459">&nbsp;</td>
  </tr>
  <tr>
    <td width="209"><strong>Kode</strong></td>
    <td>:</td>
    <td> <?php echo $myData['kd_pegawai']; ?> </td>
  </tr>
  <tr>
    <td><strong>NIP</strong></td>
    <td>:</td>
    <td> <?php echo $myData['nip']; ?> </td>
  </tr>
  <tr>
    <td><strong>Nama Pegawai </strong></td>
    <td>:</td>
    <td> <?php echo $myData['nm_pegawai']; ?>  </td>
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
    <td><strong>Bagian</strong></td>
    <td>:</td>
    <td> <?php echo $myData['nm_bagian']; ?> </td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC"><strong>LOGIN</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Username</strong></td>
    <td>:</td>
    <td> <?php echo $myData['login_username']; ?> </td>
  </tr>
  <tr>
    <td><strong>Level</strong></td>
    <td>:</td>
    <td> <?php echo $myData['login_level']; ?></td>
  </tr>
</table>
</body>
</html>
