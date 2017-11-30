<?php

/**
 * Script that makes phalanx_stats table store either user_id or IP address
 *
 * @see SUS-3454
 * @author macbre
 * @file
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/../../../../maintenance/commandLine.inc' );

$db = wfGetDB( DB_MASTER, [], $wgSpecialsDB );
$rows = 0;

do {

	// first, fetch rows that were not yet migrated
	$res = $db->select(
		'phalanx_stats',
		[
			'ps_id',
			'ps_blocked_user',
		],
		[
			'ps_blocked_user_id IS NULL',
		],
		__FILE__,
		[
			'LIMIT' => 500
		]
	);

	$affectedRows = $db->affectedRows();

	foreach($res as $row) {
		$user = User::newFromName($res->ps_blocked_user);

		$db->update(
			'phalanx_stats',
			[
				'ps_blocked_user_id' => $user->getId(),
				// keep an IP address for anon entries, empty string for users
				'ps_blocked_user' => $user->isAnon() ? $user->getName() : '',
			],
			[
				'ps_id' => $row->ps_id
			],
			__FILE__ . '::update'
		);
	}

	wfWaitForSlaves( $db->getDBname() );

	echo '.';

} while ( $affectedRows > 0 );

echo sprintf( "\n%s: updated %d rows in phalanx_stats\n", date( 'r' ), $rows );
