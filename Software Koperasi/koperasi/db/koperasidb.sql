-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2019 at 04:54 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `koperasidb`
--

-- --------------------------------------------------------

--
-- Table structure for table `bagian`
--

CREATE TABLE `bagian` (
  `kd_bagian` char(3) NOT NULL,
  `nm_bagian` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bagian`
--

INSERT INTO `bagian` (`kd_bagian`, `nm_bagian`) VALUES
('B03', 'IT'),
('B01', 'Keuangan'),
('B02', 'Kasir/ Teller'),
('B04', 'Keamanan');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_pinjaman`
--

CREATE TABLE `jenis_pinjaman` (
  `kd_jpinjaman` char(4) NOT NULL,
  `nm_jpinjaman` varchar(100) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `bunga` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_pinjaman`
--

INSERT INTO `jenis_pinjaman` (`kd_jpinjaman`, `nm_jpinjaman`, `keterangan`, `bunga`) VALUES
('JP01', 'HARIAN', 'SETORAN HARIAN, DIKOLEKSI PETUGAS, PINJAM 1.000.000 SETORAN 10.000 + 2.000 SETIAP HARI ', 20.00),
('JP02', 'MINGGUAN', 'SETORAN MINGGUAN, TIAP HARI SENIN. Pinjam 1.000.000 setoran 100.000 dengan bunga 10.000 setiap hari ', 10.00);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_simpanan`
--

CREATE TABLE `jenis_simpanan` (
  `kd_jsimpanan` char(4) NOT NULL,
  `nm_jsimpanan` varchar(100) NOT NULL,
  `bunga` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_simpanan`
--

INSERT INTO `jenis_simpanan` (`kd_jsimpanan`, `nm_jsimpanan`, `bunga`) VALUES
('JS01', 'SIMPANAN HARIAN', 1.20),
('JS02', 'SIMPANAN MINGGUAN', 1.00),
('JS03', 'SIMPANAN SUKARELA', 0.80);

-- --------------------------------------------------------

--
-- Table structure for table `nasabah`
--

CREATE TABLE `nasabah` (
  `no_nasabah` char(6) NOT NULL,
  `nm_nasabah` varchar(100) NOT NULL,
  `kelamin` enum('L','P') NOT NULL,
  `agama` varchar(20) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `status_kawin` enum('Kawin','Belum Kawin') NOT NULL DEFAULT 'Belum Kawin',
  `nama_pasangan` varchar(100) NOT NULL,
  `jenis_pekerjaan` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nasabah`
--

INSERT INTO `nasabah` (`no_nasabah`, `nm_nasabah`, `kelamin`, `agama`, `tanggal_lahir`, `tempat_lahir`, `alamat`, `no_telepon`, `foto`, `status_kawin`, `nama_pasangan`, `jenis_pekerjaan`) VALUES
('NS0001', 'SUMANTO', 'L', 'Islam', 0x313937352d30342d3034, 'Kotagajah', 'Jl. Raman Ajir, PC 2, Kec Raman Utara, Lampung Timur', '0819233344444', '', 'Kawin', 'SULAMI', 'Petani'),
('NS0002', 'Rizka Dwi Saputra', 'L', 'Islam', 0x313939342d30352d3035, 'Kotagajah', 'Raman Aji, PC 2, Kec Raman Utara, Lampung Timur', '08523344432', 'NS0002.riska.png', 'Belum Kawin', '-', 'Programmer Game Komputer'),
('NS0003', 'KUSWATI', 'P', 'Islam', 0x313937342d30322d3038, 'Raman Utara', 'Raman Aji, PC 2, No33, Kec Raman Utara, Lampung Timur', '08193322211', 'NS0003.bude-kus.png', 'Kawin', 'SUYONO', 'Guru TK - PNS'),
('NS0004', 'SULAMINI', 'P', 'Islam', 0x313937362d30382d3130, 'Metro', 'Jl. Braja Asri, No 11, Kec Way Jepara, Lampung Timur', '08213333444', 'NS0004.sulami.png', 'Kawin', 'SUMANTO', 'Pedagang Pasar'),
('NS0005', 'ZULFA AZIS', 'L', 'Islam', 0x323030302d30382d3035, 'Raman Utara', 'Jl. Raman Ajir, PC 2, Kec Raman Utara, Lampung Timur', '08212223334', 'NS0005.azis.png', 'Belum Kawin', '-', 'Pelajar SMK');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `kd_pegawai` char(5) NOT NULL,
  `nm_pegawai` varchar(100) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `kelamin` enum('L','P') NOT NULL,
  `agama` varchar(20) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `kd_bagian` char(3) NOT NULL,
  `login_username` varchar(20) NOT NULL,
  `login_password` varchar(200) NOT NULL,
  `login_level` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`kd_pegawai`, `nm_pegawai`, `nip`, `kelamin`, `agama`, `tanggal_lahir`, `tempat_lahir`, `alamat`, `no_telepon`, `foto`, `kd_bagian`, `login_username`, `login_password`, `login_level`) VALUES
('P0001', 'Indah Indriyanna, S.Kom', '2018001', 'P', 'Islam', 0x313938322d30362d3032, 'Way Jepara', 'Jl. Suhada, Way Jepara, Lampung Timur', '0819212344', 'P00001.septi.jpg', 'B01', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin'),
('P0002', 'Bunafit Nugroho, S.Kom', '2018002', 'L', 'Islam', 0x313938342d30342d3035, 'Yogyakarta', 'Jl. Suhada, Labuhan Ratu Bar, Kec. Way Jepara, Lampung Timur', '08192233445', 'P00002.gambar gong.jpg', 'B01', 'nugroho', 'd41d8cd98f00b204e9800998ecf8427e', 'Kasir'),
('P0003', 'Ardiyanto', '2018003', 'L', 'Islam', 0x313938342d30332d3033, 'Way Jepara', 'Jl. Margayu, Ds. Labuhan Ratu Baru, Kec. Way Jepara, Lampung Timur', '0812223345', '', 'B01', 'ardiyanto', 'd41d8cd98f00b204e9800998ecf8427e', 'Kasir'),
('P0004', 'Toyip Abdullah', '2018004', 'L', 'Islam', 0x313938312d30382d3033, 'Proyek Pancasila', 'Jl. Margayu, Ds. Labuhan Ratu Baru, Kec. Way Jepara, Lampung Timur', '0812444556', '', 'B01', 'toyeb', 'd41d8cd98f00b204e9800998ecf8427e', 'Kasir'),
('P0005', 'Riska Dwisaputra, S.pd', '2018005', 'L', 'Islam', 0x313938302d30352d3033, 'Raman Utara', 'Jl. Raman Aji, Kec. Raman Utara, Lampung Timur', '08293455666', 'P00005.anak lucu di rawa.jpg', 'B01', 'riska', 'd41d8cd98f00b204e9800998ecf8427e', 'Kasir'),
('P0006', 'Juwanto, S.pd', '2018006', 'L', 'Islam', 0x313938302d30362d3035, 'Manggarawan', 'Jl. Raya Siliragung, Labuhan Ratu 3, Way Jepara, Lampung Timur', '081923333333', '', 'B01', 'juwanto', 'd41d8cd98f00b204e9800998ecf8427e', 'Kasir'),
('P0007', 'Jujuk Jubaidah', '2018007', 'P', 'Islam', 0x313938322d30352d3034, 'Way Jepara', 'Jl. Braja Asri, No 11, Kec Way Jepara, Lampung Timur', '0819222223', '', 'B03', 'jujuk', 'd41d8cd98f00b204e9800998ecf8427e', 'Kasir');

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman`
--

CREATE TABLE `pinjaman` (
  `no_pinjaman` char(7) NOT NULL,
  `tgl_pinjaman` date NOT NULL,
  `no_nasabah` char(6) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_jpinjaman` char(4) NOT NULL,
  `bunga` decimal(10,2) NOT NULL,
  `lama_pinjaman` int(4) NOT NULL,
  `besar_pinjaman` int(12) NOT NULL,
  `angsuran_pokok` int(12) NOT NULL,
  `angsuran_bunga` int(12) NOT NULL,
  `administrasi` int(12) NOT NULL,
  `status` enum('Pinjam','Lunas') NOT NULL DEFAULT 'Pinjam',
  `kd_pegawai` char(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pinjaman`
--

INSERT INTO `pinjaman` (`no_pinjaman`, `tgl_pinjaman`, `no_nasabah`, `keterangan`, `kd_jpinjaman`, `bunga`, `lama_pinjaman`, `besar_pinjaman`, `angsuran_pokok`, `angsuran_bunga`, `administrasi`, `status`, `kd_pegawai`) VALUES
('PJ00001', 0x323031392d30312d3137, 'NS0001', 'pinjaman harian', 'JP01', 20.00, 10, 100000, 10000, 2000, 2000, 'Pinjam', 'P0001'),
('PJ00002', 0x323031392d30312d3234, 'NS0004', 'Pinjaman harian', 'JP01', 20.00, 100, 1000000, 10000, 2000, 5000, 'Pinjam', 'P0001'),
('PJ00003', 0x323031392d30312d3234, 'NS0003', 'Pinjaman mingguan', 'JP02', 10.00, 4, 400000, 100000, 10000, 5000, 'Lunas', 'P0001');

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman_setoran`
--

CREATE TABLE `pinjaman_setoran` (
  `no_setoran` char(8) NOT NULL,
  `tgl_setoran` date NOT NULL,
  `no_pinjaman` char(7) NOT NULL,
  `setoran_pokok` int(12) NOT NULL,
  `setoran_bunga` int(12) NOT NULL,
  `denda` int(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pinjaman_setoran`
--

INSERT INTO `pinjaman_setoran` (`no_setoran`, `tgl_setoran`, `no_pinjaman`, `setoran_pokok`, `setoran_bunga`, `denda`) VALUES
('BS000001', 0x323031392d30312d3234, 'PJ00001', 10000, 2000, 0),
('BS000002', 0x323031392d30322d3037, 'PJ00003', 100000, 10000, 0),
('BS000003', 0x323031392d30322d3037, 'PJ00003', 100000, 10000, 0),
('BS000004', 0x323031392d30322d3037, 'PJ00003', 100000, 10000, 0),
('BS000005', 0x323031392d30322d3037, 'PJ00003', 100000, 10000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `simpanan`
--

CREATE TABLE `simpanan` (
  `no_simpanan` char(7) NOT NULL,
  `tgl_simpanan` date NOT NULL,
  `no_nasabah` char(6) NOT NULL,
  `kd_jsimpanan` char(4) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_pegawai` char(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `simpanan`
--

INSERT INTO `simpanan` (`no_simpanan`, `tgl_simpanan`, `no_nasabah`, `kd_jsimpanan`, `keterangan`, `kd_pegawai`) VALUES
('SN00001', 0x323031392d30322d3032, 'NS0003', 'JS03', 'Simpanan Harian', 'P0001'),
('SN00002', 0x323031392d30322d3036, 'NS0002', 'JS03', 'Simpanan biasa', 'P0001');

-- --------------------------------------------------------

--
-- Table structure for table `simpanan_transaksi`
--

CREATE TABLE `simpanan_transaksi` (
  `no_transaksi` char(8) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `no_simpanan` char(7) NOT NULL,
  `debit` int(12) NOT NULL,
  `kredit` int(12) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_pegawai` char(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `simpanan_transaksi`
--

INSERT INTO `simpanan_transaksi` (`no_transaksi`, `tgl_transaksi`, `no_simpanan`, `debit`, `kredit`, `keterangan`, `kd_pegawai`) VALUES
('ST000001', 0x323031392d30322d3032, 'SN00001', 0, 200000, 'Tabungan pertama', 'P0001'),
('ST000002', 0x323031392d30322d3036, 'SN00002', 0, 200000, 'Tabungan pertama', 'P0001'),
('ST000003', 0x323031392d30322d3036, 'SN00002', 0, 50000, 'setoran', 'P0001'),
('ST000004', 0x323031392d30322d3037, 'SN00002', 100000, 0, 'pengambilan', 'P0001');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bagian`
--
ALTER TABLE `bagian`
  ADD PRIMARY KEY (`kd_bagian`);

--
-- Indexes for table `jenis_pinjaman`
--
ALTER TABLE `jenis_pinjaman`
  ADD PRIMARY KEY (`kd_jpinjaman`);

--
-- Indexes for table `jenis_simpanan`
--
ALTER TABLE `jenis_simpanan`
  ADD PRIMARY KEY (`kd_jsimpanan`);

--
-- Indexes for table `nasabah`
--
ALTER TABLE `nasabah`
  ADD PRIMARY KEY (`no_nasabah`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`kd_pegawai`);

--
-- Indexes for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD PRIMARY KEY (`no_pinjaman`);

--
-- Indexes for table `pinjaman_setoran`
--
ALTER TABLE `pinjaman_setoran`
  ADD PRIMARY KEY (`no_setoran`);

--
-- Indexes for table `simpanan`
--
ALTER TABLE `simpanan`
  ADD PRIMARY KEY (`no_simpanan`);

--
-- Indexes for table `simpanan_transaksi`
--
ALTER TABLE `simpanan_transaksi`
  ADD PRIMARY KEY (`no_transaksi`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
