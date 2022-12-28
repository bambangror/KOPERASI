<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/inc.pilihan.php";

# Jenis Terpilih
$jenis		= isset($_GET['jenis']) ? $_GET['jenis'] : 'Kosong'; // Baca dari URL 
$dataJenis 	= isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : $jenis; // Baca dari form Submit, jika tidak ada diisi dari $jenis

# Membuat filter Jenis
if($dataJenis =="Kosong") {
	$filterJenisSQL	= "";
}
else {
	$filterJenisSQL	= " AND pinjaman.kd_jpinjaman='$dataJenis'";
}

# Bulan terpilih dari Form dan URL
$bulan		= isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Baca dari URL, jika tidak ada diisi bulan sekarang
$dataBulan 	= isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : $bulan; // Baca dari form Submit, jika tidak ada diisi dari $bulan

# Tahun terpilih dari Form dan URL
$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun

# Membuat Filter Bulan
if($dataTahun and $dataBulan) {
	if($dataBulan == "00") {
		// Jika tidak memilih bulan
		$filterSQL = "WHERE LEFT(tgl_pinjaman,4)='$dataTahun' $filterJenisSQL";
	}
	else {
		// Jika memilih bulan dan tahun
		$filterSQL = "WHERE LEFT(tgl_pinjaman,4)='$dataTahun' AND MID(tgl_pinjaman,6,2)='$dataBulan' $filterJenisSQL";
	}
}
else {
	$filterSQL = "";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 1;
$pageSql= "SELECT * FROM pinjaman $filterSQL";
$pageQry= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumlah	= mysql_num_rows($pageQry);
$maks	= ceil($jumlah/$baris);
$mulai	= $baris * ($hal-1); 
?>
<h2>LAPORAN  PINJAMAN PER BULAN </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="900" border="0"  class="table-list">
    
    <tr>
      <td bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Jenis Pinjaman</strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbJenis" onchange="javascript:submitform();" >
          <option value="Kosong">....</option>
          <?php
		  // Skrip menampilkan data Jenis ke ComboBox (ListMenu)
	  $bacaSql = "SELECT * FROM jenis_pinjaman ORDER BY kd_jpinjaman";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['kd_jpinjaman'] == $dataJenis) {
			$cek = " selected";
		} else { $cek=""; }
		
		echo "<option value='$bacaData[kd_jpinjaman]' $cek> $bacaData[nm_jpinjaman]</option>";
	  }
	  ?>
        </select>
      </td>
    </tr>
    <tr>
      <td><strong>Periode Bulan </strong></td>
      <td><strong>:</strong></td>
  <td><select name="cmbBulan">
	<?php
	// Membuat daftar bulan 1 -12, nama bulan membaca di file inc.pilihan.php
	for($bulan = 1; $bulan <= 12; $bulan++) {
		// Skrip membuat angka 2 digit (1-9)
		if($bulan < 10) { $bln = "0".$bulan; } else { $bln = $bulan; }
		
		if ($bln == $dataBulan) { $cek=" selected"; } else { $cek = ""; }
		
		echo "<option value='$bln' $cek> $listBulan[$bln] </option>";
	}
	?>
  </select>
        <select name="cmbTahun">
          <?php
		  $$awal_th	= date('Y') - 3;
		  for($tahun = $$awal_th; $tahun <= date('Y'); $tahun++) {
			// Skrip tahun terpilih
			if ($tahun == $dataTahun) {  $cek=" selected"; } else { $cek = ""; }
			
			echo "<option value='$tahun' $cek> $tahun </option>";
		  }
		  ?>
        </select></td>
    </tr>
    <tr>
      <td width="137">&nbsp;</td>
      <td width="10">&nbsp;</td>
      <td width="739"><input name="btnTampil" type="submit" value=" Tampilkan " /></td>
    </tr>
  </table>
</form>

<table class="table-list" width="894" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="22" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="70" bgcolor="#CCCCCC"><strong>No. Pinjam </strong></td>
    <td width="70" bgcolor="#CCCCCC"><strong>Tgl. Pinjam </strong></td>
    <td width="128" bgcolor="#CCCCCC"><strong>Nasabah</strong></td>
    <td width="200" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td width="40" bgcolor="#CCCCCC"><strong>Tenor</strong></td>
    <td width="91" align="right" bgcolor="#CCCCCC"><strong>Pinjaman(Rp)</strong></td>
    <td width="90" align="right" bgcolor="#CCCCCC"><strong>Angsur Pokok(Rp) </strong></td>
    <td width="90" align="right" bgcolor="#CCCCCC"><strong>Angsur Bunga(Rp) </strong></td>
    <td width="42" bgcolor="#CCCCCC"><strong>Status</strong></td>
  </tr>
  <?php 
	// Skrip menampilkan data Peminjaman dengan filter Bulan dan Tahun
	$mySql = "SELECT pinjaman.*, nasabah.no_nasabah, nasabah.nm_nasabah 
				FROM pinjaman 
				LEFT JOIN nasabah ON pinjaman.no_nasabah = nasabah.no_nasabah
				$filterSQL
				ORDER BY pinjaman.no_pinjaman ASC LIMIT $mulai, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $mulai;  
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;		
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['no_pinjaman']; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pinjaman']); ?></td>
    <td><?php echo $myData['nm_nasabah']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td><?php echo $myData['lama_pinjaman']; ?> x </td>
    <td align="right"><?php echo format_angka($myData['besar_pinjaman']); ?></td>
    <td align="right"><?php echo format_angka($myData['angsuran_pokok']); ?></td>
    <td align="right"><?php echo format_angka($myData['angsuran_bunga']); ?></td>
    <td><?php echo $myData['status']; ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3"><strong>Jumlah Data : </strong><?php echo $jumlah; ?></td>
    <td colspan="7" align="right"><strong>Halaman ke :</strong>
<?php
for ($h = 1; $h <= $maks; $h++) {
	echo " <a href='?open=Laporan-Pinjaman-Bulan&hal=$h&bulan=$dataBulan&tahun=$dataTahun&jenis=$dataJenis'>$h</a> ";
}
?></td>
  </tr>
</table>
<br />

