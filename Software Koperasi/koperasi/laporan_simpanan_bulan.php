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
	$filterJenis	= "";
}
else {
	$filterJenis	= " AND simpanan.kd_jsimpanan='$dataJenis'";
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
		$filterSQL = "WHERE LEFT(tgl_simpanan,4)='$dataTahun' $filterJenis";
	}
	else {
		// Jika memilih bulan dan tahun
		$filterSQL = "WHERE LEFT(tgl_simpanan,4)='$dataTahun' AND MID(tgl_simpanan,6,2)='$dataBulan' $filterJenis";
	}
}
else {
	$filterSQL = "";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 1;
$pageSql= "SELECT * FROM simpanan $filterSQL";
$pageQry= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumlah	= mysql_num_rows($pageQry);
$maks	= ceil($jumlah/$baris);
$mulai	= $baris * ($hal-1); 
?>
<h2>LAPORAN  SIMPANAN PER BULAN </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="800" border="0"  class="table-list">
    
    <tr>
      <td bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Jenis Simpanan </strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbJenis" onchange="javascript:submitform();" >
          <option value="Kosong">....</option>
          <?php
		  // Skrip menampilkan data Jenis ke ComboBox (ListMenu)
	  $bacaSql = "SELECT * FROM jenis_simpanan ORDER BY kd_jsimpanan";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['kd_jsimpanan'] == $dataJenis) {
			$cek = " selected";
		} else { $cek=""; }
		
		echo "<option value='$bacaData[kd_jsimpanan]' $cek> $bacaData[nm_jsimpanan]</option>";
	  }
	  ?>
      </select></td>
    </tr>
    <tr>
      <td><strong>Periode Bulan/ Tahun </strong></td>
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
      <td width="159">&nbsp;</td>
      <td width="10">&nbsp;</td>
      <td width="617"><input name="btnTampil" type="submit" value=" Tampilkan " /></td>
    </tr>
  </table>
</form>

<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="24" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="98" bgcolor="#CCCCCC"><strong>No. Simpanan </strong></td>
    <td width="98" bgcolor="#CCCCCC"><strong>Tgl. Simpanan </strong></td>
    <td width="201" bgcolor="#CCCCCC"><strong>Nasabah</strong></td>
    <td width="233" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td width="115" align="right" bgcolor="#CCCCCC"><strong>Saldo Akhir (Rp) </strong></td>
  </tr>
  <?php
	  // Skrip menampilkan data Simpanan
	$mySql = "SELECT simpanan.*, nasabah.nm_nasabah
				FROM simpanan 
				LEFT JOIN nasabah ON simpanan.no_nasabah = nasabah.no_nasabah
				$filterSQL
				ORDER BY simpanan.no_simpanan DESC LIMIT $mulai, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $mulai; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['no_simpanan'];
		
		// Menghitng Total Simpanan Detil
		$my2Sql	= "SELECT SUM(debit) AS total_debit,  SUM(kredit) AS total_kredit FROM simpanan_transaksi WHERE no_simpanan='$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query salah 2 : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry);
		
		// Mentotal Saldo Simpanan
		$totalSaldo	= $my2Data['total_kredit'] - $my2Data['total_debit'];
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['no_simpanan']; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_simpanan']); ?></td>
    <td><?php echo $myData['no_nasabah']."/ ".$myData['nm_nasabah']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td align="right"><?php echo format_angka($totalSaldo); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3"><strong>Jumlah Data : </strong><?php echo $jumlah; ?></td>
    <td colspan="3" align="right"><strong>Halaman ke :</strong>
      <?php
	for ($h = 1; $h <= $maks; $h++) {
		echo " <a href='?open=Laporan-Simpanan-Bulan&hal=$h&bulan=$dataBulan&tahun=$dataTahun&jenis=$dataJenis'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<br />
