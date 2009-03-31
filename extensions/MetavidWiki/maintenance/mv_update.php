<?
// eventually should fix to use mediaWiki format
// for now just has little scripts for doing database operations

// include commandLine.inc from the mediaWiki maintance dir:
require_once ( '../../../maintenance/commandLine.inc' );

$dbclass = 'Database' . ucfirst( $wgDBtype ) ;

# Attempt to connect to the database as a privileged user
# This will vomit up an error if there are permissions problems

$wgDatabase = new $dbclass( $wgDBserver, $wgDBadminuser, $wgDBadminpassword, $wgDBname, 1 );


// do mvd_index text removal update:
// check if mvd_index has text field
$page_id_added = false;

// install the new search index tables:
if ( !$wgDatabase->tableExists( 'mv_search_digest' ) ) {
	echo 'CREATE TABLE mv_search_digest' . "\n";
	$wgDatabase->query( 'CREATE TABLE IF NOT EXISTS `mv_search_digest` (
  `id` int(11) NOT NULL auto_increment,
  `query_key` varchar(128) character set utf8 collate utf8_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `query` (`query_key`,`time`)
) ENGINE=MyISAM' );
}
if ( !$wgDatabase->tableExists( 'mv_clipview_digest' ) ) {
	echo 'CREATE TABLE mv_clipview_digest' . "\n";
	$wgDatabase->query( " CREATE TABLE IF NOT EXISTS `mv_clipview_digest` (
  `id` int(11) NOT NULL auto_increment,
  `query_key` int(33) NOT NULL,
  `stream_id` int(11) unsigned NOT NULL,
  `start_time` int(10) unsigned NOT NULL default '0',
  `end_time` int(10) unsigned NOT NULL,
  `view_date` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `stream_id` (`stream_id`,`start_time`,`end_time`,`view_date`),
  KEY `query_key` (`query_key`)
) ENGINE=MyISAM ;" );
}
if ( !$wgDatabase->tableExists( 'mv_query_key_lookup' ) ) {
	echo 'CREATE TABLE mv_query_key_lookup' . "\n";
	$wgDatabase->query( "CREATE TABLE IF NOT EXISTS `mv_query_key_lookup` (
  `query_key` varchar(128) NOT NULL,
  `filters` text NOT NULL,
  PRIMARY KEY  (`query_key`)
) ENGINE=MyISAM ;" );
}

if ( !$wgDatabase->fieldExists( 'mv_mvd_index', 'view_count' ) ) {
	echo '`mv_mvd_index` ADD `view_count`' . "\n";
	$wgDatabase->query( "ALTER TABLE `mv_mvd_index` ADD `view_count` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `end_time`" );
}
//make sure enum for path_type is valid: 
$res = $wgDatabase->query( 'DESCRIBE mv_stream_files');
while($row = $wgDatabase->fetchObject( $res )){
	if($row->Field =='path_type' ){
		if($row->path_type != "enum('url_anx', 'wiki_title', 'url_file', 'mp4_stream')"){
			$wgDatabase->query( " ALTER TABLE `mv_stream_files` CHANGE `path_type` `path_type` ENUM( 'url_anx', 'wiki_title', 'url_file', 'mp4_stream' ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'url_anx'" );			
		}
	}	
}

// add view_count index:
if ( !$wgDatabase->indexExists( 'mv_mvd_index', 'view_count' ) ) {
	$wgDatabase->query( "ALTER TABLE `mv_mvd_index` ADD INDEX ( `view_count` )" );
}
/*modify mvd_table index structure for more "cardinality"/faster queries*/
if ( $wgDatabase->indexExists( 'mv_mvd_index', 'mvd_type' ) ) {
 	$wgDatabase->query( "ALTER TABLE `mv_mvd_index` DROP INDEX `mvd_type`" );
}
if ( $wgDatabase->indexExists( 'mv_mvd_index', 'stream_id' ) ) {
	$wgDatabase->query( "ALTER TABLE `mv_mvd_index` DROP INDEX `stream_id`" );
}
if ( $wgDatabase->indexExists( 'mv_mvd_index', 'stream_time_start' ) ) {
	$wgDatabase->query( "ALTER TABLE `mv_mvd_index` DROP INDEX `stream_time_start`" );
}
// add missing indexes:
if ( !$wgDatabase->indexExists( 'mv_mvd_index', 'mvd_stream_index' ) ) {
	print "rebuilding mvd index ... this may take \"some time\"\n";
	$wgDatabase->query( " ALTER TABLE `mv_mvd_index` ADD INDEX `mvd_stream_index` ( `stream_id` , `start_time` , `end_time` )" );
}
if ( !$wgDatabase->indexExists( 'mv_mvd_index', 'mvd_type_index' ) ) {
	$wgDatabase->query( " ALTER TABLE `mv_mvd_index` ADD INDEX `mvd_type_index` (`mvd_type`, `stream_id`)" );
}

if ( !$wgDatabase->fieldExists( 'mv_mvd_index', 'mv_page_id' ) ) {
	print "mv_mvd_index missing `page_id`...adding\n ";
	$page_id_added = true;
	// add page_id
	$wgDatabase->query( "ALTER TABLE `mv_mvd_index` ADD `mv_page_id` INT( 10 ) UNSIGNED NOT NULL AFTER `id`" );
}
// if we added do lookups
if ( $page_id_added ) {
	$sql = "SELECT SQL_CALC_FOUND_ROWS `id`, `wiki_title` FROM `mv_mvd_index`";
	$result = $wgDatabase->query( $sql );
	echo 'updating ' . $wgDatabase->numRows( $result ) . " mvd rows \n";
	$c = $wgDatabase->numRows( $result );
	$i = $j = 0;
	$page_table =  $wgDatabase->tableName( 'page' );
	while ( $mvd_row = $wgDatabase->fetchObject( $result ) ) {
		$sql_pid = "SELECT `page_id` FROM $page_table " .
			"WHERE `page_title`='{$mvd_row->wiki_title}' " .
			"AND `page_namespace`=" . MV_NS_MVD . ' LIMIT 1';
		$pid_res = 	$wgDatabase->query( $sql_pid );
		if ( $wgDatabase->numRows( $pid_res ) != 0 ) {
			$pid_row = 	 $wgDatabase->fetchObject( $pid_res );
			$upSql = "UPDATE `mv_mvd_index` SET `mv_page_id`=$pid_row->page_id " .
					"WHERE `id`={$mvd_row->id} LIMIT 1";
			$wgDatabase->query( $upSql );
		} else {
			print "ERROR: mvd row:{$mvd_row->wiki_title} missing page (removed)\n ";
			$wgDatabase->query( "DELETE FROM `mv_mvd_index` WHERE `id`=" . $mvd_row->id . ' LIMIT 1' );
			// die;
		}
		// status updates:
		if ( $i == 100 ) {
			print "on $j of  $c mvd rows\n";
			$i = 0;
		}
		$i++;
		$j++;
	}
	// now we can drop id and add PRIMARY to mv_page_id
	print "DROP id COLUMN from mv_mvd_index ...";
	$wgDatabase->query( "ALTER TABLE `mv_mvd_index` DROP PRIMARY KEY, DROP COLUMN `id`, DROP COLUMN `text`" );
	print "done\n";

	// now add UNIQUE to mv_mvd_index
	print "ADD PRIMARY to mv_page_id ...";
	$wgDatabase->query( "ALTER TABLE `mv_mvd_index` ADD PRIMARY KEY(`mv_page_id`)" );
	print "done\n";
}

print "done with db tables update check\n";
