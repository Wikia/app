<?php
/**
 * Hooks for Usability Initiative PrefStats extension
 *
 * @file
 * @ingroup Extensions
 */

class PrefStatsHooks {

	/* Static Functions */
	public static function schema() {
		global $wgExtNewTables;
		$wgExtNewTables[] = array( 'prefstats',
			dirname( __FILE__ ) . '/PrefStats.sql' );
		return true;
	}

	public static function save( $user, &$options ) {
		global $wgPrefStatsEnable, $wgPrefStatsTrackPrefs;
		if ( !$wgPrefStatsEnable )
			return;

		$dbw = wfGetDb( DB_MASTER );
		foreach ( $wgPrefStatsTrackPrefs as $pref => $value ) {
			$start = $dbw->selectField( 'prefstats',
				'ps_start', array(
					'ps_user' => $user->getId(),
					'ps_pref' => $pref,
					'ps_end IS NULL'
				), __METHOD__ );
			if ( isset( $options[$pref] ) && $options[$pref] == $value && !$start )
				$dbw->insert( 'prefstats', array(
						'ps_user' => $user->getId(),
						'ps_pref' => $pref,
						'ps_value' => $value,
						'ps_start' => $dbw->timestamp( wfTimestamp() ),
						'ps_end' => null,
						'ps_duration' => null
					), __METHOD__, array( 'IGNORE' ) );
			else if ( ( !isset( $options[$pref] ) || $options[$pref] != $value ) && $start ) {
				if ( $start ) {
					$duration = wfTimestamp( TS_UNIX ) -
						wfTimestamp( TS_UNIX, $start );
					$dbw->update( 'prefstats', array(
							'ps_end' => $dbw->timestamp( wfTimestamp() ),
							'ps_duration' => $duration
						), array(
							'ps_user' => $user->getId(),
							'ps_pref' => $pref,
							'ps_start' => $dbw->timestamp( $start )
						), __METHOD__ );
				}
			}
		}
		return true;
	}
}
