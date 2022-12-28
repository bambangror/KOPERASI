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

# Membaca tanggal dari form, jika belum di-POST formnya, maka diisi dengan tanggal sekarang
$tanggal_1 	= isset($_GET['tanggal_1']) ? $_GET['tanggal_1'] : "01-".date('m-Y');
$tanggal_1 	= isset($_POST['cmbTanggal_1']) ? $_POST['cmbTanggal_1'] : $tanggal_1;
$tanggal_11 = InggrisTgl($tanggal_1);

$tanggal_2 	= isset($_GET['tanggal_2']) ? $_GET['tanggal_2'] : date('d-m-Y'); 
$tanggal_2 	= isset($_POST['cmbTanggal_2']) ? $_POST['cmbTanggal_2'] : $tanggal_2;
$tanggal_22 = InggrisTgl($tanggal_2);

// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
$filterSQL = " WHERE ( pinjaman.tgl_pinjaman BETWEEN '$tanggal_11' AND '$tanggal_22') $filterJenisSQL";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 1;
$pageSql= "SELECT * FROM pinjaman $filterSQL";
$pageQry= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumlah	= mysql_num_rows($pageQry);
$maks	= ceil($jumlah/$baris);
$mulai	= $baris * ($hal-1); 
?>
<h2>LAPORAN  PINJAMAN PER PERIODE </h2>
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
      <td><strong>Periode Tanggal </strong></td>
      <td><strong>:</strong></td>
      <td><input name="cmbTanggal_1" type="text" class="tcal" value="<?php echo $tanggal_1; ?>" size="17" />
s/d
  <input name="cmbTanggal_2" type="text" class="tcal" value="<?php echo $tanggal_2; ?>" size="17" /></td>
    </tr>
    <tr>
      <td width="139">&nbsp;</td>
      <td width="10">&nbsp;</td>
      <td width="737"><input name="btnTampil" type="submit" value=" Tampilkan " /></td>
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
	// Skrip menampilkan data Peminjaman dengan filter Periode
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
		echo " <a href='?open=Laporan-Pinjaman-Periode&hal=$h&tanggal_1=$tanggal_1&tanggal_2=$tanggal_2&jenis=$dataJenis'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<br />
