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
	const SERVER_BROKEN = true;
	const SERVER_STATUS_TTL = 60;

	private $conf;

	function __construct( Array $conf ) {
		$this->conf = $conf;
		$this->normalizeMultipleMasters();
	}

	/**
	 * @return array
	 */
	function getConf() {
		return $this->conf;
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
	static function markMasterAsBroken(Array $serverEntry) {
		$hostName = $serverEntry['hostName'];
		wfDebug( sprintf( "%s: marking '%s' as broken\n", __CLASS__, $hostName ) );

		\F::app()->wg->Memc->set( self::getStatusKeyForServer( $hostName ), self::SERVER_BROKEN, self::SERVER_STATUS_TTL );
	}

	static function getStatusKeyForServer($hostName) {
		return wfSharedMemcKey( __CLASS__, 'status', $hostName );
	}
}