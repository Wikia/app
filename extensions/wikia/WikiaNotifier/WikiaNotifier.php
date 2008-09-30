<?php
/*
Author: Piotr Molski (moli@wikia.com)
*/

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
	$dbw = wfGetDBExt( DB_MASTER );

	$nl_id = $dbw->nextSequenceValue( 'notify_log_nl_id_seq' );
	$dbw->insert(
		array( "notify_log"),
		array(
			'nl_id' 		=> $nl_id,
			'nl_city'		=> intval($wgCityId),
			'nl_type'		=> $notify_type,
			'nl_editor' 	=> $editor_id,
			'nl_watcher'	=> $watcher_id,
			'nl_title' 		=> $title->getDBkey(),
			'nl_namespace' 	=> $namespace,
			'nl_timestamp'	=> $dbw->timestamp($timestamp)
		),
		__METHOD__
	);
	wfProfileOut( __METHOD__ );
	return true;
}
