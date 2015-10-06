<?php

/**
 * A helper class to manage data cached for list of pages marked with flag.
 * It generates unified cache keys and provides all necessary methods to get, set and delete the data.
 *
 * @author Kamil Koterba <kamil@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

namespace Flags;

class FlaggedPagesCache {
	const FLAGS_MEMC_KEY_PREFIX = 'flaggedPagesData';
	const FLAGS_MEMC_VERSION = '1.5';

	private $memcache;

	function __construct() {
		$this->memcache = \F::app()->wg->Memc;
	}

	/**
	 * Tries to get all instances of flagged pages on wikia from memcache.
	 * @param int|null $flagTypeId Indicates that set of flags is related to this type id (Used for mcache key)
	 * @return array|bool An array if the data is cached, false otherwise.
	 */
	public function get( $flagTypeId = null ) {
		return $this->memcache->get( $this->getMemcKey( $flagTypeId ) );
	}

	/**
	 * Saves all instances of flagged pages on wikia in the memcache.
	 * @param int|null $flagTypeId Indicates that set of flags is related to this type id (Used for mcache key)
	 * @param array $flags
	 */
	public function set( Array $flags, $flagTypeId = null ) {
		$this->memcache->set(
			$this->getMemcKey( $flagTypeId ),
			$flags,
			\WikiaResponse::CACHE_LONG
		);
	}

	/**
	 * Purges the data on instances of flagged pages on wikia.
	 */
	public function purgeAllFlagTypes() {
		$flagTypes = \F::app()->sendRequest( 'FlagsApiController', 'getFlagTypes' )->getData()['data'];
		foreach( $flagTypes as $flagType ) {
			$this->purge( $flagType['flag_type_id'] );
		}
	}

	public function purgeFlagTypesByIds( Array $flagIds ) {
		foreach( $flagIds as $flagId ) {
			$this->purge( $flagId );
		}
	}

	/**
	 * Purges the data on instances of flagged pages on wikia.
	 * @param int|null $flagTypeId makes key per flag type specific
	 */
	public function purge( $flagTypeId ) {
		$this->memcache->delete( $this->getMemcKey( $flagTypeId ) );
	}

	/**
	 * Returns a memcache key for data on flag types with and without instances available for the page.
	 * @param int|null $flagTypeId makes key per flag type specific
	 * @return String A memcache key
	 */
	private function getMemcKey( $flagTypeId = null ) {
		return wfMemcKey(
			self::FLAGS_MEMC_KEY_PREFIX,
			$flagTypeId,
			self::FLAGS_MEMC_VERSION
		);
	}
}
