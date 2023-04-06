-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2023 at 09:16 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dantob_buss`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `schedules_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamatJemput` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_seats` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `schedules_id`, `name`, `age`, `alamatJemput`, `status`, `num_seats`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'test pesanan 1', '23', 'jln DI panjaitan, Laguboti', 'menunggu', 11, '2023-03-24 07:59:07', '2023-03-24 07:59:07'),
(2, 2, 1, 'test pesanan 1', '23', 'jln DI panjaitan, Laguboti', 'menunggu', 1, '2023-03-24 08:15:58', '2023-03-24 08:15:58'),
(3, 2, 2, 'Santo Lamsar Harianja', '32', 'medan', 'berhasil', 5, '2023-03-24 22:43:49', '2023-03-24 22:43:49'),
(4, 2, 2, 'santo', '122', 'not request', 'berhasil', 8, '2023-03-24 22:54:03', '2023-03-24 22:54:03'),
(5, 2, 3, 'Alexander', '23', 'not request', 'berhasil', 12, '2023-03-25 06:06:58', '2023-03-25 06:06:58'),
(6, 2, 4, 'santo', '12', 'not request', 'berhasil', 10, '2023-03-25 06:48:22', '2023-03-25 06:48:22');

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

CREATE TABLE `buses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supir_id` bigint(20) UNSIGNED NOT NULL,
  `police_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_of_seats` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_pintu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `buses`
--

INSERT INTO `buses` (`id`, `type`, `supir_id`, `police_number`, `number_of_seats`, `merk`, `nomor_pintu`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Executive', 4, 'BB 0938 KB', '11', 'KBT', 'KBT 001', 'Avaliable', '2023-03-23 05:40:52', '2023-03-23 05:40:52'),
(2, 'Economi', 5, 'BB 1234 KM', '12', 'KBT', 'KBT 002', 'Avaliable', '2023-03-23 05:43:48', '2023-03-23 05:43:48');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2023_02_11_022824_create_roles_table', 1),
(2, '2014_10_12_000000_create_users_table', 2),
(3, '2014_10_12_100000_create_password_resets_table', 3),
(4, '2016_06_01_000001_create_oauth_auth_codes_table', 3),
(5, '2016_06_01_000002_create_oauth_access_tokens_table', 3),
(6, '2016_06_01_000003_create_oauth_refresh_tokens_table', 3),
(7, '2016_06_01_000004_create_oauth_clients_table', 3),
(8, '2016_06_01_000005_create_oauth_personal_access_clients_table', 3),
(9, '2019_08_19_000000_create_failed_jobs_table', 3),
(10, '2019_12_14_000001_create_personal_access_tokens_table', 3),
(11, '2023_02_14_134154_create_buses_table', 3),
(12, '2023_02_22_035653_create_routes_table', 3),
(13, '2023_03_09_071953_create_schedulues_table', 4),
(14, '2023_02_22_070729_create_bookings_table', 5),
(15, '2023_02_22_074123_create_trackings_table', 6),
(16, '2023_03_25_051709_add_nullable_to_column_name_in_bookings', 7);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('04eb6809d054f8c603e1bd466271104f5daeebd12d876568bb81447ff0be2ea284fd4149a6d1758f', 2, 5, 'authToken', '[]', 0, '2023-03-24 07:59:39', '2023-03-24 07:59:39', '2024-03-24 14:59:39'),
('08dd3ebc0cef3d83ad761da81df0cbd633183067ec05574612c157cb1be9ddab2ce6d653c2089bf6', 2, 5, 'authToken', '[]', 0, '2023-03-24 22:03:51', '2023-03-24 22:03:52', '2024-03-25 05:03:51'),
('149d197c13aee33e26949408065f0faeaaceace2939272c110627127b5456cc30c4e26d425624540', 2, 5, 'authToken', '[]', 0, '2023-03-24 22:55:50', '2023-03-24 22:55:50', '2024-03-25 05:55:50'),
('16649e2a8bcdd10a144513eac3ba2045b5152a960149d0badb19421324a64e6a5bb6f9efecb5004c', 2, 5, 'authToken', '[]', 1, '2023-03-27 20:50:40', '2023-03-27 20:58:48', '2024-03-28 03:50:40'),
('1963178eedeb89b318bd52435f928ff4d26266e747dc3eddd7b29427f467edea47d3c063623b0eee', 6, 5, 'authToken', '[]', 0, '2023-03-29 00:12:07', '2023-03-29 00:12:08', '2024-03-29 07:12:07'),
('1a175055b17dcda2659cbbf3482925511f9f34572db8ab9f5a1c0174ea0939f68950a7f2629d2854', 4, 5, 'MyApp', '[]', 0, '2023-03-23 05:39:55', '2023-03-23 05:39:55', '2024-03-23 12:39:55'),
('2226d20fef7ff21039e5b420899776ea12388b9fddee1328956d51295572026800535f4a957f974d', 2, 5, 'authToken', '[]', 0, '2023-03-27 21:38:47', '2023-03-27 21:38:47', '2024-03-28 04:38:47'),
('306c3bbba25431a766215c49ec2d36793ba6fc10f61d4d6e47c5942c3ee98e2d9755cdde97586ba0', 6, 5, 'authToken', '[]', 0, '2023-03-28 00:08:05', '2023-03-28 00:08:05', '2024-03-28 07:08:05'),
('3940c6e28a9b31e6e2c0a8030e258b482f1776396b69859c7f0bdcae4e15444f3126a636ed8514c6', 2, 5, 'authToken', '[]', 0, '2023-03-26 06:19:57', '2023-03-26 06:19:57', '2024-03-26 13:19:57'),
('4599b53cd7786334f07fcb4968570f33b94a1d02ba1e426f73f036e48b4f0481391f26eba1a05cc8', 2, 5, 'authToken', '[]', 0, '2023-03-27 21:50:12', '2023-03-27 21:50:13', '2024-03-28 04:50:12'),
('524830a585b67b5e71bc33e293162a2440da6b99db2021edd4455315b831395a01fe2102478a2e3e', 4, 5, 'authToken', '[]', 0, '2023-03-28 00:09:05', '2023-03-28 00:09:05', '2024-03-28 07:09:05'),
('57ea7b1f19a3fb6ff5c51fc1d4789c88b92421670f28cfc76e0918b4aa2c0cc4d0b57afab5e9f6fa', 2, 5, 'authToken', '[]', 0, '2023-03-24 07:50:47', '2023-03-24 07:50:48', '2024-03-24 14:50:47'),
('5a2facde1eec96687a439f398fe10caf6f693813ba77707919080ccc129f7a5ac102702afb71ce74', 2, 5, 'authToken', '[]', 1, '2023-03-23 06:12:45', '2023-03-23 07:24:34', '2024-03-23 13:12:45'),
('5ad8490a2215fca1edb9385b9109ff2bcd0c27fb34aaa1a3ee1fe6e6c3fe90f4d2fbce4b264f442c', 6, 5, 'authToken', '[]', 0, '2023-03-28 00:15:52', '2023-03-28 00:15:52', '2024-03-28 07:15:52'),
('5b664d6bd60f86160693edbdfadbd1eccf86f911de4cb7e728d12282d2323f649bf3de06e6dcb565', 2, 5, 'authToken', '[]', 0, '2023-03-26 06:19:58', '2023-03-26 06:19:58', '2024-03-26 13:19:58'),
('612fecf3479f5e6a42bee2202565cf2a1ba9181eb811818103a55387abb602ceaacf45eb4ceebb57', 2, 5, 'authToken', '[]', 0, '2023-03-25 05:01:36', '2023-03-25 05:01:36', '2024-03-25 12:01:36'),
('632bc3679d86bc6a396634cd0bd551bea7506908a9208de862412c88bb43949839efe8f477e5b2ce', 4, 5, 'authToken', '[]', 0, '2023-03-28 00:11:33', '2023-03-28 00:11:33', '2024-03-28 07:11:33'),
('690bd3c7c270d84c840761d8e7af58a5c969722fde40a656ee57c50ef965829b6ba8f487b9580369', 2, 5, 'authToken', '[]', 1, '2023-03-27 21:34:54', '2023-03-27 21:35:21', '2024-03-28 04:34:54'),
('6b181555a8b77ff9bd9366984dceab6d49ce4dd5c7636d0cb2b35f558191d13234759fc66bead7a1', 2, 5, 'authToken', '[]', 0, '2023-03-23 05:38:14', '2023-03-23 05:38:14', '2024-03-23 12:38:14'),
('7207cf63815100b81a5fe4bb570f6e390849272270d4aecdffbe180ce43c9df005c08b0883ea92ab', 2, 5, 'authToken', '[]', 0, '2023-03-23 23:39:59', '2023-03-23 23:40:06', '2024-03-24 06:39:59'),
('7880d51bc795858d83768093ea97d5d513effff5b3bcda77d598ba61e37b6a1b95b8e4edbc013ca3', 6, 5, 'authToken', '[]', 1, '2023-03-28 00:36:18', '2023-03-28 01:33:54', '2024-03-28 07:36:18'),
('7ea8ce36e9b2326be5c248591777c690c97b99848ce8690bf2bcb75585ac23c3a4c5d3aee9632abe', 6, 5, 'authToken', '[]', 0, '2023-03-28 19:03:14', '2023-03-28 19:03:14', '2024-03-29 02:03:14'),
('82c8ab04f4846c835ee566af0e7cd5a6187ddafb2005b19f08b3bab477634223350af8c458b311af', 2, 5, 'authToken', '[]', 0, '2023-03-24 17:52:50', '2023-03-24 17:52:50', '2024-03-25 00:52:50'),
('877dcae4669f9fc7ca082e016c56bdcc9116aef2a9dc1b6fa40e47c615c708228560e451b7a66614', 6, 5, 'authToken', '[]', 0, '2023-03-28 07:25:15', '2023-03-28 07:25:15', '2024-03-28 14:25:15'),
('8a9c62197acad5da7928bcbc719e65c964b4e5e1d3b8ef5e1c04ac1bf8a7a6c53c02839a1da1a60d', 6, 5, 'authToken', '[]', 0, '2023-03-28 19:04:11', '2023-03-28 19:04:11', '2024-03-29 02:04:11'),
('8c44af911a773809bd87a7c44715a14318393f9752848d888edc29d8362e2216e706bb6cde392685', 2, 5, 'authToken', '[]', 0, '2023-03-26 16:59:52', '2023-03-26 16:59:53', '2024-03-26 23:59:52'),
('9229c5d062d386f83a532529227dc9b3d4177d114f366ab08e7ba4d8140fe05effd56f6015b14b44', 4, 5, 'authToken', '[]', 0, '2023-03-28 00:10:33', '2023-03-28 00:10:33', '2024-03-28 07:10:33'),
('960eb4eb416e927c5ab8b67f9de2fda75f0da0c6000f22d39a3cfe71ba8573d3469afcbc50938553', 6, 5, 'MyApp', '[]', 0, '2023-03-28 00:04:47', '2023-03-28 00:04:47', '2024-03-28 07:04:47'),
('9613988f60fe219481db6ff6c00c1bc43262f73b0c29993a81f41376f628d6ec97af723a7fc70e86', 2, 5, 'authToken', '[]', 0, '2023-03-23 23:40:07', '2023-03-23 23:40:07', '2024-03-24 06:40:07'),
('9c82b38d38bd6d6ed8ca836ff58c24af09cfc38bd77d909b0e87e33f6876aafc226c9fddf89fdce9', 6, 5, 'authToken', '[]', 0, '2023-03-28 18:58:45', '2023-03-28 18:58:46', '2024-03-29 01:58:45'),
('9d08b7c7871629f91d38efb4b55fbef7a398d4d926850e992ca0dc05e7fa451b0d4056e71bfb1909', 2, 5, 'authToken', '[]', 1, '2023-03-23 07:25:30', '2023-03-23 07:25:43', '2024-03-23 14:25:30'),
('9fddf01a138bc9f8886df419e82aeac6f28ff20bdfb2c55825ee4f3d1ef7ead2d4cd40d7be6ffaa6', 2, 5, 'authToken', '[]', 1, '2023-03-27 21:40:54', '2023-03-27 21:41:14', '2024-03-28 04:40:54'),
('a2ea4d3dfe25a9689f9b099b84ee56b2163d2b71845d3ac4b787779528b064dcb55aed2ca6d5acd3', 2, 5, 'authToken', '[]', 1, '2023-03-27 20:30:52', '2023-03-27 20:50:17', '2024-03-28 03:30:52'),
('a77a271562c79b14047e63c0364ebf981702995ff9af5a5718763ea15a86d8d5a308da5e4dc6bd8b', 2, 5, 'authToken', '[]', 1, '2023-03-27 20:59:00', '2023-03-27 21:12:52', '2024-03-28 03:59:00'),
('b8bf170cb8fc743334cfd96be755e57926da6ac223c4e6d2e617bf170a779e375fb9a8524e3ec2b4', 2, 5, 'authToken', '[]', 1, '2023-03-27 23:48:04', '2023-03-28 00:04:07', '2024-03-28 06:48:04'),
('b9599e434121e061b6059ff675925472a50227c32c13999c5a24dbc6d91a59edb5d868cf5d55dd8b', 2, 5, 'authToken', '[]', 1, '2023-03-27 21:31:09', '2023-03-27 21:34:37', '2024-03-28 04:31:09'),
('be860c8b94affb48fbc00499369220ae4f82c6655de8aba9ce9c0d2e1aaeab509f6f499893245f4d', 6, 5, 'authToken', '[]', 0, '2023-03-28 01:35:34', '2023-03-28 01:35:34', '2024-03-28 08:35:34'),
('c45328029f1d03cd1d3bede0c7277a6d91dc86a10efae3ffa654e1a97653ccec5f2419f725a4baae', 6, 5, 'authToken', '[]', 0, '2023-03-28 00:13:58', '2023-03-28 00:13:58', '2024-03-28 07:13:58'),
('c6bb67bd523acd1cd8d1e2139e875233a25ba0af40675f9d4ff2569628219b0a031c4562be6c3f21', 6, 5, 'authToken', '[]', 1, '2023-03-28 00:15:53', '2023-03-28 00:34:11', '2024-03-28 07:15:53'),
('c9b5473b79e98378656b01e6eaa632cf89238a82f5eeb87547d1ea90060589b3b9b8dc5238a1fa22', 2, 5, 'authToken', '[]', 1, '2023-03-28 00:34:23', '2023-03-28 00:36:01', '2024-03-28 07:34:23'),
('d476c640a832588a5fe56ab40f722c53456cca5e17061bd08b28d7c2e4f8f2f12e6b4e226a9b3383', 2, 5, 'authToken', '[]', 1, '2023-03-27 21:13:05', '2023-03-27 21:31:00', '2024-03-28 04:13:05'),
('d4afc80440c17926dcf21c79e464a5e5b81093b8685fc62a939a29ad65f3c6d2e4c39162e2617999', 5, 5, 'MyApp', '[]', 0, '2023-03-23 05:43:25', '2023-03-23 05:43:25', '2024-03-23 12:43:25'),
('d985c888197c10d5bb030c82ea4f9d539f73600c0bf33b94ef6a957a04864b2765cea0b6429468c0', 2, 5, 'authToken', '[]', 1, '2023-03-28 07:20:59', '2023-03-28 07:25:07', '2024-03-28 14:20:59'),
('dcc5fb766283d04d53ee79d348e9757b36ce7612d56b9a25e292736b4dc216dfc66b90126800352f', 2, 5, 'authToken', '[]', 0, '2023-03-23 19:14:23', '2023-03-23 19:14:23', '2024-03-24 02:14:23'),
('df07699953822e98f788fbe63a00196b453aab23a6b3be235a9adf6fbc8d05ec0b056a28659048f4', 2, 5, 'authToken', '[]', 1, '2023-03-27 21:44:31', '2023-03-27 21:46:25', '2024-03-28 04:44:31'),
('e0bf7423d9618ff1746ae5ff8cd3ad1eccb82adca394b4064304c962e78bbbfb89b1de74d3d4c9c1', 2, 5, 'authToken', '[]', 0, '2023-03-24 22:07:42', '2023-03-24 22:07:43', '2024-03-25 05:07:42'),
('e93260d7219e3a695c10b74abde33ca8c7595b9d94e330805b4429c345392aa68b1ca8b1bdd0baa2', 6, 5, 'authToken', '[]', 0, '2023-03-28 00:04:58', '2023-03-28 00:04:58', '2024-03-28 07:04:58'),
('ea9a3caa24fed54c101acb9eb26d778251e1fa62bb5830b7900debe03567e51fd184d979b960b47a', 6, 5, 'authToken', '[]', 0, '2023-03-28 18:16:57', '2023-03-28 18:16:57', '2024-03-29 01:16:57'),
('f28e18b562b8200c03c1bb9e393f801fde74b9e92f14c34359e7481886f90b6ee28179452165a405', 2, 5, 'authToken', '[]', 1, '2023-03-27 21:41:32', '2023-03-27 21:44:20', '2024-03-28 04:41:32'),
('f3fae28f435627352dc4ade701f695df9b7192688ac904e5952d8a661ed2612d97eb0ba662e22783', 2, 5, 'authToken', '[]', 1, '2023-03-28 01:34:06', '2023-03-28 01:35:24', '2024-03-28 08:34:06'),
('f51348c3c1ade4bfd5cb90a7c76a9a86b3aae39e86f2e4cb825509126facf767d49041cc46ff5570', 2, 5, 'authToken', '[]', 1, '2023-03-27 21:35:30', '2023-03-27 21:40:16', '2024-03-28 04:35:30'),
('fc1395d0648bc91170d7b1e8bbfd67389746cb0835e42e9dd1dafba0786198d41b6da5dc92fb66f2', 2, 5, 'authToken', '[]', 1, '2023-03-27 21:46:35', '2023-03-27 21:50:02', '2024-03-28 04:46:35');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'mNgNDCWub1Kbe2VfYgerB1vtkOqbPGhPtzxXVVRB', NULL, 'http://localhost', 1, 0, 0, '2023-03-23 05:30:40', '2023-03-23 05:30:40'),
(2, NULL, 'Laravel Password Grant Client', '8K3kMJLQyX7f1RFHiMc4z7lwyJICcNitT9meSODg', 'users', 'http://localhost', 0, 1, 0, '2023-03-23 05:30:40', '2023-03-23 05:30:40'),
(3, NULL, 'Laravel Personal Access Client', 'toYtS9PAd3DnQeFuUGQfxWa1bdcvdVCgz3LFkFuP', NULL, 'http://localhost', 1, 0, 0, '2023-03-23 05:31:33', '2023-03-23 05:31:33'),
(4, NULL, 'Laravel Password Grant Client', 'PoamlKc57QR4XgkYd9vmMXrGS6RP48S9pyApCpDe', 'users', 'http://localhost', 0, 1, 0, '2023-03-23 05:31:33', '2023-03-23 05:31:33'),
(5, NULL, 'Laravel Personal Access Client', 'MfVHEL9ac1LQmwHziie3vtd3h4vlQZegVbQhrwKr', NULL, 'http://localhost', 1, 0, 0, '2023-03-23 05:34:29', '2023-03-23 05:34:29'),
(6, NULL, 'Laravel Password Grant Client', 'KWLZv9K68HcDb473t3smyJLNx9h7EnEQBBNtFinT', 'users', 'http://localhost', 0, 1, 0, '2023-03-23 05:34:29', '2023-03-23 05:34:29');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-03-23 05:30:40', '2023-03-23 05:30:40'),
(2, 3, '2023-03-23 05:31:33', '2023-03-23 05:31:33'),
(3, 5, '2023-03-23 05:34:29', '2023-03-23 05:34:29');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, NULL),
(2, 'passenger', NULL, NULL),
(3, 'driver', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `derpature` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `arrival` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `derpature`, `arrival`, `created_at`, `updated_at`) VALUES
(1, 'Medan', 'Tarutung', '2023-03-23 05:41:11', '2023-03-23 05:41:11');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bus_id` bigint(20) UNSIGNED NOT NULL,
  `route_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` datetime NOT NULL,
  `harga` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `bus_id`, `route_id`, `tanggal`, `harga`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2023-03-24 08:30:00', '150000', '2023-03-23 05:41:46', '2023-03-23 05:41:46'),
(2, 2, 1, '2023-03-24 09:00:00', '80000', '2023-03-23 05:44:18', '2023-03-23 05:44:18'),
(3, 2, 1, '2023-03-25 17:00:00', '123333', '2023-03-24 23:40:57', '2023-03-24 23:40:57'),
(4, 2, 1, '2023-03-26 20:22:00', '120000', '2023-03-25 06:22:38', '2023-03-25 06:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `trackings`
--

CREATE TABLE `trackings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bus_id` bigint(20) UNSIGNED NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `phone_number`, `address`, `gender`, `photo`, `password`, `role_id`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'admin KBT', 'admin@gmail.com', 'admin', '0824783434637463', 'Medan', 'Laki-laki', 'null', '$2a$12$LUdJFioSvBCpnoEwBftCZeabXktSjftvsYOtEd4MEPKo8wGenL9Ya', 1, NULL, NULL, NULL, NULL),
(3, 'test', 'test@gmail.com', 'test', '0894738574', 'Test', 'Laki-laki', 'null', '$2a$12$z69wWNdeLDpGVo9LYi89q.Srs6dOVhNMg3CGK5LN8PX9pQ2wz87im', 1, NULL, NULL, NULL, NULL),
(4, 'supir exe 01', 'supirexe@gmail.com', 'Supir Exe', '081353883594', 'Medan', 'Laki-laki', 'null', '$2y$10$YRS9iuexSFASecaQe1rGiO3eSYotZ1d/Lo8bZjrDOQS2D9LXMe9Jm', 3, NULL, NULL, '2023-03-23 05:39:55', '2023-03-23 05:39:55'),
(5, 'Alexander', 'alexander@gmail.com', 'alex', '0836646464', 'silaen', 'Laki-laki', 'null', '$2y$10$WjkG/2U9PxrUW8prSUuI6.OST3NSjRda8Q0Q5S3xrLIpWjLODCnBa', 3, NULL, NULL, '2023-03-23 05:43:25', '2023-03-23 05:43:25'),
(6, 'user1', 'user1@gmail.com', 'user1', '082535333', 'Medan', 'Laki-laki', 'null', '$2y$10$ps8YzIIa71aGVBzxKjqHIuYFjxC4IeJjEMz5IHr5ICc8XhDvyQVgi', 2, NULL, NULL, '2023-03-28 00:04:47', '2023-03-28 00:04:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_schedules_id_foreign` (`schedules_id`);

--
-- Indexes for table `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buses_supir_id_foreign` (`supir_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_bus_id_foreign` (`bus_id`),
  ADD KEY `schedules_route_id_foreign` (`route_id`);

--
-- Indexes for table `trackings`
--
ALTER TABLE `trackings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trackings_bus_id_foreign` (`bus_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `buses`
--
ALTER TABLE `buses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `trackings`
--
ALTER TABLE `trackings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_schedules_id_foreign` FOREIGN KEY (`schedules_id`) REFERENCES `schedules` (`id`),
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `buses`
--
ALTER TABLE `buses`
  ADD CONSTRAINT `buses_supir_id_foreign` FOREIGN KEY (`supir_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_bus_id_foreign` FOREIGN KEY (`bus_id`) REFERENCES `buses` (`id`),
  ADD CONSTRAINT `schedules_route_id_foreign` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`);

--
-- Constraints for table `trackings`
--
ALTER TABLE `trackings`
  ADD CONSTRAINT `trackings_bus_id_foreign` FOREIGN KEY (`bus_id`) REFERENCES `buses` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
