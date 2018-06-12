DROP TABLE IF EXISTS `wikiastaff_log`;
CREATE TABLE `wikiastaff_log` (
  `slog_id` int(10) unsigned NOT NULL,
  `slog_type` varbinary(10) NOT NULL DEFAULT '',
  `slog_action` varbinary(10) NOT NULL DEFAULT '',
  `slog_timestamp` binary(14) NOT NULL DEFAULT '19700101000000',
  `slog_user` int(10) unsigned NOT NULL DEFAULT '0',
  `slog_userdst` int(10) unsigned NOT NULL DEFAULT '0',
  `slog_comment` blob,
  `slog_params` blob,
  `slog_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `slog_site` varbinary(200) DEFAULT NULL,
  `slog_user_name` varbinary(255) NOT NULL,
  `slog_user_namedst` varbinary(255) NOT NULL,
  `slog_city` int(11) DEFAULT NULL
  );