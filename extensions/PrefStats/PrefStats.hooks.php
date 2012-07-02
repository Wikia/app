<?php
/**
 * Hooks for PrefStats extension
 *
 * @file
 * @ingroup Extensions
 */

class PrefStatsHooks {

	/* Static Methods */

	/**
	 * LoadExtensionSchemaUpdates hook
	 */
	public static function loadExtensionSchemaUpdates( $updater = null ) {
		if ( $updater === null ) {
			global $wgExtNewTables;
			$wgExtNewTables[] = array( 'prefstats', dirname( __FILE__ ) . '/patches/PrefStats.sql' );
		} else {
			$updater->addExtensionUpdate( array( 'addTable', 'prefstats',
				dirname( __FILE__ ) . '/patches/PrefStats.sql', true ) );
		}
		return true;
	}

	/**
	 * UserSaveOptions hook
	 */
	public static function userSaveOptions( $user, &$options ) {
		global $wgPrefStatsEnable, $wgPrefStatsTrackPrefs;

		if ( !$wgPrefStatsEnable ) {
			return;
		}

		$dbw = wfGetDB( DB_MASTER );
		foreach ( $wgPrefStatsTrackPrefs as $pref => $value ) {
			$start = $dbw->selectField(
				'prefstats',
				'ps_start',
				array(
					'ps_user' => $user->getId(),
					'ps_pref' => $pref,
					'ps_end IS NULL'
				),
				__METHOD__
			);
			if ( isset( $options[$pref] ) && $options[$pref] == $value && !$start ) {
				$dbw->insert(
					'prefstats',
					array(
						'ps_user' => $user->getId(),
						'ps_pref' => $pref,
						'ps_value' => $value,
						'ps_start' => $dbw->timestamp( wfTimestamp() ),
						'ps_end' => null,
						'ps_duration' => null
					),
					__METHOD__,
					array( 'IGNORE' )
				);
			} elseif ( ( !isset( $options[$pref] ) || $options[$pref] != $value ) && $start ) {
				if ( $start ) {
					$duration = wfTimestamp( TS_UNIX ) - wfTimestamp( TS_UNIX, $start );
					$dbw->update(
						'prefstats',
						array(
							'ps_end' => $dbw->timestamp( wfTimestamp() ),
							'ps_duration' => $duration
						),
						array(
							'ps_user' => $user->getId(),
							'ps_pref' => $pref,
							'ps_start' => $dbw->timestamp( $start )
						),
						__METHOD__
					);
				}
			}
		}
		return true;
	}
}
