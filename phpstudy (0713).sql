-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 19-07-13 08:55
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
  `regdate` datetime NOT NULL,
  `filename` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `boardgroup` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `depth` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 테이블의 덤프 데이터 `boardlist`
--

INSERT INTO `boardlist` (`idx`, `subject`, `contents`, `userid`, `username`, `regdate`, `filename`, `boardgroup`, `level`, `depth`) VALUES
(1, '첫번째 글입니다.(수정버전)', '반갑습니다.\r\n\r\n수정이 제대로 되는지 확인해봅시다.', 'test1', '장형석', '2019-06-22 15:12:05', '', 1, 0, 0),
(2, '두번째 글입니다.', '환영합니다.', 'test1', '장형석', '2019-06-22 15:31:33', '', 2, 0, 0),
(3, '세번째글 ', '다음시간에 또 봐요.', 'test2', '장선생', '2019-06-22 15:56:38', '', 3, 0, 0),
(4, '오늘은 php 두번째 시간', '오늘은 세션에 대해서 배웠습니다.', 'test2', '장선생', '2019-06-29 14:11:42', '', 4, 0, 0),
(8, '다섯번째 글', '다섯번째 글.', 'test1', '장형석', '2019-06-29 15:29:44', '', 8, 0, 0),
(9, '여섯번째', '육', 'test1', '장형석', '2019-06-29 15:29:52', '', 9, 0, 0),
(10, '일곱번째', 'php 수업', 'test1', '장형석', '2019-06-29 15:30:01', '', 10, 0, 0),
(11, '여덟번째', '글입니다.', 'test1', '장형석', '2019-06-29 15:30:11', '', 11, 0, 0),
(12, 'php 수업 시간', '수업은 라이브 코딩', 'test1', '장형석', '2019-06-29 15:30:32', '', 12, 0, 0),
(13, '드뎌 열번째', '글 입니다.', 'test1', '장형석', '2019-06-29 15:30:43', '', 13, 0, 0),
(14, '열한 번째', '글 입니다.', 'test1', '장형석', '2019-06-29 15:30:52', '', 14, 0, 0),
(15, '오늘은 php 세번째 시간', '오늘은 페이징처리와 검색을 배웠습니다.', 'test1', '김형석', '2019-07-06 14:37:40', '', 15, 0, 0),
(16, '파일 업로드를 해봅시다.', '파일 업로드 테스트.', 'test1', '장형석', '2019-07-13 13:23:50', '프리랜서계약서_홍정우.doc', 16, 0, 0),
(17, '이미지 파일 업로드', '이미지 파일을 업로드 해봅시다.', 'test1', '장형석', '2019-07-13 13:38:07', 'gamecoding2x.png', 17, 0, 0),
(18, '첫번째 답변글.', '답변이 제대로 들어갈까요?', 'test1', '장형석', '2019-07-13 14:10:22', '', 17, 1, 1),
(19, '두번째 답변', '두번째 답변글을 달아 봅시다.', 'test1', '장형석', '2019-07-13 14:17:02', '', 17, 2, 2),
(20, '신규 글 써보자', '신규글은 제대로 동작해야 하는데.', 'test1', '장형석', '2019-07-13 14:17:26', '', 20, 0, 0),
(21, '첨부 답변글', '첨부 답변글을 달아 봅시다.', 'test1', '장형석', '2019-07-13 14:18:22', '2018-09-05 (1).png', 17, 3, 3),
(22, '두번째의 두번째 답변', '제대로 들어갈까나...', 'test1', '장형석', '2019-07-13 14:48:48', '', 17, 6, 3),
(23, '사이 낑겨들어가기', '사이에 들어갈까나...', 'test1', '장형석', '2019-07-13 14:49:15', '', 17, 4, 4),
(24, '또다시 낑겨들어가기', '낑겨 들어가기 제대로 될까나.', 'test1', '장형석', '2019-07-13 15:00:24', '', 17, 5, 4),
(25, '세번째 낑기기', '세번째 낑기기.', 'test1', '장형석', '2019-07-13 15:06:29', '', 17, 5, 4),
(26, '또다시 낑기기에 들어가기', '들어가기 제대로 들어갈까나.', 'test1', '장형석', '2019-07-13 15:07:07', '', 17, 6, 5),
(27, '관리자님 큰일이예요.', '서버가 죽었어요.', 'test1', '장형석', '2019-07-13 15:25:22', '', 27, 0, 0),
(28, '관리자 주목', '서버가 에러났어요.', 'test1', '장형석', '2019-07-13 15:29:42', '', 28, 0, 0),
(29, '메일로 발송해보자.', '메일 발송 본문내용.', 'test1', '장형석', '2019-07-13 15:37:16', '', 29, 0, 0);

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
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
