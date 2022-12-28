<?php
if(isset($_SESSION['SES_LOGIN'])){
	# JIKA SUDAH LOGIN, menu di bawah yang dijalankan
	$levelAkses = $_SESSION['SES_LEVEL'];
	
	if($levelAkses =="Admin") {
		// MENU UNTUK ADMINISTRATOR
		?>
		
		<ul>
			<li><a href="?open" target="_self">Home</a></li>
			<li><a href="?open=Bagian-Data" target="_self"> Data Bagian </a></li>
			<li><a href="?open=Pegawai-Data" target="_self"> Data Pegawai </a></li>
			<li><a href="?open=Jenis-Pinjaman-Data" target="_self"> Data Jenis Pinjaman </a></li>
			<li><a href="?open=Jenis-Simpanan-Data" target="_self"> Data Jenis Simpanan </a></li>
			<li><a href="?open=Nasabah-Data" target="_blank">Data Nasabah </a></li>
			<li><a href="pinjaman/" target="_blank"> Transaksi Pinjaman</a> </li>
			<li><a href="simpanan/" target="_blank"> Transaksi Simpanan</a> </li>
			<li> <a href="?open=Laporan" target="_self">Laporan</a> </li>
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
