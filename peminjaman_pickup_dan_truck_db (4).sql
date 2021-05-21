-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2021 at 05:43 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peminjaman_pickup_dan_truck_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `input_data_driver` (`nama_driver` VARCHAR(30), `jenis_kelamin_driver` ENUM('Pria','Wanita'), `tarif_driver` INT, `foto_driver` VARCHAR(20))  BEGIN
    INSERT INTO driver(nama, jenis_kelamin, tarif, nama_foto) VALUES(nama_driver, jenis_kelamin_driver, tarif_driver, foto_driver);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `input_data_helper` (`nama_helper` VARCHAR(30), `jenis_kelamin_helper` ENUM('Pria','Wanita'), `tarif_helper` INT, `foto_helper` VARCHAR(20))  BEGIN
    INSERT INTO helper(nama, jenis_kelamin, tarif, nama_foto) VALUES(nama_helper, jenis_kelamin_helper, tarif_helper, foto_helper);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `input_data_model_kendaraan` (`model_kendaraan` VARCHAR(20), `manufaktur_model` VARCHAR(20), `tarif_sewa` INT, `foto_kendaraan` VARCHAR(20))  BEGIN
    INSERT INTO tipe_kendaraan(model, manufaktur, harga_sewa, gambar) VALUES(model_kendaraan, manufaktur_model, tarif_sewa, foto_kendaraan);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `input_unit_kendaraan` (`id_model_kendaraan` VARCHAR(11), `plat_nomor_kendaraan` CHAR(11))  BEGIN
    INSERT INTO unit_kendaraan(ID_model, plat_nomor) VALUES(id_model_kendaraan, plat_nomor_kendaraan);

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID_admin` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password_admin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID_admin`, `username`, `password_admin`) VALUES
(2, 'admin422021', '$2y$10$L3EEpn67OTkVB725pEoUS.0KvpOnx0obE5K5U8FA1EA.PlhdWrMMm'),
(4, 'admin425021', '$2y$10$iG2WCwZM1gx2h6Xv2hUw2O/nnzKrpfExpYTKEnZPgW3hw8NdncRkC');

-- --------------------------------------------------------

--
-- Stand-in structure for view `akun`
-- (See below for the actual view)
--
CREATE TABLE `akun` (
`jenis_akun` varchar(9)
,`ID_akun` int(11)
,`status_akun` enum('valid','not valid','not verified')
,`username` varchar(20)
,`password_akun` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `akun_pelanggan`
--

CREATE TABLE `akun_pelanggan` (
  `ID_akun` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password_pelanggan` varchar(255) NOT NULL,
  `status_akun` enum('valid','not valid','not verified') NOT NULL,
  `ID_pelanggan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akun_pelanggan`
--

INSERT INTO `akun_pelanggan` (`ID_akun`, `username`, `password_pelanggan`, `status_akun`, `ID_pelanggan`) VALUES
(2, 'gajelas', '$2y$10$l2ueuJuIcFJ7f', 'not valid', 5),
(3, 'arvan', '$2y$10$dWZNHEG9Ojlnk', 'not verified', 6),
(4, 'alimkeren', '$2y$10$2S/RaU0hkexTR', 'not verified', 7),
(5, 'bodo', '$2y$10$.HO9QjYvlfqvW', 'not verified', 8),
(6, 'giants', '$2y$10$MjZTUZwbtoyEd', 'not verified', 9),
(7, 'fuck', '$2y$10$W9l3SvYU.HlrD', 'not verified', 10),
(8, 'abis', '$2y$10$pAL0RExQaVT5Z', 'not verified', 11),
(9, 'semangatgan', '$2y$10$URNGSeOTG0lojWABgB565.mgm.nkjA/KILeTeUWgH4F/vwIzTYMq6', 'valid', 13);

-- --------------------------------------------------------

--
-- Stand-in structure for view `data_pelanggan_baru`
-- (See below for the actual view)
--
CREATE TABLE `data_pelanggan_baru` (
`ID_pelanggan` int(11)
,`NIK` char(16)
,`nama` varchar(30)
,`alamat` varchar(75)
,`kabupaten` varchar(20)
,`jenis_kelamin` enum('Pria','Wanita')
,`ID_akun` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `detail_peminjaman`
-- (See below for the actual view)
--
CREATE TABLE `detail_peminjaman` (
`ID_peminjaman` int(11)
,`ID_model_kendaraan` int(11)
,`model` varchar(20)
,`ID_akun` int(11)
,`tanggal_peminjaman` date
,`tanggal_pengembalian` date
,`opsi_driver` enum('Ya','Tidak')
,`ID_driver` int(11)
,`nama_driver` varchar(30)
,`jumlah_helper` int(11)
,`ID_kendaraan` int(11)
,`plat_nomor` char(11)
,`ID_helper_1` int(11)
,`nama_helper_1` varchar(30)
,`ID_helper_2` int(11)
,`nama_helper_2` varchar(30)
,`gambar` varchar(20)
);

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `ID_driver` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `jenis_kelamin` enum('Pria','Wanita') NOT NULL,
  `tarif` int(11) NOT NULL,
  `nama_foto` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`ID_driver`, `nama`, `jenis_kelamin`, `tarif`, `nama_foto`) VALUES
(8, 'James Potter 2', 'Pria', 120000, '6071b2e82f20d.png'),
(9, 'Driver Tolol dan Gobloggg', 'Wanita', 15000, '6071b9492ed36.png'),
(10, 'Driver Goblok', 'Pria', 120000, '6071b98aa5862.png'),
(11, 'Sirius Black', 'Pria', 120000, '6071b9ee013c0.png'),
(14, 'Godric Gryffindor', 'Pria', 120000, '6071bb6fbed85.png'),
(16, 'Salazar Slytherin', 'Pria', 120000, '60a504378b991.png'),
(17, 'Rowena Ravenclaw', 'Wanita', 120000, '60a504706b9c7.png'),
(18, 'Ananta Wijaya', 'Pria', 120000, '60a5056f0f46e.png');

--
-- Triggers `driver`
--
DELIMITER $$
CREATE TRIGGER `ubah_id_driver` BEFORE DELETE ON `driver` FOR EACH ROW BEGIN
    UPDATE peminjaman SET ID_driver = NULL WHERE ID_driver = old.ID_driver;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `helper`
--

CREATE TABLE `helper` (
  `ID_helper` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `jenis_kelamin` enum('Pria','Wanita') NOT NULL,
  `tarif` int(11) NOT NULL,
  `nama_foto` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `helper`
--

INSERT INTO `helper` (`ID_helper`, `nama`, `jenis_kelamin`, `tarif`, `nama_foto`) VALUES
(2, 'Pasha Renaisan', 'Pria', 300000, '6086291e7c343.png'),
(4, 'Ananta Wijaya 2', 'Pria', 120000, '60a505906e4af.png');

--
-- Triggers `helper`
--
DELIMITER $$
CREATE TRIGGER `ubah_id_helper` BEFORE DELETE ON `helper` FOR EACH ROW BEGIN
    UPDATE reservasi_helper SET ID_helper = NULL WHERE ID_helper = old.ID_helper;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `invoice_pembayaran`
-- (See below for the actual view)
--
CREATE TABLE `invoice_pembayaran` (
);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `ID_pelanggan` int(11) NOT NULL,
  `NIK` char(16) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `alamat` varchar(75) NOT NULL,
  `kabupaten` varchar(20) NOT NULL,
  `jenis_kelamin` enum('Pria','Wanita') NOT NULL,
  `nomor_telepon` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`ID_pelanggan`, `NIK`, `nama`, `alamat`, `kabupaten`, `jenis_kelamin`, `nomor_telepon`) VALUES
(1, '1908561046', 'Alim Ikegami', 'Br.Tengkulak Kaja Kauh, Kemenu', 'Gianyar', 'Pria', '081239990127'),
(4, '1908561050', 'Alim Ikegami', 'Br.Tengkulak Kaja Kauh, Kemenu', 'Bangli', 'Pria', '081239990127'),
(5, '1908561099', 'Alim Ikegami', 'Br.Tengkulak Kaja Kauh, Kemenu', 'Bangli', 'Pria', '081239990127'),
(6, '1908561043', 'Alim Ikegami', 'Br.Tengkulak Kaja Kauh, Kemenuh, Sukawati, Gianyar (Depan Alam Grigis Ubud ', 'Bangli', 'Pria', '081239990127'),
(7, '1111111', 'Alim Ikegami', 'Br.Tengkulak Kaja Kauh, Kemenuh, Sukawati, Gianyar (Depan Alam Grigis Ubud ', 'Bangli', 'Pria', '081239990127'),
(8, '123123123', 'Alim Ikegami', 'Br.Tengkulak Kaja Kauh, Kemenuh, Sukawati, Gianyar (Depan Alam Grigis Ubud ', 'Denpasar', 'Pria', '081239990127'),
(9, '2233332', 'asdasd', 'asdasda', 'Bangli', 'Pria', '081239990127'),
(10, '12902132', 'Siapa aja boleh', 'asdasdasdasdsad', 'Bangli', 'Pria', '081239990127'),
(11, 'abis', 'abis', 'abis', 'Badung', 'Pria', '0899'),
(13, '1908561069', 'semangatgan', 'Br.Tengkulak Kaja Kauh, Kemenuh, Sukawati, Gianyar (Depan Alam Grigis Ubud ', 'Badung', 'Pria', '081239990127');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `ID_peminjaman` int(11) NOT NULL,
  `ID_model_kendaraan` int(11) NOT NULL,
  `ID_akun` int(11) NOT NULL,
  `tanggal_peminjaman` date NOT NULL,
  `tanggal_pengembalian` date NOT NULL,
  `opsi_driver` enum('Ya','Tidak') DEFAULT 'Tidak',
  `ID_driver` int(11) DEFAULT NULL,
  `ID_kendaraan` int(11) DEFAULT NULL,
  `jumlah_helper` int(11) DEFAULT NULL,
  `status_peminjaman` enum('not accepted yet','accepted','rejected','paid','not valid payment') NOT NULL,
  `gambar_bukti_pembayaran` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`ID_peminjaman`, `ID_model_kendaraan`, `ID_akun`, `tanggal_peminjaman`, `tanggal_pengembalian`, `opsi_driver`, `ID_driver`, `ID_kendaraan`, `jumlah_helper`, `status_peminjaman`, `gambar_bukti_pembayaran`) VALUES
(1, 2, 9, '2021-05-02', '2021-05-02', 'Tidak', NULL, 8, 0, 'paid', '60900803ca53a.jpeg'),
(2, 3, 9, '2021-05-02', '2021-05-02', 'Tidak', NULL, NULL, 0, 'rejected', NULL),
(3, 3, 9, '2021-05-02', '2021-05-02', 'Tidak', NULL, NULL, 0, 'rejected', NULL),
(4, 3, 9, '2021-05-03', '2021-05-03', 'Ya', 8, 17, 1, 'paid', '60a3c84917640.jpeg'),
(5, 2, 9, '2021-05-03', '2021-05-03', 'Ya', 8, 4, 2, 'paid', '60a3e2c47508d.jpeg'),
(6, 2, 9, '2021-05-03', '2021-05-03', 'Tidak', NULL, NULL, 1, 'not accepted yet', NULL),
(7, 2, 9, '2021-05-03', '2021-05-03', 'Ya', 8, 4, 0, 'accepted', NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `request_peminjaman`
-- (See below for the actual view)
--
CREATE TABLE `request_peminjaman` (
`ID_peminjaman` int(11)
,`nama` varchar(30)
,`ID_model` int(11)
,`model` varchar(20)
,`gambar` varchar(20)
,`ID_akun` int(11)
,`NIK` char(16)
,`nama_driver` varchar(30)
,`alamat` varchar(75)
,`tanggal_peminjaman` date
,`tanggal_pengembalian` date
,`opsi_driver` enum('Ya','Tidak')
,`jumlah_helper` int(11)
,`status_peminjaman` enum('not accepted yet','accepted','rejected','paid','not valid payment')
,`gambar_bukti_pembayaran` varchar(20)
);

-- --------------------------------------------------------

--
-- Table structure for table `reservasi_helper`
--

CREATE TABLE `reservasi_helper` (
  `ID_reservasi_helper` int(11) NOT NULL,
  `ID_peminjaman` int(11) NOT NULL,
  `ID_helper` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservasi_helper`
--

INSERT INTO `reservasi_helper` (`ID_reservasi_helper`, `ID_peminjaman`, `ID_helper`) VALUES
(2, 4, 2),
(3, 5, 2),
(4, 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tipe_kendaraan`
--

CREATE TABLE `tipe_kendaraan` (
  `ID_model` int(11) NOT NULL,
  `model` varchar(20) NOT NULL,
  `manufaktur` varchar(20) NOT NULL,
  `harga_sewa` int(11) NOT NULL,
  `gambar` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tipe_kendaraan`
--

INSERT INTO `tipe_kendaraan` (`ID_model`, `model`, `manufaktur`, `harga_sewa`, `gambar`) VALUES
(2, 'Mega Carry', 'Suzuki', 300000, '60730f65d3103.png'),
(3, 'Grand Max', 'Daihatsu', 300000, '6076a59dca071.png'),
(4, 'Truk Tronton', 'Daihatsu', 300000, '60a50721ed547.png');

-- --------------------------------------------------------

--
-- Table structure for table `unit_kendaraan`
--

CREATE TABLE `unit_kendaraan` (
  `ID_kendaraan` int(11) NOT NULL,
  `ID_model` int(11) NOT NULL,
  `plat_nomor` char(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `unit_kendaraan`
--

INSERT INTO `unit_kendaraan` (`ID_kendaraan`, `ID_model`, `plat_nomor`) VALUES
(4, 2, 'DK 1246 ASD'),
(5, 2, 'DK 546 FGH'),
(6, 2, 'DK 1232 KIH'),
(7, 2, 'DK 2344 SDA'),
(8, 2, 'DK 234 SDA'),
(17, 3, 'DK 1758 KF'),
(18, 4, 'B 1900 KF');

-- --------------------------------------------------------

--
-- Structure for view `akun`
--
DROP TABLE IF EXISTS `akun`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `akun`  AS SELECT `tb`.`jenis_akun` AS `jenis_akun`, `tb`.`ID_akun` AS `ID_akun`, `tb`.`status_akun` AS `status_akun`, `tb`.`username` AS `username`, `tb`.`password_akun` AS `password_akun` FROM (select 'pelanggan' AS `jenis_akun`,`akun_pelanggan`.`ID_akun` AS `ID_akun`,`akun_pelanggan`.`status_akun` AS `status_akun`,`akun_pelanggan`.`username` AS `username`,`akun_pelanggan`.`password_pelanggan` AS `password_akun` from `akun_pelanggan` union select 'admin' AS `admin`,`admin`.`ID_admin` AS `ID_admin`,NULL AS `NULL`,`admin`.`username` AS `username`,`admin`.`password_admin` AS `password_admin` from `admin`) AS `tb` ;

-- --------------------------------------------------------

--
-- Structure for view `data_pelanggan_baru`
--
DROP TABLE IF EXISTS `data_pelanggan_baru`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `data_pelanggan_baru`  AS SELECT `pelanggan`.`ID_pelanggan` AS `ID_pelanggan`, `pelanggan`.`NIK` AS `NIK`, `pelanggan`.`nama` AS `nama`, `pelanggan`.`alamat` AS `alamat`, `pelanggan`.`kabupaten` AS `kabupaten`, `pelanggan`.`jenis_kelamin` AS `jenis_kelamin`, `akun_pelanggan`.`ID_akun` AS `ID_akun` FROM (`pelanggan` join `akun_pelanggan` on(`pelanggan`.`ID_pelanggan` = `akun_pelanggan`.`ID_pelanggan`)) WHERE `akun_pelanggan`.`status_akun` = 'not verified' ;

-- --------------------------------------------------------

--
-- Structure for view `detail_peminjaman`
--
DROP TABLE IF EXISTS `detail_peminjaman`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `detail_peminjaman`  AS SELECT `peminjaman`.`ID_peminjaman` AS `ID_peminjaman`, `peminjaman`.`ID_model_kendaraan` AS `ID_model_kendaraan`, `tipe_kendaraan`.`model` AS `model`, `peminjaman`.`ID_akun` AS `ID_akun`, `peminjaman`.`tanggal_peminjaman` AS `tanggal_peminjaman`, `peminjaman`.`tanggal_pengembalian` AS `tanggal_pengembalian`, `peminjaman`.`opsi_driver` AS `opsi_driver`, `peminjaman`.`ID_driver` AS `ID_driver`, `driver`.`nama` AS `nama_driver`, `peminjaman`.`jumlah_helper` AS `jumlah_helper`, `peminjaman`.`ID_kendaraan` AS `ID_kendaraan`, `unit_kendaraan`.`plat_nomor` AS `plat_nomor`, `tb_2`.`ID_helper_1` AS `ID_helper_1`, `helper`.`nama` AS `nama_helper_1`, `tb_2`.`ID_helper_2` AS `ID_helper_2`, `helper_2`.`nama` AS `nama_helper_2`, `tipe_kendaraan`.`gambar` AS `gambar` FROM ((((((`peminjaman` left join ((select `rh_1`.`ID_reservasi_helper` AS `ID_reservasi_helper`,`rh_1`.`ID_peminjaman` AS `ID_peminjaman`,`rh_1`.`ID_helper` AS `ID_helper_1`,`rh_2`.`ID_helper` AS `ID_helper_2` from (`reservasi_helper` `rh_1` left join `reservasi_helper` `rh_2` on(`rh_1`.`ID_peminjaman` = `rh_2`.`ID_peminjaman`)) where `rh_1`.`ID_reservasi_helper` < `rh_2`.`ID_reservasi_helper`) union (select `reservasi_helper`.`ID_reservasi_helper` AS `ID_reservasi_helper`,`reservasi_helper`.`ID_peminjaman` AS `ID_peminjaman`,`reservasi_helper`.`ID_helper` AS `ID_helper`,NULL AS `NULL` from `reservasi_helper` group by `reservasi_helper`.`ID_peminjaman` having count(`reservasi_helper`.`ID_reservasi_helper`) = 1)) `tb_2` on(`peminjaman`.`ID_peminjaman` = `tb_2`.`ID_peminjaman`)) left join `driver` on(`driver`.`ID_driver` = `peminjaman`.`ID_driver`)) left join `unit_kendaraan` on(`unit_kendaraan`.`ID_kendaraan` = `peminjaman`.`ID_kendaraan`)) left join `tipe_kendaraan` on(`tipe_kendaraan`.`ID_model` = `peminjaman`.`ID_model_kendaraan`)) left join `helper` on(`helper`.`ID_helper` = `tb_2`.`ID_helper_1`)) left join `helper` `helper_2` on(`helper_2`.`ID_helper` = `tb_2`.`ID_helper_2`)) WHERE `peminjaman`.`status_peminjaman` = 'paid' ;

-- --------------------------------------------------------

--
-- Structure for view `invoice_pembayaran`
--
DROP TABLE IF EXISTS `invoice_pembayaran`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `invoice_pembayaran`  AS SELECT `pelanggan`.`nama` AS `nama`, `pelanggan`.`nomor_telepon` AS `nomor_telepon`, `peminjaman`.`tanggal_peminjaman` AS `tanggal_peminjaman`, `peminjaman`.`tanggal_pengembalian` AS `tanggal_pengembalian`, `tipe_kendaraan`.`model` AS `model`, `tipe_kendaraan`.`harga_sewa` AS `harga_sewa`, (to_days(`peminjaman`.`tanggal_pengembalian`) - to_days(`peminjaman`.`tanggal_peminjaman`)) * `tipe_kendaraan`.`harga_sewa` AS `jumlah_pembayaran` FROM ((`peminjaman` join `tipe_kendaraan` on(`peminjaman`.`ID_model_kendaraan` = `tipe_kendaraan`.`ID_model`)) join `pelanggan` on(`peminjaman`.`NIK` = `pelanggan`.`NIK`)) ;

-- --------------------------------------------------------

--
-- Structure for view `request_peminjaman`
--
DROP TABLE IF EXISTS `request_peminjaman`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `request_peminjaman`  AS SELECT `peminjaman`.`ID_peminjaman` AS `ID_peminjaman`, `pelanggan`.`nama` AS `nama`, `tipe_kendaraan`.`ID_model` AS `ID_model`, `tipe_kendaraan`.`model` AS `model`, `tipe_kendaraan`.`gambar` AS `gambar`, `peminjaman`.`ID_akun` AS `ID_akun`, `pelanggan`.`NIK` AS `NIK`, `driver`.`nama` AS `nama_driver`, `pelanggan`.`alamat` AS `alamat`, `peminjaman`.`tanggal_peminjaman` AS `tanggal_peminjaman`, `peminjaman`.`tanggal_pengembalian` AS `tanggal_pengembalian`, `peminjaman`.`opsi_driver` AS `opsi_driver`, `peminjaman`.`jumlah_helper` AS `jumlah_helper`, `peminjaman`.`status_peminjaman` AS `status_peminjaman`, `peminjaman`.`gambar_bukti_pembayaran` AS `gambar_bukti_pembayaran` FROM ((((`peminjaman` left join `akun_pelanggan` on(`akun_pelanggan`.`ID_akun` = `peminjaman`.`ID_akun`)) left join `pelanggan` on(`akun_pelanggan`.`ID_pelanggan` = `pelanggan`.`ID_pelanggan`)) left join `tipe_kendaraan` on(`peminjaman`.`ID_model_kendaraan` = `tipe_kendaraan`.`ID_model`)) left join `driver` on(`peminjaman`.`ID_driver` = `driver`.`ID_driver`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `akun_pelanggan`
--
ALTER TABLE `akun_pelanggan`
  ADD PRIMARY KEY (`ID_akun`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `ID_pelanggan` (`ID_pelanggan`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`ID_driver`);

--
-- Indexes for table `helper`
--
ALTER TABLE `helper`
  ADD PRIMARY KEY (`ID_helper`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`ID_pelanggan`),
  ADD UNIQUE KEY `NIK` (`NIK`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`ID_peminjaman`),
  ADD KEY `ID_model_kendaraan` (`ID_model_kendaraan`),
  ADD KEY `ID_kendaraan` (`ID_kendaraan`),
  ADD KEY `ID_driver` (`ID_driver`),
  ADD KEY `ID_akun` (`ID_akun`);

--
-- Indexes for table `reservasi_helper`
--
ALTER TABLE `reservasi_helper`
  ADD PRIMARY KEY (`ID_reservasi_helper`),
  ADD KEY `ID_peminjaman` (`ID_peminjaman`),
  ADD KEY `ID_helper` (`ID_helper`);

--
-- Indexes for table `tipe_kendaraan`
--
ALTER TABLE `tipe_kendaraan`
  ADD PRIMARY KEY (`ID_model`);

--
-- Indexes for table `unit_kendaraan`
--
ALTER TABLE `unit_kendaraan`
  ADD PRIMARY KEY (`ID_kendaraan`),
  ADD KEY `ID_model` (`ID_model`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `akun_pelanggan`
--
ALTER TABLE `akun_pelanggan`
  MODIFY `ID_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
  MODIFY `ID_driver` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `helper`
--
ALTER TABLE `helper`
  MODIFY `ID_helper` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `ID_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `ID_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reservasi_helper`
--
ALTER TABLE `reservasi_helper`
  MODIFY `ID_reservasi_helper` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tipe_kendaraan`
--
ALTER TABLE `tipe_kendaraan`
  MODIFY `ID_model` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `unit_kendaraan`
--
ALTER TABLE `unit_kendaraan`
  MODIFY `ID_kendaraan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `akun_pelanggan`
--
ALTER TABLE `akun_pelanggan`
  ADD CONSTRAINT `akun_pelanggan_ibfk_1` FOREIGN KEY (`ID_pelanggan`) REFERENCES `pelanggan` (`ID_pelanggan`);

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`ID_model_kendaraan`) REFERENCES `tipe_kendaraan` (`ID_model`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`ID_kendaraan`) REFERENCES `unit_kendaraan` (`ID_kendaraan`),
  ADD CONSTRAINT `peminjaman_ibfk_3` FOREIGN KEY (`ID_driver`) REFERENCES `driver` (`ID_driver`),
  ADD CONSTRAINT `peminjaman_ibfk_4` FOREIGN KEY (`ID_akun`) REFERENCES `akun_pelanggan` (`ID_akun`);

--
-- Constraints for table `reservasi_helper`
--
ALTER TABLE `reservasi_helper`
  ADD CONSTRAINT `reservasi_helper_ibfk_1` FOREIGN KEY (`ID_peminjaman`) REFERENCES `peminjaman` (`ID_peminjaman`),
  ADD CONSTRAINT `reservasi_helper_ibfk_2` FOREIGN KEY (`ID_helper`) REFERENCES `helper` (`ID_helper`);

--
-- Constraints for table `unit_kendaraan`
--
ALTER TABLE `unit_kendaraan`
  ADD CONSTRAINT `unit_kendaraan_ibfk_1` FOREIGN KEY (`ID_model`) REFERENCES `tipe_kendaraan` (`ID_model`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
