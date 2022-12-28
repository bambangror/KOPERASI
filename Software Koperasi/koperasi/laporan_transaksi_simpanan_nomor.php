<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/inc.pilihan.php";

# Nasabah terpilih dari Form dan URL
$nomorSp		= isset($_GET['nomorSp']) ? $_GET['nomorSp'] : 'Kosong'; // Baca dari URL, jika tidak ada diisi nsb sekarang
$dataSimpanan 	= isset($_POST['cmbSimpanan']) ? $_POST['cmbSimpanan'] : $nomorSp; // Baca dari form Submit, jika tidak ada diisi dari $nsb

# Membuat Filter Nomor Pinjaman
if($dataSimpanan=="Kosong") {
	$filterSQL = "";
}
else {
	$filterSQL = "WHERE simpanan_transaksi.no_simpanan='$dataSimpanan'";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 1;
$pageSql= "SELECT * FROM simpanan_transaksi $filterSQL";
$pageQry= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumlah	= mysql_num_rows($pageQry);
$maks	= ceil($jumlah/$baris);
$mulai	= $baris * ($hal-1); 
?>
<h2>LAPORAN TRANSAKSI SIMPANAN PER NOMOR </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="500" border="0"  class="table-list">
    
    <tr>
      <td width="137" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
      <td width="10">&nbsp;</td>
      <td width="341">&nbsp;</td>
    </tr>
    <tr>
      <td><strong>No. Simpanan </strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbSimpanan">
          <option value="Kosong">....</option>
          <?php
	  // Skrip menampilkan data Nomor Pinjaman ke ComboBox (ListMenu)
	  $bacaSql = "SELECT simpanan.no_simpanan, nasabah.nm_nasabah FROM simpanan LEFT JOIN nasabah ON simpanan.no_nasabah = nasabah.no_nasabah ORDER BY simpanan.no_simpanan";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['no_simpanan'] == $dataSimpanan) {
			$cek = " selected";
		} else { $cek=""; }
		
		echo "<option value='$bacaData[no_simpanan]' $cek> $bacaData[no_simpanan] - $bacaData[nm_nasabah]</option>";
	  }
	  ?>
        </select>
          <input name="btnTampil" type="submit" value=" Tampilkan " /></td>
    </tr>
  </table>
</form>

<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="25" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="80" rowspan="2" bgcolor="#CCCCCC"><strong>No. Trans</strong></td>
    <td width="80" rowspan="2" bgcolor="#CCCCCC"><strong>Tgl. Trans </strong></td>
    <td width="94" rowspan="2" bgcolor="#CCCCCC"><strong>No. Simpanan </strong></td>
    <td width="179" rowspan="2" bgcolor="#CCCCCC"><strong>Nasabah</strong></td>
    <td rowspan="2" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>TRANSAKSI</strong></td>
  </tr>
  <tr>
    <td width="99" align="right" bgcolor="#CCCCCC"><strong>Debit(Rp) </strong></td>
    <td width="100" align="right" bgcolor="#CCCCCC"><strong>Kredit(%)</strong></td>
  </tr>
  <?php
	  // Skrip menampilkan data Transaksi Simpanan
	$mySql = "SELECT simpanan_transaksi.*, nasabah.no_nasabah, nasabah.nm_nasabah FROM simpanan_transaksi 
				LEFT JOIN simpanan ON simpanan_transaksi.no_simpanan = simpanan.no_simpanan
				LEFT JOIN nasabah ON simpanan.no_nasabah = nasabah.no_nasabah
				$filterSQL ORDER BY simpanan_transaksi.no_transaksi DESC LIMIT $mulai, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $mulai; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['no_transaksi'];
		
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['no_transaksi']; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_transaksi']); ?></td>
    <td><?php echo $myData['no_simpanan']; ?></td>
    <td><?php echo $myData['nm_nasabah']; ?></td>
    <td width="202"><?php echo $myData['keterangan']; ?></td>
    <td align="right"><?php echo format_angka($myData['nilai_debit']); ?></td>
    <td align="right"><?php echo format_angka($myData['nilai_kredit']); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="4"><strong>Jumlah Data : </strong><?php echo $jumlah; ?></td>
    <td colspan="4" align="right"><strong>Halaman ke :</strong>
      <?php
	for ($h = 1; $h <= $maks; $h++) {
		echo " <a href='?open=Laporan-Transaksi-Simpanan-Nomor&hal=$h&nomorSp=$dataSimpanan'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<br />
<a href="cetak/transaksi_simpanan_nomor.php?nomorSp=<?php echo $dataSimpanan; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
