-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2021 at 03:06 PM
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `input_data_driver` (IN `nama_driver` VARCHAR(30), IN `jenis_kelamin_driver` ENUM('Pria','Wanita'), IN `tarif_driver` INT, IN `foto_driver` VARCHAR(20))  BEGIN
    INSERT INTO driver(nama, jenis_kelamin, tarif, nama_foto) VALUES(nama_driver, jenis_kelamin_driver, tarif_driver, foto_driver);
	UPDATE driver SET tarif = tarif_driver;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `input_data_helper` (IN `nama_helper` VARCHAR(30), IN `jenis_kelamin_helper` ENUM('Pria','Wanita'), IN `tarif_helper` INT, IN `foto_helper` VARCHAR(20))  BEGIN
    INSERT INTO helper(nama, jenis_kelamin, tarif, nama_foto) VALUES(nama_helper, jenis_kelamin_helper, tarif_helper, foto_helper);
	UPDATE helper SET tarif = tarif_helper;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `input_data_model_kendaraan` (IN `model_kendaraan` VARCHAR(20), IN `manufaktur_model` VARCHAR(20), IN `tarif_sewa` INT, IN `foto_kendaraan` VARCHAR(20))  BEGIN
    INSERT INTO tipe_kendaraan(model, manufaktur, harga_sewa, gambar) VALUES(model_kendaraan, manufaktur_model, tarif_sewa, foto_kendaraan);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `input_unit_kendaraan` (IN `id_model_kendaraan` VARCHAR(11), IN `plat_nomor_kendaraan` CHAR(11))  BEGIN
    INSERT INTO unit_kendaraan(ID_model, plat_nomor) VALUES(id_model_kendaraan, plat_nomor_kendaraan);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_data_driver` (IN `id` INT, IN `nama_driver` VARCHAR(30), IN `jenis_kelamin_driver` ENUM('Pria','Wanita'), IN `tarif_driver` INT, IN `foto_driver` VARCHAR(20))  BEGIN
	UPDATE driver SET nama = nama_driver, jenis_kelamin = jenis_kelamin_driver, tarif = tarif_driver, nama_foto = foto_driver WHERE ID_driver = id;	
	UPDATE driver SET tarif = tarif_driver;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_data_driver_tanpa_foto` (IN `id` INT, IN `nama_driver` VARCHAR(30), IN `jenis_kelamin_driver` ENUM('Pria','Wanita'), IN `tarif_driver` INT)  BEGIN
	UPDATE driver SET nama = nama_driver, jenis_kelamin = jenis_kelamin_driver, tarif = tarif_driver WHERE ID_driver = id;	
	UPDATE driver SET tarif = tarif_driver;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_data_helper` (IN `id` INT, IN `nama_helper` VARCHAR(30), IN `jenis_kelamin_helper` ENUM('Pria','Wanita'), IN `tarif_helper` INT, IN `foto_helper` VARCHAR(20))  BEGIN
	UPDATE helper SET nama = nama_helper, jenis_kelamin = jenis_kelamin_helper, tarif = tarif_helper, nama_foto = foto_helper WHERE ID_helper = id;	
	UPDATE helper SET tarif = tarif_helper;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_data_helper_tanpa_foto` (IN `id` INT, IN `nama_helper` VARCHAR(30), IN `jenis_kelamin_helper` ENUM('Pria','Wanita'), IN `tarif_helper` INT)  BEGIN
	UPDATE helper SET nama = nama_helper, jenis_kelamin = jenis_kelamin_helper, tarif = tarif_helper WHERE ID_helper = id;	
	UPDATE helper SET tarif = tarif_helper;
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
(4, 'alimkeren', '$2y$10$2S/RaU0hkexTR', 'not valid', 7),
(5, 'bodo', '$2y$10$.HO9QjYvlfqvW', 'not verified', 8),
(6, 'giants', '$2y$10$MjZTUZwbtoyEd', 'not verified', 9),
(7, 'fuck', '$2y$10$W9l3SvYU.HlrD', 'not verified', 10),
(8, 'abis', '$2y$10$pAL0RExQaVT5Z', 'not valid', 11),
(9, 'semangatgan', '$2y$10$2nSsVlMml8YuJ9S3Qi2cXOTU75ORvJCjMJ7V/L5VTxnfqizxn46Xy', 'valid', 13),
(10, 'vinna_setiawan', '$2y$10$1kkQwbS7Tx8LrfarEqAku.kafbj7rPUdhNMuKdnH1jusoW1upo3SK', 'not valid', 14);

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
,`nama` varchar(30)
,`tanggal_peminjaman` date
,`tanggal_pengembalian` date
,`opsi_driver` int(11)
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
,`harga_peminjaman` bigint(30)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `detail_pengembalian`
-- (See below for the actual view)
--
CREATE TABLE `detail_pengembalian` (
`ID_pengembalian` int(11)
,`ID_peminjaman` int(11)
,`ID_akun` int(11)
,`nama` varchar(30)
,`id_model_kendaraan` int(11)
,`model` varchar(20)
,`plat_nomor` char(11)
,`gambar` varchar(20)
,`tanggal_peminjaman` date
,`tanggal_pengembalian` date
,`tanggal_pengembalian_sebenarnya` date
,`denda_per_hari` int(11)
,`jumlah_denda` bigint(17)
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
(8, 'James Potter 2', 'Pria', 120000, '60a618e60479f.png'),
(11, 'Sirius Black', 'Pria', 120000, '6071b9ee013c0.png'),
(14, 'Godric Gryffindor', 'Pria', 120000, '6071bb6fbed85.png'),
(16, 'Salazar Slytherin', 'Pria', 120000, '60a504378b991.png'),
(17, 'Rowena Ravenclaw', 'Wanita', 120000, '60a504706b9c7.png'),
(19, 'LeBron James', 'Pria', 120000, '60a60ad8e6404.png');

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
(2, 'Pasha Renaisan', 'Pria', 120000, '60a6160056188.png'),
(4, 'Ananta Wijaya 2', 'Pria', 120000, '60a505906e4af.png'),
(5, 'Diva Dwijayana', 'Pria', 120000, '60a60ab422ca3.png'),
(6, 'Ananta Wijaya', 'Pria', 120000, '60a6143941b31.png'),
(7, 'Wayan', 'Pria', 120000, '60aa42613188a.png'),
(8, 'Pasha Renaisan II', 'Pria', 120000, '60aa4270092e3.png');

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
(1, '1908561046', 'semangatbro', 'apasih', 'Badung', 'Pria', '$nomor_telepon'),
(4, '1908561050', 'semangatbro', 'apasih', 'Badung', 'Pria', '$nomor_telepon'),
(5, '1908561099', 'semangatbro', 'apasih', 'Badung', 'Pria', '$nomor_telepon'),
(6, '1908561043', 'semangatbro', 'apasih', 'Badung', 'Pria', '$nomor_telepon'),
(7, '1111111', 'semangatbro', 'apasih', 'Badung', 'Pria', '$nomor_telepon'),
(8, '123123123', 'semangatbro', 'apasih', 'Badung', 'Pria', '$nomor_telepon'),
(9, '2233332', 'semangatbro', 'apasih', 'Badung', 'Pria', '$nomor_telepon'),
(10, '12902132', 'semangatbro', 'apasih', 'Badung', 'Pria', '$nomor_telepon'),
(11, 'abis', 'semangatbro', 'apasih', 'Badung', 'Pria', '$nomor_telepon'),
(13, '1908561033', 'semangatbro', 'apasih', 'Badung', 'Pria', '08123999'),
(14, '1908561333', 'Vinna Setiawan', 'Br.Tengkulak Kaja Kauh, Kemenuh, Sukawati, Gianyar', 'Gianyar', 'Wanita', '081239990127');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `ID_peminjaman` int(11) NOT NULL,
  `ID_model_kendaraan` int(11) DEFAULT NULL,
  `ID_akun` int(11) NOT NULL,
  `tanggal_peminjaman` date NOT NULL,
  `tanggal_pengembalian` date NOT NULL,
  `opsi_driver` int(11) NOT NULL DEFAULT 0,
  `ID_driver` int(11) DEFAULT NULL,
  `ID_kendaraan` int(11) DEFAULT NULL,
  `jumlah_helper` int(11) DEFAULT 0,
  `status_peminjaman` enum('not accepted yet','accepted','rejected','paid','not valid payment') NOT NULL,
  `gambar_bukti_pembayaran` varchar(20) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`ID_peminjaman`, `ID_model_kendaraan`, `ID_akun`, `tanggal_peminjaman`, `tanggal_pengembalian`, `opsi_driver`, `ID_driver`, `ID_kendaraan`, `jumlah_helper`, `status_peminjaman`, `gambar_bukti_pembayaran`, `keterangan`) VALUES
(9, 6, 9, '2021-05-20', '2021-05-20', 1, NULL, NULL, 1, 'not accepted yet', NULL, NULL),
(10, 6, 9, '2021-05-20', '2021-05-20', 2, 8, 20, 0, 'paid', '60a7d0f00db07.png', NULL),
(11, 6, 9, '2021-05-20', '2021-05-21', 1, 8, 20, 1, 'paid', '60a8b10254053.png', NULL),
(12, 6, 9, '2021-05-20', '2021-05-20', 0, NULL, 20, 0, 'paid', '60a7d28dedd6b.jpeg', NULL),
(13, 6, 9, '2021-05-20', '2021-05-20', 1, 8, 20, 0, 'paid', '60a5fa4f945f7.png', NULL),
(14, 6, 9, '2021-05-21', '2021-05-21', 0, NULL, NULL, 0, 'not accepted yet', NULL, NULL),
(15, 6, 9, '2021-05-21', '2021-05-21', 1, NULL, NULL, 0, 'not accepted yet', NULL, NULL),
(16, 6, 9, '2021-05-21', '2021-05-21', 0, NULL, NULL, 1, 'rejected', NULL, 'toko sudah tutup'),
(17, 6, 9, '2021-05-29', '2021-05-29', 0, NULL, 20, 0, 'accepted', NULL, NULL),
(18, 6, 9, '2021-05-23', '2021-05-24', 1, 19, 20, 0, 'paid', '60aa87bdca3ca.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `ID_pengembalian` int(11) NOT NULL,
  `ID_peminjaman` int(11) NOT NULL,
  `tanggal_pengembalian_seharusnya` date NOT NULL,
  `tanggal_pengembalian_sebenarnya` date NOT NULL,
  `denda_per_hari` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengembalian`
--

INSERT INTO `pengembalian` (`ID_pengembalian`, `ID_peminjaman`, `tanggal_pengembalian_seharusnya`, `tanggal_pengembalian_sebenarnya`, `denda_per_hari`) VALUES
(1, 10, '2021-05-20', '2021-05-23', 60000),
(2, 12, '2021-05-20', '2021-05-23', 60000),
(3, 13, '2021-05-20', '2021-05-23', 60000),
(4, 18, '2021-05-24', '2021-05-23', 60000),
(5, 11, '2021-05-21', '2021-05-24', 60000);

-- --------------------------------------------------------

--
-- Stand-in structure for view `request_peminjaman`
-- (See below for the actual view)
--
CREATE TABLE `request_peminjaman` (
`ID_peminjaman` int(11)
,`ID_model` int(11)
,`model` varchar(20)
,`gambar` varchar(20)
,`harga_sewa` int(11)
,`ID_akun` int(11)
,`nama` varchar(30)
,`username` varchar(20)
,`nama_driver` varchar(30)
,`alamat` varchar(75)
,`tanggal_peminjaman` date
,`tanggal_pengembalian` date
,`opsi_driver` int(11)
,`jumlah_helper` int(11)
,`status_peminjaman` enum('not accepted yet','accepted','rejected','paid','not valid payment')
,`gambar_bukti_pembayaran` varchar(20)
,`harga_helper` int(11)
,`harga_driver` int(11)
,`harga_peminjaman` bigint(30)
,`keterangan` text
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
(5, 11, 2);

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
(6, 'Mega Carry', 'Suzuki', 120000, '60a5d95c01754.png');

--
-- Triggers `tipe_kendaraan`
--
DELIMITER $$
CREATE TRIGGER `ubah_id_model_kendaraan` BEFORE DELETE ON `tipe_kendaraan` FOR EACH ROW BEGIN
	UPDATE peminjaman SET ID_model_kendaraan = NULL, ID_kendaraan = NULL WHERE ID_model_kendaraan = OLD.ID_model;
	DELETE FROM unit_kendaraan WHERE ID_model = OLD.ID_model;
	
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `unit_kendaraan`
--

CREATE TABLE `unit_kendaraan` (
  `ID_kendaraan` int(11) NOT NULL,
  `ID_model` int(11) DEFAULT NULL,
  `plat_nomor` char(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `unit_kendaraan`
--

INSERT INTO `unit_kendaraan` (`ID_kendaraan`, `ID_model`, `plat_nomor`) VALUES
(20, 6, 'DK 144 SDA');

--
-- Triggers `unit_kendaraan`
--
DELIMITER $$
CREATE TRIGGER `ubah_id_unit_kendaraan` BEFORE DELETE ON `unit_kendaraan` FOR EACH ROW BEGIN
    UPDATE peminjaman SET ID_kendaraan = NULL WHERE ID_kendaraan = old.ID_kendaraan;
END
$$
DELIMITER ;

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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `detail_peminjaman`  AS SELECT `peminjaman`.`ID_peminjaman` AS `ID_peminjaman`, `peminjaman`.`ID_model_kendaraan` AS `ID_model_kendaraan`, `tipe_kendaraan`.`model` AS `model`, `peminjaman`.`ID_akun` AS `ID_akun`, `pelanggan`.`nama` AS `nama`, `peminjaman`.`tanggal_peminjaman` AS `tanggal_peminjaman`, `peminjaman`.`tanggal_pengembalian` AS `tanggal_pengembalian`, `peminjaman`.`opsi_driver` AS `opsi_driver`, `peminjaman`.`ID_driver` AS `ID_driver`, `driver`.`nama` AS `nama_driver`, `peminjaman`.`jumlah_helper` AS `jumlah_helper`, `peminjaman`.`ID_kendaraan` AS `ID_kendaraan`, `unit_kendaraan`.`plat_nomor` AS `plat_nomor`, `tb_2`.`ID_helper_1` AS `ID_helper_1`, `helper`.`nama` AS `nama_helper_1`, `tb_2`.`ID_helper_2` AS `ID_helper_2`, `helper_2`.`nama` AS `nama_helper_2`, `tipe_kendaraan`.`gambar` AS `gambar`, (to_days(`peminjaman`.`tanggal_pengembalian`) - to_days(`peminjaman`.`tanggal_peminjaman`) + 1) * (ifnull(`driver`.`tarif`,0) * `peminjaman`.`opsi_driver` + `peminjaman`.`jumlah_helper` * ifnull((select `helper`.`tarif` from `helper` limit 1),0) + `tipe_kendaraan`.`harga_sewa`) AS `harga_peminjaman` FROM ((((((((`peminjaman` left join ((select `rh_1`.`ID_reservasi_helper` AS `ID_reservasi_helper`,`rh_1`.`ID_peminjaman` AS `ID_peminjaman`,`rh_1`.`ID_helper` AS `ID_helper_1`,`rh_2`.`ID_helper` AS `ID_helper_2` from (`reservasi_helper` `rh_1` left join `reservasi_helper` `rh_2` on(`rh_1`.`ID_peminjaman` = `rh_2`.`ID_peminjaman`)) where `rh_1`.`ID_reservasi_helper` < `rh_2`.`ID_reservasi_helper`) union (select `reservasi_helper`.`ID_reservasi_helper` AS `ID_reservasi_helper`,`reservasi_helper`.`ID_peminjaman` AS `ID_peminjaman`,`reservasi_helper`.`ID_helper` AS `ID_helper`,NULL AS `NULL` from `reservasi_helper` group by `reservasi_helper`.`ID_peminjaman` having count(`reservasi_helper`.`ID_reservasi_helper`) = 1)) `tb_2` on(`peminjaman`.`ID_peminjaman` = `tb_2`.`ID_peminjaman`)) left join `driver` on(`driver`.`ID_driver` = `peminjaman`.`ID_driver`)) left join `unit_kendaraan` on(`unit_kendaraan`.`ID_kendaraan` = `peminjaman`.`ID_kendaraan`)) left join `tipe_kendaraan` on(`tipe_kendaraan`.`ID_model` = `peminjaman`.`ID_model_kendaraan`)) left join `helper` on(`helper`.`ID_helper` = `tb_2`.`ID_helper_1`)) left join `helper` `helper_2` on(`helper_2`.`ID_helper` = `tb_2`.`ID_helper_2`)) join `akun_pelanggan` on(`akun_pelanggan`.`ID_akun` = `peminjaman`.`ID_akun`)) join `pelanggan` on(`pelanggan`.`ID_pelanggan` = `akun_pelanggan`.`ID_pelanggan`)) WHERE `peminjaman`.`status_peminjaman` = 'paid' ;

-- --------------------------------------------------------

--
-- Structure for view `detail_pengembalian`
--
DROP TABLE IF EXISTS `detail_pengembalian`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `detail_pengembalian`  AS SELECT `pengembalian`.`ID_pengembalian` AS `ID_pengembalian`, `peminjaman`.`ID_peminjaman` AS `ID_peminjaman`, `peminjaman`.`ID_akun` AS `ID_akun`, `pelanggan`.`nama` AS `nama`, `peminjaman`.`ID_model_kendaraan` AS `id_model_kendaraan`, `tipe_kendaraan`.`model` AS `model`, `unit_kendaraan`.`plat_nomor` AS `plat_nomor`, `tipe_kendaraan`.`gambar` AS `gambar`, `peminjaman`.`tanggal_peminjaman` AS `tanggal_peminjaman`, `peminjaman`.`tanggal_pengembalian` AS `tanggal_pengembalian`, `pengembalian`.`tanggal_pengembalian_sebenarnya` AS `tanggal_pengembalian_sebenarnya`, `pengembalian`.`denda_per_hari` AS `denda_per_hari`, if(to_days(`pengembalian`.`tanggal_pengembalian_sebenarnya`) - to_days(`peminjaman`.`tanggal_pengembalian`) > 0,(to_days(`pengembalian`.`tanggal_pengembalian_sebenarnya`) - to_days(`peminjaman`.`tanggal_pengembalian`)) * `pengembalian`.`denda_per_hari`,0) AS `jumlah_denda` FROM (((((`pengembalian` join `peminjaman` on(`pengembalian`.`ID_peminjaman` = `peminjaman`.`ID_peminjaman`)) join `unit_kendaraan` on(`unit_kendaraan`.`ID_kendaraan` = `peminjaman`.`ID_kendaraan`)) join `tipe_kendaraan` on(`tipe_kendaraan`.`ID_model` = `peminjaman`.`ID_model_kendaraan`)) join `akun_pelanggan` on(`akun_pelanggan`.`ID_akun` = `peminjaman`.`ID_akun`)) join `pelanggan` on(`pelanggan`.`ID_pelanggan` = `akun_pelanggan`.`ID_pelanggan`)) ;

-- --------------------------------------------------------

--
-- Structure for view `request_peminjaman`
--
DROP TABLE IF EXISTS `request_peminjaman`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `request_peminjaman`  AS SELECT `peminjaman`.`ID_peminjaman` AS `ID_peminjaman`, `tipe_kendaraan`.`ID_model` AS `ID_model`, `tipe_kendaraan`.`model` AS `model`, `tipe_kendaraan`.`gambar` AS `gambar`, `tipe_kendaraan`.`harga_sewa` AS `harga_sewa`, `peminjaman`.`ID_akun` AS `ID_akun`, `pelanggan`.`nama` AS `nama`, `akun_pelanggan`.`username` AS `username`, `driver`.`nama` AS `nama_driver`, `pelanggan`.`alamat` AS `alamat`, `peminjaman`.`tanggal_peminjaman` AS `tanggal_peminjaman`, `peminjaman`.`tanggal_pengembalian` AS `tanggal_pengembalian`, `peminjaman`.`opsi_driver` AS `opsi_driver`, `peminjaman`.`jumlah_helper` AS `jumlah_helper`, `peminjaman`.`status_peminjaman` AS `status_peminjaman`, `peminjaman`.`gambar_bukti_pembayaran` AS `gambar_bukti_pembayaran`, ifnull((select `helper`.`tarif` from `helper` limit 1),0) AS `harga_helper`, ifnull(`driver`.`tarif`,0) AS `harga_driver`, (to_days(`peminjaman`.`tanggal_pengembalian`) - to_days(`peminjaman`.`tanggal_peminjaman`) + 1) * (ifnull(`driver`.`tarif`,0) * `peminjaman`.`opsi_driver` + `peminjaman`.`jumlah_helper` * ifnull((select `helper`.`tarif` from `helper` limit 1),0) + `tipe_kendaraan`.`harga_sewa`) AS `harga_peminjaman`, `peminjaman`.`keterangan` AS `keterangan` FROM ((((`peminjaman` left join `akun_pelanggan` on(`akun_pelanggan`.`ID_akun` = `peminjaman`.`ID_akun`)) left join `pelanggan` on(`akun_pelanggan`.`ID_pelanggan` = `pelanggan`.`ID_pelanggan`)) left join `tipe_kendaraan` on(`peminjaman`.`ID_model_kendaraan` = `tipe_kendaraan`.`ID_model`)) left join `driver` on(`peminjaman`.`ID_driver` = `driver`.`ID_driver`)) ;

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
-- Indexes for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`ID_pengembalian`),
  ADD KEY `ID_peminjaman` (`ID_peminjaman`);

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
  MODIFY `ID_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
  MODIFY `ID_driver` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `helper`
--
ALTER TABLE `helper`
  MODIFY `ID_helper` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `ID_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `ID_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `ID_pengembalian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reservasi_helper`
--
ALTER TABLE `reservasi_helper`
  MODIFY `ID_reservasi_helper` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tipe_kendaraan`
--
ALTER TABLE `tipe_kendaraan`
  MODIFY `ID_model` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `unit_kendaraan`
--
ALTER TABLE `unit_kendaraan`
  MODIFY `ID_kendaraan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
-- Constraints for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD CONSTRAINT `pengembalian_ibfk_1` FOREIGN KEY (`ID_peminjaman`) REFERENCES `peminjaman` (`ID_peminjaman`);

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
