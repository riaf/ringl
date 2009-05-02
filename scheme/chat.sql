CREATE TABLE `CHAT_MESSAGE` (
  `id` int(14) unsigned NOT NULL auto_increment,
  `name` blob NOT NULL,
  `description` blob NOT NULL,
  `create_date` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
