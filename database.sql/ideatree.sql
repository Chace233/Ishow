-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2017-03-21 21:57:52
-- 服务器版本: 5.00.15
-- PHP 版本: 5.5.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `ishow`
--

-- --------------------------------------------------------

--
-- 表的结构 `ideatree`
--

CREATE TABLE IF NOT EXISTS `ideatree` (
  `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT '节点id',
  `pid` int(11) DEFAULT NULL COMMENT '父节点id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `text` text COLLATE utf8_unicode_ci NOT NULL COMMENT '内容',
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `ideatree`
--

INSERT INTO `ideatree` (`tid`, `pid`, `uid`, `text`) VALUES
(1, NULL, 12, '哈哈'),
(4, 1, 15, '我也觉得'),
(2, 1, 13, '楼上哈哈是二逼'),
(5, 1, 16, '赞同'),
(6, 2, 12, '你们楼上才是逗比'),
(7, 2, 12, '修正一下，免得极端'),
(8, 4, 12, '你们楼上才是逗比');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
