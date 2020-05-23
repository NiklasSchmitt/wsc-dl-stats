START TRANSACTION;

CREATE TABLE `plugins` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `pluginstore` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `stats` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `value` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


ALTER TABLE `plugins`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `stats`
  ADD PRIMARY KEY (`id`,`date`);

ALTER TABLE `plugins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
