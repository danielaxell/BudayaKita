-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Jun 2024 pada 21.31
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
-- Database: `budayakita`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `event_comments`
--

CREATE TABLE `event_comments` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `event_comments`
--

INSERT INTO `event_comments` (`id`, `event_id`, `user_id`, `comment`, `created_at`) VALUES
(1, 2, 4, 'keren', '2024-05-20 07:45:35'),
(5, 2, 2, 'lucuu', '2024-05-17 21:28:18'),
(7, 2, 2, 'kereen', '2024-05-19 13:08:06'),
(8, 12, 4, 'Ayo fathan', '2024-06-08 15:05:17'),
(9, 12, 4, 'Eh iya ayo', '2024-06-08 15:05:25'),
(10, 12, 4, 'Gasss pokoknya', '2024-06-08 15:05:33'),
(11, 18, 5, 'Bagus banget pengen ikut', '2024-06-08 15:48:31');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `event_comments`
--
ALTER TABLE `event_comments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `event_comments`
--
ALTER TABLE `event_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
