<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/inc.pilihan.php";

# Nasabah terpilih dari Form dan URL
$nsb		= isset($_GET['nsb']) ? $_GET['nsb'] : 'Kosong'; // Baca dari URL, jika tidak ada diisi nsb sekarang
$dataNasabah 	= isset($_POST['cmbNasabah']) ? $_POST['cmbNasabah'] : $nsb; // Baca dari form Submit, jika tidak ada diisi dari $nsb

# Membuat Filter Nasabah
if($dataNasabah=="Kosong") {
	$filterSQL = "";
}
else {
	$filterSQL = "WHERE pinjaman.no_nasabah='$dataNasabah'";
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
<h2>LAPORAN  PINJAMAN PER NASABAH </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="900" border="0"  class="table-list">
    
    <tr>
      <td bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Nasabah</strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbNasabah">
        <option value="Kosong">....</option>
        <?php
	  // Skrip menampilkan data Nasabah ke ComboBox (ListMenu)
	  $bacaSql = "SELECT * FROM nasabah ORDER BY no_nasabah";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['no_nasabah'] == $dataNasabah) {
			$cek = " selected";
		} else { $cek=""; }
		
		echo "<option value='$bacaData[no_nasabah]' $cek> $bacaData[no_nasabah] - $bacaData[nm_nasabah]</option>";
	  }
	  ?>
      </select></td>
    </tr>
    <tr>
      <td width="138">&nbsp;</td>
      <td width="10">&nbsp;</td>
      <td width="738"><input name="btnTampil" type="submit" value=" Tampilkan " /></td>
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
	// Skrip menampilkan data Peminjaman dengan filter Nasabah 
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
		echo " <a href='?open=Laporan-Pinjaman-Nasabah&hal=$h&nsb=$dataNasabah'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<br />

