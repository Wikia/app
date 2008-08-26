<?php
/*
Author: Piotr Molski (moli@wikia.com)
*/

define ('NOTIFY_TABLE', "CREATE TABLE `_wikialogs_`.`notify_log` (`nl_id` int(11) NOT NULL auto_increment,`nl_city` int(11) NOT NULL, `nl_type` char(32) NOT NULL,`nl_editor` int(6) NOT NULL,`nl_watcher` int(6) NOT NULL,`nl_title` varchar(255) NOT NULL,`nl_namespace` int(11) NOT NULL,`nl_timestamp` char(14) default NULL,PRIMARY KEY (`nl_id`),KEY `nl_watcher` (`nl_watcher`),KEY `nl_editor` (`nl_editor`),KEY `nl_title` (`nl_title`, `nl_namespace`),KEY `nl_type` (`nl_type`, `nl_timestamp`), KEY `nl_city` (`nl_city`)) ENGINE=InnoDB DEFAULT CHARSET=latin1");

$wgHooks['NotifyOnPageChangeComplete'][] = 'wfNotifyOnPageChangeComplete';

function wfNotifyOnPageChangeComplete($title, $timestamp, $watcher) {
	global $wgCityId, $wgDBname, $wgUser, $wgCityId;
    wfProfileIn( __METHOD__ );

	$watcher_id = intval($watcher->getID());
	$editor_id = intval($wgUser->getID());
	if ( empty($watcher) ) {
		wfProfileOut( __METHOD__ );
		return true;
	}
	if ( !empty($watcher) && empty($watcher_id) ) {
		wfProfileOut( __METHOD__ );
		return true;
	}
	if ( empty($title) || !($title instanceof Title) ) {
		wfProfileOut( __METHOD__ );
		return true;
	}
	$namespace = $title->getNamespace();
	if ( $namespace < 0 ) {
		wfProfileOut( __METHOD__ );
		return true;
	}

	if ( empty($wgCityId) ) {
		wfProfileOut( __METHOD__ );
		return true;
	}

	$notify_type = "notifyonpagechange";
	$dbw =& wfGetDB( DB_MASTER );
	if (!$dbw->tableExists("`_wikialogs_`.`notify_log`")) {
		$dbw->query(NOTIFY_TABLE);
	}

	$nl_id = $dbw->nextSequenceValue( 'notify_log_nl_id_seq' );
	$dbw->insert("`_wikialogs_`.`notify_log`", array(
		'nl_id' 		=> $nl_id,
		'nl_city'		=> intval($wgCityId),
		'nl_type'		=> $notify_type,
		'nl_editor' 	=> $editor_id,
		'nl_watcher'	=> $watcher_id,
		'nl_title' 		=> $title->getDBkey(),
		'nl_namespace' 	=> $namespace,
		'nl_timestamp'	=> $dbw->timestamp($timestamp)
	), __METHOD__);
	wfProfileOut( __METHOD__ );
	return true;
}
