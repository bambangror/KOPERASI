<?php
session_start();
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/inc.pilihan.php";
include_once "library/inc.tanggal.php";

// Baca Jam pada Komputer
date_default_timezone_set("Asia/Jakarta");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title> :: KOPERASI MANDIRI - Sistem Informasi Koperasi Simpan Pinjam </title>

<link type="text/css" rel="stylesheet" href="styles/style.css">

<link type="text/css" rel="stylesheet" href="plugins/tigra_calendar/tcal.css"/>

<script type="text/javascript" src="plugins/tigra_calendar/tcal.js"></script> 

</head>
<div id="wrap">
<body>
<table width="100%" class="table-main">
  <tr>
    <td height="103" colspan="2"> <div id="header"><a href="?open"><img src="images/logo.png" border="0" /> </a></div></td>
  </tr>
  <tr valign="top">
    <td width="15%"  style="border-right:5px solid #DDDDDD;"><div style="margin:5px; padding:5px;"><?php include "menu.php"; ?></div></td>
    <td width="69%" height="550"><div style="margin:5px; padding:5px;"><?php include "buka_file.php";?></div></td>
  </tr>
</table>
</body>
</div>
</html>
