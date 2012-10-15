<?php
/**
 * This script populates the prefstats table
 *
 * @file
 * @ingroup Extensions
 */

require_once( '../../../maintenance/commandLine.inc' );

$dbw = wfGetDB( DB_MASTER );
foreach ( $wgPrefStatsTrackPrefs as $pref => $value ) {
	echo "Populating $pref=$value ... ";
	$dbw->insertSelect( 'prefstats', 'user_properties', array(
			'ps_user' => 'up_user',
			'ps_pref' => 'up_property',
			'ps_value' => 'up_value',
			'ps_start' => $dbw->addQuotes( $dbw->timestamp( wfTimestamp() ) ),
			'ps_duration' => 0
		), array(
			'up_property' => $pref,
			'up_value' => $value
		), __METHOD__, array( 'IGNORE' )
	);
	echo "done\n";
}
