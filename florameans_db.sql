-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Jun 2026 pada 10.08
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `florameans_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(25) NOT NULL,
  `suhu_udara_min` double NOT NULL,
  `suhu_udara_max` double NOT NULL,
  `cahaya_min` double NOT NULL,
  `cahaya_max` double NOT NULL,
  `lembab_udara_min` double NOT NULL,
  `lembab_udara_max` double NOT NULL,
  `lembab_tanah_min` double NOT NULL,
  `lembab_tanah_max` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `suhu_udara_min`, `suhu_udara_max`, `cahaya_min`, `cahaya_max`, `lembab_udara_min`, `lembab_udara_max`, `lembab_tanah_min`, `lembab_tanah_max`) VALUES
(4, 'Xerofit', 25, 45, 5000, 120000, 15, 40, 0, 15),
(5, 'Hidrofit', 20, 32, 10000, 60000, 70, 95, 0, 100),
(6, 'Higrofit', 18, 28, 5000, 15000, 75, 90, 0, 70),
(7, 'Mesofit', 20, 30, 20000, 40000, 50, 70, 40, 60);

-- --------------------------------------------------------

--
-- Struktur dari tabel `simulasi`
--

CREATE TABLE `simulasi` (
  `id_simulasi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_tanaman` int(11) DEFAULT NULL,
  `nama_tanaman_input` varchar(50) NOT NULL,
  `waktu_simulasi` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `suhu_input` double NOT NULL,
  `cahaya_input` double NOT NULL,
  `lembab_tanah_input` double NOT NULL,
  `lembab_udara_input` double NOT NULL,
  `hasil_clustering` varchar(255) NOT NULL,
  `status_lingkungan` varchar(255) NOT NULL,
  `jarak_centroid` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `simulasi`
--

INSERT INTO `simulasi` (`id_simulasi`, `id_user`, `id_tanaman`, `nama_tanaman_input`, `waktu_simulasi`, `suhu_input`, `cahaya_input`, `lembab_tanah_input`, `lembab_udara_input`, `hasil_clustering`, `status_lingkungan`, `jarak_centroid`) VALUES
(4, 7, 2, 'Lidah Buaya', '2026-06-12 14:43:58', 25, 15000, 50, 79.98, 'Higrofit', 'Tidak Sesuai', 5000.0235349846),
(5, 7, 19, 'Kaktus', '2026-06-12 14:45:12', 28, 19999.99, 25, 40, 'Mesofit', 'Tidak Sesuai', 10000.061699815),
(6, 7, 8, 'Anggrek', '2026-06-12 14:54:11', 22.5, 12000, 60, 69.99, 'Higrofit', 'Tidak Sesuai', 2000.195427977),
(8, 7, NULL, 'Bayam', '2026-06-12 14:55:57', 24, 25000, 70, 55, 'Mesofit', 'Tidak Diketahui', 5000.0425998185),
(9, 7, 5, 'Mangga', '2026-06-12 14:56:56', 28, 25000, 60, 64.98, 'Mesofit', 'Sesuai', 5000.0133800221),
(10, 7, 3, 'Pisang', '2026-06-12 14:59:57', 26, 20000, 65, 60, 'Mesofit', 'Sesuai', 10000.011299994),
(11, 7, 2, 'Lidah Buaya', '2026-06-13 07:28:13', 25, 30000, 30, 40, 'Mesofit', 'Tidak Sesuai', 28.284271247462),
(12, 7, 2, 'Lidah Buaya', '2026-06-13 07:30:43', 30, 35000, 15, 25, 'Hidrofit', 'Tidak Sesuai', 67.433300378967),
(14, 7, 19, 'Kaktus', '2026-06-13 07:52:13', 35.6, 52000, 13.8, 37.8, 'Xerofit', 'Sesuai', 10500.006959045);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tanaman`
--

CREATE TABLE `tanaman` (
  `id_tanaman` int(11) NOT NULL,
  `nama_tanaman` varchar(50) NOT NULL,
  `sinonim` text NOT NULL,
  `id_kategori` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tanaman`
--

INSERT INTO `tanaman` (`id_tanaman`, `nama_tanaman`, `sinonim`, `id_kategori`) VALUES
(1, 'Rambutan', '', 7),
(2, 'Lidah Buaya', 'Aloe Vera', 4),
(3, 'Pisang', '', 7),
(4, 'Jeruk', '', 7),
(5, 'Mangga', '', 7),
(6, 'Pepaya', '', 7),
(7, 'Jambu', 'Guava', 7),
(8, 'Anggrek', '', 7),
(9, 'Jamur', '', 7),
(10, 'Jagung', '', 7),
(11, 'Gandum', '', 7),
(12, 'Bluberi', '', 7),
(13, 'Semangi', '', 7),
(14, 'Bunga Matahari', '', 7),
(15, 'Bunga Tulip', '', 7),
(16, 'Bunga Mawar', '', 7),
(17, 'Bunga Aester', '', 7),
(19, 'Kaktus', '', 4),
(20, 'Kurma', '', 4),
(21, 'Lili Gurun', '', 4),
(22, 'Adenium', '', 4),
(23, 'Akasia', '', 4),
(24, 'Buah Naga', '', 4),
(25, 'Nanas', '', 4),
(26, 'Pir Berduri', '', 4),
(27, 'Chia', '', 4),
(28, 'Lavender gurun', '', 4),
(29, 'Dandelion', '', 4),
(30, 'Padi', '', 7),
(31, 'Lilac', '', 7),
(32, 'Jintan saru', 'Jupiner', 7),
(33, 'Pohon mahoni', '', 7),
(34, 'Pohon jati', '', 7),
(35, 'Lidah mertua', '', 4),
(36, 'Pohon palem', '', 4),
(37, 'Setawar', '', 4),
(38, 'Lavender', '', 7),
(39, 'Kembang sepatu', '', 7),
(40, 'Agave', '', 4),
(41, 'Yucca', '', 4),
(42, 'Pohon joshua', '', 4),
(43, 'Euphorbia', '', 4),
(44, 'Mesquite', '', 4),
(45, 'Nolina', '', 4),
(46, 'Bromeliad', '', 4),
(47, 'Teratai', '', 5),
(48, 'Eceng gondok', '', 5),
(49, 'Selada laut', '', 5),
(50, 'Lili', '', 5),
(51, 'Kangkung', '', 5),
(52, 'Ganggang', '', 5),
(53, 'Valisineria', '', 5),
(54, 'Lili air', '', 5),
(55, 'Lemna', '', 5),
(56, 'Coontail', '', 5),
(57, 'Rumput belut', '', 5),
(58, 'Lembang', 'Cattails', 5),
(59, 'Kiambang', '', 5),
(60, 'Kemunting', '', 5),
(61, 'Selada air', '', 5),
(62, 'Daun ungu', '', 5),
(63, 'Lotus', '', 5),
(64, 'Rumput air', '', 5),
(65, 'Trapa', '', 5),
(66, 'Potamogeton', '', 5),
(67, 'Salvinia', '', 5),
(68, 'Keladi', '', 6),
(69, 'Talas', '', 6),
(70, 'Paku', '', 6),
(71, 'Lumut', '', 6),
(72, 'Pakis', '', 6),
(73, 'Aroid', 'Araceace', 6),
(74, 'Begonia', '', 6),
(75, 'Dedalu', '', 6),
(76, 'Embun matahari', '', 6),
(77, 'Pandan laut', '', 6),
(78, 'Suplir', 'Adiantum', 6),
(79, 'Selada batu', 'Arabis', 7),
(80, 'Rumput semak', 'Bushgrass', 7),
(81, 'Rumput pantai', 'Beachgrass', 4),
(82, 'Rumput ekor rubah', 'Foxtail barley grass', 7),
(83, 'Tanaman lima jari', 'Potentilla, cinquefoil, silverweeds, five fingers', 7),
(84, 'Larkspur', 'Delphinium', 7),
(85, 'Saxifraga', '', 7),
(86, 'Ranunculus', '', 7),
(87, 'Bakau', 'Mangrove', 5),
(88, 'Genjer', '', 5),
(89, 'Apel', '', 7),
(90, 'Bambu', '', 7),
(91, 'Bambu Air', '', 5),
(92, 'Kelapa', '', 7),
(93, 'Kunyit', '', 7),
(94, 'Jahe ', '', 7),
(95, 'Tebu', '', 7),
(96, 'Kencur', '', 7),
(97, 'Serai', '', 7),
(98, 'Pandan', '', 7),
(99, 'Belimbing', '', 7),
(100, 'Tomat', '', 7),
(101, 'Kentang', '', 7),
(102, 'Singkong', '', 7),
(103, 'Karet', '', 7),
(104, 'Kapas', '', 7),
(105, 'Kacang panjang', '', 7),
(106, 'Kacang hijau', '', 7),
(107, 'Cabai', '', 7),
(109, 'Cempedak', '', 7),
(110, 'Putri malu', '', 7),
(111, 'Daun wungu', '', 6),
(112, 'Marsh marigold', '', 6),
(113, 'Drosera', 'sundews', 6),
(114, 'Sorrel kayu', 'oxalis', 6),
(115, 'Juncus', '', 6),
(116, 'Cyperus', '', 6),
(117, 'Cocor bebek', '', 4),
(118, 'Jeruk nipis', '', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `tanggal_registrasi` date NOT NULL DEFAULT current_timestamp(),
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `tanggal_registrasi`, `username`, `password`) VALUES
(6, '2026-05-17', 'faizah1', 'd0356c6f6968bf02222ddf5bda208347'),
(7, '2026-06-12', 'faizah', '4c51299eb62065be9961ebe031f53053');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `simulasi`
--
ALTER TABLE `simulasi`
  ADD PRIMARY KEY (`id_simulasi`);

--
-- Indeks untuk tabel `tanaman`
--
ALTER TABLE `tanaman`
  ADD PRIMARY KEY (`id_tanaman`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `simulasi`
--
ALTER TABLE `simulasi`
  MODIFY `id_simulasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `tanaman`
--
ALTER TABLE `tanaman`
  MODIFY `id_tanaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
