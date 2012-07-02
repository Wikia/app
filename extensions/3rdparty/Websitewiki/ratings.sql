CREATE TABLE IF NOT EXISTS `ratings` (
`id` varchar(128) NOT NULL default '',
`total_votes` int(11) NOT NULL default '0',
`total_value` int(11) NOT NULL default '0',
`used_ips` longtext,
PRIMARY KEY  (`id`)
);
