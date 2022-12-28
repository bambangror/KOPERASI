<?php
include_once "../library/inc.seslogin.php";

# FILTER PEMBELIAN PER BULAN/TAHUN
# Bulan dan Tahun Terpilih
$bulan		= isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Baca dari URL, jika tidak ada diisi bulan sekarang
$dataBulan 	= isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : $bulan; // Baca dari form Submit, jika tidak ada diisi dari $bulan

$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun

# Membuat Filter Bulan
if($dataBulan and $dataTahun) {
	if($dataBulan == "00") {
		// Jika tidak memilih bulan
		$filterSQL = "WHERE LEFT(pinjaman_setoran.tgl_setoran,4)='$dataTahun'";
	}
	else {
		// Jika memilih bulan dan tahun
		$filterSQL = "WHERE LEFT(pinjaman_setoran.tgl_setoran,4)='$dataTahun' AND MID(pinjaman_setoran.tgl_setoran,6,2)='$dataBulan'";
	}
}
else {
	$filterSQL = "";
}
# ==================================================================

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 100;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM pinjaman_setoran $filterSQL ";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jmlData	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<h1><b>DATA SETORAN </b> </h1>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="500" border="0"  class="table-list">
    <tr>
      <td bgcolor="#CCCCCC"><strong>FILTER DATA</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Bulan Setoran </strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbBulan">
          <?php
		// Membuat daftar Nama Bulan
		$listBulan = array("00" => "....", 
						"01" => "01. Januari", 
						"02" => "02. Februari", 
						"03" => "03. Maret",
						"04" => "04. April", 
						"05" => "05. Mei", 
						"06" => "06. Juni", 
						"07" => "07. Juli",
						"08" => "08. Agustus", 
						"09" => "09. September", 
						"10" => "10. Oktober",
						"11" => "11. November", 
						"12" => "12. Desember");
						 
		// Menampilkan Nama Bulan ke ComboBox (List/Menu)
		foreach($listBulan as $bulanKe => $bulanNm) {
			if ($bulanKe == $dataBulan) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$bulanKe' $cek>$bulanNm</option>";
		}
	  ?>
        </select>
          <select name="cmbTahun">
            <?php
		# Baca tahun terendah(awal) di tabel Transaksi
		$thnSql = "SELECT MIN(LEFT(tgl_setoran,4)) As tahun_kecil, MAX(LEFT(tgl_setoran,4)) As tahun_besar FROM pinjaman_setoran";
		$thnQry	= mysql_query($thnSql, $koneksidb) or die ("Error".mysql_error());
		$thnRow	= mysql_fetch_array($thnQry);
		$thnKecil = $thnRow['tahun_kecil'];
		$thnBesar = $thnRow['tahun_besar'];
		
		// Menampilkan daftar Tahun, dari tahun terkecil sampai Terbesar (tahun sekarang)
		for($thn= $thnKecil; $thn <= $thnBesar; $thn++) {
			if ($thn == $dataTahun) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$thn' $cek>$thn</option>";
		}
	  ?>
        </select></td>
    </tr>
    <tr>
      <td width="137">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="344"><input name="btnTampil" type="submit" value=" Tampilkan " /></td>
    </tr>
  </table>
</form>

<table width="900" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
	<table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="24"><strong>No</strong></th>
        <th width="80"><strong>No. Setoran </strong></th>
        <th width="85"><strong>Tgl. Setoran </strong></th>
        <th width="90"><strong>No. Pinjaman </strong></th>
        <th width="186"><strong>Nasabah </strong></th>
        <th width="100" align="right"><strong>Pokok (Rp) </strong></th>
        <th width="100" align="right">Bunga (Rp) </th>
        <th width="90" align="right"><strong>Denda(Rp) </strong></th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
      </tr>
      <?php
	  // Menampilkan data transaksi Pinjaman Setoran
	$mySql = "SELECT pinjaman_setoran.*, pinjaman.tgl_pinjaman, nasabah.no_nasabah, nasabah.nm_nasabah 
				FROM pinjaman_setoran
				LEFT JOIN pinjaman ON pinjaman_setoran.no_pinjaman = pinjaman.no_pinjaman 
				LEFT JOIN nasabah ON pinjaman.no_nasabah = nasabah.no_nasabah
				$filterSQL ORDER BY pinjaman.no_pinjaman DESC LIMIT $halaman, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $halaman; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['no_setoran'];
		
			// gradasi warna
			if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
		?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['no_setoran']; ?></td>
        <td><?php echo IndonesiaTgl($myData['tgl_setoran']); ?></td>
        <td><?php echo $myData['no_pinjaman']; ?></td>
        <td><?php echo $myData['no_nasabah']."/ ".$myData['nm_nasabah']; ?></td>
        <td align="right"><?php echo format_angka($myData['setoran_pokok']); ?></td>
        <td align="right"><?php echo format_angka($myData['setoran_bunga']); ?></td>
        <td align="right"><?php echo format_angka($myData['denda']); ?></td>
        <td width="44" align="center"><a href="?open=Setoran-Hapus&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('YAKIN AKAN MENGHAPUS DATA SETORAN ( <?php echo $Kode; ?> ) INI ... ?')">Delete</a></td>
        <td width="44" align="center"><a href="setoran_nota.php?noSetoran=<?php echo $Kode; ?>" target="_blank">Nota</a></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr class="selKecil">
    <td width="299"><b>Jumlah Data :<?php echo $jmlData; ?></b></td>
    <td width="480" align="right"><b>Halaman ke :</b>
      <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Setoran-Tampil&hal=$list[$h]&bulan=$dataBulan&tahun=$dataTahun'>$h</a> ";
	}
	?></td>
  </tr>
</table>
