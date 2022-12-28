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
	$filterSQL = "WHERE simpanan.no_nasabah='$dataNasabah'";
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
<h2>LAPORAN  SIMPANAN PER NASABAH </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="800" border="0"  class="table-list">
    
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
      <td width="136">&nbsp;</td>
      <td width="10">&nbsp;</td>
      <td width="640"><input name="btnTampil" type="submit" value=" Tampilkan " /></td>
    </tr>
  </table>
</form>

<table class="table-list" width="800" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td width="26" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="98" bgcolor="#CCCCCC"><strong>No. Simpanan</strong></td>
    <td width="96" bgcolor="#CCCCCC"><strong>Tgl. Simpanan</strong></td>
    <td width="184" bgcolor="#CCCCCC"><strong>Nasabah</strong></td>
    <td width="225" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td width="121" bgcolor="#CCCCCC"><strong>Saldo Akhir (Rp) </strong></td>
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
    <td colspan="3"><strong>Jumlah Data :  <?php echo $jumlah; ?> </strong></td>
    <td colspan="3" align="right"><strong>Halaman Ke : 
<?php
for ($h = 1; $h <= $maks; $h++) {
	echo " <a href='?open=Laporan-Simpanan-Nasabah&hal=$h&nsb=$dataNasabah'>$h</a> ";
}
?>
	</strong></td>
  </tr>
</table>
