<?php

/**
 * @author Lucas 'TOR' Garczewski <tor@wikia-inc.com>
 * @date 2011-10-03
 *
 * This produces a simple report of user skin settings and mails it to the specified address
 */

require( '../../commandLine.inc' );

$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

$sql = 'SELECT count( up_user ) as number, up_value from user_properties where up_property = "skin" group by up_value';

$res = $dbr->query( $sql );

$mailBody = '';

while( $row = $dbr->fetchObject( $res ) ) {
	if ( empty( $row->up_value ) ) {
		$skinName = '(empty)'; 
	} else {
		$skinName = $row->up_value;
	}

	$mailBody .= $skinName . ":\n" . $row->number . "\n\n";
}

mail(
	'commteam-l@wikia-inc.com',
	'Weekly Report: User skin usage',
	$mailBody
);
