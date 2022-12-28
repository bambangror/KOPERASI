<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/inc.pilihan.php";

# Jenis Terpilih
$jenis		= isset($_GET['jenis']) ? $_GET['jenis'] : 'Kosong'; // Baca dari URL, jika tidak ada diisi bulan sekarang
$dataJenis 	= isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : $jenis; // Baca dari form Submit, jika tidak ada diisi dari $jenis

# Membuat filter Jenis
if($dataJenis =="Kosong") {
	$filterJenis	= "";
}
else {
	$filterJenis	= " AND simpanan.kd_jsimpanan='$dataJenis'";
}

# Membaca tanggal dari form, jika belum di-POST formnya, maka diisi dengan tanggal sekarang
$tanggal_1 	= isset($_GET['tanggal_1']) ? $_GET['tanggal_1'] : "01-".date('m-Y');
$tanggal_1 	= isset($_POST['cmbTanggal_1']) ? $_POST['cmbTanggal_1'] : $tanggal_1;
$tanggal_11 = InggrisTgl($tanggal_1);

$tanggal_2 	= isset($_GET['tanggal_2']) ? $_GET['tanggal_2'] : date('d-m-Y'); 
$tanggal_2 	= isset($_POST['cmbTanggal_2']) ? $_POST['cmbTanggal_2'] : $tanggal_2;
$tanggal_22 = InggrisTgl($tanggal_2);

// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
$filterSQL = " WHERE ( simpanan.tgl_simpanan BETWEEN '$tanggal_11' AND '$tanggal_22') $filterJenis";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 1;
$pageSql= "SELECT * FROM simpanan $filterSQL";
$pageQry= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumlah	= mysql_num_rows($pageQry);
$maks	= ceil($jumlah/$baris);
$mulai	= $baris * ($hal-1); 
?>
<h2>LAPORAN  SIMPANAN PER PERIODE </h2>
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
      <td><strong>Periode Tanggal </strong></td>
      <td><strong>:</strong></td>
      <td><input name="cmbTanggal_1" type="text" class="tcal" value="<?php echo $tanggal_1; ?>" size="17" />
        s/d
        <input name="cmbTanggal_2" type="text" class="tcal" value="<?php echo $tanggal_2; ?>" size="17" /></td>
    </tr>
    <tr>
      <td width="137">&nbsp;</td>
      <td width="10">&nbsp;</td>
      <td width="739"><input name="btnTampil" type="submit" value=" Tampilkan " /></td>
    </tr>
  </table>
</form>

<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="25" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="100" bgcolor="#CCCCCC"><strong>No. Simpanan </strong></td>
    <td width="100" bgcolor="#CCCCCC"><strong>Tgl. Simpanan </strong></td>
    <td width="210" bgcolor="#CCCCCC"><strong>Nasabah</strong></td>
    <td width="235" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td width="125" align="right" bgcolor="#CCCCCC"><strong>Saldo Akhir (Rp) </strong></td>
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
		echo " <a href='?open=Laporan-Simpanan-Periode&hal=$h&tanggal_1=$tanggal_1&tanggal_2=$tanggal_2&jenis=$dataJenis'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<br />
