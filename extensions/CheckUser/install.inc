<?php

require "cu_log_import.inc";

define( 'BATCH_SIZE', 100 );

function create_cu_changes( $db, $cutoff = null ) {
	global $wgDBtype;
	if( !$db->tableExists( 'cu_changes' ) ) {
		$sourcefile = $wgDBtype === 'postgres' ? '/cu_changes.pg.sql' : '/cu_changes.sql';
		$db->sourceFile( dirname( __FILE__ ) . $sourcefile );
	}

	echo "...cu_changes table added.\n";
	// Check if the table is empty
	$rcRows = $db->selectField( 'recentchanges', 'COUNT(*)', false, __FUNCTION__ );
	if ( !$rcRows ) {
		echo "recentchanges is empty; nothing to add.\n";
		return;
	}

	if( $cutoff ) {
		// Something leftover... clear old entries to minimize dupes
		$encCutoff = $db->addQuotes( $db->timestamp( $cutoff ) );
		$db->delete( 'cu_changes',
			array( "cuc_timestamp < $encCutoff" ),
			__METHOD__ );
		$cutoffCond = "AND rc_timestamp < $encCutoff";
	} else {
		$cutoffCond = "";
	}

	$start = $db->selectField( 'recentchanges', 'MIN(rc_id)', false, __FUNCTION__ );
	$end = $db->selectField( 'recentchanges', 'MAX(rc_id)', false, __FUNCTION__ );
	# Do remaining chunk
	$end += BATCH_SIZE - 1;
	$blockStart = $start;
	$blockEnd = $start + BATCH_SIZE - 1;

	$db->begin();
	while ( $blockStart <= $end ) {
		echo "...doing rc_id from $blockStart to $blockEnd\n";
		$cond = "rc_id BETWEEN $blockStart AND $blockEnd $cutoffCond";
		$res = $db->select( 'recentchanges', '*', $cond, __FUNCTION__ );
		$batch = array();
		foreach ( $res as $row ) {
			$batch[] = array(
				'cuc_timestamp' => $row->rc_timestamp,
				'cuc_user' => $row->rc_user,
				'cuc_user_text' => $row->rc_user_text,
				'cuc_namespace' => $row->rc_namespace,
				'cuc_title' => $row->rc_title,
				'cuc_comment' => $row->rc_comment,
				'cuc_minor' => $row->rc_minor,
				'cuc_page_id' => $row->rc_cur_id,
				'cuc_this_oldid' => $row->rc_this_oldid,
				'cuc_last_oldid' => $row->rc_last_oldid,
				'cuc_type' => $row->rc_type,
				'cuc_ip' => $row->rc_ip,
				'cuc_ip_hex' => IP::toHex( $row->rc_ip ),
			);
		}
		if ( count( $batch ) ) {
			$db->insert( 'cu_changes', $batch, __FUNCTION__ );
		}
		$blockStart += BATCH_SIZE - 1;
		$blockEnd += BATCH_SIZE - 1;
		wfWaitForSlaves( 5 );
	}
	$db->commit();

	echo "...cu_changes table added and populated.\n";
}

function create_cu_log( $db ) {
	global $wgDBtype, $wgCheckUserLog;
	if( $db->tableExists( 'cu_log' ) ) {
		echo "...cu_log already exists\n";
		return;
	}

	$sourcefile = $wgDBtype === 'postgres' ? '/cu_log.pg.sql' : '/cu_log.sql';
	$db->sourceFile( dirname( __FILE__ ) . $sourcefile );

	echo "...cu_log added\n";

	if( empty( $wgCheckUserLog ) ) {
		echo "...logging disabled, skipping log import.\n";
		return;
	}

	if( !file_exists( $wgCheckUserLog ) ) {
		echo "...log file missing, skipping log import.\n";
		return;
	}

	echo "...importing old CheckUser log file...\n";
	import_cu_log( $db, $wgCheckUserLog );
}
