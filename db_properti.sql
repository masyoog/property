-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 23, 2017 at 07:53 PM
-- Server version: 5.7.18-0ubuntu0.16.04.1
-- PHP Version: 7.0.18-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_properti`
--

-- --------------------------------------------------------

--
-- Table structure for table `c_banner_mobile_apps`
--

CREATE TABLE `c_banner_mobile_apps` (
  `id` int(11) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `user_input` varchar(20) DEFAULT NULL,
  `tgl_input` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `c_banner_mobile_apps`
--

INSERT INTO `c_banner_mobile_apps` (`id`, `filename`, `user_input`, `tgl_input`) VALUES
(1, 'banner1.jpg', 'admin', '2017-01-25 08:39:57'),
(2, 'banner2.jpg', 'admin', '2017-01-25 08:39:57');

-- --------------------------------------------------------

--
-- Table structure for table `c_fee_bagi_hasil`
--

CREATE TABLE `c_fee_bagi_hasil` (
  `id` int(11) NOT NULL,
  `investor` decimal(5,2) NOT NULL DEFAULT '0.00',
  `pengelola` decimal(5,2) NOT NULL DEFAULT '0.00',
  `upline1` decimal(5,2) NOT NULL DEFAULT '0.00',
  `upline2` decimal(5,2) NOT NULL DEFAULT '0.00',
  `upline3` decimal(5,2) NOT NULL DEFAULT '0.00',
  `upline4` decimal(5,2) NOT NULL DEFAULT '0.00',
  `upline5` decimal(5,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `c_fee_bagi_hasil`
--

INSERT INTO `c_fee_bagi_hasil` (`id`, `investor`, `pengelola`, `upline1`, `upline2`, `upline3`, `upline4`, `upline5`) VALUES
(1, '50.00', '45.00', '2.00', '1.00', '1.00', '0.50', '0.50');

-- --------------------------------------------------------

--
-- Table structure for table `c_fee_registrasi`
--

CREATE TABLE `c_fee_registrasi` (
  `id` int(11) NOT NULL,
  `upline1` int(9) NOT NULL,
  `upline2` int(9) NOT NULL,
  `upline3` int(9) NOT NULL,
  `upline4` int(9) NOT NULL,
  `upline5` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `c_fee_registrasi`
--

INSERT INTO `c_fee_registrasi` (`id`, `upline1`, `upline2`, `upline3`, `upline4`, `upline5`) VALUES
(1, 500000, 100000, 100000, 200000, 100000);

-- --------------------------------------------------------

--
-- Table structure for table `c_setting`
--

CREATE TABLE `c_setting` (
  `kode` varchar(35) NOT NULL,
  `nilai` text NOT NULL,
  `ket` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `c_setting`
--

INSERT INTO `c_setting` (`kode`, `nilai`, `ket`) VALUES
('biaya_aktivasi_bispro', '10000', 'Biaya aktivasi member BISPRO'),
('biaya_aktivasi_sipro', '1500000', 'Biaya aktivasi member SIPRO'),
('default_id_upline', '10001', 'ID Member default Upline'),
('minimum_bispro', '50000000', 'Nominal minimal topup BISPRO'),
('minimum_sipro', '500000000', 'Nominal minimal saldo SIPRO untuk dapat diambil'),
('no_wa_konfirmasi', '0812345678910', 'Nomor WA untuk konfirmasi pembayaran'),
('ppob_pin', '743923', 'PIN PPOB KITABAYAR'),
('ppob_url', 'https://api.kitabayar.com/v1', 'URL API PPOB KITABAYAR'),
('ppob_user', 'KB049', 'ID Member PPOB KITABAYAR'),
('share_image', '', 'IMAGE SHARE'),
('share_message', 'Memiliki rumah seharga Milyaran rupiah tanpa perlu memikirkan DP dan Angsuran, hanya Modal Aplikasi, mau? PRO2M solusinya..!!', 'SUBJECT MESSAGE'),
('share_subject', 'Bisnis Property Syariah - PRO2M', 'SUBJECT SHARE'),
('simpanan_pokok', '5000', 'Nominal simpanan pokok'),
('simpanan_wajib', '5000', 'Nominal simpanan wajib');

-- --------------------------------------------------------

--
-- Table structure for table `l_komisi`
--

CREATE TABLE `l_komisi` (
  `id` bigint(16) NOT NULL,
  `tgl` datetime NOT NULL,
  `id_member` varchar(10) NOT NULL,
  `id_downline` varchar(10) NOT NULL,
  `nominal` int(11) NOT NULL,
  `level` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `l_komisi`
--

INSERT INTO `l_komisi` (`id`, `tgl`, `id_member`, `id_downline`, `nominal`, `level`) VALUES
(1, '2017-01-26 01:47:47', '10006', '', 300000, 1),
(2, '2017-01-26 01:47:47', '10006', '', 200000, 2),
(3, '2017-01-26 01:49:09', '10007', '', 300000, 1),
(4, '2017-01-26 01:49:09', '10007', '', 200000, 2),
(5, '2017-01-26 02:11:04', '10008', '', 300000, 1),
(6, '2017-01-26 02:11:04', '10008', '', 200000, 2),
(7, '2017-01-26 02:11:04', '10008', '', 200000, 3),
(8, '2017-01-26 02:12:45', '10009', '', 300000, 1),
(9, '2017-01-26 02:12:45', '10009', '', 200000, 2),
(10, '2017-01-26 02:12:45', '10009', '', 200000, 3),
(11, '2017-01-26 02:21:10', '10010', '', 300000, 1),
(12, '2017-01-26 02:21:10', '10010', '', 200000, 2),
(13, '2017-01-26 02:21:10', '10010', '', 200000, 3),
(14, '2017-01-26 02:12:45', '10009', '', 200000, 4),
(15, '2017-01-26 02:21:10', '10010', '', 200000, 4),
(16, '2017-01-26 02:21:10', '10010', '', 100000, 5),
(17, '2017-01-27 00:16:17', '10010', '', 300000, 1),
(18, '2017-01-27 00:16:17', '10009', '', 200000, 2),
(19, '2017-01-27 00:16:17', '10008', '', 200000, 3),
(20, '2017-01-27 00:16:17', '10007', '', 200000, 4),
(21, '2017-01-27 00:16:17', '10003', '', 100000, 5),
(25, '2017-04-14 22:25:17', '10008', '10012', 200000, 4),
(27, '2017-04-15 05:50:39', '10001', '10013', 300000, 1),
(28, '2017-04-15 05:55:57', '10001', '10014', 300000, 1),
(29, '2017-05-07 14:47:26', '10001', '10027', 300000, 1),
(65, '2017-06-14 11:15:07', '10001', '10006', 200000, 4),
(66, '2017-06-14 11:15:07', '10003', '10006', 100000, 3),
(67, '2017-06-14 11:15:07', '10007', '10006', 100000, 2),
(68, '2017-06-14 11:15:07', '10008', '10006', 500000, 1),
(78, '2017-06-15 15:11:51', '10001', '10016', 100000, 2),
(79, '2017-06-15 15:11:51', '10002', '10016', 500000, 1),
(95, '2017-06-16 11:28:04', '10001', '10010', 100000, 2),
(96, '2017-06-16 11:28:04', '10002', '10010', 500000, 1),
(97, '2017-06-16 11:28:04', '10001', '10011', 100000, 3),
(98, '2017-06-16 11:28:04', '10002', '10011', 100000, 2),
(99, '2017-06-16 11:28:04', '10010', '10011', 500000, 1),
(107, '2017-06-16 11:36:38', '10001', '10012', 200000, 4),
(108, '2017-06-16 11:36:38', '10002', '10012', 100000, 3),
(109, '2017-06-16 11:36:38', '10010', '10012', 100000, 2),
(110, '2017-06-16 11:36:38', '10011', '10012', 500000, 1),
(119, '2017-06-16 11:50:47', '10001', '10015', 200000, 4),
(120, '2017-06-16 11:50:47', '10003', '10015', 100000, 3),
(121, '2017-06-16 11:50:47', '10007', '10015', 100000, 2),
(122, '2017-06-16 11:50:47', '10009', '10015', 500000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `l_komisi_bispro`
--

CREATE TABLE `l_komisi_bispro` (
  `id` bigint(16) NOT NULL,
  `tgl` datetime NOT NULL,
  `id_member` varchar(10) NOT NULL,
  `nominal` int(11) NOT NULL,
  `level` int(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=sudah dibagi;0=belum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `m_bank`
--

CREATE TABLE `m_bank` (
  `id` tinyint(5) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `norek` varchar(15) DEFAULT NULL,
  `atas_nama` varchar(35) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_bank`
--

INSERT INTO `m_bank` (`id`, `nama`, `norek`, `atas_nama`, `status`) VALUES
(1, 'KANTOR', 'CASH', 'KPSI', 1),
(2, 'BANK SYARIAH MANDIRI', '71044 22278', 'KSPPS PROPERTY SYAR\'I INDONESIA', 1),
(3, 'BANK MANDIRI', '14100 1472 7499', 'PT. PROPERTY SYARIAH INDONESIA', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_bank_kode`
--

CREATE TABLE `m_bank_kode` (
  `id` int(5) NOT NULL,
  `bank` varchar(30) NOT NULL,
  `kode` varchar(3) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_bank_kode`
--

INSERT INTO `m_bank_kode` (`id`, `bank`, `kode`, `status`) VALUES
(1, 'BANK BCA', '014', 1),
(2, 'BANK BCA SYARIAH', '536', 1),
(3, 'BANK MANDIRI', '008', 1),
(4, 'BANK SYARIAH MANDIRI', '451', 1),
(5, 'BANK BNI', '009', 1),
(6, 'BANK BNI SYARIAH', '009', 1),
(7, 'BANK BRI', '002', 1),
(8, 'BANK BRI SYARIAH', '422', 1),
(9, 'BANK MEGA', '426', 1),
(10, 'BANK BUKOPIN', '441', 1),
(11, 'BANK DANAMON', '011', 1),
(12, 'BANK CIMB NIAGA', '022', 1),
(13, 'BANK CIMB NIAGA SYARIAH', '022', 1),
(14, 'BANK MUAMALAT', '147', 1),
(15, 'BANK TABUNGAN NEGARA (BTN)', '200', 1),
(16, 'BANK PERMATA', '013', 1),
(17, 'CITIBANK', '031', 1),
(18, 'BANK BII / MAYBANK', '016', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_cabang`
--

CREATE TABLE `m_cabang` (
  `kode` varchar(10) NOT NULL,
  `id` int(2) UNSIGNED ZEROFILL NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(100) NOT NULL,
  `email` varchar(30) NOT NULL,
  `notelp` varchar(50) NOT NULL,
  `fax` varchar(25) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `lat` varchar(20) DEFAULT NULL,
  `lng` varchar(20) DEFAULT NULL,
  `user_input` varchar(10) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `user_update` varchar(10) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_cabang`
--

INSERT INTO `m_cabang` (`kode`, `id`, `nama`, `alamat`, `email`, `notelp`, `fax`, `status`, `lat`, `lng`, `user_input`, `tgl_input`, `user_update`, `tgl_update`) VALUES
('KDR', 03, 'KEDIRI', 'JL. RAYA KEDIRI\r\nJAWA TIMUR', 'kediri@pro2m.co.id', '0822-3030-8010', '', 1, '-7.773891', '112.133977', 'admin', '2016-12-17 04:28:12', 'admin', '2016-12-18 04:25:45'),
('MLG', 02, 'MALANG', 'JL RAYA INDAH TAK BERUJUNG\r\nMALANG', 'malang@pro2m.co.id', '0812-3369-9019 / 0888-3311-565', '', 1, '-7.977152', '112.664613', 'angga', '2016-12-07 14:17:18', 'admin', '2016-12-18 04:25:20'),
('SDA', 01, 'SIDOARJO', 'JL. RAYA PEPELEGI INDAH NO. 38, WARU, SIDOARJO, JAWA TIMUR', 'sidoarjo@pro2m.co.id', '031-855-6019', '', 1, '-7.367738', '112.724236', 'admin', '2016-12-18 04:25:45', 'admin', '2016-12-18 04:25:45');

-- --------------------------------------------------------

--
-- Table structure for table `m_faq`
--

CREATE TABLE `m_faq` (
  `id` int(11) NOT NULL,
  `question` varchar(100) NOT NULL,
  `answer` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_faq`
--

INSERT INTO `m_faq` (`id`, `question`, `answer`, `status`) VALUES
(1, 'Apa itu PRO2M?', 'PRO2M merupakan aplikasi yang dibuat oleh PT Property Syariah Indonesia dalam menjawab kebutuhan masyarakat agar memiliki daya beli property tanpa perlu Bank. Aplikasi bisnis PRO2M memiliki tujuan agar masyarakat bisa terlibat di bisnis property dan berbagai bisnis lainnya serta dapat memperoleh penghasilan besar.', 1),
(2, 'Kenapa harus bisnis property syariah?', 'Dalam bisnis atau investasi maka yang baik harus memenuhi 4 hal: <br>\r\n<ol class="list-numbering">\r\n  <li>Berkembang (untung tinggi)</li>\r\n  <li>Aman (anti rugi)</li>\r\n  <li>Bermanfaat (diperlukan semua orang)</li>\r\n  <li>Berkah</li>\r\n</ol>\r\nSemua hal tersebut hanya kami dapatkan di Bisnis Property Syariah yang didukung oleh management PRO2M. Tidak ada bisnis yang sebaik management PRO2M dengan konsep dari masyarakat untuk masyarakat.', 1),
(3, 'Apa itu BISPRO?', 'Bispro adalah Bisnis Properti.', 1),
(4, 'Apa itu SIPRO?', 'Sipro adalah Simpanan Properti', 1),
(5, 'Apa itu mitra bisnis PPOB?', 'Mitra bisnis PPOB adalah layanan masyarakat agar memiliki aplikasi pembayaran online yang mudah serta murah baik untuk dipakai sendiri atau untuk usaha berupa layanan transaksi (pulsa, PLN, PDAM, Telkom, angsuran pinjaman, tiket, dll)', 1),
(6, 'Apa itu mitra reseller?', 'Mitra reseller adalah wadah bagi pemilik UKM dan INDUSTRI dalam bekerja sama dengan member kami agar bisa ikut memasarkan produk-produknya dengan harga spesial dan komisi lebih besar sehingga member memiliki potensi bisnis lebih banyak yaitu sebagai reseller produk-produk yang memang sudah bekerja sama dengan PT. PSI', 1),
(7, 'Apa itu network referral PRO2M?', 'Netrowking PRO2M adalah sebagai wujud ucapat terima kasih kami atau reward kami kepada pengguna dari aplikasi bisnis PRO2M yang telah ikut mereferensikan produk kami sehingga dengan demikian kami memberikan reward bukan hanya terima kasih tapi juga berbagi rejeki', 1),
(8, 'Apa itu kios property syariah?', 'Kios property syariah adalah aplikasi bisnis property yang menyambungkan member juga bisa turut menjualkan dengan bantuan informasi management yang baik dan dengan komisi yang menarik', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_kabupaten`
--

CREATE TABLE `m_kabupaten` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kode` varchar(3) DEFAULT NULL,
  `user_input` varchar(20) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `user_update` varchar(20) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `id_provinsi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_kabupaten`
--

INSERT INTO `m_kabupaten` (`id`, `nama`, `kode`, `user_input`, `tgl_input`, `user_update`, `tgl_update`, `id_provinsi`) VALUES
(1, 'Kab. Aceh Barat', NULL, 'admin', '2016-02-29 12:29:08', NULL, NULL, 1),
(2, 'Kab. Aceh Barat Daya', NULL, 'admin', '2016-02-29 12:29:08', NULL, NULL, 1),
(3, 'Kab. Aceh Besar', NULL, 'admin', '2016-02-29 12:29:09', NULL, NULL, 1),
(4, 'Kab. Aceh Jaya', NULL, 'admin', '2016-02-29 12:29:10', NULL, NULL, 1),
(5, 'Kab. Aceh Selatan', NULL, 'admin', '2016-02-29 12:29:10', NULL, NULL, 1),
(6, 'Kab. Aceh Singkil', NULL, 'admin', '2016-02-29 12:29:11', NULL, NULL, 1),
(7, 'Kab. Aceh Tamiang', NULL, 'admin', '2016-02-29 12:29:12', NULL, NULL, 1),
(8, 'Kab. Aceh Tengah', NULL, 'admin', '2016-02-29 12:29:12', NULL, NULL, 1),
(9, 'Kab. Aceh Tenggara', NULL, 'admin', '2016-02-29 12:29:13', NULL, NULL, 1),
(10, 'Kab. Aceh Timur', NULL, 'admin', '2016-02-29 12:29:14', NULL, NULL, 1),
(11, 'Kab. Aceh Utara', NULL, 'admin', '2016-02-29 12:29:15', NULL, NULL, 1),
(12, 'Kab. Bener Meriah', NULL, 'admin', '2016-02-29 12:29:16', NULL, NULL, 1),
(13, 'Kab. Bireuen', NULL, 'admin', '2016-02-29 12:29:16', NULL, NULL, 1),
(14, 'Kab. Gayo Lues', NULL, 'admin', '2016-02-29 12:29:17', NULL, NULL, 1),
(15, 'Kab. Nagan Raya', NULL, 'admin', '2016-02-29 12:29:18', NULL, NULL, 1),
(16, 'Kab. Pidie', NULL, 'admin', '2016-02-29 12:29:19', NULL, NULL, 1),
(17, 'Kab. Pidie Jaya', NULL, 'admin', '2016-02-29 12:29:20', NULL, NULL, 1),
(18, 'Kab. Simeuleu', NULL, 'admin', '2016-02-29 12:29:21', NULL, NULL, 1),
(19, 'Kota Banda Aceh', NULL, 'admin', '2016-02-29 12:29:21', NULL, NULL, 1),
(20, 'Kota Langsa', NULL, 'admin', '2016-02-29 12:29:22', NULL, NULL, 1),
(21, 'Kota Lhokseumawe', NULL, 'admin', '2016-02-29 12:29:22', NULL, NULL, 1),
(22, 'Kota Sabang', NULL, 'admin', '2016-02-29 12:29:23', NULL, NULL, 1),
(23, 'Kota Subulussalam', NULL, 'admin', '2016-02-29 12:29:23', NULL, NULL, 1),
(24, 'Kab. Asahan', NULL, 'admin', '2016-02-29 12:29:29', NULL, NULL, 2),
(25, 'Kab. Batubara', NULL, 'admin', '2016-02-29 12:29:30', NULL, NULL, 2),
(26, 'Kab. Dairi', NULL, 'admin', '2016-02-29 12:29:30', NULL, NULL, 2),
(27, 'Kab. Deli Serdang', NULL, 'admin', '2016-02-29 12:29:31', NULL, NULL, 2),
(28, 'Kab. Humbang Hasudutan', NULL, 'admin', '2016-02-29 12:29:32', NULL, NULL, 2),
(29, 'Kab. Karo', NULL, 'admin', '2016-02-29 12:29:33', NULL, NULL, 2),
(30, 'Kab. Labuhan Batu', NULL, 'admin', '2016-02-29 12:29:34', NULL, NULL, 2),
(31, 'Kab. Langkat', NULL, 'admin', '2016-02-29 12:29:35', NULL, NULL, 2),
(32, 'Kab. Mandailing Natal', NULL, 'admin', '2016-02-29 12:29:36', NULL, NULL, 2),
(33, 'Kab. Nias', NULL, 'admin', '2016-02-29 12:29:37', NULL, NULL, 2),
(34, 'Kab. Nias Selatan', NULL, 'admin', '2016-02-29 12:29:37', NULL, NULL, 2),
(35, 'Kab. Padang Lawas', NULL, 'admin', '2016-02-29 12:29:38', NULL, NULL, 2),
(36, 'Kab. Padang Lawas Utara', NULL, 'admin', '2016-02-29 12:29:39', NULL, NULL, 2),
(37, 'Kab. Pakpak Barat', NULL, 'admin', '2016-02-29 12:29:40', NULL, NULL, 2),
(38, 'Kab. Samosir', NULL, 'admin', '2016-02-29 12:29:40', NULL, NULL, 2),
(39, 'Kab. Serdang Bedagai', NULL, 'admin', '2016-02-29 12:29:41', NULL, NULL, 2),
(40, 'Kab. Simalungun', NULL, 'admin', '2016-02-29 12:29:42', NULL, NULL, 2),
(41, 'Kab. Tapanuli Selatan', NULL, 'admin', '2016-02-29 12:29:43', NULL, NULL, 2),
(42, 'Kab. Tapanuli Tengah', NULL, 'admin', '2016-02-29 12:29:44', NULL, NULL, 2),
(43, 'Kab. Tapanuli Utara', NULL, 'admin', '2016-02-29 12:29:45', NULL, NULL, 2),
(44, 'Kab. Toba Samosir', NULL, 'admin', '2016-02-29 12:29:46', NULL, NULL, 2),
(45, 'Kota Binjai', NULL, 'admin', '2016-02-29 12:29:47', NULL, NULL, 2),
(46, 'Kota Medan', NULL, 'admin', '2016-02-29 12:29:47', NULL, NULL, 2),
(47, 'Kota Padang Sidempuan', NULL, 'admin', '2016-02-29 12:29:48', NULL, NULL, 2),
(48, 'Kota Pematangsiantar', NULL, 'admin', '2016-02-29 12:29:49', NULL, NULL, 2),
(49, 'Kota Sibolga', NULL, 'admin', '2016-02-29 12:29:49', NULL, NULL, 2),
(50, 'Kota Tanjung Balai', NULL, 'admin', '2016-02-29 12:29:50', NULL, NULL, 2),
(51, 'Kota Tebing Tinggi', NULL, 'admin', '2016-02-29 12:29:51', NULL, NULL, 2),
(52, 'Kab. Bengkulu Selatan', NULL, 'admin', '2016-02-29 12:29:56', NULL, NULL, 7),
(53, 'Kab. Bengkulu Utara', NULL, 'admin', '2016-02-29 12:29:57', NULL, NULL, 7),
(54, 'Kab. Kaur', NULL, 'admin', '2016-02-29 12:29:58', NULL, NULL, 7),
(55, 'Kab. Kepahiang', NULL, 'admin', '2016-02-29 12:29:59', NULL, NULL, 7),
(56, 'Kab. Lebong', NULL, 'admin', '2016-02-29 12:29:59', NULL, NULL, 7),
(57, 'Kab. Muko-Muko', NULL, 'admin', '2016-02-29 12:29:59', NULL, NULL, 7),
(58, 'Kab. Rejang Lebong', NULL, 'admin', '2016-02-29 12:30:00', NULL, NULL, 7),
(59, 'Kab. Seluma', NULL, 'admin', '2016-02-29 12:30:00', NULL, NULL, 7),
(60, 'Kota Bengkulu', NULL, 'admin', '2016-02-29 12:30:01', NULL, NULL, 7),
(61, 'Kab. Batang Hari', NULL, 'admin', '2016-02-29 12:30:07', NULL, NULL, 5),
(62, 'Kab. Bungo', NULL, 'admin', '2016-02-29 12:30:08', NULL, NULL, 5),
(63, 'Kab. Kerinci', NULL, 'admin', '2016-02-29 12:30:08', NULL, NULL, 5),
(64, 'Kab. Merangin', NULL, 'admin', '2016-02-29 12:30:09', NULL, NULL, 5),
(65, 'Kab. Muaro Jambi', NULL, 'admin', '2016-02-29 12:30:10', NULL, NULL, 5),
(66, 'Kab. Sarolangun', NULL, 'admin', '2016-02-29 12:30:10', NULL, NULL, 5),
(67, 'Kab. Tanjung Jabung Timur', NULL, 'admin', '2016-02-29 12:30:11', NULL, NULL, 5),
(68, 'Kab. Tanjung Jabung Barat', NULL, 'admin', '2016-02-29 12:30:11', NULL, NULL, 5),
(69, 'Kab. Tebo', NULL, 'admin', '2016-02-29 12:30:12', NULL, NULL, 5),
(70, 'Kota Jambi', NULL, 'admin', '2016-02-29 12:30:12', NULL, NULL, 5),
(71, 'Kab. Bengkalis', NULL, 'admin', '2016-02-29 12:30:18', NULL, NULL, 4),
(72, 'Kab. Indragiri Hilir', NULL, 'admin', '2016-02-29 12:30:19', NULL, NULL, 4),
(73, 'Kab. Indragiri Hulu', NULL, 'admin', '2016-02-29 12:30:20', NULL, NULL, 4),
(74, 'Kab. Kampar', NULL, 'admin', '2016-02-29 12:30:20', NULL, NULL, 4),
(75, 'Kab. Kepulauan Meranti', NULL, 'admin', '2016-02-29 12:30:22', NULL, NULL, 4),
(76, 'Kab. Kuantan Sengingi', NULL, 'admin', '2016-02-29 12:30:22', NULL, NULL, 4),
(77, 'Kab. Pelalawan', NULL, 'admin', '2016-02-29 12:30:23', NULL, NULL, 4),
(78, 'Kab. Rokan Hulu', NULL, 'admin', '2016-02-29 12:30:24', NULL, NULL, 4),
(79, 'Kab. Rokan Hilir', NULL, 'admin', '2016-02-29 12:30:23', NULL, NULL, 4),
(80, 'Kab. Siak', NULL, 'admin', '2016-02-29 12:30:25', NULL, NULL, 4),
(81, 'Kota Dumai', NULL, 'admin', '2016-02-29 12:30:26', NULL, NULL, 4),
(82, 'Kota Pekanbaru', NULL, 'admin', '2016-02-29 12:30:26', NULL, NULL, 4),
(83, 'Kab. Agam', NULL, 'admin', '2016-02-29 12:30:32', NULL, NULL, 3),
(84, 'Kab. Dharmasraya', NULL, 'admin', '2016-02-29 12:30:33', NULL, NULL, 3),
(85, 'Kab. Lima Puluh Kota', NULL, 'admin', '2016-02-29 12:30:34', NULL, NULL, 3),
(86, 'Kab. Kepulauan Mentawai', NULL, 'admin', '2016-02-29 12:30:33', NULL, NULL, 3),
(87, 'Kab. Padang Pariaman', NULL, 'admin', '2016-02-29 12:30:34', NULL, NULL, 3),
(88, 'Kab. Pasaman', NULL, 'admin', '2016-02-29 12:30:35', NULL, NULL, 3),
(89, 'Kab. Pasaman Barat', NULL, 'admin', '2016-02-29 12:30:36', NULL, NULL, 3),
(90, 'Kab. Pesisir Selatan', NULL, 'admin', '2016-02-29 12:30:36', NULL, NULL, 3),
(91, 'Kab. Sijunjung', NULL, 'admin', '2016-02-29 12:30:37', NULL, NULL, 3),
(92, 'Kab. Solok', NULL, 'admin', '2016-02-29 12:30:38', NULL, NULL, 3),
(93, 'Kab. Solok Selatan', NULL, 'admin', '2016-02-29 12:30:38', NULL, NULL, 3),
(94, 'Kab. Tanah Datar', NULL, 'admin', '2016-02-29 12:30:39', NULL, NULL, 3),
(95, 'Kota Bukit Tinggi', NULL, 'admin', '2016-02-29 12:30:40', NULL, NULL, 3),
(96, 'Kota Padang', NULL, 'admin', '2016-02-29 12:30:40', NULL, NULL, 3),
(97, 'Kota Padang Panjang', NULL, 'admin', '2016-02-29 12:30:41', NULL, NULL, 3),
(98, 'Kota Pariaman', NULL, 'admin', '2016-02-29 12:30:41', NULL, NULL, 3),
(99, 'Kota Payakumbuh', NULL, 'admin', '2016-02-29 12:30:41', NULL, NULL, 3),
(100, 'Kota Sawahlunto', NULL, 'admin', '2016-02-29 12:30:42', NULL, NULL, 3),
(101, 'Kota Solok', NULL, 'admin', '2016-02-29 12:30:42', NULL, NULL, 3),
(102, 'Kab. Banyuasin', NULL, 'admin', '2016-02-29 12:30:48', NULL, NULL, 6),
(103, 'Kab. Empat Lawang', NULL, 'admin', '2016-02-29 12:30:49', NULL, NULL, 6),
(104, 'Kab. Lahat', NULL, 'admin', '2016-02-29 12:30:50', NULL, NULL, 6),
(105, 'Kab. Muara Enim', NULL, 'admin', '2016-02-29 12:30:51', NULL, NULL, 6),
(106, 'Kab. Musi Banyuasin', NULL, 'admin', '2016-02-29 12:30:52', NULL, NULL, 6),
(107, 'Kab. Musi Rawas', NULL, 'admin', '2016-02-29 12:30:52', NULL, NULL, 6),
(108, 'Kab. Ogan Ilir', NULL, 'admin', '2016-02-29 12:30:54', NULL, NULL, 6),
(109, 'Kab. Ogan Komering Ilir', NULL, 'admin', '2016-02-29 12:30:54', NULL, NULL, 6),
(110, 'Kab. Ogan Komering Ulu', NULL, 'admin', '2016-02-29 12:30:55', NULL, NULL, 6),
(111, 'Kab. Ogan Komering Ulu Timur', NULL, 'admin', '2016-02-29 12:30:56', NULL, NULL, 6),
(112, 'Kab. Ogan Komering Ulu Selatan', NULL, 'admin', '2016-02-29 12:30:56', NULL, NULL, 6),
(113, 'Kota Lubuk Linggau', NULL, 'admin', '2016-02-29 12:30:57', NULL, NULL, 6),
(114, 'Kota Pagar Alam', NULL, 'admin', '2016-02-29 12:30:58', NULL, NULL, 6),
(115, 'Kota Palembang', NULL, 'admin', '2016-02-29 12:30:58', NULL, NULL, 6),
(116, 'Kota Prabumulih', NULL, 'admin', '2016-02-29 12:30:59', NULL, NULL, 6),
(117, 'Kab. Lampung Barat', NULL, 'admin', '2016-02-29 12:31:05', NULL, NULL, 8),
(118, 'Kab. Lampung Selatan', NULL, 'admin', '2016-02-29 12:31:06', NULL, NULL, 8),
(119, 'Kab. Lampung Tengah', NULL, 'admin', '2016-02-29 12:31:07', NULL, NULL, 8),
(120, 'Kab. Lampung Timur', NULL, 'admin', '2016-02-29 12:31:08', NULL, NULL, 8),
(121, 'Kab. Lampung Utara', NULL, 'admin', '2016-02-29 12:31:09', NULL, NULL, 8),
(122, 'Kab. Way Kanan', NULL, 'admin', '2016-02-29 12:31:12', NULL, NULL, 8),
(123, 'Kab. Tanggamus', NULL, 'admin', '2016-02-29 12:31:10', NULL, NULL, 8),
(124, 'Kab. Tulang Bawang', NULL, 'admin', '2016-02-29 12:31:11', NULL, NULL, 8),
(125, 'Kab. Pesawaran', NULL, 'admin', '2016-02-29 12:31:10', NULL, NULL, 8),
(126, 'Kota Bandar Lampung', NULL, 'admin', '2016-02-29 12:31:12', NULL, NULL, 8),
(127, 'Kota Metro', NULL, 'admin', '2016-02-29 12:31:13', NULL, NULL, 8),
(128, 'Kab. Bangka', NULL, 'admin', '2016-02-29 12:31:19', NULL, NULL, 9),
(129, 'Kab. Bangka Barat', NULL, 'admin', '2016-02-29 12:31:19', NULL, NULL, 9),
(130, 'Kab. Bangka Tengah', NULL, 'admin', '2016-02-29 12:31:20', NULL, NULL, 9),
(131, 'Kab. Bangka Selatan', NULL, 'admin', '2016-02-29 12:31:20', NULL, NULL, 9),
(132, 'Kab. Belitung', NULL, 'admin', '2016-02-29 12:31:21', NULL, NULL, 9),
(133, 'Kab. Belitung Timur', NULL, 'admin', '2016-02-29 12:31:21', NULL, NULL, 9),
(134, 'Kota Pangkal Pinang', NULL, 'admin', '2016-02-29 12:31:22', NULL, NULL, 9),
(135, 'Kab. Karimun', NULL, 'admin', '2016-02-29 12:31:28', NULL, NULL, 10),
(136, 'Kab. Bintan', NULL, 'admin', '2016-02-29 12:31:27', NULL, NULL, 10),
(137, 'Kab. Lingga', NULL, 'admin', '2016-02-29 12:31:28', NULL, NULL, 10),
(138, 'Kab. Natuna', NULL, 'admin', '2016-02-29 12:31:29', NULL, NULL, 10),
(139, 'Kota Batam', NULL, 'admin', '2016-02-29 12:31:30', NULL, NULL, 10),
(140, 'Kota Tanjung Pinang', NULL, 'admin', '2016-02-29 12:31:30', NULL, NULL, 10),
(141, 'Kab. Lebak', NULL, 'admin', '2016-02-29 12:31:36', NULL, NULL, 14),
(142, 'Kab. Pandeglang', NULL, 'admin', '2016-02-29 12:31:37', NULL, NULL, 14),
(143, 'Kab. Serang', NULL, 'admin', '2016-02-29 12:31:39', NULL, NULL, 14),
(144, 'Kab. Tangerang', NULL, 'admin', '2016-02-29 12:31:40', NULL, NULL, 14),
(145, 'Kota Cilegon', NULL, 'admin', '2016-02-29 12:31:41', NULL, NULL, 14),
(146, 'Kota Tangerang', NULL, 'admin', '2016-02-29 12:31:42', NULL, NULL, 14),
(147, 'Kota Serang', NULL, 'admin', '2016-02-29 12:31:42', NULL, NULL, 14),
(148, 'Kab. Bandung', NULL, 'admin', '2016-02-29 12:31:49', NULL, NULL, 12),
(149, 'Kab. Bandung Barat', NULL, 'admin', '2016-02-29 12:31:51', NULL, NULL, 12),
(150, 'Kab. Bekasi', NULL, 'admin', '2016-02-29 12:31:51', NULL, NULL, 12),
(151, 'Kab. Bogor', NULL, 'admin', '2016-02-29 12:31:52', NULL, NULL, 12),
(152, 'Kab.Ciamis', NULL, 'admin', '2016-02-29 12:31:54', NULL, NULL, 12),
(153, 'Kab. Cianjur', NULL, 'admin', '2016-02-29 12:31:55', NULL, NULL, 12),
(154, 'Kab. Cirebon', NULL, 'admin', '2016-02-29 12:31:56', NULL, NULL, 12),
(155, 'Kab. Garut', NULL, 'admin', '2016-02-29 12:31:58', NULL, NULL, 12),
(156, 'Kab. Indramayu', NULL, 'admin', '2016-02-29 12:31:59', NULL, NULL, 12),
(157, 'Kab. Karawang', NULL, 'admin', '2016-02-29 12:32:00', NULL, NULL, 12),
(158, 'Kab. Kuningan', NULL, 'admin', '2016-02-29 12:32:02', NULL, NULL, 12),
(159, 'Kab. Majalengka', NULL, 'admin', '2016-02-29 12:32:04', NULL, NULL, 12),
(160, 'Kab. Purwakarta', NULL, 'admin', '2016-02-29 12:32:05', NULL, NULL, 12),
(161, 'Kab. Subang', NULL, 'admin', '2016-02-29 12:32:06', NULL, NULL, 12),
(162, 'Kab. Sukabumi', NULL, 'admin', '2016-02-29 12:32:07', NULL, NULL, 12),
(163, 'Kab. Sumedang', NULL, 'admin', '2016-02-29 12:32:11', NULL, NULL, 12),
(164, 'Kab. Tasikmalaya', NULL, 'admin', '2016-02-29 12:32:12', NULL, NULL, 12),
(165, 'Kota Bandung', NULL, 'admin', '2016-02-29 12:32:14', NULL, NULL, 12),
(166, 'Kota Banjar', NULL, 'admin', '2016-02-29 12:32:15', NULL, NULL, 12),
(167, 'Kota Bekasi', NULL, 'admin', '2016-02-29 12:32:15', NULL, NULL, 12),
(168, 'Kota Bogor', NULL, 'admin', '2016-02-29 12:32:16', NULL, NULL, 12),
(169, 'Kota Cimahi', NULL, 'admin', '2016-02-29 12:32:16', NULL, NULL, 12),
(170, 'Kota Cirebon', NULL, 'admin', '2016-02-29 12:32:17', NULL, NULL, 12),
(171, 'Kota Depok', NULL, 'admin', '2016-02-29 12:32:17', NULL, NULL, 12),
(172, 'Kota Sukabumi', NULL, 'admin', '2016-02-29 12:32:18', NULL, NULL, 12),
(173, 'Kota Tasikmalaya', NULL, 'admin', '2016-02-29 12:32:18', NULL, NULL, 12),
(174, 'Kota Administrasi Jakarta Barat', NULL, 'admin', '2016-02-29 12:32:24', NULL, NULL, 11),
(175, 'Kota Administrasi Jakarta Selatan', NULL, 'admin', '2016-02-29 12:32:25', NULL, NULL, 11),
(176, 'Kota Administrasi Jakarta Pusat', NULL, 'admin', '2016-02-29 12:32:25', NULL, NULL, 11),
(177, 'Kota Administrasi Jakarta Utara', NULL, 'admin', '2016-02-29 12:32:26', NULL, NULL, 11),
(178, 'Kota Administrasi Jakarta Timur', NULL, 'admin', '2016-02-29 12:32:26', NULL, NULL, 11),
(179, 'Kota Administrasi Kepulauan Seribu', NULL, 'admin', '2016-02-29 12:32:27', NULL, NULL, 11),
(180, 'Kab. Banjarnegara', NULL, 'admin', '2016-02-29 12:32:32', NULL, NULL, 13),
(181, 'Kab. Banyumas', NULL, 'admin', '2016-02-29 12:32:33', NULL, NULL, 13),
(182, 'Kab. Batang', NULL, 'admin', '2016-02-29 12:32:35', NULL, NULL, 13),
(183, 'Kab. Blora', NULL, 'admin', '2016-02-29 12:32:36', NULL, NULL, 13),
(184, 'Kab. Boyolali', NULL, 'admin', '2016-02-29 12:32:36', NULL, NULL, 13),
(185, 'Kab. Brebes', NULL, 'admin', '2016-02-29 12:32:37', NULL, NULL, 13),
(186, 'Kab. Cilacap', NULL, 'admin', '2016-02-29 12:32:38', NULL, NULL, 13),
(187, 'Kab. Demak', NULL, 'admin', '2016-02-29 12:32:39', NULL, NULL, 13),
(188, 'Kab. Grobogan', NULL, 'admin', '2016-02-29 12:32:40', NULL, NULL, 13),
(189, 'Kab. Jepara', NULL, 'admin', '2016-02-29 12:32:41', NULL, NULL, 13),
(190, 'Kab. Karang Anyar', NULL, 'admin', '2016-02-29 12:32:41', NULL, NULL, 13),
(191, 'Kab. Kebumen', NULL, 'admin', '2016-02-29 12:32:42', NULL, NULL, 13),
(192, 'Kab. Kendal', NULL, 'admin', '2016-02-29 12:32:43', NULL, NULL, 13),
(193, 'Kab. Klaten', NULL, 'admin', '2016-02-29 12:32:44', NULL, NULL, 13),
(194, 'Kab. Kudus', NULL, 'admin', '2016-02-29 12:32:46', NULL, NULL, 13),
(195, 'Kab. Magelang', NULL, 'admin', '2016-02-29 12:32:46', NULL, NULL, 13),
(196, 'Kab. Pati', NULL, 'admin', '2016-02-29 12:32:47', NULL, NULL, 13),
(197, 'Kab. Pekalongan', NULL, 'admin', '2016-02-29 12:32:48', NULL, NULL, 13),
(198, 'Kab. Pemalang', NULL, 'admin', '2016-02-29 12:32:49', NULL, NULL, 13),
(199, 'Kab. Purbalingga', NULL, 'admin', '2016-02-29 12:32:50', NULL, NULL, 13),
(200, 'Kab. Purworejo', NULL, 'admin', '2016-02-29 12:32:51', NULL, NULL, 13),
(201, 'Kab. Rembang', NULL, 'admin', '2016-02-29 12:32:51', NULL, NULL, 13),
(202, 'Kab. Semarang', NULL, 'admin', '2016-02-29 12:32:52', NULL, NULL, 13),
(203, 'Kab. Sragen', NULL, 'admin', '2016-02-29 12:32:53', NULL, NULL, 13),
(204, 'Kab. Sukoharjo', NULL, 'admin', '2016-02-29 12:32:54', NULL, NULL, 13),
(205, 'Kab. Tegal', NULL, 'admin', '2016-02-29 12:32:54', NULL, NULL, 13),
(206, 'Kab. Temanggung', NULL, 'admin', '2016-02-29 12:32:55', NULL, NULL, 13),
(207, 'Kab. Wonogiri', NULL, 'admin', '2016-02-29 12:32:56', NULL, NULL, 13),
(208, 'Kab. Wonosobo', NULL, 'admin', '2016-02-29 12:32:57', NULL, NULL, 13),
(209, 'Kota Magelang', NULL, 'admin', '2016-02-29 12:32:58', NULL, NULL, 13),
(210, 'Kota Surakarta', NULL, 'admin', '2016-02-29 12:33:00', NULL, NULL, 13),
(211, 'Kota Salatiga', NULL, 'admin', '2016-02-29 12:32:59', NULL, NULL, 13),
(212, 'Kota Semarang', NULL, 'admin', '2016-02-29 12:32:59', NULL, NULL, 13),
(213, 'Kota Pekalongan', NULL, 'admin', '2016-02-29 12:32:59', NULL, NULL, 13),
(214, 'Kota Tegal', NULL, 'admin', '2016-02-29 12:33:01', NULL, NULL, 13),
(215, 'Kab. Bangkalan', 'BWX', 'admin', '2016-02-29 12:33:06', NULL, NULL, 15),
(216, 'Kab. Banyuwangi', 'BWW', 'admin', '2016-02-29 12:33:08', NULL, NULL, 15),
(217, 'Kab. Blitar', 'BXR', 'admin', '2016-02-29 12:33:09', NULL, NULL, 15),
(218, 'Kab. Bojonegoro', 'BJE', 'admin', '2016-02-29 12:33:10', NULL, NULL, 15),
(219, 'Kab. Bondowoso', 'BWS', 'admin', '2016-02-29 12:33:11', NULL, NULL, 15),
(220, 'Kab.Gresik', NULL, 'admin', '2016-02-29 12:33:12', NULL, NULL, 15),
(221, 'Kab. Jember', NULL, 'admin', '2016-02-29 12:33:14', NULL, NULL, 15),
(222, 'Kab. Jombang', 'JBG', 'admin', '2016-02-29 12:33:15', NULL, NULL, 15),
(223, 'Kab. Kediri', 'KII', 'admin', '2016-02-29 12:33:16', NULL, NULL, 15),
(224, 'Kab. Lamongan', 'LNN', 'admin', '2016-02-29 12:33:18', NULL, NULL, 15),
(225, 'Kab. Lumajang', 'LMJ', 'admin', '2016-02-29 12:33:19', NULL, NULL, 15),
(226, 'Kab. Madiun', NULL, 'admin', '2016-02-29 12:33:20', NULL, NULL, 15),
(227, 'Kab. Magetan', 'MTX', 'admin', '2016-02-29 12:33:21', NULL, NULL, 15),
(228, 'Kab. Malang', 'MLG', 'admin', '2016-02-29 12:33:21', NULL, NULL, 15),
(229, 'Kab. Mojokerto', NULL, 'admin', '2016-02-29 12:33:23', NULL, NULL, 15),
(230, 'Kab. Nganjuk', 'NJK', 'admin', '2016-02-29 12:33:24', NULL, NULL, 15),
(231, 'Kab. Ngawi', 'NIW', 'admin', '2016-02-29 12:33:25', NULL, NULL, 15),
(232, 'Kab. Pacitan', 'PCI', 'admin', '2016-02-29 12:33:26', NULL, NULL, 15),
(233, 'Kab. Pamekasan', 'PKS', 'admin', '2016-02-29 12:33:26', NULL, NULL, 15),
(234, 'Kab. Pasuruan', NULL, 'admin', '2016-02-29 12:33:27', NULL, NULL, 15),
(235, 'Kab. Ponorogo', 'PNO', 'admin', '2016-02-29 12:33:29', NULL, NULL, 15),
(236, 'Kab. Probolinggo', 'PRO', 'admin', '2016-02-29 12:33:29', NULL, NULL, 15),
(237, 'Kab. Sampang', 'SPG', 'admin', '2016-02-29 12:33:31', NULL, NULL, 15),
(238, 'Kab. Sidoarjo', NULL, 'admin', '2016-02-29 12:33:31', NULL, NULL, 15),
(239, 'Kab. Situbondo', 'SBD', 'admin', '2016-02-29 12:33:32', 'admin', '2016-03-14 02:14:23', 15),
(240, 'Kab. Sumenep', 'SNX', 'admin', '2016-02-29 12:33:33', NULL, NULL, 15),
(241, 'Kab. Trenggalek', 'TGK', 'admin', '2016-02-29 12:33:34', NULL, NULL, 15),
(242, 'Kab. Tuban', 'TWN', 'admin', '2016-02-29 12:33:35', NULL, NULL, 15),
(243, 'Kab. Tulungagung', 'TGA', 'admin', '2016-02-29 12:33:36', NULL, NULL, 15),
(244, 'Kota Batu', 'BAT', 'admin', '2016-02-29 12:33:37', NULL, NULL, 15),
(245, 'Kota Blitar', 'BXR', 'admin', '2016-02-29 12:33:37', NULL, NULL, 15),
(246, 'Kota Kediri', 'KII', 'admin', '2016-02-29 12:33:38', NULL, NULL, 15),
(247, 'Kota Madiun', NULL, 'admin', '2016-02-29 12:33:38', NULL, NULL, 15),
(248, 'Kota Malang', 'MLG', 'admin', '2016-02-29 12:33:39', NULL, NULL, 15),
(249, 'Kota Mojokerto', NULL, 'admin', '2016-02-29 12:33:40', NULL, NULL, 15),
(250, 'Kota Pasuruan', NULL, 'admin', '2016-02-29 12:33:40', NULL, NULL, 15),
(251, 'Kota Probolinggo', 'PRO', 'admin', '2016-02-29 12:33:40', NULL, NULL, 15),
(252, 'Kota Surabaya', 'SUB', 'admin', '2016-02-29 12:33:41', NULL, NULL, 15),
(253, 'Kab. Bantul', NULL, 'admin', '2016-02-29 12:33:47', NULL, NULL, 16),
(254, 'Kab. Gunung Kidul', NULL, 'admin', '2016-02-29 12:33:48', NULL, NULL, 16),
(255, 'Kab. Kulon Progo', NULL, 'admin', '2016-02-29 12:33:50', NULL, NULL, 16),
(256, 'Kab. Sleman', NULL, 'admin', '2016-02-29 12:33:50', NULL, NULL, 16),
(257, 'Kota Yogyakarta', NULL, 'admin', '2016-02-29 12:33:51', NULL, NULL, 16),
(258, 'Kab. Badung', NULL, 'admin', '2016-02-29 12:33:57', NULL, NULL, 17),
(259, 'Kab. Bangli', NULL, 'admin', '2016-02-29 12:33:58', NULL, NULL, 17),
(260, 'Kab. Buleleng', NULL, 'admin', '2016-02-29 12:33:58', NULL, NULL, 17),
(261, 'Kab. Gianyar', NULL, 'admin', '2016-02-29 12:33:59', NULL, NULL, 17),
(262, 'Kab. Jembrana', NULL, 'admin', '2016-02-29 12:33:59', NULL, NULL, 17),
(263, 'Kab. Karangasem', NULL, 'admin', '2016-02-29 12:34:00', NULL, NULL, 17),
(264, 'Kab. Klungkung', NULL, 'admin', '2016-02-29 12:34:01', NULL, NULL, 17),
(265, 'Kab. Tabanan', NULL, 'admin', '2016-02-29 12:34:01', NULL, NULL, 17),
(266, 'Kota Denpasar', NULL, 'admin', '2016-02-29 12:34:02', NULL, NULL, 17),
(267, 'Kab. Bima', NULL, 'admin', '2016-02-29 12:34:08', NULL, NULL, 18),
(268, 'Kab. Dompu', NULL, 'admin', '2016-02-29 12:34:08', NULL, NULL, 18),
(269, 'Kab. Lombok Barat', NULL, 'admin', '2016-02-29 12:34:09', NULL, NULL, 18),
(270, 'Kab. Lombok Tengah', NULL, 'admin', '2016-02-29 12:34:09', NULL, NULL, 18),
(271, 'Kab. Lombok Timur', NULL, 'admin', '2016-02-29 12:34:10', NULL, NULL, 18),
(272, 'Kab. Sumbawa', NULL, 'admin', '2016-02-29 12:34:12', NULL, NULL, 18),
(273, 'Kab. Sumbawa Barat', NULL, 'admin', '2016-02-29 12:34:13', NULL, NULL, 18),
(274, 'Kota Mataram', NULL, 'admin', '2016-02-29 12:34:13', NULL, NULL, 18),
(275, 'Kota Bima', NULL, 'admin', '2016-02-29 12:34:13', NULL, NULL, 18),
(276, 'Kab. Alor', NULL, 'admin', '2016-02-29 12:34:19', NULL, NULL, 19),
(277, 'Kab. Belu', NULL, 'admin', '2016-02-29 12:34:20', NULL, NULL, 19),
(278, 'Kab. Ende', NULL, 'admin', '2016-02-29 12:34:20', NULL, NULL, 19),
(279, 'Kab. Flores Timur', NULL, 'admin', '2016-02-29 12:34:22', NULL, NULL, 19),
(280, 'Kab. Kupang', NULL, 'admin', '2016-02-29 12:34:22', NULL, NULL, 19),
(281, 'Kab. Lembata', NULL, 'admin', '2016-02-29 12:34:24', NULL, NULL, 19),
(282, 'Kab. Manggarai', NULL, 'admin', '2016-02-29 12:34:24', NULL, NULL, 19),
(283, 'Kab. Manggarai Barat', NULL, 'admin', '2016-02-29 12:34:25', NULL, NULL, 19),
(284, 'Kab. Manggarai Timur', NULL, 'admin', '2016-02-29 12:34:25', NULL, NULL, 19),
(285, 'Kab. Nagekeo', NULL, 'admin', '2016-02-29 12:34:26', NULL, NULL, 19),
(286, 'Kab. Ngada', NULL, 'admin', '2016-02-29 12:34:26', NULL, NULL, 19),
(287, 'Kab. Rote Ndao', NULL, 'admin', '2016-02-29 12:34:27', NULL, NULL, 19),
(288, 'Kab. Sikka', NULL, 'admin', '2016-02-29 12:34:27', NULL, NULL, 19),
(289, 'Kab. Sumba Barat', NULL, 'admin', '2016-02-29 12:34:28', NULL, NULL, 19),
(290, 'Kab. Sumba Barat Daya', NULL, 'admin', '2016-02-29 12:34:28', NULL, NULL, 19),
(291, 'Kab. Sumba Tengah', NULL, 'admin', '2016-02-29 12:34:29', NULL, NULL, 19),
(292, 'Kab. Sumba Timur', NULL, 'admin', '2016-02-29 12:34:29', NULL, NULL, 19),
(293, 'Kab. Timor Tengah Selatan', NULL, 'admin', '2016-02-29 12:34:30', NULL, NULL, 19),
(294, 'Kab. Timor Tengah Utara', NULL, 'admin', '2016-02-29 12:34:31', NULL, NULL, 19),
(295, 'Kota Kupang', NULL, 'admin', '2016-02-29 12:34:32', NULL, NULL, 19),
(296, 'Kab. Bengkayang', NULL, 'admin', '2016-02-29 12:34:37', NULL, NULL, 20),
(297, 'Kab. Kapuas Hulu', NULL, 'admin', '2016-02-29 12:34:38', NULL, NULL, 20),
(298, 'Kab. Ketapang', NULL, 'admin', '2016-02-29 12:34:40', NULL, NULL, 20),
(299, 'Kab. Kayong Utara', NULL, 'admin', '2016-02-29 12:34:39', NULL, NULL, 20),
(300, 'Kab. Landak', NULL, 'admin', '2016-02-29 12:34:41', NULL, NULL, 20),
(301, 'Kab. Melawi', NULL, 'admin', '2016-02-29 12:34:42', NULL, NULL, 20),
(302, 'Kab. Pontianak', NULL, 'admin', '2016-02-29 12:34:43', NULL, NULL, 20),
(303, 'Kab. Sambas', NULL, 'admin', '2016-02-29 12:34:43', NULL, NULL, 20),
(304, 'Kab. Sanggau', NULL, 'admin', '2016-02-29 12:34:44', NULL, NULL, 20),
(305, 'Kab. Sekadau', NULL, 'admin', '2016-02-29 12:34:45', NULL, NULL, 20),
(306, 'Kab. Sintang', NULL, 'admin', '2016-02-29 12:34:45', NULL, NULL, 20),
(307, 'Kab. Kubu Raya', NULL, 'admin', '2016-02-29 12:34:40', NULL, NULL, 20),
(308, 'Kota Pontianak', NULL, 'admin', '2016-02-29 12:34:46', NULL, NULL, 20),
(309, 'Kota Singkawang', NULL, 'admin', '2016-02-29 12:34:47', NULL, NULL, 20),
(310, 'Kab. Balangan', NULL, 'admin', '2016-02-29 12:34:52', NULL, NULL, 22),
(311, 'Kab. Banjar', NULL, 'admin', '2016-02-29 12:34:53', NULL, NULL, 22),
(312, 'Kab. Barito Kuala', NULL, 'admin', '2016-02-29 12:34:53', NULL, NULL, 22),
(313, 'Kab. Hulu Sungai Selatan', NULL, 'admin', '2016-02-29 12:34:54', NULL, NULL, 22),
(314, 'Kab. Hulu Sungai Tengah', NULL, 'admin', '2016-02-29 12:34:55', NULL, NULL, 22),
(315, 'Kab. Hulu Sungai Utara', NULL, 'admin', '2016-02-29 12:34:55', NULL, NULL, 22),
(316, 'Kab. Kota Baru', NULL, 'admin', '2016-02-29 12:34:56', NULL, NULL, 22),
(317, 'Kab. Tanah Laut', NULL, 'admin', '2016-02-29 12:34:58', NULL, NULL, 22),
(318, 'Kab. Tabalong', NULL, 'admin', '2016-02-29 12:34:57', NULL, NULL, 22),
(319, 'Kab. Tanah Bumbu', NULL, 'admin', '2016-02-29 12:34:57', NULL, NULL, 22),
(320, 'Kab. Tapin', NULL, 'admin', '2016-02-29 12:34:58', NULL, NULL, 22),
(321, 'Kota Banjarbaru', NULL, 'admin', '2016-02-29 12:34:59', NULL, NULL, 22),
(322, 'Kota Banjarmasin', NULL, 'admin', '2016-02-29 12:34:59', NULL, NULL, 22),
(323, 'Kab. Barito Selatan', NULL, 'admin', '2016-02-29 12:35:05', NULL, NULL, 21),
(324, 'Kab. Barito Timur', NULL, 'admin', '2016-02-29 12:35:05', NULL, NULL, 21),
(325, 'Kab. Barito Utara', NULL, 'admin', '2016-02-29 12:35:06', NULL, NULL, 21),
(326, 'Kab. Gunung Mas', NULL, 'admin', '2016-02-29 12:35:06', NULL, NULL, 21),
(327, 'Kab. Kapuas', NULL, 'admin', '2016-02-29 12:35:07', NULL, NULL, 21),
(328, 'Kab. Katingan', NULL, 'admin', '2016-02-29 12:35:08', NULL, NULL, 21),
(329, 'Kab. Kotawaringin Barat', NULL, 'admin', '2016-02-29 12:35:08', NULL, NULL, 21),
(330, 'Kab. Kotawaringin Timur', NULL, 'admin', '2016-02-29 12:35:09', NULL, NULL, 21),
(331, 'Kab. Lamandau', NULL, 'admin', '2016-02-29 12:35:09', NULL, NULL, 21),
(332, 'Kab. Murung Raya', NULL, 'admin', '2016-02-29 12:35:10', NULL, NULL, 21),
(333, 'Kab. Pulang Pisau', NULL, 'admin', '2016-02-29 12:35:10', NULL, NULL, 21),
(334, 'Kab. Sukamara', NULL, 'admin', '2016-02-29 12:35:11', NULL, NULL, 21),
(335, 'Kab. Seruyan', NULL, 'admin', '2016-02-29 12:35:11', NULL, NULL, 21),
(336, 'Kota Palangkaraya', NULL, 'admin', '2016-02-29 12:35:11', NULL, NULL, 21),
(337, 'Kab. Berau', NULL, 'admin', '2016-02-29 12:35:17', NULL, NULL, 23),
(339, 'Kab. Kutai Barat', NULL, 'admin', '2016-02-29 12:35:18', NULL, NULL, 23),
(340, 'Kab. Kutai Kartanegara', NULL, 'admin', '2016-02-29 12:35:19', NULL, NULL, 23),
(341, 'Kab. Kutai Timur', NULL, 'admin', '2016-02-29 12:35:20', NULL, NULL, 23),
(344, 'Kab. Paser', NULL, 'admin', '2016-02-29 12:35:21', NULL, NULL, 23),
(345, 'Kab. Penajam Paser Utara', NULL, 'admin', '2016-02-29 12:35:21', NULL, NULL, 23),
(347, 'Kota Balikpapan', NULL, 'admin', '2016-02-29 12:35:22', NULL, NULL, 23),
(348, 'Kota Bontang', NULL, 'admin', '2016-02-29 12:35:22', NULL, NULL, 23),
(349, 'Kota Samarinda', NULL, 'admin', '2016-02-29 12:35:22', NULL, NULL, 23),
(350, 'Kota Tarakan', NULL, 'admin', '2016-02-29 12:35:23', NULL, NULL, 23),
(351, 'Kab. Boalemo', NULL, 'admin', '2016-02-29 12:35:28', NULL, NULL, 29),
(352, 'Kota Bone Bolango', NULL, 'admin', '2016-02-29 12:35:31', NULL, NULL, 29),
(353, 'Kab. Gorontalo', NULL, 'admin', '2016-02-29 12:35:29', NULL, NULL, 29),
(354, 'Kab. Gorontalo Utara', NULL, 'admin', '2016-02-29 12:35:30', NULL, NULL, 29),
(355, 'Kab. Pohuwato', NULL, 'admin', '2016-02-29 12:35:30', NULL, NULL, 29),
(356, 'Kota Gorontalo', NULL, 'admin', '2016-02-29 12:35:31', NULL, NULL, 29),
(357, 'Kab. Bantaeng', NULL, 'admin', '2016-02-29 12:35:37', NULL, NULL, 27),
(358, 'Kab. Barru', NULL, 'admin', '2016-02-29 12:35:37', NULL, NULL, 27),
(359, 'Kab. Bone', NULL, 'admin', '2016-02-29 12:35:38', NULL, NULL, 27),
(360, 'Kab. Bulukumba', NULL, 'admin', '2016-02-29 12:35:39', NULL, NULL, 27),
(361, 'Kab. Enrekang', NULL, 'admin', '2016-02-29 12:35:40', NULL, NULL, 27),
(362, 'Kab. Gowa', NULL, 'admin', '2016-02-29 12:35:41', NULL, NULL, 27),
(363, 'Kab. Jeneponto', NULL, 'admin', '2016-02-29 12:35:41', NULL, NULL, 27),
(364, 'Kab. Luwu', NULL, 'admin', '2016-02-29 12:35:42', NULL, NULL, 27),
(365, 'Kab. Luwu Timur', NULL, 'admin', '2016-02-29 12:35:43', NULL, NULL, 27),
(366, 'Kab. Luwu Utara', NULL, 'admin', '2016-02-29 12:35:44', NULL, NULL, 27),
(367, 'Kab. Maros', NULL, 'admin', '2016-02-29 12:35:44', NULL, NULL, 27),
(368, 'Kab. Pangkajene Kepulauan', NULL, 'admin', '2016-02-29 12:35:45', NULL, NULL, 27),
(369, 'Kab. Pinrang', NULL, 'admin', '2016-02-29 12:35:46', NULL, NULL, 27),
(370, 'Kab. Selayar', NULL, 'admin', '2016-02-29 12:35:47', NULL, NULL, 27),
(371, 'Kab. Sinjai', NULL, 'admin', '2016-02-29 12:35:48', NULL, NULL, 27),
(372, 'Kab. Sindenreng Rappang', NULL, 'admin', '2016-02-29 12:35:48', NULL, NULL, 27),
(373, 'Kab. Soppeng', NULL, 'admin', '2016-02-29 12:35:49', NULL, NULL, 27),
(374, 'Kab. Takalar', NULL, 'admin', '2016-02-29 12:35:50', NULL, NULL, 27),
(375, 'Kab. Tana Toraja', NULL, 'admin', '2016-02-29 12:35:51', NULL, NULL, 27),
(376, 'Kab. Tana Toraja Utara', NULL, 'admin', '2016-02-29 12:35:52', NULL, NULL, 27),
(377, 'Kota Wajo', NULL, 'admin', '2016-02-29 12:35:54', NULL, NULL, 27),
(378, 'Kota Makassar', NULL, 'admin', '2016-02-29 12:35:53', NULL, NULL, 27),
(379, 'Kota Palopo', NULL, 'admin', '2016-02-29 12:35:54', NULL, NULL, 27),
(380, 'Kota Pare-Pare', NULL, 'admin', '2016-02-29 12:35:54', NULL, NULL, 27),
(381, 'Kab. Bombana', NULL, 'admin', '2016-02-29 12:36:00', NULL, NULL, 28),
(382, 'Kab. Buton & Buton Utara', NULL, 'admin', '2016-02-29 12:36:01', NULL, NULL, 28),
(383, 'Kab. Kolaka', NULL, 'admin', '2016-02-29 12:36:02', NULL, NULL, 28),
(384, 'Kab. Kolaka Utara', NULL, 'admin', '2016-02-29 12:36:02', NULL, NULL, 28),
(385, 'Kab. Konawe', NULL, 'admin', '2016-02-29 12:36:03', NULL, NULL, 28),
(386, 'Kab. Konawe Utara/ Selatan', NULL, 'admin', '2016-02-29 12:36:04', NULL, NULL, 28),
(387, 'Kab. Muna', NULL, 'admin', '2016-02-29 12:36:05', NULL, NULL, 28),
(388, 'Kab. Wakatobi', NULL, 'admin', '2016-02-29 12:36:06', NULL, NULL, 28),
(389, 'Kab. Kota Bau-Bau', NULL, 'admin', '2016-02-29 12:36:04', NULL, NULL, 28),
(390, 'Kota Kendari', NULL, 'admin', '2016-02-29 12:36:06', NULL, NULL, 28),
(391, 'Kab. Banggai', NULL, 'admin', '2016-02-29 12:36:12', NULL, NULL, 26),
(392, 'Kab. Banggai Kepulauan', NULL, 'admin', '2016-02-29 12:36:13', NULL, NULL, 26),
(393, 'Kab. Buol', NULL, 'admin', '2016-02-29 12:36:13', NULL, NULL, 26),
(394, 'Kab. Donggala', NULL, 'admin', '2016-02-29 12:36:14', NULL, NULL, 26),
(395, 'Kab. Morowali', NULL, 'admin', '2016-02-29 12:36:15', NULL, NULL, 26),
(396, 'Kab. Parigi Moutong', NULL, 'admin', '2016-02-29 12:36:15', NULL, NULL, 26),
(397, 'Kab. Poso', NULL, 'admin', '2016-02-29 12:36:16', NULL, NULL, 26),
(398, 'Kab. Tojo Una-Una', NULL, 'admin', '2016-02-29 12:36:16', NULL, NULL, 26),
(399, 'Kab. Toli-Toli', NULL, 'admin', '2016-02-29 12:36:17', NULL, NULL, 26),
(400, 'Kota Palu', NULL, 'admin', '2016-02-29 12:36:18', NULL, NULL, 26),
(401, 'Kab. Bolaang Mongondow', NULL, 'admin', '2016-02-29 12:36:23', NULL, NULL, 25),
(402, 'Kab. Bolaang Mongondow Utara', NULL, 'admin', '2016-02-29 12:36:24', NULL, NULL, 25),
(403, 'Kab. Kepulauan Sangihe', NULL, 'admin', '2016-02-29 12:36:25', NULL, NULL, 25),
(404, 'Kab. Kepulauan Talaud', NULL, 'admin', '2016-02-29 12:36:26', NULL, NULL, 25),
(405, 'Kab. Minahasa', NULL, 'admin', '2016-02-29 12:36:26', NULL, NULL, 25),
(406, 'Kab. Minahasa Utara', NULL, 'admin', '2016-02-29 12:36:28', NULL, NULL, 25),
(407, 'Kab. Minahasa Selatan', NULL, 'admin', '2016-02-29 12:36:27', NULL, NULL, 25),
(408, 'Kab. Minahasa Tenggara', NULL, 'admin', '2016-02-29 12:36:28', NULL, NULL, 25),
(409, 'Kota Bitung', NULL, 'admin', '2016-02-29 12:36:29', NULL, NULL, 25),
(410, 'Kota Manado', NULL, 'admin', '2016-02-29 12:36:29', NULL, NULL, 25),
(411, 'Kota Tomohon', NULL, 'admin', '2016-02-29 12:36:30', NULL, NULL, 25),
(412, 'Kab. Majene', NULL, 'admin', '2016-02-29 12:36:36', NULL, NULL, 30),
(413, 'Kab. Mamasa', NULL, 'admin', '2016-02-29 12:36:36', NULL, NULL, 30),
(414, 'Kab. Mamuju', NULL, 'admin', '2016-02-29 12:36:37', NULL, NULL, 30),
(415, 'Kab. Mamuju Utara', NULL, 'admin', '2016-02-29 12:36:38', NULL, NULL, 30),
(416, 'Kab. Polewali Mandar', NULL, 'admin', '2016-02-29 12:36:38', NULL, NULL, 30),
(417, 'Kab. Buru', NULL, 'admin', '2016-02-29 12:36:44', NULL, NULL, 31),
(418, 'Kab. Kepulauan Aru', NULL, 'admin', '2016-02-29 12:36:45', NULL, NULL, 31),
(419, 'Kab. Maluku Tengah', NULL, 'admin', '2016-02-29 12:36:45', NULL, NULL, 31),
(420, 'Kab. Maluku Tenggara', NULL, 'admin', '2016-02-29 12:36:46', NULL, NULL, 31),
(421, 'Kab. Maluku Tenggara Barat', NULL, 'admin', '2016-02-29 12:36:46', NULL, NULL, 31),
(422, 'Kab. Seram Bagian Barat', NULL, 'admin', '2016-02-29 12:36:47', NULL, NULL, 31),
(423, 'Kab. Seram Bagian Timur', NULL, 'admin', '2016-02-29 12:36:48', NULL, NULL, 31),
(424, 'Kota Ambon', NULL, 'admin', '2016-02-29 12:36:48', NULL, NULL, 31),
(425, 'Kab. Halmahera Barat', NULL, 'admin', '2016-02-29 12:36:54', NULL, NULL, 32),
(426, 'Kab. Halmahera Selatan', NULL, 'admin', '2016-02-29 12:36:54', NULL, NULL, 32),
(427, 'Kab. Halmahera Tengah', NULL, 'admin', '2016-02-29 12:36:55', NULL, NULL, 32),
(428, 'Kab. Halmahera Timur', NULL, 'admin', '2016-02-29 12:36:55', NULL, NULL, 32),
(429, 'Kab. Halmahera Utara', NULL, 'admin', '2016-02-29 12:36:56', NULL, NULL, 32),
(430, 'Kab. Kepulauan Sula', NULL, 'admin', '2016-02-29 12:36:57', NULL, NULL, 32),
(431, 'Kota Ternate', NULL, 'admin', '2016-02-29 12:36:58', NULL, NULL, 32),
(432, 'Kota Tidore Kepulauan', NULL, 'admin', '2016-02-29 12:36:58', NULL, NULL, 32),
(433, 'Kab. Fakfak', NULL, 'admin', '2016-02-29 12:37:04', NULL, NULL, 34),
(434, 'Kab. Kaimana', NULL, 'admin', '2016-02-29 12:37:04', NULL, NULL, 34),
(435, 'Kab. Manokwari', NULL, 'admin', '2016-02-29 12:37:05', NULL, NULL, 34),
(436, 'Kab. Raja Ampat', NULL, 'admin', '2016-02-29 12:37:05', NULL, NULL, 34),
(437, 'Kab. Sorong', NULL, 'admin', '2016-02-29 12:37:06', NULL, NULL, 34),
(438, 'Kab. Sorong Selatan', NULL, 'admin', '2016-02-29 12:37:07', NULL, NULL, 34),
(439, 'Kab. Teluk Bintuni', NULL, 'admin', '2016-02-29 12:37:08', NULL, NULL, 34),
(440, 'Kab. Teluk Wondama', NULL, 'admin', '2016-02-29 12:37:08', NULL, NULL, 34),
(441, 'Kota Sorong', NULL, 'admin', '2016-02-29 12:37:09', NULL, NULL, 34),
(442, 'Kab. Asmat', NULL, 'admin', '2016-02-29 12:37:14', NULL, NULL, 33),
(443, 'Kab. Biak Numfor', NULL, 'admin', '2016-02-29 12:37:15', NULL, NULL, 33),
(444, 'Kab. Boven Digoel', NULL, 'admin', '2016-02-29 12:37:16', NULL, NULL, 33),
(445, 'Kab. Jayapura', NULL, 'admin', '2016-02-29 12:37:16', NULL, NULL, 33),
(446, 'Kab. Jayawijaya', NULL, 'admin', '2016-02-29 12:37:17', NULL, NULL, 33),
(447, 'Kab. Keerom', NULL, 'admin', '2016-02-29 12:37:18', NULL, NULL, 33),
(448, 'Kab. Mappi', NULL, 'admin', '2016-02-29 12:37:19', NULL, NULL, 33),
(449, 'Kab. Merauke', NULL, 'admin', '2016-02-29 12:37:20', NULL, NULL, 33),
(450, 'Kab. Mimika', NULL, 'admin', '2016-02-29 12:37:20', NULL, NULL, 33),
(451, 'Kab. Nabire', NULL, 'admin', '2016-02-29 12:37:21', NULL, NULL, 33),
(452, 'Kab. Paniai', NULL, 'admin', '2016-02-29 12:37:22', NULL, NULL, 33),
(453, 'Kab. Pegunungan Bintang', NULL, 'admin', '2016-02-29 12:37:23', NULL, NULL, 33),
(454, 'Kab. Puncak Jaya', NULL, 'admin', '2016-02-29 12:37:23', NULL, NULL, 33),
(455, 'Kab. Sarmi', NULL, 'admin', '2016-02-29 12:37:24', NULL, NULL, 33),
(456, 'Kab. Supiori', NULL, 'admin', '2016-02-29 12:37:24', NULL, NULL, 33),
(457, 'Kab. Tolikara', NULL, 'admin', '2016-02-29 12:37:25', NULL, NULL, 33),
(458, 'Kab. Waropen', NULL, 'admin', '2016-02-29 12:37:25', NULL, NULL, 33),
(459, 'Kab. Yahukimo', NULL, 'admin', '2016-02-29 12:37:25', NULL, NULL, 33),
(460, 'Kab. Yapen Waropen', NULL, 'admin', '2016-02-29 12:37:26', NULL, NULL, 33),
(461, 'Kab. Mamberamo Raya', NULL, 'admin', '2016-02-29 12:37:18', NULL, NULL, 33),
(462, 'Kota Jayapura', NULL, 'admin', '2016-02-29 12:37:26', NULL, NULL, 33),
(463, 'Kota Tangerang Selatan', NULL, 'admin', '2016-02-29 12:31:43', NULL, NULL, 14),
(464, 'Kab. Bengkulu Tengah', NULL, 'admin', '2016-02-29 12:29:57', NULL, NULL, 7),
(465, 'Kab. Baturaja', NULL, 'admin', '2016-02-29 12:30:49', NULL, NULL, 6),
(466, 'Kab. Bulungan', NULL, 'admin', '2016-02-29 12:37:32', NULL, NULL, 24),
(467, 'Kab. Malinau', NULL, 'admin', '2016-02-29 12:37:33', NULL, NULL, 24),
(468, 'Kab. Nunukan', NULL, 'admin', '2016-02-29 12:37:33', NULL, NULL, 24),
(469, 'Kab. Tana Tidung', NULL, 'admin', '2016-02-29 12:37:34', NULL, NULL, 24),
(470, 'Kota Tarakan', NULL, 'admin', '2016-02-29 12:37:35', NULL, NULL, 24),
(471, 'Kab. Pringsewu', NULL, 'admin', '2016-02-29 12:31:10', NULL, NULL, 8),
(472, 'Kab. Lombok Utara', NULL, 'admin', '2016-02-29 12:34:11', NULL, NULL, 18),
(473, 'Kab. Pangandaran', NULL, 'admin', '2016-02-29 12:32:05', NULL, NULL, 12),
(474, 'Kotamobagu', NULL, 'admin', '2016-02-29 12:36:30', NULL, NULL, 25),
(475, 'Kota Gunung Sitoli', NULL, 'admin', '2016-02-29 12:29:47', NULL, NULL, 2),
(476, 'Kota Denpasar Utara', NULL, 'admin', '2016-02-29 12:34:02', NULL, NULL, 17),
(477, 'Kab. Sabu Raijua', NULL, 'admin', '2016-02-29 12:34:32', NULL, NULL, 19),
(478, 'Kota Tual', NULL, 'admin', '2016-02-29 12:36:44', NULL, NULL, 31),
(479, 'Kab. Buru Selatan', NULL, 'admin', '2016-02-29 12:36:44', NULL, NULL, 31),
(480, 'Kab. Maluku Barat Daya', NULL, 'admin', '2016-02-29 12:36:45', NULL, NULL, 31),
(481, 'Kab. Pulau Morotai', NULL, 'admin', '2016-02-29 12:36:58', NULL, NULL, 32),
(482, 'Kab. Maybrat', NULL, 'admin', '2016-02-29 12:37:09', NULL, NULL, 34),
(483, 'Kab. Tambrauw', NULL, 'admin', '2016-02-29 12:37:09', NULL, NULL, 34),
(484, 'Kab. Deiyai / Deliyai', NULL, 'admin', '2016-02-29 12:37:15', NULL, NULL, 33),
(485, 'Kab. Dogiyai', NULL, 'admin', '2016-02-29 12:37:16', NULL, NULL, 33),
(486, 'Kab. Intan Jaya', NULL, 'admin', '2016-02-29 12:37:16', NULL, NULL, 33),
(487, 'Kab. Lanny Jaya', NULL, 'admin', '2016-02-29 12:37:18', NULL, NULL, 33),
(488, 'Kab. Mamberamo Tengah', NULL, 'admin', '2016-02-29 12:37:18', NULL, NULL, 33),
(489, 'Kab. Nduga', NULL, 'admin', '2016-02-29 12:37:22', NULL, NULL, 33),
(490, 'Kab. Puncak', NULL, 'admin', '2016-02-29 12:37:23', NULL, NULL, 33),
(491, 'Kab. Yalimo', NULL, 'admin', '2016-02-29 12:37:25', NULL, NULL, 33);

-- --------------------------------------------------------

--
-- Table structure for table `m_kolektor`
--

CREATE TABLE `m_kolektor` (
  `id` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `nohp` varchar(50) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  `user` varchar(20) DEFAULT NULL,
  `user_input` varchar(20) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `user_update` varchar(20) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `id_cabang` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `m_legalitas`
--

CREATE TABLE `m_legalitas` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `notaris` varchar(50) DEFAULT NULL,
  `nomor` varchar(50) DEFAULT NULL,
  `berlaku` varchar(50) DEFAULT NULL,
  `urutan` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_legalitas`
--

INSERT INTO `m_legalitas` (`id`, `nama`, `notaris`, `nomor`, `berlaku`, `urutan`) VALUES
(1, 'SIUP PT PROPERTY SYARIAH INDONESIA', NULL, '510/200/404.6.2/2015', '05 Februari 2020', 1),
(2, 'TDP PT PROPERTY SYARIAH INDONESIA', NULL, '13.17.168.05880', '06 Februari 2020', 2),
(3, 'NPWP PT PROPERTY SYARIAH INDONESIA', NULL, '71.780.298.7-603.000', NULL, 3),
(4, 'SIUP KSPPS PROPERTY SYAR\'I INDONESIA (KOPERASI)', NULL, 'Sedang diperbarui', NULL, 4),
(5, 'TDP KSPPS PROPERTY SYAR\'I INDONESIA (KOPERASI)', NULL, '13.28.2.6400338', 'Desember 2021', 5),
(6, 'NPWP KSPPS PROPERTY SYAR\'I INDONESIA (KOPERASI)', NULL, '80.571.918.4-655.000', NULL, 6);

-- --------------------------------------------------------

--
-- Table structure for table `m_level`
--

CREATE TABLE `m_level` (
  `level` int(3) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `downline1` int(6) NOT NULL DEFAULT '0',
  `downline2` int(6) NOT NULL DEFAULT '0',
  `downline3` int(6) NOT NULL DEFAULT '0',
  `downline4` int(6) NOT NULL DEFAULT '0',
  `downline5` int(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_level`
--

INSERT INTO `m_level` (`level`, `kode`, `nama`, `downline1`, `downline2`, `downline3`, `downline4`, `downline5`) VALUES
(0, 'MEMBER', 'MEMBER', 0, 0, 0, 0, 0),
(1, 'LEADER', 'LEADER', 10, 0, 0, 0, 0),
(2, 'EXC-SPV', 'EXECUTIVE SUPERVISOR', 10, 100, 0, 0, 0),
(3, 'MANAGER', 'MANAGER', 10, 100, 1000, 0, 0),
(4, 'EXC-MAN', 'EXECUTIVE MANAGER', 10, 100, 1000, 10000, 0),
(5, 'DIR', 'DIRECTOR', 10, 100, 1000, 10000, 100000);

-- --------------------------------------------------------

--
-- Table structure for table `m_member`
--

CREATE TABLE `m_member` (
  `id` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `no_ktp` varchar(20) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `kota` varchar(45) DEFAULT NULL,
  `provinsi` varchar(30) DEFAULT NULL,
  `kodepos` varchar(5) DEFAULT NULL,
  `nohp` varchar(16) NOT NULL,
  `nohp_alt` varchar(16) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `no_npwp` varchar(20) DEFAULT NULL,
  `tgl_registrasi` datetime NOT NULL,
  `tgl_aktivasi` datetime DEFAULT NULL,
  `level` int(3) NOT NULL DEFAULT '0',
  `id_upline1` varchar(10) NOT NULL,
  `id_upline2` varchar(10) DEFAULT NULL,
  `id_upline3` varchar(10) DEFAULT NULL,
  `id_upline4` varchar(10) DEFAULT NULL,
  `id_upline5` varchar(10) DEFAULT NULL,
  `jenis_member` varchar(7) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `pass` varchar(32) DEFAULT NULL,
  `token` varchar(32) DEFAULT NULL,
  `token_expired` datetime DEFAULT NULL,
  `user_input` varchar(20) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `user_update` varchar(20) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `id_cabang` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_member`
--

INSERT INTO `m_member` (`id`, `nama`, `no_ktp`, `alamat`, `kota`, `provinsi`, `kodepos`, `nohp`, `nohp_alt`, `email`, `no_npwp`, `tgl_registrasi`, `tgl_aktivasi`, `level`, `id_upline1`, `id_upline2`, `id_upline3`, `id_upline4`, `id_upline5`, `jenis_member`, `status`, `pass`, `token`, `token_expired`, `user_input`, `tgl_input`, `user_update`, `tgl_update`, `id_cabang`) VALUES
('10001', 'KPSI', '1', 'SIDOARJO', NULL, NULL, NULL, '0812312', NULL, 'arihanggara@gmail.com', NULL, '2017-01-01 07:00:00', '2017-01-01 07:00:00', 0, '', NULL, NULL, NULL, NULL, 'SIPRO', 1, '81dc9bdb52d04dc20036dbd8313ed055', 'fb82a26d91c84ce1c16df6afdde63165', '2017-03-14 22:29:52', '', '2017-01-01 07:00:00', NULL, NULL, 'SDA'),
('10002', 'ARI HANGGARA', '3524192302870002', 'SIDOARJO', 'SIDOARJO', 'JAWA TIMUR', '61252', '0812313', '', 'arihanggara@gmail.com', NULL, '2017-01-01 07:00:00', '2017-01-01 07:00:00', 0, '10001', NULL, NULL, NULL, NULL, 'SIPRO', 1, '81dc9bdb52d04dc20036dbd8313ed055', 'f4790b3308feb1b8902db3a665e30c4c', '2017-02-17 20:35:19', '', '2017-01-01 07:00:00', 'admin', '2017-01-27 00:21:12', 'SDA'),
('10003', 'IRA HERIAWAN', '6434342231112', 'SIDOARJO', 'PASURUAN', 'JAWA TIMUR', '53232', '0812314', '', 'ira@gmail.com', NULL, '2017-01-01 07:00:00', '2017-01-01 07:00:00', 0, '10001', NULL, NULL, NULL, NULL, 'SIPRO', 1, NULL, NULL, NULL, '', '2017-01-01 07:00:00', 'admin', '2017-01-27 00:20:27', 'SDA'),
('10004', 'INDAH KALALO', '3524191234120001', 'SIDOARJO', 'SIDOARJO', 'JAWA TIMUR', '', '0812315', '', 'indahlo@gmail.com', NULL, '2017-01-01 07:00:00', '2017-01-01 07:00:00', 4, '10001', NULL, NULL, NULL, NULL, 'SIPRO', 1, NULL, NULL, NULL, '', '2017-01-01 07:00:00', 'admin', '2017-01-25 21:45:41', 'SDA'),
('10005', 'LUKMAN HABIBI', '352419230219870002', 'PERUM SURYA RESIDENCE 1D-16', 'SIDOARJO', 'JAWA TIMUR', '61252', '0812345678', '98123299', 'lukmanhabibi@gmail.com', NULL, '2017-01-25 13:49:27', NULL, 0, '10002', '10001', NULL, NULL, NULL, 'SIPRO', 1, NULL, NULL, NULL, '10002', '2017-01-25 13:49:27', NULL, NULL, 'SDA'),
('10006', 'MARIA SARAPOVA', '352419230219870001', 'PERUM SURYA RESIDENCE 1D-16', 'SIDOARJO', 'JAWA TIMUR', '61252', '081234567891', '081987654321', 'mariasaraf@gmail.com', NULL, '2017-01-25 14:18:37', NULL, 0, '10008', '10007', '10003', '10001', NULL, 'SIPRO', 1, NULL, NULL, NULL, '10002', '2017-01-25 14:18:37', 'admin', '2017-06-14 11:15:07', 'SDA'),
('10007', 'MARGARET MAIMUNAH', '3524191234120002', 'SURABAYA TIMUR LAUT', 'SURABAYA', 'JAWA TIMUR', '12346', '0898989', '', 'margaret@gmail', NULL, '2017-01-25 21:31:39', NULL, 0, '10003', '10001', NULL, NULL, NULL, 'SIPRO', 1, NULL, NULL, NULL, 'admin', '2017-01-25 21:31:39', 'admin', '2017-01-25 21:43:42', 'SDA'),
('10008', 'SHINTA MURNI', '352122123123123', 'SURABAYA', 'SURABAYA', 'JAWA TIMUR', '62342', '081212', '0813311', 'shinta@gmail.com', NULL, '2017-01-26 01:51:16', NULL, 0, '10007', '10003', '10001', NULL, NULL, 'SIPRO', 1, NULL, NULL, NULL, 'admin', '2017-01-26 01:51:16', NULL, NULL, 'SDA'),
('10009', 'DARWANTO SUMARGONO', '352323132899232', 'JL. GRESIK', 'SURABAYA', 'JAWA TIMUR', '63232', '08434893', '084343882', 'sumargo@gmail.com', NULL, '2017-01-26 02:12:26', NULL, 0, '10007', '10003', '10001', NULL, NULL, 'SIPRO', 1, NULL, NULL, NULL, 'admin', '2017-01-26 02:12:26', 'admin', '2017-05-14 14:00:38', 'SDA'),
('10010', 'WIDURI INDAHSARI', '334300434932899', 'JL KEMIRI TIMUR 32', 'SIDOARJO', 'JAWA TIMUR', '61323', '084342322', '0812121', 'sundari@gmail.com', NULL, '2017-01-26 02:20:51', NULL, 0, '10002', '10001', NULL, NULL, NULL, 'SIPRO', 1, NULL, NULL, NULL, 'admin', '2017-01-26 02:20:51', 'admin', '2017-06-16 11:28:04', 'SDA'),
('10011', 'SOFYAN JALIL', '3200329394989', 'MALANG', 'MALANG', 'JAWA TIMUR', '60123', '08343422', '04348923', 'sofyanjalil@gmail.com', NULL, '2017-01-26 15:22:02', '2017-01-27 00:16:16', 0, '10010', '10002', '10001', NULL, NULL, 'SIPRO', 1, NULL, NULL, NULL, 'admin', '2017-01-26 15:22:02', 'admin', '2017-06-16 11:28:04', 'SDA'),
('10012', 'ABDUL MALIK', '453432930049001', 'SURABAYA', 'SURABAYA', 'JAWA TIMUR', '60232', '0844342', '04834232', 'arihanggara@gmail.com', NULL, '2017-01-27 00:19:48', '2017-04-14 22:25:16', 0, '10011', '10010', '10002', '10001', NULL, 'SIPRO', 1, '6947c4adf32c5f951438ac54cb5379ef', NULL, NULL, 'admin', '2017-01-27 00:19:48', 'admin', '2017-06-16 11:36:38', 'SDA'),
('10013', 'THORIQUL MAJID', '55478343994389920', 'PAGERWOJO', 'SIDOARJO', 'JAWA TIMUR', '61322', '08123445432', '0812323233', 'sindo@gmail.com', NULL, '2017-01-30 20:27:19', '2017-04-15 05:50:39', 0, '10001', '', NULL, NULL, NULL, 'SIPRO', 1, '83215f097d2d76015a0ffcbd55b30fac', NULL, NULL, '10001', '2017-01-30 20:27:19', 'admin', '2017-01-31 06:01:20', 'SDA'),
('10014', 'NATASYA WILONA', '4343223238900932', 'PULOGADUNG, JAKARTA TIMUR', 'JAKARTA', 'DKI JAKARTA', '12432', '081232121', '084893434', 'natasya@wilona.id', NULL, '2017-01-31 05:41:33', '2017-04-15 05:55:57', 0, '10001', '', NULL, NULL, NULL, 'SIPRO', 1, 'e4ccef13239639ffa1fcab67073ff72a', NULL, NULL, '10001', '2017-01-31 05:41:33', NULL, NULL, 'SDA'),
('10015', 'RUDI KOMARUDIN', '352434230219870002', 'PERUM SURYA RESIDENCE 1D-16', 'SIDOARJO', 'JAWA TIMUR', '61252', '081234543433', '0819876543439', 'rudi@gmail.com', NULL, '2017-01-31 05:43:01', '2017-05-14 15:39:15', 0, '10009', '10007', '10003', '10001', NULL, 'SIPRO', 1, 'c81a4b4e8b8bf1ff18890c2c1fde41d8', NULL, NULL, '10002', '2017-01-31 05:43:01', 'admin', '2017-06-16 11:50:47', 'SDA'),
('10016', 'WACHID NURDIN', '3524342323219870002', 'PERUM SURYA RESIDENCE', 'SIDOARJO', 'JAWA TIMUR', '61252', '081234543443', '0819876543440', 'wachid@gmail.com', NULL, '2017-01-31 05:50:31', NULL, 0, '10002', '10001', NULL, NULL, NULL, 'SIPRO', 0, NULL, NULL, NULL, '10002', '2017-01-31 05:50:31', NULL, NULL, 'SDA'),
('10017', 'SUSAN SUNARYA', '352123230219870001', 'PERUM SURYA RESIDENCE 1D-16', 'SIDOARJO', 'JAWA TIMUR', '61252', '081234567', '081987654321', 'mariamaria@gmail.com', NULL, '2017-02-02 15:26:15', NULL, 0, '10002', '10001', NULL, NULL, NULL, 'SIPRO', 0, NULL, NULL, NULL, '10002', '2017-02-02 15:26:15', NULL, NULL, 'SDA'),
('10018', 'UCUP MARKUCUP', '3239283928893', 'JL. LAMONGAN', 'GRESIK', 'JAWA TIMUR', '43432', '09323232', '', 'it.pro2m4@gmail.com', NULL, '2017-02-09 05:03:34', NULL, 0, '10002', '10001', NULL, NULL, NULL, 'SIPRO', 0, NULL, NULL, NULL, '10002', '2017-02-09 05:03:34', NULL, NULL, 'SDA'),
('10019', 'LINTA LAHU', '893829399', 'SUDIRMAN SAID 48', 'JAKARTA', 'DKI JAKARTA', '12312', '08432323', '', 'it.pro2m2@gmail.com', NULL, '2017-02-09 05:07:11', NULL, 0, '10002', '10001', NULL, NULL, NULL, 'SIPRO', 0, NULL, NULL, NULL, '10002', '2017-02-09 05:07:11', NULL, NULL, 'SDA'),
('10020', 'MAJU TAK GENTAR', '832938298', 'JL. PAHLAWAN KEMERDEKAAN 89 SUNAN GIRI', 'SIDOARJO', 'JAWA TIMUR', '43434', '0844322', '', 'it.pro2m3@gmail.com', NULL, '2017-02-09 05:09:52', NULL, 0, '10002', '10001', NULL, NULL, NULL, 'SIPRO', 0, NULL, NULL, NULL, '10002', '2017-02-09 05:09:52', NULL, NULL, 'SDA'),
('10021', 'MUNAWAR SALEH', '3434784892729', 'JL TITIPAN LUMINTING 67', 'MALANG', 'JAWA TIMUR', '67366', '08673883662', '', 'hanggaraari@yahoo.com', NULL, '2017-02-09 06:02:43', NULL, 0, '10002', '10001', NULL, NULL, NULL, 'SIPRO', 0, NULL, NULL, NULL, '10002', '2017-02-09 06:02:43', NULL, NULL, 'SDA'),
('10022', 'MARIA KITRI', '4342323', 'JL. ILALANG SELATAN NO.78', 'SIDOARJO', 'JAWA TIMUR', '23232', '081213122', '', 'it.pro2m', NULL, '2017-02-09 21:30:39', NULL, 0, '10001', '', NULL, NULL, NULL, 'SIPRO', 0, NULL, NULL, NULL, '10001', '2017-02-09 21:30:39', NULL, NULL, 'SDA'),
('10023', 'WIDURI KUSUMAWARDANI', '243923209323', 'JL MUNCAL SEWU 77', 'SEMARANG', 'JAWA TENGAH', '12121', '084334232', '', 'muncalsewu@', NULL, '2017-02-09 21:37:17', NULL, 0, '10002', '10001', NULL, NULL, NULL, 'SIPRO', 0, NULL, NULL, NULL, '10002', '2017-02-09 21:37:17', NULL, NULL, 'SDA'),
('10024', 'SINTIANA TUNGGAL DEWI', '3238989', 'JL. MUHAMMAD NURMAN 55', 'MOJOKERTO', 'JAWA TIMUR', '42232', '082321121', '', 'munurmanat', NULL, '2017-02-09 21:39:07', NULL, 0, '10002', '10001', NULL, NULL, NULL, 'SIPRO', 0, NULL, NULL, NULL, '10002', '2017-02-09 21:39:07', NULL, NULL, 'SDA'),
('10025', 'MARGARET WEJANGAN', '8498493499', 'JL. JAKARTA 88', 'SURABAYA', 'JAWA TIMUR', '23239', '08434232', '', 'ajeng.com', NULL, '2017-02-09 21:42:28', NULL, 0, '10002', '10001', NULL, NULL, NULL, 'SIPRO', 0, NULL, NULL, NULL, '10002', '2017-02-09 21:42:28', NULL, NULL, 'SDA'),
('10026', 'TEST REGISTRASI NPWP_BANK', '12312332323121', 'JL INDAH TAK BERUJUNG 69', 'LAMONGAN', 'JAWA TIMUR', '62282', '0812312121', '081233232', 'it.pro2m@gmail.com', '839289322232', '2017-03-15 07:52:32', NULL, 0, '10002', '10001', NULL, NULL, NULL, 'SIPRO', 0, NULL, NULL, NULL, '10002', '2017-03-15 07:52:32', NULL, NULL, 'SDA'),
('10027', 'MEMBER TIDUR SIPRO', '12345678999999', 'MABES', 'SIDOARJO', 'JAWA TIMUR', '61256', '081385551542', '', 'membertidursipro@buatente.com', NULL, '2017-05-07 14:43:08', '2017-05-07 14:47:26', 0, '10001', '', NULL, NULL, NULL, 'SIPRO', 1, 'a77ced2a192a3d857dbaf75b7db12f09', NULL, NULL, 'admin', '2017-05-07 14:43:08', NULL, NULL, 'SDA');

-- --------------------------------------------------------

--
-- Table structure for table `m_member_bank`
--

CREATE TABLE `m_member_bank` (
  `id` int(11) NOT NULL,
  `id_member` varchar(10) NOT NULL,
  `id_kode_bank` int(5) NOT NULL,
  `norek` varchar(20) NOT NULL,
  `atas_nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_member_bank`
--

INSERT INTO `m_member_bank` (`id`, `id_member`, `id_kode_bank`, `norek`, `atas_nama`) VALUES
(1, '10001', 1, '3300486508', 'MOHAMMAD SYAFI\'I ARI HANGGARA'),
(2, '10001', 3, '1400043211235', 'MOHAMMAD SYAFI\'I ARI HANGGARA'),
(3, '10026', 1, '012312312', 'ari hanggara'),
(4, '10027', 1, 'KANTOR', 'MEMBER TIDUR SIPRO');

-- --------------------------------------------------------

--
-- Table structure for table `m_member_device`
--

CREATE TABLE `m_member_device` (
  `id` int(11) NOT NULL,
  `id_member` varchar(10) NOT NULL,
  `device_id` varchar(200) NOT NULL,
  `tgl_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_member_device`
--

INSERT INTO `m_member_device` (`id`, `id_member`, `device_id`, `tgl_update`) VALUES
(1, '10001', 'fciOwpgsPMU:APA91bGnmCn8ri_-IaTGht-n4B79iG1opwSeyHbWeZnibwyxsmJFicKH9JJ6kIqxnLkPTfKaWOILLaOU9_3EaTQg0hRv-K7uCmSHFuvWa8p4_XgzbHR-8A0YnRLgHme3waHzncgrX4H-', '2017-03-11 09:18:05');

-- --------------------------------------------------------

--
-- Table structure for table `m_member_gallery`
--

CREATE TABLE `m_member_gallery` (
  `id` int(11) NOT NULL,
  `id_member` varchar(10) NOT NULL,
  `gambar` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `m_member_profile`
--

CREATE TABLE `m_member_profile` (
  `id` int(11) NOT NULL,
  `id_member` varchar(10) NOT NULL,
  `tgl` date NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `notelp` varchar(50) NOT NULL,
  `about_me` varchar(200) DEFAULT NULL,
  `bisnis` varchar(100) DEFAULT NULL,
  `alamat_bisnis` varchar(100) DEFAULT NULL,
  `bisnis_lat` varchar(20) DEFAULT NULL,
  `bisnis_lng` varchar(20) DEFAULT NULL,
  `foto` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_member_profile`
--

INSERT INTO `m_member_profile` (`id`, `id_member`, `tgl`, `nama`, `alamat`, `notelp`, `about_me`, `bisnis`, `alamat_bisnis`, `bisnis_lat`, `bisnis_lng`, `foto`) VALUES
(1, '10002', '2017-01-01', 'ARI HANGGARA', 'SIDOARJO', '0812313', NULL, NULL, NULL, NULL, NULL, NULL),
(2, '10003', '2017-01-01', 'IRA HERIAWAN', 'SIDOARJO', '0812314', NULL, NULL, NULL, NULL, NULL, NULL),
(3, '10004', '2017-01-01', 'INDAH KALALO', 'SIDOARJO', '0812315', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_menu`
--

CREATE TABLE `m_menu` (
  `id` tinyint(5) NOT NULL,
  `id_parent` tinyint(6) NOT NULL DEFAULT '0',
  `menu` varchar(30) NOT NULL,
  `link` varchar(100) DEFAULT NULL,
  `icon` varchar(30) DEFAULT NULL,
  `urutan` tinyint(5) UNSIGNED NOT NULL DEFAULT '1',
  `status` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_menu`
--

INSERT INTO `m_menu` (`id`, `id_parent`, `menu`, `link`, `icon`, `urutan`, `status`) VALUES
(1, 0, 'Dashboard', 'dashboard', 'md md-home', 1, 1),
(2, 0, 'Data Management', NULL, 'fa fa-table', 2, 1),
(3, 0, 'Program SIPRO', NULL, 'fa fa-home', 4, 1),
(4, 0, 'Project Management', NULL, 'fa fa-cogs', 8, 1),
(5, 0, 'Account / Rekening', NULL, 'md md-account-balance', 9, 1),
(6, 0, 'Transaksi', NULL, 'fa fa-shopping-cart', 10, 1),
(7, 0, 'Finance & Accounting', NULL, 'fa fa-money', 11, 1),
(8, 0, 'Laporan', NULL, 'fa fa-bar-chart', 12, 1),
(9, 0, 'Setting', NULL, 'fa fa-wrench', 13, 1),
(10, 2, 'Member', 'member', NULL, 1, 1),
(11, 2, 'Cabang', 'cabang', NULL, 2, 1),
(12, 52, 'Daftar Produk', 'produk', NULL, 2, 1),
(13, 52, 'Jenis Produk', 'jenis_produk', NULL, 5, 1),
(14, 2, 'Kolektor', 'kolektor', NULL, 6, 0),
(15, 2, 'User', 'user', NULL, 7, 1),
(16, 2, 'Group User', 'group_user', NULL, 8, 1),
(17, 3, 'Komisi Registrasi', 'komisi_registrasi', NULL, 3, 1),
(18, 2, 'Data Program', 'program', NULL, 2, 1),
(19, 48, 'Saham Referensi BISPRO', 'saham_ref_bispro', NULL, 4, 1),
(20, 5, 'Setoran Dana', 'setoran_wallet', NULL, 2, 1),
(21, 5, 'Penarikan Dana', 'penarikan_wallet', NULL, 3, 1),
(22, 5, 'Bayar Angsuran', 'angsuran', NULL, 8, 1),
(23, 5, 'Rekening Angsuran', 'rek_angsuran', NULL, 7, 1),
(24, 5, 'Mutasi Rekening', 'mutasi_wallet', NULL, 4, 1),
(25, 52, 'Penjualan', 'penjualan', NULL, 1, 1),
(26, 6, 'Input Pengeluaran', 'pengeluaran', NULL, 2, 1),
(27, 6, 'Bagi Hasil', 'bagi_hasil', NULL, 3, 1),
(28, 7, 'Jurnal', 'jurnal', NULL, 2, 1),
(29, 7, 'Laporan Keuangan', 'lap_keuangan', NULL, 3, 1),
(30, 7, 'Laporan Laba-Rugi', 'lap_laba_rugi', NULL, 4, 1),
(31, 7, 'Laporan Neraca', 'lap_neraca', NULL, 5, 1),
(32, 8, 'Laporan Modal Sipro', 'lap_modal_sipro', NULL, 1, 1),
(33, 8, 'Laporan Cost Project', 'lap_cost_project', NULL, 2, 1),
(34, 8, 'Laporan Revenue Project', 'lap_revenue_project', NULL, 3, 1),
(35, 8, 'Laporan Bagi Hasil', 'lap_bagi_hasil', NULL, 4, 1),
(36, 8, 'Laporan Fee Marketing', 'lap_fee_marketing', NULL, 5, 1),
(37, 8, 'Laporan Registrasi Member', 'lap_registrasi', NULL, 6, 1),
(38, 9, 'Prosentase Bagi Hasil', 'set_prosentase', NULL, 1, 1),
(39, 9, 'Fee Marketing', 'set_fee', NULL, 2, 1),
(40, 5, 'Rekening E-Wallet', 'rek_wallet', NULL, 1, 1),
(41, 5, 'Rekening Sipro', 'rek_sipro', NULL, 5, 1),
(42, 62, 'Aktivasi Member', 'aktivasi_member', NULL, 1, 1),
(43, 62, 'Jaringan Mitra Kerja', 'jaringan_mitra_kerja', NULL, 7, 1),
(44, 3, 'Simpanan Anggota', 'simpanan_anggota', NULL, 6, 1),
(45, 5, 'Rekening Bispro', 'rek_bispro', NULL, 6, 1),
(46, 4, 'Project List', 'project', NULL, 1, 1),
(47, 4, 'Cost Project', 'cost_project', NULL, 2, 1),
(48, 0, 'Program BISPRO', NULL, 'fa fa-line-chart', 5, 1),
(49, 48, 'Validasi Topup BISPRO', 'validasi_topup_bispro', '', 1, 1),
(50, 48, 'Topup BISPRO', 'topup_bispro', '', 2, 1),
(51, 48, 'Lihat Saham BISPRO', 'saham_bispro', '', 3, 1),
(52, 0, 'Kios Property', NULL, 'fa fa-shopping-cart', 7, 1),
(53, 52, 'Group Produk', 'group_produk', NULL, 3, 1),
(54, 3, 'Komisi Royalty', 'komisi_royalty', NULL, 4, 1),
(55, 3, 'Validasi Topup SIPRO', 'validasi_topup_sipro', '', 1, 1),
(56, 3, 'Topup SIPRO', 'topup_sipro', '', 2, 1),
(57, 0, 'PPOB', NULL, 'fa fa-credit-card', 6, 1),
(58, 57, 'Topup Deposit', 'deposit_ppob', '', 1, 1),
(59, 57, 'Produk & Fee', 'fee_trx_ppob', '', 2, 1),
(60, 57, 'History Transaksi', 'history_trx_ppob', '', 3, 1),
(61, 57, 'Rekap Transaksi', 'rekap_trx_ppob', '', 4, 1),
(62, 0, 'PRO2M', NULL, 'fa fa-sellsy', 3, 1),
(63, 62, 'Konfirmasi Aktivasi', 'konfirmasi_aktivasi', NULL, 2, 1),
(64, 62, 'Testimonial', 'testimonial', NULL, 4, 1),
(65, 62, 'Komplain Member', 'komplain', NULL, 5, 1),
(66, 62, 'Request Withdraw', 'withdraw', NULL, 3, 1),
(67, 62, 'Kirim Pesan Ke Member', 'kirim_pesan', NULL, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_news`
--

CREATE TABLE `m_news` (
  `id` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `teks` text NOT NULL,
  `gambar` varchar(50) DEFAULT NULL,
  `tgl` date NOT NULL,
  `user` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_news`
--

INSERT INTO `m_news` (`id`, `judul`, `teks`, `gambar`, `tgl`, `user`) VALUES
(1, 'Tanah Semakin Mahal, Harga Rumah Jauh Dari Jangkauan', 'Ketersediaan lahan masih menjadi masalah yang dihadapi oleh pengembang perumahan. Hal itu, karena harga lahan yang setiap hari mengalami kenaikan dan tidak terkendali, sehingga imbasnya, harga rumah pun menjadi sulit untuk terjangkau. <br>" bahkan dalam satu tahun harganya bisa naik hingga 100 persen " CEO PT. Property Syariah Indonesia, Yoko. <br>Dia menegaskan, hal inilah yang patut diwaspadai, karena tanah itu merupakan komponen utama dalam pembangunan rumah. Artinya, jika terus naik, harga rumah tidak lagi terjangkau.<br>"Kenaikannya ini yang enggak kira-kira. Harga tanah sekarang saja bisa puluhan juta per meter persegi," ungkap nya.<br>Dengan terus naik nya harga property maka kebutuhan rumah untuk masyarakat menjadi terkendala. Satu sisi masyarakat menginginkan rumah yang bagus namun terjangkau sementara harga tanah mahal Sehingga apa yang di lakukan developer adalah, dengan menawarkan rumah tipe sangat kecil dan cenderung berdesak desakan  Dengan kata lain jauh dari kebutuhan rumah sehat yang ideal. Itupun kalau di area strategis tidak jauh dari kota harganya sudah cukup memberatkan masyarakat kecil.<br><br>Dengan mahal nya harga rumah maka para pekerja seperti sopir taxi, pekerja pabrik ataupun pekerja pekerja umumnya sangat sulit untuk membeli rumah. Bahkan untuk Dp nya saja mereka harus berusaha keras manabung dengan cara mengencangkan ikat pinggang, meskipun sebenarnya dengan pendapatan yang sangat minim dan jauh dari kata cukup.<br><br>“Kondisi inilah yang menjadi keriasuan saya selaku pengembang Property syariah. ketika promosi menghadirkan rumah syariah, banyak sekali masyarakat yang meminta solusi kepada saya bagaimana cara nya bisa beli rumah kepada saya sementara gaji Cuma 3,5jt dan itu pun untuk biaya sekolah 2 anak 1,5 jt dan 2 jt di pakai untuk keperluan pribadi” ungkap Nya.<br>Maka dengan hadirnya APPS Pro2M ini mudah2 han menjadi Solusi bagi masyarakat kecil ataupun menengah sehingga bisa memperoleh pendapatan tambahan dan simpanan pembelian property.<br>', 'tanah_semakin_mahal.jpg', '2017-02-18', 'admin'),
(2, 'KPR, Cara membeli rumah yang Salah', 'Membeli rumah dengan kredit jangka panjang dari bank ternyata cara yang salah. Saya tidak tahu apakah ratusan bahkan jutaan orang lainnya merasakannya juga. Ataukah malah menganggap keberuntungan, tersebab dengan pinjaman berbunga itu dapat mengatasi ketidakmampuan membeli rumah secara tunai. Jika pun keberuntungan, di baliknya ada kesalahan—karena dilakukan oleh banyak orang, maka kesalahan ini terlihat benar.<br>Semua akar persoalannya ada pada riba. Riba pula yang dijadikan solusinya. Riba, biang segala persoalan hidup manusia, telah mengakibatkan orang kebanyakan tidak mampu memiliki rumah dengan uang sendiri, dan memaksanya untuk meminjam uang dari bank. Bagi orang Islam, membeli dengan KPR bukan hanya menjeratnya dalam utang jangka panjang. Namun yang lebih buruk dari itu—dan inilah yang telah menenggelamkan umat Islam dalam kubangan lumpur bunga bank alias riba!<br>Riba telah mengakibatkan seluruh beban kehidupan menjadi semakin tidak tertanggungkan. Biaya dan harga apa pun menjadi berlipat ganda akibat riba. Bersamaan dengan bank memasarkan KPR, semakin banyak tanah yang dikuasai oleh para bankir melalui para developer. Akibatnya, memiliki rumah dengan uang sendiri menjadi sebuah kemewahan.<br>Harga rumah semakin tidak terjangkau. KPR yang semula ditujukan untuk rumah tipe 70 harus diturunkan untuk tipe 60. Turun lagi menjadi tipe 45, lalu tipe 36, dan terus mengecil. Karena harganya makin mahal, rumah tipe 36 itu pun hanya bisa dibeli oleh sedikit orang. Selain tipenya mengecil dan harganya makin mahal, letak rumah kreditan juga makin jauh lokasinya, sehingga lebih banyak lagi keluar biaya transportasi.<br>Simulasi harga Rumah di surabaya<br>Tipe/ luas tanah (55/110) harga 1M<br>Dp 20% 			: Rp 200 jt<br>Pajak 5%			: Rp50 jt<br>Provisi asuransi dll 2,5% 	: Rp 25 jt<br>Total pengeluaran awal 		: Rp 275 jt<br>Nilai KPR 800jt /15 thn dengan bunga rata 15% maka <br>nilai angsuran adalah		: Rp.12jt<br>Persyaratan Gaji atau pendapatan adalah 3X nilai cicilan<br>Gaji atau pendapatan minimal	: Rp.36jt<br><br>Nah setelah KPR di setujui maka biasanya pembeli rumah akan senang untuk beberapa waktu, Namun ketika waktu berjalan maka pembeli rumah mulai merasakan beban nya mengangsur, dan apalagi ketika ekonomy keluarga turun maka harus kencangkan ikat pinggang demi tinggal di rumah yang telah di beli pakai KPR. Nah ketika angsuran lancar maka baik2 saja tapi ketika mulai terlambat bayar maka denda yang mencekik mulai mengganggu kebahagian keluarga dan yang lebih parah adalah ketika angsuran tidak terbayar lebih dari 3 bulan maka teror rumah akan di sita mulai mampir. Tidak enak bukan?<br><br>Bagi kita semua tentu mengharapkan bisa memiliki rumah idaman tanpa harus  mengalami situasi tersebut di atas dan juga sebisa mungkin tanpa riba. Mengingat riba sangat di larang dalam hampir semua kitab suci di berbagai agama.<br><br>Semoga Allah Ta’ala mengabulkan doa kita untuk bisa memiliki rumah idaman tanpa hutang tanpa riba. amiin.***<br>', 'kpr.jpg', '2017-02-18', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `m_ppob_produk`
--

CREATE TABLE `m_ppob_produk` (
  `kode` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `denom` int(9) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `id_group` int(11) NOT NULL,
  `urutan` int(3) NOT NULL,
  `fee_member` int(8) NOT NULL,
  `fee_upline1` int(5) NOT NULL DEFAULT '0',
  `fee_upline2` int(5) NOT NULL DEFAULT '0',
  `fee_upline3` int(5) NOT NULL DEFAULT '0',
  `fee_upline4` int(5) NOT NULL DEFAULT '0',
  `fee_upline5` int(5) NOT NULL DEFAULT '0',
  `fee_supplier` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_ppob_produk`
--

INSERT INTO `m_ppob_produk` (`kode`, `nama`, `denom`, `status`, `id_group`, `urutan`, `fee_member`, `fee_upline1`, `fee_upline2`, `fee_upline3`, `fee_upline4`, `fee_upline5`, `fee_supplier`) VALUES
('ACC', 'ACC KREDIT MOBIL', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('ADIRA', 'ADIRA FINANCE', 0, 0, 38, 1, 1025, 25, 25, 25, 25, 25, 1350),
('AETRA', 'AETRA JAKARTA', 0, 1, 37, 1, 625, 25, 25, 25, 25, 25, 950),
('AETRATANGERANG', 'AETRA TANGERANG', 0, 0, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('ALIJARAH', 'AL IJARAH FINANCE', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('AORATV', 'AORA TV', 0, 1, 35, 1, 625, 25, 25, 25, 25, 25, 950),
('APF', 'ARTHA PRIMA FINANCE', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('AS10', 'ASIASOFT 10RB', 10000, 1, 1, 1, 9650, 25, 25, 25, 25, 25, 9425),
('AS100', 'ASIASOFT 100RB', 100000, 1, 1, 1, 92350, 25, 25, 25, 25, 25, 92125),
('AS20', 'ASIASOFT 20RB', 20000, 1, 1, 1, 18850, 25, 25, 25, 25, 25, 18625),
('AS25', 'ASIASOFT 25RB', 25000, 0, 1, 1, 25350, 25, 25, 25, 25, 25, 25125),
('AS300', 'ASIASOFT 300RB', 300000, 0, 1, 1, 300350, 25, 25, 25, 25, 25, 300125),
('AS50', 'ASIASOFT 50RB', 50000, 1, 1, 1, 46350, 25, 25, 25, 25, 25, 46125),
('ASIA', 'ASIA FINANCE (ARTHAASIA FINANCE)', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('AX1', 'AXIS 1RB', 1000, 0, 2, 1, 1750, 25, 25, 25, 25, 25, 1525),
('AX10', 'AXIS 10RB', 10000, 1, 2, 1, 11400, 25, 25, 25, 25, 25, 11175),
('AX100', 'AXIS 100RB', 100000, 1, 2, 1, 100725, 25, 25, 25, 25, 25, 100500),
('AX2', 'AXIS 2RB', 2000, 0, 2, 1, 2725, 25, 25, 25, 25, 25, 2500),
('AX20', 'AXIS 20RB', 20000, 0, 2, 1, 20725, 25, 25, 25, 25, 25, 20500),
('AX25', 'AXIS 25RB', 25000, 1, 2, 1, 26025, 25, 25, 25, 25, 25, 25800),
('AX3', 'AXIS 3RB', 3000, 0, 2, 1, 3725, 25, 25, 25, 25, 25, 3500),
('AX4', 'AXIS 4RB', 4000, 0, 2, 1, 4725, 25, 25, 25, 25, 25, 4500),
('AX5', 'AXIS 5RB', 5000, 1, 2, 1, 6375, 25, 25, 25, 25, 25, 6150),
('AX50', 'AXIS 50RB', 50000, 1, 2, 1, 50725, 25, 25, 25, 25, 25, 50500),
('AXIS', 'AXIS PASCA', 0, 0, 36, 1, 675, 25, 25, 25, 25, 25, 1000),
('BAF', 'BAF (BUSSAN AUTO FINANCE)', 0, 1, 38, 1, 675, 25, 25, 25, 25, 25, 1000),
('BFI', 'BFI FINANCE INDONESIA', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('BIMA', 'BIMA FINANCE', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('BPJSKES', 'BPSJ KESEHATAN', 0, 0, 39, 1, 875, 25, 25, 25, 25, 25, 1200),
('BPJSTK', 'BPSJ TENAGA KERJA', 0, 0, 39, 1, 875, 25, 25, 25, 25, 25, 1200),
('BUANA', 'BUANA FINANCE', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('CENTRINTV', 'CENTRIN TV', 0, 1, 35, 1, 625, 25, 25, 25, 25, 25, 950),
('CHER100', 'CHERRYCREDITS 100RB', 100000, 0, 4, 1, 100350, 25, 25, 25, 25, 25, 100125),
('CHER200', 'CHERRYCREDITS 200RB', 200000, 0, 4, 1, 200350, 25, 25, 25, 25, 25, 200125),
('CHER300', 'CHERRYCREDITS 300RB', 300000, 0, 4, 1, 300350, 25, 25, 25, 25, 25, 300125),
('CHER50', 'CHERRYCREDITS 50RB', 50000, 0, 4, 1, 50350, 25, 25, 25, 25, 25, 50125),
('CIMB', 'CIMB NIAGA AUTO FINANCE', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('COLUMBIA', 'COLUMBIA FINANCE', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('CP100', 'CAPPLE 100RB', 100000, 1, 3, 1, 92350, 25, 25, 25, 25, 25, 92125),
('CP12', 'CAPPLE 12RB', 12000, 1, 3, 1, 11350, 25, 25, 25, 25, 25, 11125),
('CP32', 'CAPPLE 32RB', 32000, 1, 3, 1, 29650, 25, 25, 25, 25, 25, 29425),
('CP52', 'CAPPLE 52RB', 52000, 1, 3, 1, 48150, 25, 25, 25, 25, 25, 47925),
('CSF', 'CS FINANCE', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('DC10', 'DIGICASH 10RB', 10000, 1, 5, 1, 9650, 25, 25, 25, 25, 25, 9425),
('DC100', 'DIGICASH 100RB', 100000, 1, 5, 1, 92350, 25, 25, 25, 25, 25, 92125),
('DC20', 'DIGICASH 20RB', 20000, 1, 5, 1, 18850, 25, 25, 25, 25, 25, 18625),
('DC250', 'DIGICASH 250RB', 250000, 1, 5, 1, 228350, 25, 25, 25, 25, 25, 228125),
('DC50', 'DIGICASH 50RB', 50000, 1, 5, 1, 46350, 25, 25, 25, 25, 25, 46125),
('DG10', 'DIGISOFT 10RB', 10000, 0, 6, 1, 10350, 25, 25, 25, 25, 25, 10125),
('DG100', 'DIGISOFT 100RB', 100000, 0, 6, 1, 100350, 25, 25, 25, 25, 25, 100125),
('DG20', 'DIGISOFT 20RB', 20000, 0, 6, 1, 20350, 25, 25, 25, 25, 25, 20125),
('DG50', 'DIGISOFT 50RB', 50000, 0, 6, 1, 50350, 25, 25, 25, 25, 25, 50125),
('ESIAPASCA', 'ESIA PASCA', 0, 0, 36, 1, 1675, 25, 25, 25, 25, 25, 2000),
('FB30', 'FACEBOOK 30RB', 30000, 0, 7, 1, 30350, 25, 25, 25, 25, 25, 30125),
('FIF', 'FIF FINANCE', 0, 1, 38, 1, 675, 25, 25, 25, 25, 25, 1000),
('G10', 'GEMSCOOL 10RB', 10000, 1, 11, 1, 9950, 25, 25, 25, 25, 25, 9725),
('G100', 'GEMSCOOL 100RB', 100000, 1, 11, 1, 95350, 25, 25, 25, 25, 25, 95125),
('G20', 'GEMSCOOL 20RB', 20000, 1, 11, 1, 19250, 25, 25, 25, 25, 25, 19025),
('G200', 'GEMSCOOL 200RB', 200000, 1, 11, 1, 187850, 25, 25, 25, 25, 25, 187625),
('G30', 'GEMSCOOL 30RB', 30000, 1, 11, 1, 28750, 25, 25, 25, 25, 25, 28525),
('G300', 'GEMSCOOL 300RB', 300000, 1, 11, 1, 280350, 25, 25, 25, 25, 25, 280125),
('G50', 'GEMSCOOL 50RB', 50000, 1, 11, 1, 47250, 25, 25, 25, 25, 25, 47025),
('GR125', 'GARENA V100', 125000, 1, 10, 1, 113850, 25, 25, 25, 25, 25, 113625),
('GR250', 'GARENA V200', 250000, 1, 10, 1, 227350, 25, 25, 25, 25, 25, 227125),
('GR50', 'GARENA V50', 50000, 1, 10, 1, 46350, 25, 25, 25, 25, 25, 46125),
('GW100', 'GAMEWAVE 300 V-CASH', 100000, 1, 8, 1, 92350, 25, 25, 25, 25, 25, 92125),
('GW1000', 'GAMEWAVE 3000 V-CASH', 1000000, 1, 8, 1, 910350, 25, 25, 25, 25, 25, 910125),
('GW200', 'GAMEWAVE 600 V-CASH', 200000, 1, 8, 1, 183350, 25, 25, 25, 25, 25, 183125),
('GW50', 'GAMEWAVE 150 V-CASH', 50000, 1, 8, 1, 46350, 25, 25, 25, 25, 25, 46125),
('GW500', 'GAMEWAVE 1500 V-CASH', 500000, 1, 8, 1, 455350, 25, 25, 25, 25, 25, 455125),
('GWB10', 'GAMEWEB 10RB', 10000, 1, 9, 1, 11100, 25, 25, 25, 25, 25, 10875),
('GWB100', 'GAMEWEB 100RB', 100000, 1, 9, 1, 106350, 25, 25, 25, 25, 25, 106125),
('GWB20', 'GAMEWEB 20RB', 20000, 1, 9, 1, 21750, 25, 25, 25, 25, 25, 21525),
('GWB50', 'GAMEWEB 50RB', 50000, 1, 9, 1, 53600, 25, 25, 25, 25, 25, 53375),
('HALO', 'KARTU HALO', 0, 1, 36, 1, 1675, 25, 25, 25, 25, 25, 2000),
('HDF', 'HD FINANCE', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('I10', 'INDOSAT REGULER 10RB', 10000, 1, 13, 1, 11625, 25, 25, 25, 25, 25, 11400),
('I100', 'INDOSAT REGULER 100RB', 100000, 1, 13, 1, 99600, 25, 25, 25, 25, 25, 99375),
('I100T', 'INDOSAT TRANSFER 100RB', 100002, 1, 13, 1, 96375, 25, 25, 25, 25, 25, 96150),
('I10G', 'INDOSAT GPRS 10RB', 10002, 1, 13, 1, 11500, 25, 25, 25, 25, 25, 11275),
('I10S', 'INDOSAT SMS 10RB', 10001, 1, 13, 1, 11600, 25, 25, 25, 25, 25, 11375),
('I10T', 'INDOSAT TRANSFER 10RB', 10002, 1, 13, 1, 11175, 25, 25, 25, 25, 25, 10950),
('I12', 'INDOSAT REGULER 12RB', 12000, 0, 13, 1, 12725, 25, 25, 25, 25, 25, 12500),
('I2', 'INDOSAT REGULER 2RB', 2000, 0, 13, 1, 2725, 25, 25, 25, 25, 25, 2500),
('I20', 'INDOSAT REGULER 20RB', 20000, 1, 13, 1, 20725, 25, 25, 25, 25, 25, 20500),
('I20T', 'INDOSAT TRANSFER 20RB', 20002, 1, 13, 1, 20575, 25, 25, 25, 25, 25, 20350),
('I25', 'INDOSAT REGULER 25RB', 25000, 1, 13, 1, 25850, 25, 25, 25, 25, 25, 25625),
('I25D', 'INDOSAT DATA 1GB 1 BLN', 25003, 1, 13, 1, 29575, 25, 25, 25, 25, 25, 29350),
('I25G', 'INDOSAT GPRS 25RB', 25002, 1, 13, 1, 26300, 25, 25, 25, 25, 25, 26075),
('I25S', 'INDOSAT SMS 25RB', 25001, 1, 13, 1, 26300, 25, 25, 25, 25, 25, 26075),
('I25T', 'INDOSAT TRANSFER 25RB', 25002, 1, 13, 1, 25225, 25, 25, 25, 25, 25, 25000),
('I30', 'INDOSAT REGULER 30RB', 30000, 1, 13, 1, 30375, 25, 25, 25, 25, 25, 30150),
('I35D', 'INDOSAT DATA 1.5GB+BONUS TOTAL 11GB', 35003, 1, 13, 1, 36775, 25, 25, 25, 25, 25, 36550),
('I40D', 'INDOSAT DATA 2GB 1BLN', 40003, 1, 13, 1, 41125, 25, 25, 25, 25, 25, 40900),
('I42D', 'INDOSAT DATA 3GB', 42003, 1, 13, 1, 42225, 25, 25, 25, 25, 25, 42000),
('I45D', 'INDOSAT DATA 4GB', 45003, 1, 13, 1, 45775, 25, 25, 25, 25, 25, 45550),
('I5', 'INDOSAT REGULER 5RB', 5000, 1, 13, 1, 6625, 25, 25, 25, 25, 25, 6400),
('I50', 'INDOSAT REGULER 50RB', 50000, 1, 13, 1, 50400, 25, 25, 25, 25, 25, 50175),
('I50D', 'INDOSAT DATA 600MB+BONUS TOTAL 3GB', 50003, 1, 13, 1, 50775, 25, 25, 25, 25, 25, 50550),
('I50T', 'INDOSAT TRANSFER 50RB', 50002, 1, 13, 1, 48975, 25, 25, 25, 25, 25, 48750),
('I5G', 'INDOSAT GPRS 5RB', 5002, 1, 13, 1, 6500, 25, 25, 25, 25, 25, 6275),
('I5S', 'INDOSAT SMS 5RB', 5001, 1, 13, 1, 6550, 25, 25, 25, 25, 25, 6325),
('I5T', 'INDOSAT TRANSFER 5RB', 5002, 1, 13, 1, 6150, 25, 25, 25, 25, 25, 5925),
('I70D', 'INDOSAT DATA 6.5GB', 70003, 1, 13, 1, 71425, 25, 25, 25, 25, 25, 71200),
('IAH10', 'IAH 10RB', 10000, 0, 12, 1, 10350, 25, 25, 25, 25, 25, 10125),
('IAH100', 'IAH 100RB', 100000, 0, 12, 1, 100350, 25, 25, 25, 25, 25, 100125),
('IAH20', 'IAH 20RB', 20000, 0, 12, 1, 20350, 25, 25, 25, 25, 25, 20125),
('IAH50', 'IAH 50RB', 50000, 0, 12, 1, 50350, 25, 25, 25, 25, 25, 50125),
('INDOMOBIL', 'INDOMOBIL FINANCE', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('INDOVISION', 'INDOVISION', 0, 1, 35, 1, 525, 25, 25, 25, 25, 25, 850),
('KREDITPLUS', 'KREDITPLUS (FINANSIA MULTI FINANCE)', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('L10', 'LYTO 10RB', 10000, 1, 14, 1, 11100, 25, 25, 25, 25, 25, 10875),
('L175', 'LYTO 175RB', 175000, 1, 14, 1, 183850, 25, 25, 25, 25, 25, 183625),
('L20', 'LYTO 20RB', 20000, 1, 14, 1, 21750, 25, 25, 25, 25, 25, 21525),
('L35', 'LYTO 35RB', 35000, 1, 14, 1, 37350, 25, 25, 25, 25, 25, 37125),
('L500', 'LYTO 500RB', 500000, 1, 14, 1, 524850, 25, 25, 25, 25, 25, 524625),
('L65', 'LYTO 65RB', 65000, 1, 14, 1, 68850, 25, 25, 25, 25, 25, 68625),
('MAF', 'MEGA AUTO FINANCE', 0, 0, 38, 1, 375, 25, 25, 25, 25, 25, 700),
('MATRIX', 'INDOSAT PASCA (MATRIX)', 0, 0, 36, 1, 1675, 25, 25, 25, 25, 25, 2000),
('MCF', 'MEGA CENTRAL FINANCE', 0, 0, 38, 1, 375, 25, 25, 25, 25, 25, 700),
('MEGA', 'MEGA FINANCE', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('MMF', 'MANDALA MULTI FINANCE', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('MNC', 'MNC FINANCE', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('MOG100', 'MOGPLAY 100RB', 100000, 1, 16, 1, 92350, 25, 25, 25, 25, 25, 92125),
('MOG20 ', 'MOGPLAY 20RB', 20000, 1, 16, 1, 18850, 25, 25, 25, 25, 25, 18625),
('MOG200', 'MOGPLAY 200RB', 200000, 1, 16, 1, 182850, 25, 25, 25, 25, 25, 182625),
('MOG50', 'MOGPLAY 50RB', 50000, 1, 16, 1, 46350, 25, 25, 25, 25, 25, 46125),
('MOG500', 'MOGPLAY 500RB', 500000, 1, 16, 1, 455350, 25, 25, 25, 25, 25, 455125),
('MS10', 'MEGAXUS 10RB', 10000, 1, 15, 1, 11100, 25, 25, 25, 25, 25, 10875),
('MS100', 'MEGAXUS 100RB', 100000, 1, 15, 1, 106350, 25, 25, 25, 25, 25, 106125),
('MS20', 'MEGAXUS 20RB', 20000, 1, 15, 1, 21750, 25, 25, 25, 25, 25, 21525),
('MS200', 'MEGAXUS 200RB', 200000, 1, 15, 1, 210850, 25, 25, 25, 25, 25, 210625),
('MS50', 'MEGAXUS 50RB', 50000, 1, 15, 1, 53350, 25, 25, 25, 25, 25, 53125),
('MS500', 'MEGAXUS 500RB', 500000, 1, 15, 1, 524850, 25, 25, 25, 25, 25, 524625),
('MTF', 'MANDIRI TUNAS FINANCE', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('MULTINDO', 'MULTINDO AUTO FINANCE', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('NH10', 'NHH G-COINS V10', 10000, 1, 17, 1, 9650, 25, 25, 25, 25, 25, 9425),
('NH100', 'NHH G-COINS V100', 100000, 1, 17, 1, 92350, 25, 25, 25, 25, 25, 92125),
('NH20', 'NHH G-COINS V20', 20000, 1, 17, 1, 18850, 25, 25, 25, 25, 25, 18625),
('NH300', 'NHH G-COINS V300', 300000, 1, 17, 1, 273350, 25, 25, 25, 25, 25, 273125),
('NH50', 'NHH G-COINS V50', 50000, 1, 17, 1, 46350, 25, 25, 25, 25, 25, 46125),
('NH500', 'NHH G-COINS V500', 500000, 1, 17, 1, 454350, 25, 25, 25, 25, 25, 454125),
('NSC', 'NSC FINANCE', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('OG10', 'ORANGE GAME 10RB', 10000, 1, 19, 1, 9650, 25, 25, 25, 25, 25, 9425),
('OG100', 'ORANGE GAME 100RB', 100000, 1, 19, 1, 92350, 25, 25, 25, 25, 25, 92125),
('OG30', 'ORANGE GAME 30RB', 30000, 1, 19, 1, 27850, 25, 25, 25, 25, 25, 27625),
('OG50', 'ORANGE GAME 50RB', 50000, 1, 19, 1, 46350, 25, 25, 25, 25, 25, 46125),
('OL10', 'ONELIFE 10RB', 10000, 0, 18, 1, 10350, 25, 25, 25, 25, 25, 10125),
('OL25', 'ONELIFE 25RB', 25000, 0, 18, 1, 25350, 25, 25, 25, 25, 25, 25125),
('OTO', 'SUMMIT OTO FINANCE', 0, 1, 38, 1, 675, 25, 25, 25, 25, 25, 1000),
('PALYJA', 'PALYJA JAKARTA', 0, 1, 37, 1, 625, 25, 25, 25, 25, 25, 950),
('PDAMBALANGAN', 'PDAM BALANGAN (KALSEL)', 0, 1, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('PDAMBALIKPAPAN', 'PDAM BALIKPAPAN (KALTIM)', 0, 0, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('PDAMBANDUNG', 'PDAM BANDUNG (JABAR)', 0, 0, 37, 1, 625, 25, 25, 25, 25, 25, 950),
('PDAMBANGKALAN', 'PDAM BANGKALAN (JATIM)', 0, 1, 37, 1, 425, 25, 25, 25, 25, 25, 750),
('PDAMBANJARBARU', 'PDAM BANJARBARU (KALSEL)', 0, 1, 37, 1, 375, 25, 25, 25, 25, 25, 700),
('PDAMBANJARMASIN', 'PDAM BANJARMASIN (KALSEL)', 0, 1, 37, 1, 575, 25, 25, 25, 25, 25, 900),
('PDAMBANYUMAS', 'PDAM BANYUMAS (JATENG)', 0, 1, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('PDAMBATU', 'PDAM BATU (JATIM)', 0, 0, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('PDAMBEKASI', 'PDAM BEKASI (JABAR)', 0, 0, 37, 1, 625, 25, 25, 25, 25, 25, 950),
('PDAMBOGOR', 'PDAM BOGOR (JABAR)', 0, 0, 37, 1, 625, 25, 25, 25, 25, 25, 950),
('PDAMBOJONEGORO', 'PDAM BOJONEGORO (JATIM)', 0, 1, 37, 1, 625, 25, 25, 25, 25, 25, 950),
('PDAMBONDOWOSO', 'PDAM BONDOWOSO (JATIM)', 0, 1, 37, 1, 425, 25, 25, 25, 25, 25, 750),
('PDAMBOYOLALI', 'PDAM BOYOLALI (JATENG)', 0, 1, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('PDAMBREBES', 'PDAM BREBES (JATENG)', 0, 0, 37, 1, 375, 25, 25, 25, 25, 25, 700),
('PDAMBULELENG', 'PDAM BULELENG (BALI)', 0, 1, 37, 1, 275, 25, 25, 25, 25, 25, 600),
('PDAMCILACAP', 'PDAM CILACAP (JATENG)', 0, 1, 37, 1, 275, 25, 25, 25, 25, 25, 600),
('PDAMCIREBON', 'PDAM CIREBON (JABAR)', 0, 0, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('PDAMDENPASAR', 'PDAM DENPASAR (BALI)', 0, 1, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('PDAMDEPOK', 'PDAM DEPOK (JABAR)', 0, 1, 37, 1, 575, 25, 25, 25, 25, 25, 900),
('PDAMGROBOGAN', 'PDAM GROBOGAN (JATENG)', 0, 0, 37, 1, 125, 25, 25, 25, 25, 25, 450),
('PDAMJAMBI', 'PDAM JAMBI', 0, 0, 37, 1, 525, 25, 25, 25, 25, 25, 850),
('PDAMJAMBITMJ', 'PDAM JAMBI (TIRTA MAYANG)', 0, 0, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('PDAMJEMBER', 'PDAM JEMBER (JATIM)', 0, 1, 37, 1, 225, 25, 25, 25, 25, 25, 550),
('PDAMJEPARA', 'PDAM JEPARA (JATENG)', 0, 0, 37, 1, 25, 25, 25, 25, 25, 25, 350),
('PDAMKABBANDUNG', 'PDAM BANDUNG KAB (JABAR)', 0, 1, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('PDAMKABBEKASI', 'PDAM BEKASI KAB (JABAR)', 0, 1, 37, 1, 575, 25, 25, 25, 25, 25, 900),
('PDAMKABBOGOR', 'PDAM BOGOR KAB (JABAR)', 0, 1, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('PDAMKABMALANG', 'PDAM MALANG KAB (JATIM)', 0, 1, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('PDAMKABSEMARANG', 'PDAM SEMARANG KAB (JATENG)', 0, 1, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('PDAMKABTANGERANG', 'PDAM TANGERANG KAB (JABAR)', 0, 1, 37, 1, 375, 25, 25, 25, 25, 25, 700),
('PDAMKARANGANYAR', 'PDAM KARANGANYAR (JATENG)', 0, 1, 37, 1, 375, 25, 25, 25, 25, 25, 700),
('PDAMKARAWANG', 'PDAM KARAWANG (JABAR)', 0, 0, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('PDAMKEBUMEN', 'PDAM KEBUMEN (JATENG)', 0, 1, 37, 1, 375, 25, 25, 25, 25, 25, 700),
('PDAMKENDAL', 'PDAM KENDAL', 0, 0, 37, 1, 275, 25, 25, 25, 25, 25, 600),
('PDAMKLATEN', 'PDAM KLATEN', 0, 0, 37, 1, 375, 25, 25, 25, 25, 25, 700),
('PDAMKUBURAYA', 'PDAM KUBU RAYA', 0, 0, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('PDAMLAMPUNG', 'PDAM LAMPUNG', 0, 1, 37, 1, 525, 25, 25, 25, 25, 25, 850),
('PDAMLOMBOKTENGAH', 'PDAM LOMBOK TENGAH (NTB)', 0, 1, 37, 1, 275, 25, 25, 25, 25, 25, 600),
('PDAMMADIUN', 'PDAM MADIUN (JATIM)', 0, 1, 37, 1, 375, 25, 25, 25, 25, 25, 700),
('PDAMMAKASAR', 'PDAM MAKASAR (SULSEL)', 0, 0, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('PDAMMALANG', 'PDAM MALANG (JATIM)', 0, 0, 37, 1, 625, 25, 25, 25, 25, 25, 950),
('PDAMMANADO', 'PDAM MANADO (SULUT)', 0, 1, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('PDAMMATARAM', 'PDAM MATARAM (NTB)', 0, 1, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('PDAMMEDAN', 'PDAM MEDAN (SUMUT)', 0, 1, 37, 1, 275, 25, 25, 25, 25, 25, 600),
('PDAMMOJOKERTO', 'PDAM MOJOKERTO (JATIM)', 0, 1, 37, 1, 525, 25, 25, 25, 25, 25, 850),
('PDAMPADANG', 'PDAM PADANG (SUMBAR)', 0, 0, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('PDAMPALEMBANG', 'PDAM PALEMBANG (SUMSEL)', 0, 1, 37, 1, 625, 25, 25, 25, 25, 25, 950),
('PDAMPASURUAN', 'PDAM PASURUAN KOTA (JATIM)', 0, 1, 37, 1, 675, 25, 25, 25, 25, 25, 1000),
('PDAMPEKALONGAN', 'PDAM PEKALONGAN (JATENG)', 0, 1, 37, 1, 375, 25, 25, 25, 25, 25, 700),
('PDAMPONTIANAK', 'PDAM PONTIANAK (KALBAR)', 0, 1, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('PDAMPROBOLINGGO', 'PDAM PROBOLINGGO (JATIM)', 0, 1, 37, 1, 375, 25, 25, 25, 25, 25, 700),
('PDAMPURBALINGGA', 'PDAM PURBALINGGA (JATENG)', 0, 1, 37, 1, 375, 25, 25, 25, 25, 25, 700),
('PDAMPURWOREJO', 'PDAM PURWOREJO (JATENG)', 0, 1, 37, 1, 375, 25, 25, 25, 25, 25, 700),
('PDAMREMBANG', 'PDAM REMBANG (JATENG)', 0, 1, 37, 1, 375, 25, 25, 25, 25, 25, 700),
('PDAMSALATIGA', 'PDAM SALATIGA (JATENG)', 0, 1, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('PDAMSEMARANG', 'PDAM SEMARANG (JATENG)', 0, 1, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('PDAMSIDOARJO', 'PDAM SIDOARJO (JATIM)', 0, 1, 37, 1, 275, 25, 25, 25, 25, 25, 600),
('PDAMSLEMAN', 'PDAM SLEMAN (DIY)', 0, 0, 37, 1, 125, 25, 25, 25, 25, 25, 450),
('PDAMSOLO', 'PDAM SOLO / SURAKARTA (JATENG)', 0, 1, 37, 1, 75, 25, 25, 25, 25, 25, 400),
('PDAMSUBANG', 'PDAM SUBANG (JABAR)', 0, 1, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('PDAMSURABAYA', 'PDAM SURABAYA (JATIM)', 0, 1, 37, 1, 575, 25, 25, 25, 25, 25, 900),
('PDAMTANAHGROGOT', 'PDAM TANAH GROGOT (KALTIM)', 0, 1, 37, 1, 575, 25, 25, 25, 25, 25, 900),
('PDAMTANGERANG', 'PDAM TANGERANG (JABAR)', 0, 1, 37, 1, 375, 25, 25, 25, 25, 25, 700),
('PDAMTAPIN', 'PDAM TAPIN (KALSEL)', 0, 1, 37, 1, 625, 25, 25, 25, 25, 25, 950),
('PDAMWONOGIRI', 'PDAM WONOGIRI (JATENG)', 0, 0, 37, 1, 375, 25, 25, 25, 25, 25, 700),
('PDAMWONOSOBO', 'PDAM WONOSOBO (JATENG)', 0, 1, 37, 1, 475, 25, 25, 25, 25, 25, 800),
('PLNNON', 'PLN NONTAGLIS', 0, 1, 33, 1, 3050, 50, 50, 50, 50, 50, 3500),
('PLNPASCA', 'PLN PASCABAYAR', 0, 1, 31, 1, 1550, 50, 50, 50, 50, 50, 2000),
('PLNPRA', 'PLN PRABAYAR', 0, 1, 32, 1, 1550, 50, 50, 50, 50, 50, 2000),
('PN100', 'PLAYNEXIA 100RB', 100000, 1, 20, 1, 92350, 25, 25, 25, 25, 25, 92125),
('PN200', 'PLAYNEXIA 200RB', 200000, 1, 20, 1, 182850, 25, 25, 25, 25, 25, 182625),
('PN25', 'PLAYNEXIA 25RB', 25000, 1, 20, 1, 23350, 25, 25, 25, 25, 25, 23125),
('PN50', 'PLAYNEXIA 50RB', 50000, 1, 20, 1, 46350, 25, 25, 25, 25, 25, 46125),
('PROCAR', 'PRO CAR FINANCE', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('PROMITRA', 'PRO MITRA FINANCE', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('Q10', 'QEON 10RB', 10000, 1, 21, 1, 9650, 25, 25, 25, 25, 25, 9425),
('Q100', 'QEON 100RB', 100000, 1, 21, 1, 92350, 25, 25, 25, 25, 25, 92125),
('Q30', 'QEON 30RB', 30000, 1, 21, 1, 27850, 25, 25, 25, 25, 25, 27625),
('Q50', 'QEON 50RB', 50000, 1, 21, 1, 46350, 25, 25, 25, 25, 25, 46125),
('S10', 'TELKOMSEL NASIONAL 10RB', 10000, 1, 23, 1, 11575, 25, 25, 25, 25, 25, 11350),
('S100', 'TELKOMSEL NASIONAL 100RB', 100000, 1, 23, 1, 97825, 25, 25, 25, 25, 25, 97600),
('S100D', 'SIMPATI DATA 100RB', 100001, 1, 23, 1, 99275, 25, 25, 25, 25, 25, 99050),
('S100T', 'TELKOMSEL TRANSFER 100RB', 100002, 1, 23, 1, 94225, 25, 25, 25, 25, 25, 94000),
('S10D', 'SIMPATI DATA 40MB 7hari', 10001, 1, 23, 1, 11375, 25, 25, 25, 25, 25, 11150),
('S10T', 'TELKOMSEL TRANSFER 10RB', 10002, 1, 23, 1, 11175, 25, 25, 25, 25, 25, 10950),
('S20', 'TELKOMSEL NASIONAL 20RB', 20000, 1, 23, 1, 20925, 25, 25, 25, 25, 25, 20700),
('S20D', 'SIMPATI DATA 200MB 7hari', 20001, 1, 23, 1, 21275, 25, 25, 25, 25, 25, 21050),
('S20T', 'TELKOMSEL TRANSFER 20RB', 20002, 1, 23, 1, 20325, 25, 25, 25, 25, 25, 20100),
('S25', 'TELKOMSEL NASIONAL 25RB', 25000, 1, 23, 1, 25825, 25, 25, 25, 25, 25, 25600),
('S25D', 'SIMPATI DATA 360MB 30hari', 25001, 1, 23, 1, 26175, 25, 25, 25, 25, 25, 25950),
('S25T', 'TELKOMSEL TRANSFER 25RB', 25002, 1, 23, 1, 24975, 25, 25, 25, 25, 25, 24750),
('S5', 'TELKOMSEL NASIONAL 5RB', 5000, 1, 23, 1, 6675, 25, 25, 25, 25, 25, 6450),
('S50', 'TELKOMSEL NASIONAL 50RB', 50000, 1, 23, 1, 49925, 25, 25, 25, 25, 25, 49700),
('S50D', 'SIMPATI DATA 1.2GB 30hr', 50001, 1, 23, 1, 50275, 25, 25, 25, 25, 25, 50050),
('S50T', 'TELKOMSEL TRANSFER 50RB', 50002, 1, 23, 1, 48200, 25, 25, 25, 25, 25, 47975),
('S5D', 'SIMPATI DATA 5RB 20MB 7hari', 5001, 1, 23, 1, 6325, 25, 25, 25, 25, 25, 6100),
('S5T', 'TELKOMSEL TRANSFER 5RB', 5002, 1, 23, 1, 6350, 25, 25, 25, 25, 25, 6125),
('SAF', 'SASANA ARTHA FINANCE', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('SM10', 'SMART 10RB', 10000, 1, 22, 1, 10600, 25, 25, 25, 25, 25, 10375),
('SM100', 'SMART 100RB', 100000, 1, 22, 1, 97975, 25, 25, 25, 25, 25, 97750),
('SM150', 'SMART 150RB', 150000, 1, 22, 1, 149325, 25, 25, 25, 25, 25, 149100),
('SM20', 'SMART 20RB', 20000, 1, 22, 1, 20625, 25, 25, 25, 25, 25, 20400),
('SM25', 'SMART 25RB', 25000, 1, 22, 1, 25250, 25, 25, 25, 25, 25, 25025),
('SM5', 'SMART 5RB', 5000, 1, 22, 1, 5700, 25, 25, 25, 25, 25, 5475),
('SM50', 'SMART 50RB', 50000, 1, 22, 1, 49525, 25, 25, 25, 25, 25, 49300),
('SMARTFREN', 'SMARTFREN PASCA', 0, 0, 36, 1, 675, 25, 25, 25, 25, 25, 1000),
('SMF', 'SMART MULTI FINANCE', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('SPEEDY', 'SPEEDY', 0, 1, 34, 2, 875, 25, 25, 25, 25, 25, 1200),
('SUZUKI', 'SUZUKI FINANCE INDONESIA', 0, 0, 38, 1, 725, 25, 25, 25, 25, 25, 1050),
('T1', 'THREE 1RB', 1000, 1, 25, 1, 1775, 25, 25, 25, 25, 25, 1550),
('T10', 'THREE 10RB', 10000, 1, 25, 1, 10650, 25, 25, 25, 25, 25, 10425),
('T100', 'THREE 100RB', 100000, 1, 25, 1, 99275, 25, 25, 25, 25, 25, 99050),
('T10D', 'THREE DATA 400MB', 10001, 1, 25, 1, 10975, 25, 25, 25, 25, 25, 10750),
('T15', 'THREE 15RB', 15000, 0, 25, 1, 15725, 25, 25, 25, 25, 25, 15500),
('T2', 'THREE 2RB', 2000, 0, 25, 1, 2725, 25, 25, 25, 25, 25, 2500),
('T20', 'THREE 20RB', 20000, 1, 25, 1, 20525, 25, 25, 25, 25, 25, 20300),
('T25', 'THREE 25RB', 25000, 1, 25, 1, 25525, 25, 25, 25, 25, 25, 25300),
('T25D', 'THREE DATA 1250MB', 25001, 1, 25, 1, 25275, 25, 25, 25, 25, 25, 25050),
('T2D', 'THREE DATA 25MB', 2001, 1, 25, 1, 3475, 25, 25, 25, 25, 25, 3250),
('T3', 'THREE 3RB', 3000, 0, 25, 1, 3725, 25, 25, 25, 25, 25, 3500),
('T30', 'THREE 30RB', 30000, 1, 25, 1, 30425, 25, 25, 25, 25, 25, 30200),
('T30D', 'THREE DATA 500MB', 30001, 1, 25, 1, 34275, 25, 25, 25, 25, 25, 34050),
('T35D', 'THREE DATA 2 GIGA', 35001, 1, 25, 1, 34425, 25, 25, 25, 25, 25, 34200),
('T4', 'THREE 4RB', 4000, 0, 25, 1, 4725, 25, 25, 25, 25, 25, 4500),
('T5', 'THREE 5RB', 5000, 1, 25, 1, 5775, 25, 25, 25, 25, 25, 5550),
('T50', 'THREE 50RB', 50000, 1, 25, 1, 50325, 25, 25, 25, 25, 25, 50100),
('T5D', 'THREE DATA 100MB', 5001, 1, 25, 1, 5975, 25, 25, 25, 25, 25, 5750),
('T60D', 'THREE DATA 4 GIGA', 60001, 1, 25, 1, 59325, 25, 25, 25, 25, 25, 59100),
('T75D', 'THREE DATA 5 GIGA', 75001, 1, 25, 1, 73075, 25, 25, 25, 25, 25, 72850),
('TELEPON', 'TELEPON', 0, 1, 34, 1, 875, 25, 25, 25, 25, 25, 1200),
('TELVIS', 'TELKOM VISION', 0, 1, 35, 1, 875, 25, 25, 25, 25, 25, 1200),
('TELVISCOMBO', 'TELVIS COMBO PRA', 0, 1, 35, 1, 875, 25, 25, 25, 25, 25, 1200),
('TELVISCOSMO', 'TELVIS COSMO PRA', 0, 1, 35, 1, 875, 25, 25, 25, 25, 25, 1200),
('TELVISFILM', 'TELVIS FILM PRA', 0, 1, 35, 1, 875, 25, 25, 25, 25, 25, 1200),
('TELVISHEMAT', 'TELVIS HEMAT PRA', 0, 1, 35, 1, 875, 25, 25, 25, 25, 25, 1200),
('TELVISOLAHRAGA', 'TELVIS OLAHRAGA PRA', 0, 1, 35, 1, 875, 25, 25, 25, 25, 25, 1200),
('TELVISPELANGI', 'TELVIS PELANGI PRA', 0, 1, 35, 1, 875, 25, 25, 25, 25, 25, 1200),
('TELVISPENDIDIKAN', 'TELVIS PENDIDIKAN PRA', 0, 1, 35, 1, 875, 25, 25, 25, 25, 25, 1200),
('THREE', '3 PASCA', 0, 0, 36, 1, 675, 25, 25, 25, 25, 25, 1000),
('TOYOTA', 'TOYOTA FINANCE', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('TRIHAMAS', 'TRIHAMAS FINANCE', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('TV137', 'TRAVIAN V137', 137000, 1, 24, 1, 153850, 25, 25, 25, 25, 25, 153625),
('TV256', 'TRAVIAN V256', 256000, 1, 24, 1, 304350, 25, 25, 25, 25, 25, 304125),
('TV27', 'TRAVIAN V27', 27000, 1, 24, 1, 30550, 25, 25, 25, 25, 25, 30325),
('TV63', 'TRAVIAN V63', 63000, 1, 24, 1, 71550, 25, 25, 25, 25, 25, 71325),
('UN10', 'UNOGAME 10RB', 10000, 0, 26, 1, 10350, 25, 25, 25, 25, 25, 10125),
('UN100', 'UNOGAME 100RB', 100000, 0, 26, 1, 100350, 25, 25, 25, 25, 25, 100125),
('UN30', 'UNOGAME 30RB', 30000, 0, 26, 1, 30350, 25, 25, 25, 25, 25, 30125),
('UN50', 'UNOGAME 50RB', 50000, 0, 26, 1, 50350, 25, 25, 25, 25, 25, 50125),
('VIF', 'VARIA INTRA FINANCE', 0, 0, 38, 1, 475, 25, 25, 25, 25, 25, 800),
('VW15', 'VIWAWA 15RB', 15000, 1, 27, 1, 14150, 25, 25, 25, 25, 25, 13925),
('VW30', 'VIWAWA 30RB', 30000, 1, 27, 1, 27850, 25, 25, 25, 25, 25, 27625),
('VW60', 'VIWAWA 60RB', 60000, 1, 27, 1, 55350, 25, 25, 25, 25, 25, 55125),
('W10', 'WAVEGAME 10RB', 10000, 1, 28, 1, 10650, 25, 25, 25, 25, 25, 10425),
('W100', 'WAVEGAME 100RB', 100000, 1, 28, 1, 102350, 25, 25, 25, 25, 25, 102125),
('W20', 'WAVEGAME 20RB', 20000, 1, 28, 1, 20850, 25, 25, 25, 25, 25, 20625),
('W250', 'WAVEGAME 250RB', 250000, 1, 28, 1, 252850, 25, 25, 25, 25, 25, 252625),
('W50', 'WAVEGAME 50RB', 50000, 1, 28, 1, 51350, 25, 25, 25, 25, 25, 51125),
('WOM', 'WOM FINANCE', 0, 1, 38, 1, 875, 25, 25, 25, 25, 25, 1200),
('X1', 'XL REGULER 1RB', 1000, 0, 29, 1, 1725, 25, 25, 25, 25, 25, 1500),
('X10', 'XL REGULER 10RB', 10000, 1, 29, 1, 11450, 25, 25, 25, 25, 25, 11225),
('X100', 'XL REGULER 100RB', 100000, 1, 29, 1, 100525, 25, 25, 25, 25, 25, 100300),
('X100T', 'XL TRANSFER 100RB', 100001, 1, 29, 1, 97575, 25, 25, 25, 25, 25, 97350),
('X10T', 'XL TRANSFER 10RB', 10001, 1, 29, 1, 11150, 25, 25, 25, 25, 25, 10925),
('X150D', 'XL HOTROD 3G 6GB 30HR', 150002, 1, 29, 1, 142275, 25, 25, 25, 25, 25, 142050),
('X15D', 'XL BB FULL BIS LITE+PULSA 10RB 7HR', 15002, 1, 29, 1, 16775, 25, 25, 25, 25, 25, 16550),
('X15T', 'XL TRANSFER 15RB', 15001, 1, 29, 1, 16225, 25, 25, 25, 25, 25, 16000),
('X200', 'XL REGULER 200RB', 200000, 1, 29, 1, 197625, 25, 25, 25, 25, 25, 197400),
('X20D', 'XL DATA 2GB', 20002, 1, 29, 1, 22425, 25, 25, 25, 25, 25, 22200),
('X20T', 'XL TRANSFER 20RB', 20001, 0, 29, 1, 20975, 25, 25, 25, 25, 25, 20750),
('X25', 'XL REGULER 25RB', 25000, 1, 29, 1, 26200, 25, 25, 25, 25, 25, 25975),
('X25T', 'XL TRANSFER 25RB', 25001, 1, 29, 1, 25775, 25, 25, 25, 25, 25, 25550),
('X275D', 'XL HOTROD PREMIUM 14GB 30HR', 275002, 1, 29, 1, 272275, 25, 25, 25, 25, 25, 272050),
('X30D', 'XL HOTROD 3G 3GB 30HR', 30002, 1, 29, 1, 49225, 25, 25, 25, 25, 25, 49000),
('X30T', 'XL TRANSFER 30RB', 30001, 1, 29, 1, 30625, 25, 25, 25, 25, 25, 30400),
('X35D', 'XL BB GAUL+BONUS TOTAL 35RB', 35001, 1, 29, 1, 51725, 25, 25, 25, 25, 25, 51500),
('X40D', 'XL BB FULL BIS +PULSA 40RB', 40002, 1, 29, 1, 83275, 25, 25, 25, 25, 25, 83050),
('X40T', 'XL TRANSFER 40RB', 40001, 1, 29, 1, 40325, 25, 25, 25, 25, 25, 40100),
('X5', 'XL REGULER 5RB', 5000, 1, 29, 1, 6625, 25, 25, 25, 25, 25, 6400),
('X50', 'XL REGULER 50RB', 50000, 1, 29, 1, 50875, 25, 25, 25, 25, 25, 50650),
('X50D', 'XL SUPER NGEBUT 5GB 30HR', 50002, 1, 29, 1, 41875, 25, 25, 25, 25, 25, 41650),
('X50T', 'XL TRANSFER 50RB', 50001, 1, 29, 1, 49675, 25, 25, 25, 25, 25, 49450),
('X60D', 'XL HOTROD 3G 2.1GB 30HR', 60002, 1, 29, 1, 56525, 25, 25, 25, 25, 25, 56300),
('X75D', 'XL HOTROD 3G 6.3GB 90HR', 75002, 1, 29, 1, 78925, 25, 25, 25, 25, 25, 78700),
('X75T', 'XL TRANSFER 75RB', 75001, 1, 29, 1, 73875, 25, 25, 25, 25, 25, 73650),
('X85D', 'XL SUPER NGEBUT 11GB+BONUS', 85002, 1, 29, 1, 83325, 25, 25, 25, 25, 25, 83100),
('X90D', 'XL BB FULL SERVICE 30HR', 90002, 1, 29, 1, 92275, 25, 25, 25, 25, 25, 92050),
('X99D', 'XL HOTROD 3G 5.1GB 30HR', 99002, 1, 29, 1, 111925, 25, 25, 25, 25, 25, 111700),
('XPLOR', 'XL PASCA (XPLOR)', 0, 0, 36, 1, 1675, 25, 25, 25, 25, 25, 2000),
('ZY100', 'ZYNGA 100RB', 100000, 1, 30, 1, 114850, 25, 25, 25, 25, 25, 114625),
('ZY20', 'ZYNGA 21RB', 20000, 1, 30, 1, 23350, 25, 25, 25, 25, 25, 23125),
('ZY50', 'ZYNGA 50RB', 50000, 1, 30, 1, 57600, 25, 25, 25, 25, 25, 57375),
('ZY52', 'ZYNGA 52RB', 52000, 0, 30, 1, 52350, 25, 25, 25, 25, 25, 52125);

-- --------------------------------------------------------

--
-- Table structure for table `m_ppob_produk_group`
--

CREATE TABLE `m_ppob_produk_group` (
  `id` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `jenis` varchar(10) NOT NULL COMMENT 'PULSA, GAME, PPOB'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_ppob_produk_group`
--

INSERT INTO `m_ppob_produk_group` (`id`, `nama`, `jenis`) VALUES
(1, 'ASIASOFT', 'GAME'),
(2, 'AXIS', 'PULSA'),
(3, 'CAPPLE', 'GAME'),
(4, 'CHERRYCREDITS', 'GAME'),
(5, 'DIGICASH', 'GAME'),
(6, 'DIGISOFT', 'GAME'),
(7, 'FACEBOOK GAME', 'GAME'),
(8, 'GAMEWAVE', 'GAME'),
(9, 'GAMEWEB', 'GAME'),
(10, 'GARENA', 'GAME'),
(11, 'GEMSCOOL', 'GAME'),
(12, 'IAH', 'GAME'),
(13, 'INDOSAT', 'PULSA'),
(14, 'LYTO', 'GAME'),
(15, 'MEGAXUS', 'GAME'),
(16, 'MOGPLAY', 'GAME'),
(17, 'NHN G-COINS', 'GAME'),
(18, 'ONELIFE', 'GAME'),
(19, 'ORANGE', 'GAME'),
(20, 'PLAYNEXIA', 'GAME'),
(21, 'QEON', 'GAME'),
(22, 'SMARTFREN', 'PULSA'),
(23, 'TELKOMSEL', 'PULSA'),
(24, 'TRAVIAN', 'GAME'),
(25, 'TRI', 'PULSA'),
(26, 'UNOGAME', 'GAME'),
(27, 'VIWAWA', 'GAME'),
(28, 'WAVEGAME', 'GAME'),
(29, 'XL', 'PULSA'),
(30, 'ZYNGA', 'GAME'),
(31, 'PLN PASCABAYAR', 'PPOB'),
(32, 'PLN PRABAYAR', 'PPOB'),
(33, 'PLN NONTAGLIS', 'PPOB'),
(34, 'TELKOM', 'PPOB'),
(35, 'TV BERLANGGANAN', 'PPOB'),
(36, 'TELEPON PASCABAYAR', 'PPOB'),
(37, 'PDAM', 'PPOB'),
(38, 'PINJAMAN', 'PPOB'),
(39, 'ASURANSI', 'PPOB'),
(40, 'PENDIDIKAN', 'PPOB'),
(41, 'PBB', 'PPOB'),
(42, 'TV PRABAYAR', 'PPOB'),
(43, 'ASURANSI PRABAYAR', 'PPOB'),
(44, 'KARTU KREDIT', 'PPOB');

-- --------------------------------------------------------

--
-- Table structure for table `m_produk`
--

CREATE TABLE `m_produk` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `panjang` int(5) DEFAULT NULL,
  `lebar` int(5) DEFAULT NULL,
  `lt` int(5) DEFAULT NULL,
  `lb` int(5) DEFAULT NULL,
  `jenis_produk` varchar(3) NOT NULL,
  `project` int(11) NOT NULL,
  `sertifikasi` varchar(10) DEFAULT NULL,
  `lokasi_alamat` varchar(200) DEFAULT NULL,
  `lokasi_kota` varchar(30) NOT NULL,
  `lat` varchar(20) DEFAULT NULL,
  `lng` varchar(20) DEFAULT NULL,
  `deskripsi` text,
  `harga` int(10) NOT NULL DEFAULT '0',
  `fee` decimal(5,2) NOT NULL DEFAULT '0.00',
  `diskon` decimal(5,2) NOT NULL DEFAULT '0.00',
  `stok` int(5) NOT NULL DEFAULT '0',
  `gambar` varchar(30) DEFAULT NULL,
  `user_input` varchar(20) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `user_update` varchar(20) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_produk`
--

INSERT INTO `m_produk` (`id`, `nama`, `panjang`, `lebar`, `lt`, `lb`, `jenis_produk`, `project`, `sertifikasi`, `lokasi_alamat`, `lokasi_kota`, `lat`, `lng`, `deskripsi`, `harga`, `fee`, `diskon`, `stok`, `gambar`, `user_input`, `tgl_input`, `user_update`, `tgl_update`) VALUES
(1, 'GREEN LAND BOHAR', 6, 11, NULL, NULL, '1', 1, 'SHM', 'Jalan Joko Laut, Bohar, Taman', 'SIDOARJO', '-7.382685', '112.707025', '<p>Tanah sudah urug Siap bangun, lokasi strategis</p>\r\n<ul class="list-disc">\r\n<li>6 menit dari Tol Waru dan Terminal Bungurasih.</li>\r\n<li>10 menit dari Shopping Area (Mall Cito, Giant Waru)</li>\r\n</ul>', 130000000, '7.00', '0.00', 0, 'bohar1.jpg', 'admin', '2017-04-16 07:49:07', NULL, NULL),
(2, 'GREEN LAND BOHAR', 7, 11, NULL, NULL, '1', 1, 'SHM', 'Jalan Joko Laut, Bohar, Taman', 'SIDOARJO', '-7.382685', '112.707025 ', '<p>Tanah sudah urug Siap bangun, lokasi strategis</p>\r\n<ul class="list-disc">\r\n<li>6 menit dari Tol Waru dan Terminal Bungurasih.</li>\r\n<li>10 menit dari Shopping Area (Mall Cito, Giant Waru)</li>\r\n</ul>', 180000000, '7.00', '0.00', 0, 'bohar2', 'admin', '2017-04-16 07:49:07', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_produk_foto`
--

CREATE TABLE `m_produk_foto` (
  `id` int(11) NOT NULL,
  `id_produk` varchar(10) NOT NULL,
  `foto` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `m_program`
--

CREATE TABLE `m_program` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tgl` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  `user_input` varchar(20) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `user_update` varchar(20) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_program`
--

INSERT INTO `m_program` (`id`, `nama`, `tgl`, `status`, `user_input`, `tgl_input`, `user_update`, `tgl_update`) VALUES
(1, 'INVESTASI BERJAMAAH 2017', '2016-12-01', 1, 'admin', '2016-12-18 09:37:49', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_project`
--

CREATE TABLE `m_project` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tgl_pengerjaan` date NOT NULL,
  `pic` varchar(40) NOT NULL,
  `id_program` int(11) NOT NULL,
  `id_parent` int(11) DEFAULT NULL,
  `user_input` varchar(20) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `user_update` varchar(20) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `m_provinsi`
--

CREATE TABLE `m_provinsi` (
  `id` int(11) NOT NULL,
  `nama` varchar(35) NOT NULL,
  `user_input` varchar(20) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `user_update` varchar(20) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_provinsi`
--

INSERT INTO `m_provinsi` (`id`, `nama`, `user_input`, `tgl_input`, `user_update`, `tgl_update`) VALUES
(1, 'D.I. ACEH', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(2, 'SUMATERA UTARA', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(3, 'SUMATERA BARAT', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(4, 'RIAU', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(5, 'JAMBI', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(6, 'SUMATERA SELATAN', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(7, 'BENGKULU', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(8, 'LAMPUNG', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(9, 'KEPULAUAN BANGKA BELITUNG', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(10, 'KEPULAUAN RIAU', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(11, 'DKI JAKARTA', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(12, 'JAWA BARAT', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(13, 'JAWA TENGAH', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(14, 'BANTEN', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(15, 'JAWA TIMUR', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(16, 'D.I. YOGYAKARTA', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(17, 'BALI', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(18, 'NUSA TENGGARA BARAT', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(19, 'NUSA TENGGARA TIMUR', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(20, 'KALIMANTAN BARAT', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(21, 'KALIMANTAN TENGAH', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(22, 'KALIMANTAN SELATAN', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(23, 'KALIMANTAN TIMUR', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(24, 'KALIMANTAN UTARA', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(25, 'SULAWESI UTARA', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(26, 'SULAWESI TENGAH', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(27, 'SULAWESI SELATAN', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(28, 'SULAWESI TENGGARA', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(29, 'GORONTALO', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(30, 'SULAWESI BARAT', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(31, 'MALUKU', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(32, 'MALUKU UTARA', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(33, 'PAPUA', 'admin', '2015-05-06 13:39:42', NULL, NULL),
(34, 'PAPUA BARAT', 'admin', '2015-05-06 13:39:42', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_rekening`
--

CREATE TABLE `m_rekening` (
  `norek` varchar(20) NOT NULL,
  `no_atm` varchar(20) DEFAULT NULL,
  `id_member` varchar(10) NOT NULL,
  `jenis_rekening` varchar(7) NOT NULL,
  `saldo` bigint(16) NOT NULL DEFAULT '0',
  `user_input` varchar(20) NOT NULL,
  `tgl_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_rekening`
--

INSERT INTO `m_rekening` (`norek`, `no_atm`, `id_member`, `jenis_rekening`, `saldo`, `user_input`, `tgl_input`) VALUES
('0110001', NULL, '10001', 'WALLET', 4040000, '', '0000-00-00 00:00:00'),
('0110002', NULL, '10002', 'WALLET', 11976325, '', '0000-00-00 00:00:00'),
('0110003', NULL, '10003', 'WALLET', 3000000, '', '0000-00-00 00:00:00'),
('0110004', NULL, '10004', 'WALLET', 1000000, '', '0000-00-00 00:00:00'),
('0110005', NULL, '10005', 'WALLET', 1000000, '', '0000-00-00 00:00:00'),
('0110006', NULL, '10006', 'WALLET', 0, '', '0000-00-00 00:00:00'),
('0110007', NULL, '10007', 'WALLET', 2800000, '', '0000-00-00 00:00:00'),
('0110008', NULL, '10008', 'WALLET', 1200000, '', '0000-00-00 00:00:00'),
('0110009', NULL, '10009', 'WALLET', 500000, '', '0000-00-00 00:00:00'),
('0110010', NULL, '10010', 'WALLET', 3000000, '', '0000-00-00 00:00:00'),
('0110011', NULL, '10011', 'WALLET', 2500000, 'admin', '2017-01-27 00:16:16'),
('0110012', NULL, '10012', 'WALLET', 500000, 'admin', '2017-04-14 22:25:16'),
('0110013', NULL, '10013', 'WALLET', 500000, 'admin', '2017-04-15 05:50:39'),
('0110014', NULL, '10014', 'WALLET', 500000, 'admin', '2017-04-15 05:55:57'),
('0110015', NULL, '10015', 'WALLET', 0, 'admin', '2017-05-14 15:39:15'),
('0110027', NULL, '10027', 'WALLET', 0, 'admin', '2017-05-07 14:47:26'),
('0210001', NULL, '10001', 'SIPRO', 350000, '', '0000-00-00 00:00:00'),
('0210002', NULL, '10002', 'SIPRO', 1150000, '', '0000-00-00 00:00:00'),
('0210003', NULL, '10003', 'SIPRO', 300000, '', '0000-00-00 00:00:00'),
('0210004', NULL, '10004', 'SIPRO', 0, '', '0000-00-00 00:00:00'),
('0210005', NULL, '10005', 'SIPRO', 0, '', '0000-00-00 00:00:00'),
('0210006', NULL, '10006', 'SIPRO', 0, '', '0000-00-00 00:00:00'),
('0210007', NULL, '10007', 'SIPRO', 300000, '', '0000-00-00 00:00:00'),
('0210008', NULL, '10008', 'SIPRO', 200000, '', '0000-00-00 00:00:00'),
('0210009', NULL, '10009', 'SIPRO', 0, '', '0000-00-00 00:00:00'),
('0210010', NULL, '10010', 'SIPRO', 0, '', '0000-00-00 00:00:00'),
('0210011', NULL, '10011', 'SIPRO', 0, 'admin', '2017-01-27 00:16:16'),
('0210012', NULL, '10012', 'SIPRO', 0, 'admin', '2017-04-14 22:25:16'),
('0210013', NULL, '10013', 'SIPRO', 0, 'admin', '2017-04-15 05:50:39'),
('0210014', NULL, '10014', 'SIPRO', 0, 'admin', '2017-04-15 05:55:57'),
('0210015', NULL, '10015', 'SIPRO', 0, 'admin', '2017-05-14 15:39:15'),
('0210027', NULL, '10027', 'SIPRO', 0, 'admin', '2017-05-07 14:47:26'),
('0310001', NULL, '10001', 'BISPRO', 0, '', '0000-00-00 00:00:00'),
('0310002', NULL, '10002', 'BISPRO', 0, '', '0000-00-00 00:00:00'),
('0310003', NULL, '10003', 'BISPRO', 0, '', '0000-00-00 00:00:00'),
('0310004', NULL, '10004', 'BISPRO', 0, '', '0000-00-00 00:00:00'),
('0310005', NULL, '10005', 'BISPRO', 0, '', '0000-00-00 00:00:00'),
('0310006', NULL, '10006', 'BISPRO', 0, '', '0000-00-00 00:00:00'),
('0310007', NULL, '10007', 'BISPRO', 0, '', '0000-00-00 00:00:00'),
('0310008', NULL, '10008', 'BISPRO', 0, '', '0000-00-00 00:00:00'),
('0310009', NULL, '10009', 'BISPRO', 0, '', '0000-00-00 00:00:00'),
('0310010', NULL, '10010', 'BISPRO', 0, '', '0000-00-00 00:00:00'),
('0310011', NULL, '10011', 'BISPRO', 0, 'admin', '2017-01-27 00:16:16'),
('0310012', NULL, '10012', 'BISPRO', 0, 'admin', '2017-04-14 22:25:16'),
('0310013', NULL, '10013', 'BISPRO', 0, 'admin', '2017-04-15 05:50:39'),
('0310014', NULL, '10014', 'BISPRO', 0, 'admin', '2017-04-15 05:55:57'),
('0310015', NULL, '10015', 'BISPRO', 0, 'admin', '2017-05-14 15:39:15'),
('0310027', NULL, '10027', 'BISPRO', 0, 'admin', '2017-05-07 14:47:26');

-- --------------------------------------------------------

--
-- Table structure for table `m_saldo_supplier`
--

CREATE TABLE `m_saldo_supplier` (
  `id` varchar(10) NOT NULL,
  `tgl_update` datetime NOT NULL,
  `saldo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_saldo_supplier`
--

INSERT INTO `m_saldo_supplier` (`id`, `tgl_update`, `saldo`) VALUES
('PPOB', '2017-02-03 16:31:10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `m_testimonial`
--

CREATE TABLE `m_testimonial` (
  `id` int(11) NOT NULL,
  `tgl` datetime NOT NULL,
  `id_member` varchar(10) NOT NULL,
  `testimonial` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `user_update` varchar(20) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_testimonial`
--

INSERT INTO `m_testimonial` (`id`, `tgl`, `id_member`, `testimonial`, `status`, `user_update`, `tgl_update`) VALUES
(1, '2017-01-02 07:25:10', '10003', 'Bagus banget program bisnisnya, sangat cocok untuk semua kalangan.', 1, 'admin', '2017-04-16 21:05:43'),
(3, '2017-01-02 07:25:10', '10002', 'Ediaaann.. Hanya orang yang enggak waras yang tertarik', 1, 'admin', '2017-04-16 21:05:41'),
(4, '2017-03-11 09:05:31', '10001', 'aku ingin begini, aku ingin begitu, ingin ini ingin itu banyak sekali....', 1, 'admin', '2017-04-16 21:12:01');

-- --------------------------------------------------------

--
-- Table structure for table `m_user`
--

CREATE TABLE `m_user` (
  `id_user` varchar(20) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `id_user_group` int(10) NOT NULL,
  `id_cabang` varchar(10) DEFAULT NULL,
  `user_input` varchar(10) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `user_update` varchar(10) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_user`
--

INSERT INTO `m_user` (`id_user`, `nama`, `password`, `status`, `id_user_group`, `id_cabang`, `user_input`, `tgl_input`, `user_update`, `tgl_update`) VALUES
('admin', 'Admin', '21232f297a57a5a743894a0e4a801fc3', 1, 1, '', 'angga', '2016-12-07 08:21:14', 'admin', '2016-12-18 03:02:35'),
('angga', 'Ari Hanggara', 'e172dd95f4feb21412a692e73929961e', 1, 1, '', 'admin', '2016-12-07 01:02:56', 'angga', '2016-12-07 16:40:16'),
('user', 'User', 'd41d8cd98f00b204e9800998ecf8427e', 1, 5, 'MLG', 'admin', '2016-12-18 10:12:01', 'admin', '2016-12-18 10:12:41');

-- --------------------------------------------------------

--
-- Table structure for table `m_user_akses`
--

CREATE TABLE `m_user_akses` (
  `id_group_user` int(10) NOT NULL,
  `id_menu` tinyint(5) NOT NULL,
  `print` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `add` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `delete` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `edit` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `export` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `user_input` varchar(20) DEFAULT NULL,
  `tgl_input` datetime DEFAULT NULL,
  `user_update` varchar(20) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `m_user_akses`
--

INSERT INTO `m_user_akses` (`id_group_user`, `id_menu`, `print`, `add`, `delete`, `edit`, `export`, `user_input`, `tgl_input`, `user_update`, `tgl_update`) VALUES
(1, 1, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 2, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 3, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 4, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 5, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 6, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 7, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 8, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 9, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 10, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 11, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 12, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 13, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 15, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 16, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 17, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 18, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 19, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 20, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 21, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 22, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 23, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 24, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 25, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 26, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 27, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 28, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 29, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 30, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 31, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 32, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 33, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 34, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 35, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 36, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 37, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 38, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 39, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 40, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 41, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 42, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 43, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 44, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 45, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 46, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 47, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 48, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 49, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 50, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 51, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 52, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 53, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 54, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 55, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 56, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 57, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 58, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 59, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 60, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 61, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 62, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 63, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 64, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 65, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 66, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(1, 67, 0, 1, 1, 1, 0, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(2, 1, 0, 0, 0, 0, 0, 'admin', '2016-12-18 03:11:50', 'admin', '2016-12-18 03:11:50'),
(3, 1, 0, 0, 0, 0, 0, 'admin', '2016-12-18 03:12:23', 'admin', '2016-12-18 03:12:23'),
(4, 1, 0, 0, 0, 0, 0, 'admin', '2016-12-18 03:12:02', 'admin', '2016-12-18 03:12:02'),
(5, 1, 0, 0, 0, 0, 0, 'admin', '2016-12-18 03:13:08', 'admin', '2016-12-18 03:13:08');

-- --------------------------------------------------------

--
-- Table structure for table `m_user_akses_dashboard`
--

CREATE TABLE `m_user_akses_dashboard` (
  `id_group_user` int(10) NOT NULL,
  `out_cn` tinyint(1) NOT NULL DEFAULT '0',
  `out_outgoing` tinyint(1) NOT NULL DEFAULT '0',
  `out_incoming` tinyint(1) NOT NULL DEFAULT '0',
  `out_delivery` tinyint(1) NOT NULL DEFAULT '0',
  `out_pod` tinyint(1) NOT NULL DEFAULT '0',
  `out_dex` tinyint(1) NOT NULL DEFAULT '0',
  `out_invoice` tinyint(1) NOT NULL DEFAULT '0',
  `out_payment` tinyint(1) NOT NULL DEFAULT '0',
  `summary_pickup` tinyint(1) NOT NULL DEFAULT '0',
  `summary_cn` tinyint(1) NOT NULL DEFAULT '0',
  `summary_outgoing` tinyint(1) NOT NULL DEFAULT '0',
  `summary_incoming` tinyint(1) NOT NULL DEFAULT '0',
  `summary_delivery` tinyint(1) NOT NULL DEFAULT '0',
  `summary_pod` tinyint(1) NOT NULL DEFAULT '0',
  `summary_dex` tinyint(1) NOT NULL DEFAULT '0',
  `summary_payment` tinyint(1) NOT NULL DEFAULT '0',
  `panel_transaksi` tinyint(1) NOT NULL DEFAULT '0',
  `panel_revenue` tinyint(1) NOT NULL DEFAULT '0',
  `panel_tracing` tinyint(1) NOT NULL DEFAULT '0',
  `user_input` varchar(20) DEFAULT NULL,
  `tgl_input` datetime DEFAULT NULL,
  `user_update` varchar(20) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `m_user_akses_dashboard`
--

INSERT INTO `m_user_akses_dashboard` (`id_group_user`, `out_cn`, `out_outgoing`, `out_incoming`, `out_delivery`, `out_pod`, `out_dex`, `out_invoice`, `out_payment`, `summary_pickup`, `summary_cn`, `summary_outgoing`, `summary_incoming`, `summary_delivery`, `summary_pod`, `summary_dex`, `summary_payment`, `panel_transaksi`, `panel_revenue`, `panel_tracing`, `user_input`, `tgl_input`, `user_update`, `tgl_update`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 'admin', '2017-04-14 15:37:37', 'admin', '2017-04-14 15:37:37'),
(2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'admin', '2016-12-18 03:11:50', 'admin', '2016-12-18 03:11:50'),
(3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'admin', '2016-12-18 03:12:23', 'admin', '2016-12-18 03:12:23'),
(4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'admin', '2016-12-18 03:12:02', 'admin', '2016-12-18 03:12:02'),
(5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'admin', '2016-12-18 03:13:08', 'admin', '2016-12-18 03:13:08');

-- --------------------------------------------------------

--
-- Table structure for table `m_user_group`
--

CREATE TABLE `m_user_group` (
  `id` int(10) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `user_input` varchar(10) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `user_update` varchar(10) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_user_group`
--

INSERT INTO `m_user_group` (`id`, `nama`, `user_input`, `tgl_input`, `user_update`, `tgl_update`) VALUES
(1, 'ADMINISTRATOR', '', '0000-00-00 00:00:00', 'admin', '2017-04-14 15:37:37'),
(2, 'CABANG', '', '0000-00-00 00:00:00', 'admin', '2016-12-18 03:11:50'),
(3, 'FINANCE', '', '0000-00-00 00:00:00', 'admin', '2016-12-18 03:12:23'),
(4, 'KOLEKTOR', 'angga', '2016-12-07 07:09:11', 'admin', '2016-12-18 03:12:02'),
(5, 'MEMBER', 'angga', '2016-12-07 07:09:18', 'admin', '2016-12-18 03:13:08');

-- --------------------------------------------------------

--
-- Table structure for table `r_jenis_konfirmasi`
--

CREATE TABLE `r_jenis_konfirmasi` (
  `id` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `r_jenis_konfirmasi`
--

INSERT INTO `r_jenis_konfirmasi` (`id`, `nama`) VALUES
(1, 'AKTIVASI'),
(2, 'TOPUP WALLET'),
(3, 'TOPUP SIPRO'),
(4, 'TOPUP BISPRO');

-- --------------------------------------------------------

--
-- Table structure for table `r_jenis_member`
--

CREATE TABLE `r_jenis_member` (
  `id` varchar(7) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `ket` varchar(150) DEFAULT NULL,
  `user_input` varchar(20) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `user_update` varchar(20) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `r_jenis_member`
--

INSERT INTO `r_jenis_member` (`id`, `nama`, `ket`, `user_input`, `tgl_input`, `user_update`, `tgl_update`) VALUES
('BISPRO', 'BISPRO', 'Program Bisnis Properti. Skema bisnis tanpa jaringan, tanpa fee simpanan pokok, fee mitra = bagi hasil', 'admin', '2016-12-23 06:35:59', NULL, NULL),
('SIPRO', 'SIPRO', 'Program simpanan untuk beli properti. Skema bisnis jaringan 5 level untuk registrasi dan bagi hasil', 'admin', '2016-12-23 06:35:59', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `r_jenis_operator`
--

CREATE TABLE `r_jenis_operator` (
  `kode` varchar(10) NOT NULL,
  `nama` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `r_jenis_operator`
--

INSERT INTO `r_jenis_operator` (`kode`, `nama`) VALUES
('GAME', 'GAME'),
('PPOB', 'PPOB'),
('PULSA', 'PULSA');

-- --------------------------------------------------------

--
-- Table structure for table `r_jenis_produk`
--

CREATE TABLE `r_jenis_produk` (
  `id` varchar(3) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `user_input` varchar(20) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `user_update` varchar(20) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `r_jenis_produk`
--

INSERT INTO `r_jenis_produk` (`id`, `nama`, `user_input`, `tgl_input`, `user_update`, `tgl_update`) VALUES
('KAV', 'TANAH KAVLING', 'admin', '2016-12-18 04:46:50', 'admin', '2016-12-18 08:36:29'),
('RUM', 'RUMAH', 'admin', '2016-12-18 04:47:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `r_jenis_rekening`
--

CREATE TABLE `r_jenis_rekening` (
  `id` varchar(7) NOT NULL,
  `nama` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `r_jenis_rekening`
--

INSERT INTO `r_jenis_rekening` (`id`, `nama`) VALUES
('ANGSUR', 'ANGSURAN'),
('BISPRO', 'BISPRO'),
('SIPRO', 'SIPRO'),
('WALLET', 'E-WALLET');

-- --------------------------------------------------------

--
-- Table structure for table `r_jenis_transaksi`
--

CREATE TABLE `r_jenis_transaksi` (
  `kode` varchar(3) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `r_jenis_transaksi`
--

INSERT INTO `r_jenis_transaksi` (`kode`, `nama`) VALUES
('ADJ', 'ADJUSTMENT / KOREKSI'),
('FEE', 'BONUS / KOMISI'),
('PAY', 'PAYMENT'),
('STR', 'SETORAN'),
('TAR', 'TARIK TUNAI'),
('TRF', 'TRANSFER');

-- --------------------------------------------------------

--
-- Table structure for table `t_aktivasi`
--

CREATE TABLE `t_aktivasi` (
  `id` bigint(16) NOT NULL,
  `tgl` datetime NOT NULL,
  `id_member` varchar(10) NOT NULL,
  `id_bank` tinyint(5) NOT NULL,
  `nominal` int(11) NOT NULL,
  `ket` text,
  `user_input` varchar(20) NOT NULL,
  `tgl_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_aktivasi`
--

INSERT INTO `t_aktivasi` (`id`, `tgl`, `id_member`, `id_bank`, `nominal`, `ket`, `user_input`, `tgl_input`) VALUES
(1, '2017-01-27 00:16:16', '10011', 2, 1500000, 'trasfer', 'admin', '2017-01-27 00:16:16'),
(2, '2017-04-14 22:25:16', '10012', 2, 2000000, 'sukses', 'admin', '2017-04-14 22:25:16'),
(3, '2017-04-15 05:50:39', '10013', 2, 2000000, 'OKE SIP MANTABB', 'admin', '2017-04-15 05:50:39'),
(4, '2017-04-15 05:55:57', '10014', 2, 2000000, 'oke sip mantabb', 'admin', '2017-04-15 05:55:57'),
(5, '2017-05-07 14:47:26', '10027', 1, 0, 'BUKTI TRANSFER', 'admin', '2017-05-07 14:47:26'),
(6, '2017-05-14 15:39:15', '10015', 1, 1500000, 'Ini Bukti transfer', 'admin', '2017-05-14 15:39:15');

-- --------------------------------------------------------

--
-- Table structure for table `t_komplain`
--

CREATE TABLE `t_komplain` (
  `id` int(11) NOT NULL,
  `tgl` datetime NOT NULL,
  `id_member` varchar(10) NOT NULL,
  `ket` varchar(200) NOT NULL,
  `response` varchar(150) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_komplain`
--

INSERT INTO `t_komplain` (`id`, `tgl`, `id_member`, `ket`, `response`, `status`) VALUES
(2, '2017-05-02 00:00:00', '10002', 'sdsdsdsd', 'sdsdsdsd', 1),
(3, '2017-05-02 00:00:00', '10002', 'dsdsdsdsdsdsdsdsd', 'sdsdsdsdsdsdsdsdsdsddsdsd', 0);

-- --------------------------------------------------------

--
-- Table structure for table `t_konfirmasi`
--

CREATE TABLE `t_konfirmasi` (
  `id` int(11) NOT NULL,
  `id_member` varchar(10) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `id_bank` tinyint(5) DEFAULT NULL,
  `atas_nama` varchar(50) NOT NULL,
  `nomor` varchar(50) DEFAULT NULL,
  `tgl` date NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL,
  `ket` varchar(255) DEFAULT NULL,
  `user_input` varchar(20) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `user_update` varchar(20) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `nominal` bigint(16) UNSIGNED NOT NULL,
  `jenis_konfirmasi` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_konfirmasi`
--

INSERT INTO `t_konfirmasi` (`id`, `id_member`, `nama`, `id_bank`, `atas_nama`, `nomor`, `tgl`, `status`, `ket`, `user_input`, `tgl_input`, `user_update`, `tgl_update`, `nominal`, `jenis_konfirmasi`) VALUES
(1, '10001', 'ARI HANGGARA', 3, 'MOHAMMAD SYAFII ARI HANGGARA', NULL, '2017-02-08', 2, NULL, 'sistem', '2017-02-10 22:15:26', 'admin', '2017-04-14 22:23:34', 1500000, 1),
(2, '10012', 'ABDUL MALIK', 2, 'ABDUL MALIK SOLAHUDIN', NULL, '2017-04-13', 2, NULL, 'sistem', '2017-04-13 22:15:26', 'admin', '2017-04-14 22:37:10', 2000000, 1),
(3, '10014', 'THORIQUL MAJID', 2, 'THORIQUL MAJID', NULL, '2017-04-13', 1, NULL, 'sistem', '2017-04-13 22:15:26', 'admin', '2017-04-15 05:55:57', 2000000, 1),
(4, '1015', 'RUDI KOMARUDIN', 2, 'RUDI KOMARUDIN', NULL, '2017-04-13', 0, NULL, 'sistem', '2017-04-13 22:15:26', NULL, NULL, 2000000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_outbox`
--

CREATE TABLE `t_outbox` (
  `id` int(11) UNSIGNED NOT NULL,
  `nomor` varchar(100) DEFAULT NULL,
  `id_member` varchar(32) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `tgl` datetime NOT NULL,
  `pesan` varchar(1000) NOT NULL,
  `type` tinyint(1) UNSIGNED NOT NULL,
  `port` int(6) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_outbox`
--

INSERT INTO `t_outbox` (`id`, `nomor`, `id_member`, `nama`, `tgl`, `pesan`, `type`, `port`, `status`) VALUES
(1, '08343422', '10011', 'SOFYAN JALIL', '2017-01-27 00:17:18', 'Yth.SOFYAN JALIL, selamat ID Member PRO2M Anda telah aktif. ID: password:Eq8REYyrt. Download app PRO2M di https://goo.gl/PVWABu', 1, 0, 0),
(2, '0812313', '10002', 'ARI HANGGARA', '2017-01-27 01:39:37', 'Yth.ARI HANGGARA, selamat saldo rekening SIPRO Anda telah berhasil ditambahkan sebesar Rp 1,000,000', 1, 0, 0),
(3, '0812313', '10002', 'ARI HANGGARA', '2017-01-27 02:45:46', 'Yth.ARI HANGGARA (10002), selamat saldo rekening SIPRO Anda telah berhasil ditambahkan sebesar Rp 150,000', 1, 0, 0),
(4, '08123122', '10019', 'WIJAYA KARYA', '2017-02-09 04:40:56', 'Yth.WIJAYA KARYA, Selamat Anda terdaftar menjadi member PRO2M dg ID 10019. Silahkan aktivasi dg trf 1,500,000 ke rek PRO2M. Info norek ada di app dan website. Download app di https://goo.gl/PVWABu', 1, 0, 0),
(5, '0812321', '10019', 'WIKA HANUM', '2017-02-09 04:44:23', 'Yth.WIKA HANUM, Selamat Anda terdaftar menjadi member PRO2M dg ID 10019. Silahkan aktivasi dg trf 1,500,000 ke rek PRO2M. Info norek ada di app dan website. Download app di https://goo.gl/PVWABu', 1, 0, 0),
(6, '09323232', '10018', 'UCUP MARKUCUP', '2017-02-09 05:03:37', 'Yth.UCUP MARKUCUP, Selamat Anda terdaftar menjadi member PRO2M dg ID 10018. Silahkan aktivasi dg trf 1,500,000 ke rek PRO2M. Info norek ada di app dan website. Download app di https://goo.gl/PVWABu', 1, 0, 0),
(7, '08432323', '10019', 'LINTA LAHU', '2017-02-09 05:07:23', 'Yth.LINTA LAHU, Selamat Anda terdaftar menjadi member PRO2M dg ID 10019. Silahkan aktivasi dg trf 1,500,000 ke rek PRO2M. Info norek ada di app dan website. Download app di https://goo.gl/PVWABu', 1, 0, 0),
(8, '0844322', '10020', 'MAJU TAK GENTAR', '2017-02-09 05:09:59', 'Yth.MAJU TAK GENTAR, Selamat Anda terdaftar menjadi member PRO2M dg ID 10020. Silahkan aktivasi dg trf 1,500,000 ke rek PRO2M. Info norek ada di app dan website. Download app di https://goo.gl/PVWABu', 1, 0, 0),
(9, '08673883662', '10021', 'MUNAWAR SALEH', '2017-02-09 06:02:44', 'Yth.MUNAWAR SALEH, Selamat Anda terdaftar menjadi member PRO2M dg ID 10021. Silahkan aktivasi dg trf 1,500,000 ke rek PRO2M. Info norek ada di app dan website. Download app di https://goo.gl/PVWABu', 1, 0, 0),
(10, '081213122', '10022', 'MARIA KITRI', '2017-02-09 21:30:49', 'Yth.MARIA KITRI, Selamat Anda terdaftar menjadi member PRO2M dg ID 10022. Silahkan aktivasi dg trf 1,500,000 ke rek PRO2M. Info norek ada di app dan website. Download app di https://goo.gl/PVWABu', 1, 0, 0),
(11, '084334232', '10023', 'WIDURI KUSUMAWARDANI', '2017-02-09 21:37:28', 'Yth.WIDURI KUSUMAWARDANI, Selamat Anda terdaftar menjadi member PRO2M dg ID 10023. Silahkan aktivasi dg trf 1,500,000 ke rek PRO2M. Info norek ada di app dan website. Download app di https://goo.gl/PVWABu', 1, 0, 0),
(12, '082321121', '10024', 'SINTIANA TUNGGAL DEWI', '2017-02-09 21:39:25', 'Yth.SINTIANA TUNGGAL DEWI, Selamat Anda terdaftar menjadi member PRO2M dg ID 10024. Silahkan aktivasi dg trf 1,500,000 ke rek PRO2M. Info norek ada di app dan website. Download app di https://goo.gl/PVWABu', 1, 0, 0),
(13, '08434232', '10025', 'MARGARET WEJANGAN', '2017-02-09 21:42:43', 'Yth.MARGARET WEJANGAN, Selamat Anda terdaftar menjadi member PRO2M dg ID 10025. Silahkan aktivasi dg trf 1,500,000 ke rek PRO2M. Info norek ada di app dan website. Download app di https://goo.gl/PVWABu', 1, 0, 0),
(14, '0812313', '10002', 'ARI HANGGARA', '2017-03-10 08:40:11', 'Yth.KPSI, Anda telah menerima transfer saldo E-Wallet dari KPSI (10001) sebesar 10,000. Silahkan login dan cek saldo Anda', 1, 0, 0),
(15, '0812312', '10001', 'KPSI', '2017-03-10 10:13:19', 'Yth.KPSI, Topup saldo SIPRO Anda sebesar 50,000 telah BERHASIL dilakukan. Saldo SIPRO Anda saat ini=Rp 350,000.', 1, 0, 0),
(16, '0812312121', '10026', 'TEST REGISTRASI NPWP_BANK', '2017-03-15 07:52:33', 'Yth.TEST REGISTRASI NPWP_BANK, Selamat Anda terdaftar menjadi member PRO2M dg ID 10026. Silahkan aktivasi dg trf 1,500,000 ke rek PRO2M. Info norek ada di website https://pro2m.co.id. Download App di https://goo.gl/PVWABu', 1, 0, 0),
(17, '0844342', '10012', 'ABDUL MALIK', '2017-04-14 22:25:20', 'Yth.ABDUL MALIK (10012), selamat ID Member PRO2M Anda telah aktif. Password Anda adalah jvBTrP9kV. Download Mobile App PRO2M di https://goo.gl/PVWABu', 1, 0, 0),
(18, '08123445432', '10013', 'THORIQUL MAJID', '2017-04-15 05:50:41', 'Yth.THORIQUL MAJID (10013), selamat ID Member PRO2M Anda telah aktif. Password Anda adalah jd8MrwFK8. Download Mobile App PRO2M di https://goo.gl/PVWABu', 1, 0, 0),
(19, '081232121', '10014', 'NATASYA WILONA', '2017-04-15 05:56:00', 'Yth.NATASYA WILONA (10014), selamat ID Member PRO2M Anda telah aktif. Password Anda adalah 8fCvqEdwC. Download Mobile App PRO2M di https://goo.gl/PVWABu', 1, 0, 0),
(20, '081385551542', '10027', 'MEMBER TIDUR SIPRO', '2017-05-07 14:43:11', 'Yth.MEMBER TIDUR SIPRO, Selamat Anda terdaftar menjadi member PRO2M dg ID 10027. Silahkan aktivasi dg trf 1,500,000 ke rek PRO2M. Info norek ada di website https://pro2m.co.id. Download App di https://goo.gl/PVWABu', 1, 0, 0),
(21, '081385551542', '10027', 'MEMBER TIDUR SIPRO', '2017-05-07 14:47:27', 'Yth.MEMBER TIDUR SIPRO (10027), selamat ID Member PRO2M Anda telah aktif. Password Anda adalah VUs89Nw2M. Download Mobile App PRO2M di https://goo.gl/PVWABu', 1, 0, 0),
(22, '081234543433', '10015', 'RUDI KOMARUDIN', '2017-05-14 15:39:16', 'Yth.RUDI KOMARUDIN (10015), selamat ID Member PRO2M Anda telah aktif. Password Anda adalah mU5MU8r6D. Download Mobile App PRO2M di https://goo.gl/PVWABu', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `t_rek_bispro`
--

CREATE TABLE `t_rek_bispro` (
  `id` bigint(20) NOT NULL,
  `tgl` datetime NOT NULL,
  `norek` varchar(20) NOT NULL,
  `jenis_trx` varchar(3) NOT NULL,
  `ket` varchar(50) DEFAULT NULL,
  `dk` varchar(1) NOT NULL,
  `nominal` bigint(16) NOT NULL,
  `saldo_awal` bigint(16) NOT NULL,
  `saldo_akhir` bigint(16) NOT NULL,
  `user_input` varchar(20) NOT NULL,
  `tgl_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_rek_sipro`
--

CREATE TABLE `t_rek_sipro` (
  `id` bigint(20) NOT NULL,
  `tgl` datetime NOT NULL,
  `norek` varchar(20) NOT NULL,
  `jenis_trx` varchar(3) NOT NULL,
  `ket` varchar(50) DEFAULT NULL,
  `dk` varchar(1) NOT NULL,
  `nominal` bigint(16) NOT NULL,
  `saldo_awal` bigint(16) NOT NULL,
  `saldo_akhir` bigint(16) NOT NULL,
  `user_input` varchar(20) NOT NULL,
  `tgl_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_rek_sipro`
--

INSERT INTO `t_rek_sipro` (`id`, `tgl`, `norek`, `jenis_trx`, `ket`, `dk`, `nominal`, `saldo_awal`, `saldo_akhir`, `user_input`, `tgl_input`) VALUES
(1, '2017-01-26 02:12:45', '0210001', 'FEE', 'FEE 4: 10009 DARWANTO SUMARGONO', 'K', 200000, 0, 200000, '10009', '2017-01-26 02:12:45'),
(2, '2017-01-26 02:21:10', '0210003', 'FEE', 'FEE 4: 10010 WIDURI INDAHSARI', 'K', 200000, 0, 200000, '10010', '2017-01-26 02:21:10'),
(3, '2017-01-26 02:21:10', '0210001', 'FEE', 'FEE 5: 10010 WIDURI INDAHSARI', 'K', 100000, 200000, 300000, '10010', '2017-01-26 02:21:10'),
(4, '2017-01-27 00:16:17', '0210007', 'FEE', 'FEE 4: 10011 SOFYAN JALIL', 'K', 200000, 0, 200000, 'admin', '2017-01-27 00:16:17'),
(5, '2017-01-27 00:16:17', '0210003', 'FEE', 'FEE 5: 10011 SOFYAN JALIL', 'K', 100000, 200000, 300000, 'admin', '2017-01-27 00:16:17'),
(6, '2017-01-27 01:38:37', '0210002', 'STR', 'TOPUP : 10002 ARI HANGGARA', 'K', 1000000, 0, 1000000, 'admin', '2017-01-27 01:38:37'),
(7, '2017-01-27 02:44:46', '0210002', 'STR', 'TOPUP FROM 0110002: 10002 ARI HANGGARA', 'K', 150000, 1000000, 1150000, 'admin', '2017-01-27 02:44:46'),
(8, '2017-03-10 10:13:18', '0210001', 'TRF', 'TRF FROM WALLET : 0110001', 'K', 50000, 300000, 350000, '10001', '2017-03-10 10:13:18'),
(9, '2017-04-14 22:25:17', '0210008', 'FEE', 'FEE 4: 10012 ABDUL MALIK', 'K', 200000, 0, 200000, 'admin', '2017-04-14 22:25:17'),
(10, '2017-04-14 22:25:17', '0210007', 'FEE', 'FEE 5: 10012 ABDUL MALIK', 'K', 100000, 200000, 300000, 'admin', '2017-04-14 22:25:17');

-- --------------------------------------------------------

--
-- Table structure for table `t_rek_wallet`
--

CREATE TABLE `t_rek_wallet` (
  `id` bigint(20) NOT NULL,
  `tgl` datetime NOT NULL,
  `norek` varchar(20) NOT NULL,
  `jenis_trx` varchar(3) NOT NULL,
  `ket` varchar(50) DEFAULT NULL,
  `dk` varchar(1) NOT NULL,
  `nominal` bigint(16) NOT NULL,
  `saldo_awal` bigint(16) NOT NULL,
  `saldo_akhir` bigint(16) NOT NULL,
  `user_input` varchar(20) NOT NULL,
  `tgl_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_rek_wallet`
--

INSERT INTO `t_rek_wallet` (`id`, `tgl`, `norek`, `jenis_trx`, `ket`, `dk`, `nominal`, `saldo_awal`, `saldo_akhir`, `user_input`, `tgl_input`) VALUES
(1, '2017-06-16 11:44:42', '0110001', 'FEE', 'FEE 3: 10015 RUDI KOMARUDIN', 'K', 100000, 3440000, 3540000, 'admin', '2017-06-16 11:44:42'),
(2, '2017-06-16 11:44:42', '0110002', 'FEE', 'FEE 2: 10015 RUDI KOMARUDIN', 'K', 100000, 11776325, 11876325, 'admin', '2017-06-16 11:44:42'),
(3, '2017-06-16 11:44:42', '0110005', 'FEE', 'FEE 1: 10015 RUDI KOMARUDIN', 'K', 500000, 0, 500000, 'admin', '2017-06-16 11:44:42'),
(4, '2017-06-16 11:46:04', '0110001', 'ADJ', 'ADJ: UBAH UPLINE 10015 FROM 10005 TO 10007', 'D', 100000, 3540000, 3440000, 'admin', '2017-06-16 11:46:04'),
(5, '2017-06-16 11:46:04', '0110002', 'ADJ', 'ADJ: UBAH UPLINE 10015 FROM 10005 TO 10007', 'D', 100000, 11876325, 11776325, 'admin', '2017-06-16 11:46:04'),
(6, '2017-06-16 11:46:04', '0110005', 'ADJ', 'ADJ: UBAH UPLINE 10015 FROM 10005 TO 10007', 'D', 500000, 500000, 0, 'admin', '2017-06-16 11:46:04'),
(7, '2017-06-16 11:46:04', '0110003', 'FEE', 'FEE 2: 10015 RUDI KOMARUDIN', 'K', 100000, 2700000, 2800000, 'admin', '2017-06-16 11:46:04'),
(8, '2017-06-16 11:46:04', '0110007', 'FEE', 'FEE 1: 10015 RUDI KOMARUDIN', 'K', 500000, 1700000, 2200000, 'admin', '2017-06-16 11:46:04'),
(9, '2017-06-16 11:50:14', '0110003', 'ADJ', 'ADJ: UBAH UPLINE 10015 FROM 10007 TO 10004', 'D', 100000, 2800000, 2700000, 'admin', '2017-06-16 11:50:14'),
(10, '2017-06-16 11:50:14', '0110007', 'ADJ', 'ADJ: UBAH UPLINE 10015 FROM 10007 TO 10004', 'D', 500000, 2200000, 1700000, 'admin', '2017-06-16 11:50:14'),
(11, '2017-06-16 11:50:14', '0110001', 'FEE', 'FEE 2: 10015 RUDI KOMARUDIN', 'K', 100000, 3640000, 3740000, 'admin', '2017-06-16 11:50:14'),
(12, '2017-06-16 11:50:14', '0110004', 'FEE', 'FEE 1: 10015 RUDI KOMARUDIN', 'K', 500000, 0, 500000, 'admin', '2017-06-16 11:50:14'),
(13, '2017-06-16 11:50:47', '0110001', 'ADJ', 'ADJ: UBAH UPLINE 10015 FROM 10004 TO 10009', 'D', 100000, 3740000, 3640000, 'admin', '2017-06-16 11:50:47'),
(14, '2017-06-16 11:50:47', '0110004', 'ADJ', 'ADJ: UBAH UPLINE 10015 FROM 10004 TO 10009', 'D', 500000, 500000, 0, 'admin', '2017-06-16 11:50:47'),
(15, '2017-06-16 11:50:47', '0110001', 'FEE', 'FEE 4: 10015 RUDI KOMARUDIN', 'K', 200000, 3840000, 4040000, 'admin', '2017-06-16 11:50:47'),
(16, '2017-06-16 11:50:47', '0110003', 'FEE', 'FEE 3: 10015 RUDI KOMARUDIN', 'K', 100000, 2900000, 3000000, 'admin', '2017-06-16 11:50:47'),
(17, '2017-06-16 11:50:47', '0110007', 'FEE', 'FEE 2: 10015 RUDI KOMARUDIN', 'K', 100000, 2700000, 2800000, 'admin', '2017-06-16 11:50:47'),
(18, '2017-06-16 11:50:47', '0110009', 'FEE', 'FEE 1: 10015 RUDI KOMARUDIN', 'K', 500000, 0, 500000, 'admin', '2017-06-16 11:50:47');

-- --------------------------------------------------------

--
-- Table structure for table `t_request_withdraw`
--

CREATE TABLE `t_request_withdraw` (
  `id` int(11) NOT NULL,
  `tgl` datetime NOT NULL,
  `jenis_rekening` varchar(7) NOT NULL,
  `id_member` varchar(10) NOT NULL,
  `nominal` bigint(16) NOT NULL,
  `id_bank` int(11) NOT NULL,
  `kode_bank` varchar(3) NOT NULL,
  `nama_bank` varchar(50) NOT NULL,
  `norek` varchar(20) NOT NULL,
  `atas_nama` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `ket` text,
  `user_input` varchar(20) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `user_update` varchar(20) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_request_withdraw`
--

INSERT INTO `t_request_withdraw` (`id`, `tgl`, `jenis_rekening`, `id_member`, `nominal`, `id_bank`, `kode_bank`, `nama_bank`, `norek`, `atas_nama`, `status`, `ket`, `user_input`, `tgl_input`, `user_update`, `tgl_update`) VALUES
(1, '2017-03-11 07:07:37', 'WALLET', '10001', 100000, 1, '014', 'BANK BCA', '3300486508', 'MOHAMMAD SYAFI\'I ARI HANGGARA', 1, 'Transfer telah selesai dilakukan\nterima kasih atas perhatiannya\nsampai jumpa di lain waktu', 'admin', '2017-04-15 22:01:49', NULL, NULL),
(2, '2017-03-11 07:09:01', 'WALLET', '10001', 100000, 2, '008', 'BANK MANDIRI', '1400043211235', 'MOHAMMAD SYAFI\'I ARI HANGGARA', 2, 'refund ajah', '10001', '2017-03-11 07:09:01', 'admin', '2017-04-15 22:31:58'),
(3, '2017-03-11 07:09:29', 'WALLET', '10001', 100000, 2, '008', 'BANK MANDIRI', '1400043211235', 'MOHAMMAD SYAFI\'I ARI HANGGARA', 2, 'aku adalah anak gembala\r\nselalu riang serta gembira\r\ntak pernah aku\r\nmerasa malas\r\nataupun di kaki bukit', '10001', '2017-03-11 07:09:29', 'admin', '2017-04-15 22:39:36'),
(4, '2017-03-11 07:09:01', 'WALLET', '10001', 100000, 2, '008', 'BANK MANDIRI', '1400043211235', 'MOHAMMAD SYAFI\'I ARI HANGGARA', 2, 'satu\r\ndua\r\ntiga\r\nempat\r\nlima', '10001', '2017-03-11 07:09:01', 'admin', '2017-04-15 22:44:13');

-- --------------------------------------------------------

--
-- Table structure for table `t_simpanan_pokok`
--

CREATE TABLE `t_simpanan_pokok` (
  `id` bigint(20) NOT NULL,
  `id_member` varchar(20) NOT NULL,
  `tgl` datetime NOT NULL,
  `nominal` int(9) NOT NULL,
  `saldo_awal` bigint(16) NOT NULL,
  `saldo_akhir` bigint(16) NOT NULL,
  `user_input` varchar(20) NOT NULL,
  `tgl_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_simpanan_pokok`
--

INSERT INTO `t_simpanan_pokok` (`id`, `id_member`, `tgl`, `nominal`, `saldo_awal`, `saldo_akhir`, `user_input`, `tgl_input`) VALUES
(1, '10005', '2017-01-26 01:35:25', 100000, 0, 100000, '', '0000-00-00 00:00:00'),
(3, '10006', '2017-01-26 01:47:47', 100000, 100000, 200000, '', '0000-00-00 00:00:00'),
(4, '10007', '2017-01-26 01:49:09', 100000, 200000, 300000, '', '0000-00-00 00:00:00'),
(5, '10008', '2017-01-26 02:11:04', 100000, 300000, 400000, '', '0000-00-00 00:00:00'),
(6, '10009', '2017-01-26 02:12:45', 100000, 400000, 500000, '', '0000-00-00 00:00:00'),
(7, '10010', '2017-01-26 02:21:10', 100000, 500000, 600000, '', '0000-00-00 00:00:00'),
(8, '10011', '2017-01-27 00:16:17', 100000, 600000, 700000, 'admin', '2017-01-27 00:16:16'),
(9, '10012', '2017-04-14 22:25:16', 5000, 700000, 705000, 'admin', '2017-04-14 22:25:16'),
(10, '10013', '2017-04-15 05:50:39', 5000, 705000, 710000, 'admin', '2017-04-15 05:50:39'),
(11, '10014', '2017-04-15 05:55:57', 5000, 710000, 715000, 'admin', '2017-04-15 05:55:57'),
(12, '10027', '2017-05-07 14:47:26', 5000, 715000, 720000, 'admin', '2017-05-07 14:47:26'),
(13, '10015', '2017-05-14 15:39:15', 5000, 720000, 725000, 'admin', '2017-05-14 15:39:15');

-- --------------------------------------------------------

--
-- Table structure for table `t_simpanan_wajib`
--

CREATE TABLE `t_simpanan_wajib` (
  `id` bigint(20) NOT NULL,
  `id_member` varchar(20) NOT NULL,
  `tgl` datetime NOT NULL,
  `nominal` int(9) NOT NULL,
  `saldo_awal` bigint(16) NOT NULL,
  `saldo_akhir` bigint(16) NOT NULL,
  `user_input` varchar(20) NOT NULL,
  `tgl_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_simpanan_wajib`
--

INSERT INTO `t_simpanan_wajib` (`id`, `id_member`, `tgl`, `nominal`, `saldo_awal`, `saldo_akhir`, `user_input`, `tgl_input`) VALUES
(1, '10005', '2017-01-26 01:35:25', 400000, 0, 400000, '', '0000-00-00 00:00:00'),
(3, '10006', '2017-01-26 01:47:47', 400000, 400000, 800000, '', '0000-00-00 00:00:00'),
(4, '10007', '2017-01-26 01:49:09', 400000, 800000, 1200000, '', '0000-00-00 00:00:00'),
(5, '10008', '2017-01-26 02:11:04', 400000, 1200000, 1600000, '', '0000-00-00 00:00:00'),
(6, '10009', '2017-01-26 02:12:45', 400000, 1600000, 2000000, '', '0000-00-00 00:00:00'),
(7, '10010', '2017-01-26 02:21:10', 400000, 2000000, 2400000, '', '0000-00-00 00:00:00'),
(8, '10011', '2017-01-27 00:16:17', 400000, 2400000, 2800000, 'admin', '2017-01-27 00:16:16'),
(9, '10012', '2017-04-14 22:25:17', 5000, 2800000, 2805000, 'admin', '2017-04-14 22:25:16'),
(10, '10013', '2017-04-15 05:50:39', 5000, 2805000, 2810000, 'admin', '2017-04-15 05:50:39'),
(11, '10014', '2017-04-15 05:55:57', 5000, 2810000, 2815000, 'admin', '2017-04-15 05:55:57'),
(12, '10027', '2017-05-07 14:47:26', 5000, 2815000, 2820000, 'admin', '2017-05-07 14:47:26'),
(13, '10015', '2017-05-14 15:39:15', 5000, 2820000, 2825000, 'admin', '2017-05-14 15:39:15');

-- --------------------------------------------------------

--
-- Table structure for table `t_topup`
--

CREATE TABLE `t_topup` (
  `id` int(11) NOT NULL,
  `id_bank` tinyint(5) NOT NULL,
  `id_member` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tgl` datetime NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL,
  `ket` varchar(255) DEFAULT NULL,
  `nominal` decimal(16,0) NOT NULL,
  `user_update` varchar(20) NOT NULL,
  `tgl_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_topup_konfirmasi`
--

CREATE TABLE `t_topup_konfirmasi` (
  `id` int(11) NOT NULL,
  `id_member` varchar(10) NOT NULL,
  `id_bank` tinyint(5) DEFAULT NULL,
  `atas_nama` varchar(50) NOT NULL,
  `nomor` varchar(50) NOT NULL,
  `tgl` datetime NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL,
  `ket` varchar(255) DEFAULT NULL,
  `user_input` varchar(20) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `user_update` varchar(20) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `nominal` decimal(16,0) UNSIGNED NOT NULL,
  `jenis_rekening` varchar(7) NOT NULL COMMENT 'SIPRO,BISPRO,WALLET'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_topup_konfirmasi`
--

INSERT INTO `t_topup_konfirmasi` (`id`, `id_member`, `id_bank`, `atas_nama`, `nomor`, `tgl`, `status`, `ket`, `user_input`, `tgl_input`, `user_update`, `tgl_update`, `nominal`, `jenis_rekening`) VALUES
(1, '10002', 3, 'MOHAMMAD SYAFII ARI HANGGARA', '1400043211235', '2017-01-27 00:41:43', 1, 'Atas Nama Pengirim  :  MOHAMMAD SYAFII ARI HANGGARA', '', '0000-00-00 00:00:00', 'admin', '2017-01-27 01:38:37', '1000000', 'SIPRO'),
(2, '10002', 3, 'MOHAMMAD SYAFII ARI HANGGARA', '1400043211235', '2017-01-27 00:41:43', 0, NULL, '10002', '2017-01-27 01:42:49', NULL, NULL, '500000', 'SIPRO');

-- --------------------------------------------------------

--
-- Table structure for table `t_transaksi_ppob`
--

CREATE TABLE `t_transaksi_ppob` (
  `id` int(11) NOT NULL,
  `tgl` datetime NOT NULL,
  `id_member` varchar(10) NOT NULL,
  `produk` varchar(20) NOT NULL,
  `idpel` varchar(20) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `rc` varchar(4) DEFAULT NULL,
  `ket` varchar(200) DEFAULT NULL,
  `noresi` varchar(30) DEFAULT NULL,
  `nominal` bigint(16) NOT NULL DEFAULT '0',
  `struk` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_transaksi_ppob`
--

INSERT INTO `t_transaksi_ppob` (`id`, `tgl`, `id_member`, `produk`, `idpel`, `type`, `status`, `rc`, `ket`, `noresi`, `nominal`, `struk`) VALUES
(1, '2017-02-02 16:42:05', '10002', 'plnpascaa', '123456789012', 0, 0, NULL, NULL, NULL, 0, NULL),
(2, '2017-02-02 19:57:03', '10002', 'PLNPASCA', '123456789012', 0, 1, '0000', 'SUCCESSFUL', '000000280690', 55500, NULL),
(3, '2017-02-02 19:57:34', '10002', 'PLNPASCA', '123456789034', 0, 1, '0000', 'SUCCESSFUL', '000000280691', 55500, NULL),
(4, '2017-02-02 19:59:28', '10002', 'PLNPASCA', '123123123123', 0, 1, '0000', 'SUCCESSFUL', '000000280692', 55500, NULL),
(5, '2017-02-03 07:14:18', '10002', 'PLNPASCA', '123123123123', 0, 1, '0000', 'SUCCESSFUL', '000000280693', 55500, NULL),
(6, '2017-02-03 07:15:06', '10002', 'PLNPASCA', '123123123123', 0, 1, '0000', 'SUCCESSFUL', '000000280694', 55500, NULL),
(7, '2017-02-03 07:16:52', '10002', 'PLNPASCA', '123123123123', 0, 1, '0000', 'SUCCESSFUL', '000000280695', 55500, NULL),
(8, '2017-02-03 07:17:18', '10002', 'PLNPASCA', '123123123123', 0, 1, '0000', 'SUCCESSFUL', '000000280696', 55500, NULL),
(9, '2017-02-03 07:17:58', '10002', 'PLNPASCA', '123123123123', 0, 1, '0000', 'SUCCESSFUL', '000000280697', 55500, NULL),
(10, '2017-02-03 07:18:17', '10002', 'PLNPASCA', '123123123123', 0, 1, '0000', 'SUCCESSFUL', '000000280698', 55500, NULL),
(11, '2017-02-03 07:19:32', '10002', 'PLNPASCA', '123123123123', 0, 1, '0000', 'SUCCESSFUL', '000000280699', 55500, NULL),
(12, '2017-02-03 07:20:14', '10002', 'PLNPASCA', '123123123123', 0, 1, '0000', 'SUCCESSFUL', '000000280700', 55500, NULL),
(13, '2017-02-03 09:39:41', '10002', 'PLNPASCA', '123123123123', 0, 1, '0000', 'SUCCESSFUL', '000000280701', 55500, NULL),
(14, '2017-02-03 09:46:36', '10002', 'PLNPASCA', '123123123123', 0, 1, '0000', 'SUCCESSFUL', '000000280702', 55500, NULL),
(15, '2017-02-03 09:47:13', '10002', 'PLNPASCA', '123123123123', 0, 1, '0000', 'SUCCESSFUL', '000000280703', 55500, NULL),
(16, '2017-02-03 09:48:04', '10002', 'PLNPASCA', '123213123122', 0, 1, '0000', 'SUCCESSFUL', '000000280704', 55500, NULL),
(17, '2017-02-03 09:48:13', '10002', 'PLNPASCA', '123213123122', 1, 1, '0000', 'SUCCESSFUL', '000000280705', 55500, NULL),
(18, '2017-02-03 09:51:18', '10002', 'PLNPASCA', '324323423332', 0, 1, '0000', 'SUCCESSFUL', '000000280706', 55500, NULL),
(19, '2017-02-03 09:52:08', '10002', 'PLNPASCA', '123456789009', 0, 1, '0000', 'SUCCESSFUL', '000000280707', 55500, NULL),
(20, '2017-02-03 09:52:22', '10002', 'PLNPASCA', '123456789009', 1, 1, '0000', 'SUCCESSFUL', '000000280708', 55500, NULL),
(21, '2017-02-03 09:54:41', '10002', 'PLNPASCA', '213436457654', 0, 1, '0000', 'SUCCESSFUL', '000000280709', 55500, NULL),
(22, '2017-02-03 09:55:26', '10002', 'PLNPASCA', '987654328765', 0, 1, '0000', 'SUCCESSFUL', '000000280710', 55500, NULL),
(23, '2017-02-03 09:56:22', '10002', 'PLNPASCA', '543676543676', 0, 1, '0000', 'SUCCESSFUL', '000000280711', 55500, NULL),
(24, '2017-02-03 09:56:30', '10002', 'PLNPASCA', '765432321234', 0, 1, '0000', 'SUCCESSFUL', '000000280712', 55500, NULL),
(25, '2017-02-03 09:58:34', '10002', 'PLNPASCA', '765432321234', 1, 1, '0000', 'SUCCESSFUL', '000000280713', 55500, NULL),
(26, '2017-02-03 10:00:04', '10002', 'PLNNON', '4545423232434', 0, 1, '0000', 'SUCCESSFUL', '000000280714', 455000, NULL),
(27, '2017-02-03 10:00:18', '10002', 'PLNNON', '4545423232434', 1, 2, '0096', 'DATA TRANSAKSI TIDAK DITEMUKAN. SILAHKAN MELAKUKAN INQUIRY ULANG', '000000280714', 455000, NULL),
(28, '2017-02-03 10:09:25', '10002', 'PLNPRA', '12312321413', 0, 1, '0000', 'SUCCESSFUL', '000000280715', 0, NULL),
(29, '2017-02-03 10:13:01', '10002', 'PLNPRA', '23423765432', 0, 1, '0000', 'SUCCESSFUL', '000000280716', 0, NULL),
(30, '2017-02-03 10:13:20', '10002', 'PLNPRA', '23423765432', 1, 1, '0000', 'SUCCESSFUL', '000000280717', 22500, NULL),
(31, '2017-02-03 10:14:26', '10002', 'PLNPRA', '876543345678', 0, 1, '0000', 'SUCCESSFUL', '000000280718', 0, NULL),
(32, '2017-02-03 10:14:40', '10002', 'PLNPRA', '876543345678', 1, 2, '0096', 'DATA TRANSAKSI TIDAK DITEMUKAN. SILAHKAN MELAKUKAN INQUIRY ULANG', '000000280718', 20000, NULL),
(33, '2017-02-03 10:15:50', '10002', 'PLNNON', '6543234567765', 0, 1, '0000', 'SUCCESSFUL', '000000280719', 455000, NULL),
(34, '2017-02-03 10:15:58', '10002', 'PLNNON', '6543234567765', 1, 2, '0096', 'DATA TRANSAKSI TIDAK DITEMUKAN. SILAHKAN MELAKUKAN INQUIRY ULANG', '000000280719', 455000, NULL),
(35, '2017-02-03 10:24:30', '10002', 'PLNPRA', '876543234567', 0, 1, '0000', 'SUCCESSFUL', '000000280720', 0, NULL),
(36, '2017-02-03 10:24:50', '10002', 'PLNPRA', '876543234567', 1, 1, '0000', 'SUCCESSFUL', '000000280721', 22500, NULL),
(37, '2017-02-03 10:25:07', '10002', 'PLNNON', '7654367574565', 0, 1, '0000', 'SUCCESSFUL', '000000280722', 455000, NULL),
(38, '2017-02-03 10:25:14', '10002', 'PLNNON', '7654367574565', 1, 2, '0096', 'DATA TRANSAKSI TIDAK DITEMUKAN. SILAHKAN MELAKUKAN INQUIRY ULANG', '000000280722', 455000, NULL),
(39, '2017-02-03 10:30:08', '10002', 'TELEPON', '021432374', 0, 1, '0000', 'SUCCESSFUL', '000000280723', 141330, NULL),
(40, '2017-02-03 10:30:18', '10002', 'TELEPON', '021432374', 1, 2, '0096', 'DATA TRANSAKSI TIDAK DITEMUKAN. SILAHKAN MELAKUKAN INQUIRY ULANG', '000000280723', 141330, NULL),
(41, '2017-02-03 10:30:35', '10002', 'SPEEDY', '8764543425324', 0, 1, '0000', 'SUCCESSFUL', '000000280724', 141330, NULL),
(42, '2017-02-03 10:30:45', '10002', 'SPEEDY', '8764543425324', 1, 1, '0000', 'SUCCESSFUL', '000000280725', 141330, NULL),
(43, '2017-02-03 10:33:10', '10002', 'SPEEDY', '3475937493949', 0, 1, '0000', 'SUCCESSFUL', '000000280726', 141330, NULL),
(44, '2017-02-03 10:33:58', '10002', 'SPEEDY', '7654242342342', 0, 1, '0000', 'SUCCESSFUL', '000000280727', 141330, NULL),
(45, '2017-02-03 10:34:43', '10002', 'SPEEDY', '7654332142141', 0, 1, '0000', 'SUCCESSFUL', '000000280728', 141330, NULL),
(46, '2017-02-03 10:38:32', '10002', 'SPEEDY', '4354534534343', 0, 1, '0000', 'SUCCESSFUL', '000000280729', 141330, NULL),
(47, '2017-02-03 10:38:54', '10002', 'SPEEDY', '3242343242342', 0, 1, '0000', 'SUCCESSFUL', '000000280730', 141330, NULL),
(48, '2017-02-03 10:39:27', '10002', 'SPEEDY', '1231231231231', 0, 1, '0000', 'SUCCESSFUL', '000000280731', 141330, NULL),
(49, '2017-02-03 10:40:06', '10002', 'SPEEDY', '4353453453434', 0, 1, '0000', 'SUCCESSFUL', '000000280732', 141330, NULL),
(50, '2017-02-03 10:40:10', '10002', 'SPEEDY', '4353453453434', 1, 1, '0000', 'SUCCESSFUL', '000000280733', 141330, NULL),
(51, '2017-02-03 10:49:03', '10002', 'SPEEDY', '2343253252532', 0, 1, '0000', 'SUCCESSFUL', '000000280734', 141330, NULL),
(52, '2017-02-03 10:51:25', '10002', 'SPEEDY', '4534534534345', 0, 1, '0000', 'SUCCESSFUL', '000000280735', 141330, NULL),
(53, '2017-02-03 10:51:59', '10002', 'SPEEDY', '2342352352423', 0, 1, '0000', 'SUCCESSFUL', '000000280736', 141330, NULL),
(54, '2017-02-03 10:52:07', '10002', 'SPEEDY', '2342352352423', 1, 1, '0000', 'SUCCESSFUL', '000000280737', 141330, NULL),
(55, '2017-02-03 14:32:13', '10002', 'AETRA', '1231231212', 0, 1, '0000', 'SUCCESSFUL', '000000280738', 148610, NULL),
(56, '2017-02-03 14:32:27', '10002', 'AETRA', '1231231212', 1, 1, '0000', 'SUCCESSFUL', '000000280739', 148610, NULL),
(57, '2017-02-03 14:39:47', '10002', 'FIF', '123123212', 0, 2, NULL, NULL, 'ERROR', 0, NULL),
(58, '2017-02-03 14:41:09', '10002', 'FIF', '123123212', 0, 2, NULL, NULL, 'ERROR', 0, NULL),
(59, '2017-02-03 14:42:44', '10002', 'FIF', '12312312312', 0, 2, NULL, NULL, 'ERROR', 0, NULL),
(60, '2017-02-03 14:43:22', '10002', 'FIF', '123123123', 0, 2, NULL, NULL, 'ERROR', 0, NULL),
(61, '2017-02-03 14:44:06', '10002', 'FIF', '123123123', 0, 2, NULL, NULL, 'ERROR', 0, NULL),
(62, '2017-02-03 14:45:04', '10002', 'FIF', '123123123', 0, 0, NULL, NULL, NULL, 0, NULL),
(63, '2017-02-03 14:47:31', '10002', 'FIF', '103002224016', 0, 0, NULL, NULL, NULL, 0, NULL),
(64, '2017-02-03 14:55:12', '10002', 'FIF', '103002224016', 0, 0, NULL, NULL, NULL, 0, NULL),
(65, '2017-02-03 14:56:35', '10002', 'plnpasca', '123456789012', 0, 0, NULL, NULL, NULL, 0, NULL),
(66, '2017-02-03 14:57:11', '10002', 'plnpasca', '123456789012', 0, 0, NULL, NULL, NULL, 0, NULL),
(67, '2017-02-03 14:57:26', '10002', 'FIF', '103002224016', 0, 0, NULL, NULL, NULL, 0, NULL),
(68, '2017-02-03 14:59:39', '10002', 'FIF', '103002224016', 0, 0, NULL, NULL, NULL, 0, NULL),
(69, '2017-02-03 15:00:12', '10002', 'FIF', '123123123', 0, 2, '0110', 'PRODUK KOSONG', '000000000000', 0, NULL),
(70, '2017-02-03 15:00:19', '10002', 'OTO', '123123123', 0, 2, '0103', 'KODE PRODUK TIDAK DITEMUKAN', '000000000000', 0, NULL),
(71, '2017-02-03 15:00:24', '10002', 'BAF', '123123123', 0, 1, '0000', 'SUCCESSFUL', '000000280741', 56100, NULL),
(72, '2017-02-03 15:00:38', '10002', 'BAF', '123123123', 1, 1, '0000', 'SUCCESSFUL', '000000280742', 56100, NULL),
(73, '2017-02-03 15:04:34', '10002', 'HALO', '081231232', 0, 2, NULL, NULL, 'ERROR', 0, NULL),
(74, '2017-02-03 15:04:56', '10002', 'HALO', '08123123', 0, 2, NULL, NULL, 'ERROR', 0, NULL),
(75, '2017-02-03 15:08:26', '10002', 'HALO', '08123123', 0, 2, '0068', 'TIDAK ADA RESPON DARI PROVIDER (TIMEOUT)', '000000000000', 0, NULL),
(76, '2017-02-03 15:08:33', '10002', 'HALO', '081231232', 0, 2, '0068', 'TIDAK ADA RESPON DARI PROVIDER (TIMEOUT)', '000000000000', 0, NULL),
(77, '2017-02-03 16:11:28', '10002', 'I5', '0823424233', 1, 0, NULL, NULL, NULL, 0, NULL),
(78, '2017-02-03 16:13:02', '10002', 'I5', '0823424233', 1, 1, '0000', 'Yth.KITABAYAR RETAIL ID KB002 Trx I5 ke 0823424233 (1) sudah pernah dilakukan pada 2017-02-03 16:11:32.0 status SUKSES SN: 1bb9e1786a6082f62da26fe10df63848 . Trx lancar', '000000000000', 0, NULL),
(79, '2017-02-03 16:13:45', '10002', 'i5', '081243433123', 1, 1, '0000', 'Yth.KITABAYAR RETAIL ID KB002 Trx I5 ke 081243433123 (1) BERHASIL SN:dca61674ac8392aea23f262f6bdd8eea harga 5700. Saldo -700600 . Trx lancar', '148611322883', 5700, NULL),
(80, '2017-02-03 16:28:31', '10002', 'I5', '085654343423', 1, 1, '0000', 'TRANSAKSI ANDA I5 KE 085654343423 BERHASIL. SN = 566f1336cb02c847e1286e0863d1526b', '148611411496', 5700, NULL),
(81, '2017-02-03 16:30:17', '10002', 'I5', '352342342323', 1, 1, '0000', 'TRANSAKSI ANDA I5 KE 352342342323 BERHASIL. SN = dc44260c25f43915949dbe416302dc8f', '148611422091', 5700, NULL),
(82, '2017-02-03 16:31:10', '10002', 'CP32', '0463454343', 1, 1, '0000', 'TRANSAKSI ANDA CP32 KE 0463454343 BERHASIL. SN = 008d4d4b906300ac2b62d463dd5e4a1b', '148611427393', 29425, NULL),
(83, '2017-03-06 15:30:51', '10001', 'PLNPASCA', '123123123123', 0, 0, NULL, NULL, NULL, 0, NULL),
(84, '2017-03-06 15:31:21', '10001', 'PDAMSURABAYA', '121323232', 0, 0, NULL, NULL, NULL, 0, NULL),
(85, '2017-03-10 15:06:08', '10001', 'PLNPASCA', '123552136458', 0, 0, NULL, NULL, NULL, 0, NULL),
(86, '2017-03-10 15:06:26', '10001', 'AETRA', '2636736717', 0, 0, NULL, NULL, NULL, 0, NULL),
(87, '2017-03-11 05:28:56', '10001', 'PLNPASCA', '123123123', 0, 0, NULL, NULL, NULL, 0, NULL),
(88, '2017-03-12 16:10:20', '10002', 'PLNPASCA', '123123123123', 0, 0, NULL, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_transaksi_ppob_suspect`
--

CREATE TABLE `t_transaksi_ppob_suspect` (
  `id` int(11) NOT NULL,
  `tgl` datetime NOT NULL,
  `id_member` varchar(10) NOT NULL,
  `produk` varchar(20) NOT NULL,
  `idpel` varchar(20) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `rc` varchar(4) DEFAULT NULL,
  `ket` varchar(100) DEFAULT NULL,
  `nominal` bigint(16) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_komisi_bispro_0`
--
CREATE TABLE `v_komisi_bispro_0` (
`id` bigint(16)
,`tgl` datetime
,`id_member` varchar(10)
,`nominal` int(11)
,`level` int(1)
,`status` tinyint(1)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_komisi_bispro_1`
--
CREATE TABLE `v_komisi_bispro_1` (
`id` bigint(16)
,`tgl` datetime
,`id_member` varchar(10)
,`nominal` int(11)
,`level` int(1)
,`status` tinyint(1)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_komisi_registrasi`
--
CREATE TABLE `v_komisi_registrasi` (
`id` bigint(16)
,`tgl` datetime
,`id_member` varchar(10)
,`id_downline` varchar(10)
,`nominal` int(11)
,`level` int(1)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_komisi_royalty`
--
CREATE TABLE `v_komisi_royalty` (
`id` bigint(16)
,`tgl` datetime
,`id_member` varchar(10)
,`id_downline` varchar(10)
,`nominal` int(11)
,`level` int(1)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_konfirmasi_bispro`
--
CREATE TABLE `v_konfirmasi_bispro` (
`id` int(11)
,`id_member` varchar(10)
,`id_bank` tinyint(5)
,`atas_nama` varchar(50)
,`nomor` varchar(50)
,`tgl` datetime
,`status` tinyint(1) unsigned
,`ket` varchar(255)
,`user_update` varchar(20)
,`tgl_update` datetime
,`nominal` decimal(16,0) unsigned
,`jenis_rekening` varchar(7)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_konfirmasi_sipro`
--
CREATE TABLE `v_konfirmasi_sipro` (
`id` int(11)
,`id_member` varchar(10)
,`id_bank` tinyint(5)
,`atas_nama` varchar(50)
,`nomor` varchar(50)
,`tgl` datetime
,`status` tinyint(1) unsigned
,`ket` varchar(255)
,`user_update` varchar(20)
,`tgl_update` datetime
,`nominal` decimal(16,0) unsigned
,`jenis_rekening` varchar(7)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_konfirmasi_wallet`
--
CREATE TABLE `v_konfirmasi_wallet` (
`id` int(11)
,`id_member` varchar(10)
,`id_bank` tinyint(5)
,`atas_nama` varchar(50)
,`nomor` varchar(50)
,`tgl` datetime
,`status` tinyint(1) unsigned
,`ket` varchar(255)
,`user_update` varchar(20)
,`tgl_update` datetime
,`nominal` decimal(16,0) unsigned
,`jenis_rekening` varchar(7)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_rekening_bispro`
--
CREATE TABLE `v_rekening_bispro` (
`norek` varchar(20)
,`no_atm` varchar(20)
,`id_member` varchar(10)
,`jenis_rekening` varchar(7)
,`saldo` bigint(16)
,`user_input` varchar(20)
,`tgl_input` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_rekening_sipro`
--
CREATE TABLE `v_rekening_sipro` (
`norek` varchar(20)
,`no_atm` varchar(20)
,`id_member` varchar(10)
,`jenis_rekening` varchar(7)
,`saldo` bigint(16)
,`user_input` varchar(20)
,`tgl_input` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_rekening_wallet`
--
CREATE TABLE `v_rekening_wallet` (
`norek` varchar(20)
,`no_atm` varchar(20)
,`id_member` varchar(10)
,`jenis_rekening` varchar(7)
,`saldo` bigint(16)
,`user_input` varchar(20)
,`tgl_input` datetime
);

-- --------------------------------------------------------

--
-- Structure for view `v_komisi_bispro_0`
--
DROP TABLE IF EXISTS `v_komisi_bispro_0`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_komisi_bispro_0`  AS  select `l_komisi_bispro`.`id` AS `id`,`l_komisi_bispro`.`tgl` AS `tgl`,`l_komisi_bispro`.`id_member` AS `id_member`,`l_komisi_bispro`.`nominal` AS `nominal`,`l_komisi_bispro`.`level` AS `level`,`l_komisi_bispro`.`status` AS `status` from `l_komisi_bispro` where (`l_komisi_bispro`.`status` = 0) ;

-- --------------------------------------------------------

--
-- Structure for view `v_komisi_bispro_1`
--
DROP TABLE IF EXISTS `v_komisi_bispro_1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_komisi_bispro_1`  AS  select `l_komisi_bispro`.`id` AS `id`,`l_komisi_bispro`.`tgl` AS `tgl`,`l_komisi_bispro`.`id_member` AS `id_member`,`l_komisi_bispro`.`nominal` AS `nominal`,`l_komisi_bispro`.`level` AS `level`,`l_komisi_bispro`.`status` AS `status` from `l_komisi_bispro` where (`l_komisi_bispro`.`status` = 1) ;

-- --------------------------------------------------------

--
-- Structure for view `v_komisi_registrasi`
--
DROP TABLE IF EXISTS `v_komisi_registrasi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_komisi_registrasi`  AS  select `l_komisi`.`id` AS `id`,`l_komisi`.`tgl` AS `tgl`,`l_komisi`.`id_member` AS `id_member`,`l_komisi`.`id_downline` AS `id_downline`,`l_komisi`.`nominal` AS `nominal`,`l_komisi`.`level` AS `level` from `l_komisi` where (`l_komisi`.`level` = 1) ;

-- --------------------------------------------------------

--
-- Structure for view `v_komisi_royalty`
--
DROP TABLE IF EXISTS `v_komisi_royalty`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_komisi_royalty`  AS  select `l_komisi`.`id` AS `id`,`l_komisi`.`tgl` AS `tgl`,`l_komisi`.`id_member` AS `id_member`,`l_komisi`.`id_downline` AS `id_downline`,`l_komisi`.`nominal` AS `nominal`,`l_komisi`.`level` AS `level` from `l_komisi` where (`l_komisi`.`level` <> 1) ;

-- --------------------------------------------------------

--
-- Structure for view `v_konfirmasi_bispro`
--
DROP TABLE IF EXISTS `v_konfirmasi_bispro`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_konfirmasi_bispro`  AS  select `t_topup_konfirmasi`.`id` AS `id`,`t_topup_konfirmasi`.`id_member` AS `id_member`,`t_topup_konfirmasi`.`id_bank` AS `id_bank`,`t_topup_konfirmasi`.`atas_nama` AS `atas_nama`,`t_topup_konfirmasi`.`nomor` AS `nomor`,`t_topup_konfirmasi`.`tgl` AS `tgl`,`t_topup_konfirmasi`.`status` AS `status`,`t_topup_konfirmasi`.`ket` AS `ket`,`t_topup_konfirmasi`.`user_update` AS `user_update`,`t_topup_konfirmasi`.`tgl_update` AS `tgl_update`,`t_topup_konfirmasi`.`nominal` AS `nominal`,`t_topup_konfirmasi`.`jenis_rekening` AS `jenis_rekening` from `t_topup_konfirmasi` where (`t_topup_konfirmasi`.`jenis_rekening` = 'BISPRO') ;

-- --------------------------------------------------------

--
-- Structure for view `v_konfirmasi_sipro`
--
DROP TABLE IF EXISTS `v_konfirmasi_sipro`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_konfirmasi_sipro`  AS  select `t_topup_konfirmasi`.`id` AS `id`,`t_topup_konfirmasi`.`id_member` AS `id_member`,`t_topup_konfirmasi`.`id_bank` AS `id_bank`,`t_topup_konfirmasi`.`atas_nama` AS `atas_nama`,`t_topup_konfirmasi`.`nomor` AS `nomor`,`t_topup_konfirmasi`.`tgl` AS `tgl`,`t_topup_konfirmasi`.`status` AS `status`,`t_topup_konfirmasi`.`ket` AS `ket`,`t_topup_konfirmasi`.`user_update` AS `user_update`,`t_topup_konfirmasi`.`tgl_update` AS `tgl_update`,`t_topup_konfirmasi`.`nominal` AS `nominal`,`t_topup_konfirmasi`.`jenis_rekening` AS `jenis_rekening` from `t_topup_konfirmasi` where (`t_topup_konfirmasi`.`jenis_rekening` = 'SIPRO') ;

-- --------------------------------------------------------

--
-- Structure for view `v_konfirmasi_wallet`
--
DROP TABLE IF EXISTS `v_konfirmasi_wallet`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_konfirmasi_wallet`  AS  select `t_topup_konfirmasi`.`id` AS `id`,`t_topup_konfirmasi`.`id_member` AS `id_member`,`t_topup_konfirmasi`.`id_bank` AS `id_bank`,`t_topup_konfirmasi`.`atas_nama` AS `atas_nama`,`t_topup_konfirmasi`.`nomor` AS `nomor`,`t_topup_konfirmasi`.`tgl` AS `tgl`,`t_topup_konfirmasi`.`status` AS `status`,`t_topup_konfirmasi`.`ket` AS `ket`,`t_topup_konfirmasi`.`user_update` AS `user_update`,`t_topup_konfirmasi`.`tgl_update` AS `tgl_update`,`t_topup_konfirmasi`.`nominal` AS `nominal`,`t_topup_konfirmasi`.`jenis_rekening` AS `jenis_rekening` from `t_topup_konfirmasi` where (`t_topup_konfirmasi`.`jenis_rekening` = 'WALLET') ;

-- --------------------------------------------------------

--
-- Structure for view `v_rekening_bispro`
--
DROP TABLE IF EXISTS `v_rekening_bispro`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_rekening_bispro`  AS  select `m_rekening`.`norek` AS `norek`,`m_rekening`.`no_atm` AS `no_atm`,`m_rekening`.`id_member` AS `id_member`,`m_rekening`.`jenis_rekening` AS `jenis_rekening`,`m_rekening`.`saldo` AS `saldo`,`m_rekening`.`user_input` AS `user_input`,`m_rekening`.`tgl_input` AS `tgl_input` from `m_rekening` where (`m_rekening`.`jenis_rekening` = 'BISPRO') ;

-- --------------------------------------------------------

--
-- Structure for view `v_rekening_sipro`
--
DROP TABLE IF EXISTS `v_rekening_sipro`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_rekening_sipro`  AS  select `m_rekening`.`norek` AS `norek`,`m_rekening`.`no_atm` AS `no_atm`,`m_rekening`.`id_member` AS `id_member`,`m_rekening`.`jenis_rekening` AS `jenis_rekening`,`m_rekening`.`saldo` AS `saldo`,`m_rekening`.`user_input` AS `user_input`,`m_rekening`.`tgl_input` AS `tgl_input` from `m_rekening` where (`m_rekening`.`jenis_rekening` = 'SIPRO') ;

-- --------------------------------------------------------

--
-- Structure for view `v_rekening_wallet`
--
DROP TABLE IF EXISTS `v_rekening_wallet`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_rekening_wallet`  AS  select `m_rekening`.`norek` AS `norek`,`m_rekening`.`no_atm` AS `no_atm`,`m_rekening`.`id_member` AS `id_member`,`m_rekening`.`jenis_rekening` AS `jenis_rekening`,`m_rekening`.`saldo` AS `saldo`,`m_rekening`.`user_input` AS `user_input`,`m_rekening`.`tgl_input` AS `tgl_input` from `m_rekening` where (`m_rekening`.`jenis_rekening` = 'WALLET') ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `c_banner_mobile_apps`
--
ALTER TABLE `c_banner_mobile_apps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `c_fee_bagi_hasil`
--
ALTER TABLE `c_fee_bagi_hasil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `c_fee_registrasi`
--
ALTER TABLE `c_fee_registrasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `c_setting`
--
ALTER TABLE `c_setting`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `l_komisi`
--
ALTER TABLE `l_komisi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_member` (`id_member`);

--
-- Indexes for table `l_komisi_bispro`
--
ALTER TABLE `l_komisi_bispro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_member` (`id_member`);

--
-- Indexes for table `m_bank`
--
ALTER TABLE `m_bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_bank_kode`
--
ALTER TABLE `m_bank_kode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_cabang`
--
ALTER TABLE `m_cabang`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `id` (`id`),
  ADD KEY `user_input` (`user_input`),
  ADD KEY `user_update` (`user_update`);

--
-- Indexes for table `m_faq`
--
ALTER TABLE `m_faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_kabupaten`
--
ALTER TABLE `m_kabupaten`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_kolektor`
--
ALTER TABLE `m_kolektor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_update` (`user_update`),
  ADD KEY `id_cabang` (`id_cabang`),
  ADD KEY `user_input` (`user_input`);

--
-- Indexes for table `m_legalitas`
--
ALTER TABLE `m_legalitas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_level`
--
ALTER TABLE `m_level`
  ADD PRIMARY KEY (`level`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- Indexes for table `m_member`
--
ALTER TABLE `m_member`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_upline1` (`id_upline1`),
  ADD KEY `id_upline2` (`id_upline2`),
  ADD KEY `id_upline3` (`id_upline3`),
  ADD KEY `id_upline4` (`id_upline4`),
  ADD KEY `id_upline5` (`id_upline5`),
  ADD KEY `user_input` (`user_input`),
  ADD KEY `user_update` (`user_update`),
  ADD KEY `id_cabang` (`id_cabang`),
  ADD KEY `level` (`level`),
  ADD KEY `jenis_member` (`jenis_member`);

--
-- Indexes for table `m_member_bank`
--
ALTER TABLE `m_member_bank`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_member` (`id_member`,`id_kode_bank`);

--
-- Indexes for table `m_member_device`
--
ALTER TABLE `m_member_device`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_member` (`id_member`);

--
-- Indexes for table `m_member_gallery`
--
ALTER TABLE `m_member_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_member` (`id_member`);

--
-- Indexes for table `m_member_profile`
--
ALTER TABLE `m_member_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_member` (`id_member`);

--
-- Indexes for table `m_menu`
--
ALTER TABLE `m_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_parent` (`id_parent`);

--
-- Indexes for table `m_news`
--
ALTER TABLE `m_news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_ppob_produk`
--
ALTER TABLE `m_ppob_produk`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `id_group` (`id_group`),
  ADD KEY `id_group_2` (`id_group`);

--
-- Indexes for table `m_ppob_produk_group`
--
ALTER TABLE `m_ppob_produk_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jenis` (`jenis`);

--
-- Indexes for table `m_produk`
--
ALTER TABLE `m_produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jenis_produk` (`jenis_produk`),
  ADD KEY `project` (`project`),
  ADD KEY `user_input` (`user_input`),
  ADD KEY `user_update` (`user_update`);

--
-- Indexes for table `m_produk_foto`
--
ALTER TABLE `m_produk_foto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `m_program`
--
ALTER TABLE `m_program`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_input` (`user_input`),
  ADD KEY `user_update` (`user_update`);

--
-- Indexes for table `m_project`
--
ALTER TABLE `m_project`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_update` (`user_update`),
  ADD KEY `user_input` (`user_input`),
  ADD KEY `id_parent` (`id_parent`),
  ADD KEY `id_program` (`id_program`);

--
-- Indexes for table `m_provinsi`
--
ALTER TABLE `m_provinsi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_rekening`
--
ALTER TABLE `m_rekening`
  ADD PRIMARY KEY (`norek`),
  ADD UNIQUE KEY `no_atm` (`no_atm`),
  ADD KEY `jenis_rekening` (`jenis_rekening`),
  ADD KEY `id_member` (`id_member`);

--
-- Indexes for table `m_saldo_supplier`
--
ALTER TABLE `m_saldo_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_testimonial`
--
ALTER TABLE `m_testimonial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_user`
--
ALTER TABLE `m_user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_user_group` (`id_user_group`),
  ADD KEY `id_cabang` (`id_cabang`),
  ADD KEY `user_input` (`user_input`),
  ADD KEY `user_update` (`user_update`);

--
-- Indexes for table `m_user_akses`
--
ALTER TABLE `m_user_akses`
  ADD UNIQUE KEY `id_group_user` (`id_group_user`,`id_menu`);

--
-- Indexes for table `m_user_akses_dashboard`
--
ALTER TABLE `m_user_akses_dashboard`
  ADD UNIQUE KEY `id_group_user` (`id_group_user`),
  ADD KEY `user_input` (`user_input`),
  ADD KEY `user_update` (`user_update`);

--
-- Indexes for table `m_user_group`
--
ALTER TABLE `m_user_group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type` (`nama`),
  ADD KEY `user_input` (`user_input`),
  ADD KEY `user_update` (`user_update`);

--
-- Indexes for table `r_jenis_konfirmasi`
--
ALTER TABLE `r_jenis_konfirmasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `r_jenis_member`
--
ALTER TABLE `r_jenis_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `r_jenis_operator`
--
ALTER TABLE `r_jenis_operator`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `r_jenis_produk`
--
ALTER TABLE `r_jenis_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `r_jenis_rekening`
--
ALTER TABLE `r_jenis_rekening`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `r_jenis_transaksi`
--
ALTER TABLE `r_jenis_transaksi`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `t_aktivasi`
--
ALTER TABLE `t_aktivasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_member` (`id_member`),
  ADD KEY `id_bank` (`id_bank`);

--
-- Indexes for table `t_komplain`
--
ALTER TABLE `t_komplain`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_konfirmasi`
--
ALTER TABLE `t_konfirmasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_member` (`id_member`),
  ADD KEY `id_bank` (`id_bank`),
  ADD KEY `user_update` (`user_update`),
  ADD KEY `user_input` (`user_input`),
  ADD KEY `jenis_konfirmasi` (`jenis_konfirmasi`);

--
-- Indexes for table `t_outbox`
--
ALTER TABLE `t_outbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_rek_bispro`
--
ALTER TABLE `t_rek_bispro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `norek` (`norek`),
  ADD KEY `jenis_trx` (`jenis_trx`),
  ADD KEY `user_input` (`user_input`);

--
-- Indexes for table `t_rek_sipro`
--
ALTER TABLE `t_rek_sipro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_input` (`user_input`);

--
-- Indexes for table `t_rek_wallet`
--
ALTER TABLE `t_rek_wallet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_input` (`user_input`);

--
-- Indexes for table `t_request_withdraw`
--
ALTER TABLE `t_request_withdraw`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_member` (`id_member`,`id_bank`);

--
-- Indexes for table `t_simpanan_pokok`
--
ALTER TABLE `t_simpanan_pokok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_member` (`id_member`);

--
-- Indexes for table `t_simpanan_wajib`
--
ALTER TABLE `t_simpanan_wajib`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_member` (`id_member`);

--
-- Indexes for table `t_topup`
--
ALTER TABLE `t_topup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_update` (`user_update`),
  ADD KEY `id_member` (`id_member`),
  ADD KEY `id_bank` (`id_bank`);

--
-- Indexes for table `t_topup_konfirmasi`
--
ALTER TABLE `t_topup_konfirmasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_member` (`id_member`),
  ADD KEY `id_bank` (`id_bank`),
  ADD KEY `user_update` (`user_update`),
  ADD KEY `user_input` (`user_input`);

--
-- Indexes for table `t_transaksi_ppob`
--
ALTER TABLE `t_transaksi_ppob`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_transaksi_ppob_suspect`
--
ALTER TABLE `t_transaksi_ppob_suspect`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `c_banner_mobile_apps`
--
ALTER TABLE `c_banner_mobile_apps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `c_fee_bagi_hasil`
--
ALTER TABLE `c_fee_bagi_hasil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `c_fee_registrasi`
--
ALTER TABLE `c_fee_registrasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `l_komisi`
--
ALTER TABLE `l_komisi`
  MODIFY `id` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;
--
-- AUTO_INCREMENT for table `l_komisi_bispro`
--
ALTER TABLE `l_komisi_bispro`
  MODIFY `id` bigint(16) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `m_bank`
--
ALTER TABLE `m_bank`
  MODIFY `id` tinyint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `m_bank_kode`
--
ALTER TABLE `m_bank_kode`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `m_cabang`
--
ALTER TABLE `m_cabang`
  MODIFY `id` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `m_faq`
--
ALTER TABLE `m_faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `m_kabupaten`
--
ALTER TABLE `m_kabupaten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=492;
--
-- AUTO_INCREMENT for table `m_legalitas`
--
ALTER TABLE `m_legalitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `m_level`
--
ALTER TABLE `m_level`
  MODIFY `level` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `m_member_bank`
--
ALTER TABLE `m_member_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `m_member_device`
--
ALTER TABLE `m_member_device`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `m_member_gallery`
--
ALTER TABLE `m_member_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `m_member_profile`
--
ALTER TABLE `m_member_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `m_menu`
--
ALTER TABLE `m_menu`
  MODIFY `id` tinyint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `m_news`
--
ALTER TABLE `m_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `m_ppob_produk_group`
--
ALTER TABLE `m_ppob_produk_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `m_produk`
--
ALTER TABLE `m_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `m_produk_foto`
--
ALTER TABLE `m_produk_foto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `m_program`
--
ALTER TABLE `m_program`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `m_project`
--
ALTER TABLE `m_project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `m_provinsi`
--
ALTER TABLE `m_provinsi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `m_testimonial`
--
ALTER TABLE `m_testimonial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `m_user_group`
--
ALTER TABLE `m_user_group`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `r_jenis_konfirmasi`
--
ALTER TABLE `r_jenis_konfirmasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `t_aktivasi`
--
ALTER TABLE `t_aktivasi`
  MODIFY `id` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `t_komplain`
--
ALTER TABLE `t_komplain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `t_konfirmasi`
--
ALTER TABLE `t_konfirmasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `t_outbox`
--
ALTER TABLE `t_outbox`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `t_rek_bispro`
--
ALTER TABLE `t_rek_bispro`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_rek_sipro`
--
ALTER TABLE `t_rek_sipro`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `t_rek_wallet`
--
ALTER TABLE `t_rek_wallet`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `t_request_withdraw`
--
ALTER TABLE `t_request_withdraw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `t_simpanan_pokok`
--
ALTER TABLE `t_simpanan_pokok`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `t_simpanan_wajib`
--
ALTER TABLE `t_simpanan_wajib`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `t_topup`
--
ALTER TABLE `t_topup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_topup_konfirmasi`
--
ALTER TABLE `t_topup_konfirmasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `t_transaksi_ppob`
--
ALTER TABLE `t_transaksi_ppob`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT for table `t_transaksi_ppob_suspect`
--
ALTER TABLE `t_transaksi_ppob_suspect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
