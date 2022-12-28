<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

date_default_timezone_set("Asia/Jakarta");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Transaksi Simpanan - Koperasi Mandiri </title>

<link rel="stylesheet" type="text/css" href="../styles/style.css">
<link rel="stylesheet" type="text/css" href="../plugins/tigra_calendar/tcal.css">

<script type="text/javascript" src="../plugins/tigra_calendar/tcal.js"></script> 
<script type="text/javascript" src="../plugins/js.popupWindow.js"></script>

</head>
<body>
<table width="400" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="../images/logo.png" width="499" height="80"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="?open=Simpanan-Baru" target="_self">Simpanan Baru</a> | <a href="?open=Simpanan-Tampil" target="_self">Tampil Simpanan</a> </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
# KONTROL MENU PROGRAM
if(isset($_GET['open'])) {
	// Jika mendapatkan variabel URL ?open
	switch($_GET['open']){				
		case 'Simpanan-Baru' :
			if(!file_exists ("simpanan_baru.php")) die ("File tidak ada !"); 
			include "simpanan_baru.php";	break;
		case 'Simpanan-Tampil' :
			if(!file_exists ("simpanan_tampil.php")) die ("File tidak ada !"); 
			include "simpanan_tampil.php";	break;
		case 'Simpanan-Batal' :
			if(!file_exists ("simpanan_batal.php")) die ("File tidak ada !"); 
			include "simpanan_batal.php";	break;

		case 'Transaksi-Setoran' :
			if(!file_exists ("transaksi_setoran.php")) die ("File tidak ada !"); 
			include "transaksi_setoran.php";	break;
		case 'Transaksi-Penarikan' :
			if(!file_exists ("transaksi_penarikan.php")) die ("File tidak ada !"); 
			include "transaksi_penarikan.php";	break;

	}
}
else {
	include "simpanan_tampil.php";
}
?>
</body>
</html>