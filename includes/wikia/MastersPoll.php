<?php

namespace Wikia;

/**
 * This class handles multiple masters in DB config
 *
 * @author macbre
 * @see PLATFORM-434
 */
class MastersPoll {
	# store server states in memcache (for 60 seconds)
	const SERVER_BROKEN = 'broken';
	const SERVER_STATUS_TTL = 60;

	private $conf;

	function __construct( Array $conf ) {
		$this->conf = $conf;
		$this->normalizeMultipleMasters();

		// ugly hack taken from LoadMonitor_MySQL
		global $wgMemc;
		if ( empty( $wgMemc ) ) {
			$wgMemc = wfGetMainCache();
		}
	}

	/**
	 * @return array
	 */
	function getConf() {
		return $this->conf;
	}

	/**
	 * Get secondary master node for given section
	 *
	 * This method is called when isMasterBroken() returns true
	 * for the "primary" master node  (i.e. selected by the fair dice roll)
	 *
	 * Return DB server settings array that can be used by LoadBalancer
	 *
	 * @param string $clusterInfo eg. main-c1, main-central
	 * @return bool|mixed
	 */
	function getNextMasterForSection($clusterInfo) {
		$cluserName = explode( '-', $clusterInfo )[1];

		wfDebug( sprintf( "%s: getting next master for %s\n", __CLASS__, $cluserName ) );

		$hosts = array_keys( $this->conf['mastersPoolBySection'][$cluserName] );
		$hostName = reset( $hosts );

		if ( !empty( $hostName ) ) {
			wfDebug( sprintf( "%s: using %s as next master for %s\n", __CLASS__, $hostName, $cluserName ) );

			// resolve settings for hostname
			$servers = wfGetLBFactory()->makeServerArray( $this->conf['serverTemplate'], [ $hostName => 1 ], [] );

			// return the first element
			return reset( $servers );
		}
		else {
			// master node not found
			return false;
		}
	}

	/**
	 * Normalize the list of multiple masters and slaves
	 *
	 * @param array $sectionLoads
	 * @author macbre
	 */
	private function normalizeMultipleMasters() {
		$this->conf['mastersPoolBySection'] = [];

		foreach ( $this->conf['sectionLoads'] as $sectionName => &$sectionConf ) {
			# section config has both "masters" and "slaves" section
			if ( isset( $sectionConf['masters'] ) && isset( $sectionConf['slaves'] ) ) {
				# randomize masters server and normalize the section config
				$master = array_rand( $sectionConf['masters'], 1 );

				wfDebug( sprintf( "%s: randomizing master for %s: picked %s\n", __CLASS__, $sectionName, $master ) );

				# store the rest of master nodes
				# we will try to use one of them if the one we picked is not responding
				$mastersPoll = $sectionConf['masters'];
				unset( $mastersPoll[$master] );

				$this->conf['mastersPoolBySection'][$sectionName] = $mastersPoll;
				wfDebug( sprintf( "%s: keeping masters pool for %s: %s\n", __CLASS__, $sectionName, join( ', ', array_keys( $mastersPoll ) ) ) );

				# make it flat
				$sectionConf = array( $master => $sectionConf['masters'][$master] ) + $sectionConf['slaves'];
			}
			else {
				$this->conf['mastersPoolBySection'][$sectionName] = [];
			}
		}
	}

	/**
	 * Mark given master node as broken
	 *
	 * This information will be stored in memcache for 60 seconds
	 * Subsequent requests will skip this master node
	 *
	 * @param array $serverEntry
	 */
	function markMasterAsBroken(Array $serverEntry) {
		$hostName = $serverEntry['hostName'];
		wfDebug( sprintf( "%s: marking '%s' as broken\n", __CLASS__, $hostName ) );

		\F::app()->wg->Memc->set( self::getStatusKeyForServer( $hostName ), self::SERVER_BROKEN, self::SERVER_STATUS_TTL );
	}

	/**
	 * Check if given master node is broken
	 *
	 * @param array $serverEntry
	 * @return bool
	 */
	function isMasterBroken(Array $serverEntry) {
		$hostName = $serverEntry['hostName'];

		wfDebug( sprintf( "%s: checking if '%s' is broken\n", __CLASS__, $hostName ) );
		$isBroken = \F::app()->wg->Memc->get( self::getStatusKeyForServer( $hostName ) ) === self::SERVER_BROKEN;

		if ( $isBroken ) {
			wfDebug( sprintf( "%s: '%s' is marked as broken\n", __CLASS__, $hostName ) );
		}

		return $isBroken;
	}

	static private function getStatusKeyForServer($hostName) {
		return wfSharedMemcKey( __CLASS__, 'status', $hostName );
	}
}