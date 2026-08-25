-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2026-08-24 05:31:07
-- サーバのバージョン： 10.4.24-MariaDB
-- PHP のバージョン: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `care_system`
--
DROP DATABASE IF EXISTS `care_system`;
CREATE DATABASE IF NOT EXISTS `care_system` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `care_system`;

-- --------------------------------------------------------

--
-- テーブルの構造 `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$mPKBp/UOIxbf/IX9sbDBBOugEhu0wG4w2GzThQICV4kvTJuuzx87O');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `kana` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `birth` date NOT NULL,
  `care_level` varchar(20) NOT NULL,
  `staff` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `emergency` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `days` varchar(50) NOT NULL,
  `note` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `name`, `kana`, `age`, `gender`, `birth`, `care_level`, `staff`, `address`, `tel`, `emergency`, `start_date`, `days`, `note`) VALUES
(1, '山田 太郎', 'やまだ たろう', 82, '男性', '1942-03-15', '要介護2', '田中 美咲', '東京都新宿区◯◯1-2-3', '03-0000-0001', '山田 一郎(長男)090-0000-0001', '2022-04-01', '月･水･金', '高血圧のため塩分制限あり。'),
(2, '佐藤 花子', 'さとう はなこ', 78, '女性', '1946-07-22', '要介護1', '鈴木 健太', '東京都渋谷区◯◯4-5-6', '03-0000-0002', '佐藤 次郎(夫)090-0000-0002', '2023-01-10', '水･木', '手芸が趣味。視力低下あり。'),
(3, '鈴木 一郎', 'すずき いちろう', 88, '男性', '1936-11-03', '要介護4', '田中 美咲', '東京都世田谷区◯◯7-8-9', '03-0000-0003', '鈴木 花子(妻)090-0000-0003', '2021-06-01', '月･火･水･木･金', '糖尿病管理中。'),
(4, '田中 幸子', 'たなか さちこ', 75, '女性', '1949-02-14', '要支援2', '伊藤 良子', '東京都杉並区〇〇2-3-4', '03-0000-0004', '田中 勇(息子)090-0000-0004', '2023-09-01', '水･金', '軽度の認知症。ウォーキングが日課。'),
(5, '伊藤 正雄', 'いとう まさお', 84, '男性', '1940-08-30', '要介護3', '鈴木 健太', '東京都練馬区〇〇5-6-7', '03-0000-0005', '伊藤 恵子(娘)090-0000-0005', '2022-10-15', '月･水･金', 'パーキンソン病。転倒リスク高。元教師で読書が趣味。'),
(6, '渡辺 久美子', 'わたなべ くみこ', 79, '女性', '2945-05-05', '要介護2', '伊藤 良子', '東京都板橋区〇〇8-9-1', '03-0000-0006', '渡辺 太郎(夫)090-0000-0006', '2023-03-01', '月･水･金', '骨粗しょう症。転倒注意。料理が得意で調理レクに積極的。'),
(7, '中村 健二', 'なかむら けんじ', 91, '男性', '1933-12-01', '要介護5', '田中 美咲', '東京都足立区〇〇3-4-5', '03-0000-0007', '中村 朋子(娘)090-0000-0007', '2020-04-01', '月･火･水･木･金', '寝たきり。経管栄養。ご家族様が毎週面会に来訪。穏やかな表情が印象的。'),
(8, '小林 節子', 'こばやし せつこ', 73, '女性', '1951-04-18', '要支援1', '鈴木 健太', '東京都江東区〇〇6-7-8', '03-0000-0008', '小林 誠(息子)090-0000-0008', '2024-01-20', '木', '軽度の膝関節症。ヨガ経験者でストレッチに意欲的。社交的で場を和ませる存在。');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
