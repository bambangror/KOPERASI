<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

date_default_timezone_set("Asia/Jakarta");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Transaksi Pinjaman - Koperasi Mandiri </title>

<link href="../styles/style.css" rel="stylesheet" type="text/css">
<link href="../plugins/tigra_calendar/tcal.css" rel="stylesheet" type="text/css" />

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
    <td><a href="?open=Pinjaman-Baru" target="_self">Pinjaman Baru</a> | <a href="?open=Pinjaman-Tampil" target="_self">Tampil Pinjaman</a> </td>
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
		case 'Pinjaman-Baru' :
			if(!file_exists ("pinjaman_baru.php")) die ("File tidak ada !"); 
			include "pinjaman_baru.php";	break;
		case 'Pinjaman-Tampil' :
			if(!file_exists ("pinjaman_tampil.php")) die ("File tidak ada !"); 
			include "pinjaman_tampil.php";	break;
		case 'Pinjaman-Batal' :
			if(!file_exists ("pinjaman_batal.php")) die ("File tidak ada !"); 
			include "pinjaman_batal.php";	break;

		case 'Setoran-Bayar' :
			if(!file_exists ("setoran_bayar.php")) die ("File tidak ada !"); 
			include "setoran_bayar.php";	break;

	}
}
else {
	include "pinjaman_baru.php";
}
?>
</body>
</html>