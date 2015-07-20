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
	 * @return array|bool An array if the data is cached, false otherwise.
	 */
	public function get() {
		return $this->memcache->get( $this->getMemcKey() );
	}

	/**
	 * Saves all instances of flagged pages on wikia in the memcache.
	 * @param int $pageId
	 * @param array $flags
	 */
	public function set( Array $flags ) {
		$this->memcache->set(
			$this->getMemcKey(),
			$flags,
			\WikiaResponse::CACHE_LONG
		);
	}

	/**
	 * Purges the data on instances of flagged pages on wikia.
	 */
	public function purge() {
		$this->memcache->delete( $this->getMemcKey() );
	}

	/**
	 * Returns a memcache key for data on flag types with and without instances available for the page.
	 * @return String A memcache key
	 */
	private function getMemcKey() {
		return wfMemcKey(
			self::FLAGS_MEMC_KEY_PREFIX,
			'flaggedPages',
			self::FLAGS_MEMC_VERSION
		);
	}
}
