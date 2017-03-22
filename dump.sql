-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 01 2013 г., 00:06
-- Версия сервера: 5.6.10-log
-- Версия PHP: 5.4.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `task`
--
CREATE DATABASE `task` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `task`;

-- --------------------------------------------------------

--
-- Структура таблицы `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `text` varchar(500) NOT NULL,
  `question_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__question` (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='ответы' AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Структура таблицы `interviews`
--

CREATE TABLE IF NOT EXISTS `interviews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `type` enum('draft','active','closed') NOT NULL DEFAULT 'draft',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='опросы' AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `interview_id` int(10) unsigned NOT NULL,
  `text` varchar(500) NOT NULL,
  `type` enum('multiple','single') NOT NULL DEFAULT 'single',
  `required` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK__interview` (`interview_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='вопросы' AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Структура таблицы `results`
--

CREATE TABLE IF NOT EXISTS `results` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `interview_id` int(10) unsigned NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__interviews` (`interview_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='результаты' AUTO_INCREMENT=6 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `FK__question` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `FK__interview` FOREIGN KEY (`interview_id`) REFERENCES `interviews` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `FK__interviews` FOREIGN KEY (`interview_id`) REFERENCES `interviews` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
