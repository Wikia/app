<?php

function import_cu_log_line( $line ) {
	$rxTimestamp = '(?P<timestamp>\d+:\d+, \d+ \w+ \d+)';
	$rxUser = '(?P<user>.*?)';
	$rxTarget = '(?P<target>.*?)';
	$rxWiki = '(?P<wiki>[^)]*?)';
	$rxReason = '(?: \("(?P<reason>.*)"\))?';

	// Strip nulls due to NFS write collisions
	$line = str_replace( "\0", "", $line );

	$regexes = array(
		'ipedits-xff' => "!^<li>$rxTimestamp, $rxUser got edits for XFF $rxTarget on $rxWiki$rxReason</li>!",
		'ipedits'     => "!^<li>$rxTimestamp, $rxUser got edits for" ." $rxTarget on $rxWiki$rxReason</li>!",
		'ipusers-xff' => "!^<li>$rxTimestamp, $rxUser got users for XFF $rxTarget on $rxWiki$rxReason</li>!",
		'ipusers'     => "!^<li>$rxTimestamp, $rxUser got users for" ." $rxTarget on $rxWiki$rxReason</li>!",
		'userips'     => "!^<li>$rxTimestamp, $rxUser got IPs for".   " $rxTarget on $rxWiki$rxReason</li>!" );

	foreach ( $regexes as $type => $regex ) {
		$m = false;
		if ( preg_match( $regex, $line, $m ) ) {

			$data = array(
				'timestamp' => strtotime( $m['timestamp'] ),
				'user' => $m['user'],
				'reason' => isset( $m['reason'] ) ? $m['reason'] : '',
				'type' => $type,
				'wiki' => $m['wiki'],
				'target' => $m['target'] );

			return $data;
		}
	}
}

function import_cu_log( $db, $log ) {
	global $wgDBname;

	$file = fopen( $log, 'r' );

	$matched = 0;
	$unmatched = 0;

	while ( false !== ( $line = fgets( $file ) ) ) {
		$data = import_cu_log_line( $line );
		if( $data ) {
			if ( $data['wiki'] != wfWikiID() && $data['wiki'] != $wgDBname ) {
				$unmatched++;
				continue;
			}

			// Local wiki lookups...
			$user = User::newFromName( $data['user'] );

			list( $start, $end ) = IP::parseRange( $data['target'] );
			if ( $start === false ) {
				$targetUser = User::newFromName( $data['target'] );
				$targetID = $targetUser ? $targetUser->getID() : 0;
				$start = $end = $hex = '';
			} else {
				$hex = $start;
				if ( $start == $end ) {
					$start = $end = '';
				}
				$targetID = 0;
			}

			if( $db ) {
				$fields = array(
					'cul_id' => $db->nextSequenceValue( 'cu_log_cul_id_seq' ),
					'cul_timestamp' => $db->timestamp( $data['timestamp'] ),
					'cul_user' => $user->getID(),
					'cul_user_text' => $user->getName(),
					'cul_reason' => $data['reason'],
					'cul_type' => $data['type'],
					'cul_target_id' => $targetID,
					'cul_target_text' => $data['target'],
					'cul_target_hex' => $hex,
					'cul_range_start' => $start,
					'cul_range_end' => $end );

				$db->insert( 'cu_log', $fields, __METHOD__ );
			}

			$matched++;
		}
		$unmatched ++;
	}
	echo "...cu_log table populated: $matched matched rows, $unmatched discarded rows\n";
}
