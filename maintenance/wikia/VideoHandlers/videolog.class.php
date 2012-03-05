<?php

function videoLog($action, $status, $description) {
	global $wgCityId, $wgExternalDatawareDB;
	$dbw_dataware = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

	$dbw_dataware->insert(
		'video_migration_log',
		array(
			'wiki_id'		=> $wgCityId,
			'action_name'	=> $action,
			'action_time'	=> wfTimestampNow(),
			'action_status'	=> $status,
			'action_desc'	=> $description,
		)
	);

}