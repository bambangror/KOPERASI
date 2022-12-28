<?php
if(isset($_SESSION['SES_LOGIN'])){
	# JIKA SUDAH LOGIN, menu di bawah yang dijalankan
	$levelAkses = $_SESSION['SES_LEVEL'];
	
	if($levelAkses =="Admin") {
		// MENU UNTUK ADMINISTRATOR
		?>
		
		<ul>
			<li><a href="?open" target="_self">Home</a></li>
			<li> Data Bagian </li>
			<li> Data Pegawai </li>
			<li> Data Jenis Pinjaman </li>
			<li> Data Jenis Simpanan </li>
			<li>Data Nasabah </li>
			<li> Transaksi Pinjaman </li>
			<li> Transaksi Simpanan </li>
			<li> Laporan </li>
			<li> <a href="?open=Logout" target="_self"> Logout </a></li>
		</ul>	 
		
	<?php 
	}
	else if($levelAkses =="Kasir") {
		// MENU UNTUK KASIR
		
	
	}
	else {
		// TIDAK ADA LEVEL
	}
}
else {
	# JIKA BELUM LOGIN (Tidak ada Session yang ditemukan)
?>
	<ul>
		<li><a href="?open=Login" target="_self">Login</a> </li>	
	</ul>
<?php
}
?>
