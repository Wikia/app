<?php
/**
 * @package MediaWiki
 * @subpackage Maintenance

  Copyright: Wikia, Inc
  @author Łukasz "Egon" Matysiak; egon@wikia.com
  @author Lucas 'TOR' Garczewski <tor@wikia-inc.com> (tweaks)

  This script generates local table of users containing users wich have 
  adleast one contribution on Wiki, or belong to any group.
*/

require_once( dirname(__FILE__).'/../commandLine.inc' );

print ("Building local users table for database: wgSharedDB='$wgSharedDB', wgDBname='$wgDBname' with user='$wgDBuser'\n");

$local_users_table = 'local_users';

$db =& wfGetDB( DB_MASTER );

# Auxiliary variable declarations
list ($user, $user_groups, $revision) = $db->tableNamesN('user','user_groups','revision');
$local_users_table = 'local_users';

unset($wgSharedDB); # To prevent inserts from going into shared user DB

print ("got variables: user='$user', user_groups='$user_groups', revision='$revision'\n");

$db->selectDB($wgDBname);

# Cleanup and table creation (just in case)

$db->query( "CREATE TABLE IF NOT EXISTS user_rev_cnt 
(rev_user int(5) unsigned primary key,
rev_cnt int );" );

$db->query("truncate table user_rev_cnt;");

$db->query("CREATE TABLE IF NOT EXISTS `$local_users_table` (
  `user_name` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `user_id` int(5) unsigned default NULL,
  `numgroups` bigint(21) NOT NULL default '0',
  `singlegroup` char(16) default NULL,
  `rev_cnt` int(11) default NULL,
  UNIQUE KEY `user_name_index` (`user_name`),
  UNIQUE KEY `user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;");

$db->query("truncate table $local_users_table;");

# Table population

$sql0 = "insert into `user_rev_cnt` 
(select rev_user, count(*) as rev_cnt 
from $revision 
group by rev_user)
ON DUPLICATE KEY UPDATE rev_cnt=values(rev_cnt);";

$sql1 = "INSERT INTO $local_users_table 
SELECT user_name, MAX(user_id) AS user_id, COUNT(ug_group) AS numgroups, MAX(ug_group) AS singlegroup, rev_cnt 
FROM $user LEFT JOIN $user_groups ON user_id=ug_user JOIN user_rev_cnt ON user_id=rev_user GROUP BY user_name ORDER BY user_name;";

$sql2 = "INSERT INTO $local_users_table
SELECT user_name, MAX(user_id) AS user_id, COUNT(ug_GROUP) AS numgroups, MAX(ug_group) AS singlegroup, rev_cnt 
FROM $user JOIN $user_groups ON user_id=ug_user LEFT JOIN user_rev_cnt ON user_id=rev_user GROUP BY user_name ORDER BY user_name 
ON DUPLICATE KEY UPDATE rev_cnt=values(rev_cnt);";

$result0 = $db->query($sql0);
$result1 = $db->query($sql1);
$result2 = $db->query($sql2);

print ("Result='$result0,$result1,$result2'; Done\n");

if ( function_exists( 'wfWaitForSlaves' ) ) {
	wfWaitForSlaves( 10 );
} else {
	sleep( 1 );
}
