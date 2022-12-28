<?php
# KONTROL MENU PROGRAM
if(isset($_GET['open'])) {
	// Jika mendapatkan variabel URL ?open
	switch($_GET['open']){	

		case '' :
			if(!file_exists ("info.php")) die ("File tidak ada !"); 
			include "info.php";	break;
			
		case 'Halaman-Utama' :
			if(!file_exists ("info.php")) die ("File tidak ada !"); 
			include "info.php";	break;
		
		# KONTROL PROGRAM LOGIN
		case 'Login' :
			if(!file_exists ("login.php")) die ("File tidak ada !"); 
			include "login.php"; break;
			
		case 'Login-Validasi' :
			if(!file_exists ("login_validasi.php")) die ("File tidak ada !"); 
			include "login_validasi.php"; break;
			
		case 'Logout' :
			if(!file_exists ("login_out.php")) die ("File tidak ada !"); 
			include "login_out.php"; break;		

		# KONTROL PROGRAM MANAJEMEN DATA PELAJARAN
		case 'Bagian-Data' :
			if(!file_exists ("bagian_data.php")) die ("File tidak ada !"); 
			include "bagian_data.php";	 break;		
		case 'Bagian-Add' :
			if(!file_exists ("bagian_add.php")) die ("File tidak ada !"); 
			include "bagian_add.php";	 break;		
		case 'Bagian-Delete' :
			if(!file_exists ("bagian_delete.php")) die ("File tidak ada !"); 
			include "bagian_delete.php"; break;		
		case 'Bagian-Edit' :
			if(!file_exists ("bagian_edit.php")) die ("File tidak ada !"); 
			include "bagian_edit.php"; break;	

		# DATA PEGAWAI
		case 'Pegawai-Data' :
			if(!file_exists ("pegawai_data.php")) die ("File tidak ada !"); 
			include "pegawai_data.php";	 break;		
		case 'Pegawai-Add' :
			if(!file_exists ("pegawai_add.php")) die ("File tidak ada !"); 
			include "pegawai_add.php";	 break;		
		case 'Pegawai-Delete' :
			if(!file_exists ("pegawai_delete.php")) die ("File tidak ada !"); 
			include "pegawai_delete.php"; break;		
		case 'Pegawai-Edit' :
			if(!file_exists ("pegawai_edit.php")) die ("File tidak ada !"); 
			include "pegawai_edit.php"; break;	

		# KONTROL MENU DATA NASABAH
		case 'Nasabah-Data' :
			if(!file_exists ("nasabah_data.php")) die ("File tidak ada !"); 
			include "nasabah_data.php";	 break;		
		case 'Nasabah-Add' :
			if(!file_exists ("nasabah_add.php")) die ("File tidak ada !"); 
			include "nasabah_add.php";	 break;		
		case 'Nasabah-Delete' :
			if(!file_exists ("nasabah_delete.php")) die ("File tidak ada !"); 
			include "nasabah_delete.php"; break;		
		case 'Nasabah-Edit' :
			if(!file_exists ("nasabah_edit.php")) die ("File tidak ada !"); 
			include "nasabah_edit.php"; break;	

		# KONTROL PROGRAM MANAJEMEN DATA JENIS PINJAMAN
		case 'Jenis-Pinjaman-Data' :
			if(!file_exists ("jenis_simpanan_data.php")) die ("File tidak ada !"); 
			include "jenis_pinjaman_data.php";	 break;		
		case 'Jenis-Pinjaman-Add' :
			if(!file_exists ("jenis_pinjaman_add.php")) die ("File tidak ada !"); 
			include "jenis_pinjaman_add.php";	 break;		
		case 'Jenis-Pinjaman-Delete' :
			if(!file_exists ("jenis_pinjaman_delete.php")) die ("File tidak ada !"); 
			include "jenis_pinjaman_delete.php"; break;		
		case 'Jenis-Pinjaman-Edit' :
			if(!file_exists ("jenis_pinjaman_edit.php")) die ("File tidak ada !"); 
			include "jenis_pinjaman_edit.php"; break;	


		# JENIS SIMPANAN
		case 'Jenis-Simpanan-Data' :
			if(!file_exists ("jenis_simpanan_data.php")) die ("File tidak ada !"); 
			include "jenis_simpanan_data.php";	 break;		
		case 'Jenis-Simpanan-Add' :
			if(!file_exists ("jenis_simpanan_add.php")) die ("File tidak ada !"); 
			include "jenis_simpanan_add.php";	 break;		
		case 'Jenis-Simpanan-Delete' :
			if(!file_exists ("jenis_simpanan_delete.php")) die ("File tidak ada !"); 
			include "jenis_simpanan_delete.php"; break;		
		case 'Jenis-Simpanan-Edit' :
			if(!file_exists ("jenis_simpanan_edit.php")) die ("File tidak ada !"); 
			include "jenis_simpanan_edit.php"; break;	 
 			

		# REPORT INFORMASI / LAPORAN DATA
		case 'Laporan' :
				if(!file_exists ("menu_laporan.php")) die ("File tidak ada !"); 
				include "menu_laporan.php"; break;

			# LAPORAN MASTER DATA
			case 'Laporan-Bagian' :
				if(!file_exists ("laporan_bagian.php")) die ("File tidak ada !"); 
				include "laporan_bagian.php"; break;
				
			case 'Laporan-Jenis-Simpanan' :
				if(!file_exists ("laporan_jenis_simpanan.php")) die ("File tidak ada !"); 
				include "laporan_jenis_simpanan.php"; break;
				
			case 'Laporan-Jenis-Pinjaman' :
				if(!file_exists ("laporan_jenis_pinjaman.php")) die ("File tidak ada !"); 
				include "laporan_jenis_pinjaman.php"; break;
				
			case 'Laporan-Pegawai' :
				if(!file_exists ("laporan_pegawai.php")) die ("File tidak ada !"); 
				include "laporan_pegawai.php"; break;
				
			case 'Laporan-Nasabah' :
				if(!file_exists ("laporan_nasabah.php")) die ("File tidak ada !"); 
				include "laporan_nasabah.php"; break;
				
			case 'Laporan-Pinjaman-Nasabah' :
				if(!file_exists ("laporan_pinjaman_nasabah.php")) die ("File tidak ada !"); 
				include "laporan_pinjaman_nasabah.php"; break;
				
			case 'Laporan-Pinjaman-Periode' :
				if(!file_exists ("laporan_pinjaman_periode.php")) die ("File tidak ada !"); 
				include "laporan_pinjaman_periode.php"; break;
				
			case 'Laporan-Pinjaman-Bulan' :
				if(!file_exists ("laporan_pinjaman_bulan.php")) die ("File tidak ada !"); 
				include "laporan_pinjaman_bulan.php"; break;

			case 'Laporan-Simpanan-Nasabah' :
				if(!file_exists ("laporan_simpanan_nasabah.php")) die ("File tidak ada !"); 
				include "laporan_simpanan_nasabah.php"; break;
				
			case 'Laporan-Simpanan-Periode' :
				if(!file_exists ("laporan_simpanan_periode.php")) die ("File tidak ada !"); 
				include "laporan_simpanan_periode.php"; break;
				
			case 'Laporan-Simpanan-Bulan' :
				if(!file_exists ("laporan_simpanan_bulan.php")) die ("File tidak ada !"); 
				include "laporan_simpanan_bulan.php"; break;
		default:
			if(!file_exists ("info.php")) die ("File tidak ada !"); 
			include "info.php";						
		break;
	}
}
else {
	// Jika tidak mendapatkan variabel URL : ?open
	if(!file_exists ("info.php")) die ("File tidak ada !"); 
	include "info.php";	
}
?>