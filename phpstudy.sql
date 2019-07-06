-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 19-07-06 08:57
-- 서버 버전: 10.1.38-MariaDB
-- PHP 버전: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `phpstudy`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `boardlist`
--

CREATE TABLE `boardlist` (
  `idx` int(11) NOT NULL,
  `subject` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `contents` text COLLATE utf8_unicode_ci NOT NULL,
  `userid` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `regdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 테이블의 덤프 데이터 `boardlist`
--

INSERT INTO `boardlist` (`idx`, `subject`, `contents`, `userid`, `username`, `regdate`) VALUES
(1, '첫번째 글입니다.(수정버전)', '반갑습니다.\r\n\r\n수정이 제대로 되는지 확인해봅시다.', 'test1', '장형석', '2019-06-22 15:12:05'),
(2, '두번째 글입니다.', '환영합니다.', 'test1', '장형석', '2019-06-22 15:31:33'),
(3, '세번째글 ', '다음시간에 또 봐요.', 'test2', '장선생', '2019-06-22 15:56:38'),
(4, '오늘은 php 두번째 시간', '오늘은 세션에 대해서 배웠습니다.', 'test2', '장선생', '2019-06-29 14:11:42'),
(8, '다섯번째 글', '다섯번째 글.', 'test1', '장형석', '2019-06-29 15:29:44'),
(9, '여섯번째', '육', 'test1', '장형석', '2019-06-29 15:29:52'),
(10, '일곱번째', 'php 수업', 'test1', '장형석', '2019-06-29 15:30:01'),
(11, '여덟번째', '글입니다.', 'test1', '장형석', '2019-06-29 15:30:11'),
(12, 'php 수업 시간', '수업은 라이브 코딩', 'test1', '장형석', '2019-06-29 15:30:32'),
(13, '드뎌 열번째', '글 입니다.', 'test1', '장형석', '2019-06-29 15:30:43'),
(14, '열한 번째', '글 입니다.', 'test1', '장형석', '2019-06-29 15:30:52'),
(15, '오늘은 php 세번째 시간', '오늘은 페이징처리와 검색을 배웠습니다.', 'test1', '김형석', '2019-07-06 14:37:40');

-- --------------------------------------------------------

--
-- 테이블 구조 `reply`
--

CREATE TABLE `reply` (
  `idx` int(11) NOT NULL,
  `boardidx` int(11) NOT NULL,
  `replytext` text COLLATE utf8_unicode_ci NOT NULL,
  `userid` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `regdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 테이블의 덤프 데이터 `reply`
--

INSERT INTO `reply` (`idx`, `boardidx`, `replytext`, `userid`, `regdate`) VALUES
(1, 1, '오늘은 한 줄 댓글을 달아 봅시다.', 'test1', '2019-07-06 15:12:55'),
(2, 1, '두번째 댓글을 달아 봅시다.', 'test1', '2019-07-06 15:21:39'),
(3, 1, '세번째 댓글 달아봅시다.', 'test1', '2019-07-06 15:23:16'),
(4, 1, '이번엔 제대로 되기를!', 'test1', '2019-07-06 15:24:04'),
(5, 1, '다섯번째 댓글 테스트!!!', 'test1', '2019-07-06 15:30:10');

-- --------------------------------------------------------

--
-- 테이블 구조 `user`
--

CREATE TABLE `user` (
  `idx` int(11) NOT NULL,
  `userid` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `userpw` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `regdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 테이블의 덤프 데이터 `user`
--

INSERT INTO `user` (`idx`, `userid`, `username`, `userpw`, `regdate`) VALUES
(1, 'test1', '장형석', '1111', '2019-06-29 14:05:56'),
(2, 'test2', '장선생', '1111', '2019-06-29 14:20:59');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `boardlist`
--
ALTER TABLE `boardlist`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idx`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `boardlist`
--
ALTER TABLE `boardlist`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 테이블의 AUTO_INCREMENT `reply`
--
ALTER TABLE `reply`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 테이블의 AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
