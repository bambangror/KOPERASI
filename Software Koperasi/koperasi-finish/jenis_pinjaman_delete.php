<?php
// Periksa Login
include_once "library/inc.seslogin.php"; 

// Koneksi ke database MySQL
include_once "library/inc.connection.php";

// Membaca variabel Kode pada URL (alamat browser)
if(isset($_GET['Kode'])){
	$Kode	= $_GET['Kode'];

	// Hapus data sesuai Kode yang terbaca
	$mySql = "DELETE FROM jenis_pinjaman WHERE kd_jpinjaman='$Kode' ";

	$myQry = mysql_query($mySql, $koneksidb) or die ("Error hapus data".mysql_error());
	if($myQry){
		// Refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?open=Jenis-Pinjaman-Data'>";
	}
}
else {
	// Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
?>
