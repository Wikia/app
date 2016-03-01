<?php

/**
 * A helper class to manage data cached by the extension.
 * It generates unified cache keys and provides all necessary methods to get, set and delete the data.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

namespace Flags;

use Flags\Models\FlagsBaseModel;
use Flags\Models\FlagType;

class FlagsCache {
	const FLAGS_MEMC_KEY_PREFIX = 'flagsData';
	const FLAGS_MEMC_VERSION = '1.6';

	private $memcache;

	function __construct() {
		$this->memcache = \F::app()->wg->Memc;
	}

	/**
	 * Cache all types of flags for a wikia.
	 */

	/**
	 * Tries to get all types of flags available for the wikia from memcache.
	 * @param int $targeting @see FlagType::{flag_targeting constants}
	 * @return array|bool An array if the data is cached, false otherwise.
	 */
	public function getFlagTypesForWikia( $targeting = 0 ) {
		return $this->memcache->get( $this->getMemcKeyFlagTypesOnWikia( $targeting ) );
	}

	/**
	 * Saves all types of flags in the memcache.
	 * @param array $flagTypes
	 * @param int $targeting @see FlagType::{flag_targeting constants}
	 */
	public function setFlagTypesForWikia( Array $flagTypes, $targeting = 0 ) {
		$this->memcache->set(
			$this->getMemcKeyFlagTypesOnWikia( $targeting ),
			$flagTypes,
			\WikiaResponse::CACHE_LONG
		);
	}

	/**
	 * Purges the data on types of flags for the given wikia.
	 */
	public function purgeFlagTypesForWikia() {
		$this->memcache->delete( $this->getMemcKeyFlagTypesOnWikia() );
		$this->memcache->delete( $this->getMemcKeyFlagTypesOnWikia( FlagType::FLAG_TARGETING_CONTRIBUTORS ) );
		$this->memcache->delete( $this->getMemcKeyFlagTypesOnWikia( FlagType::FLAG_TARGETING_READERS ) );
	}

	/**
	 * Cache flags instances on a page.
	 */

	/**
	 * Tries to get all instances of flag types for the given page from memcache.
	 * @return array|bool An array if the data is cached, false otherwise.
	 */
	public function getFlagsForPage( $pageId ) {
		return $this->memcache->get( $this->getMemcKeyFlagsOnPage( $pageId ) );
	}

	/**
	 * Saves all instances of flags for the page in the memcache.
	 * @param int $pageId
	 * @param array $flags
	 */
	public function setFlagsForPage( $pageId, Array $flags ) {
		$this->memcache->set(
			$this->getMemcKeyFlagsOnPage( $pageId ),
			$flags,
			\WikiaResponse::CACHE_LONG
		);
	}

	/**
	 * Purges the data on instances of flags for the given page.
	 * @param int $pageId
	 */

	public function purgeFlagsForPage( $pageId ) {
		$this->memcache->delete( $this->getMemcKeyFlagsOnPage( $pageId ) );
	}

	/**
	 * Purges the data on instances of flags for set of pages.	 *
	 * @param array $pageIds
	 */
	public function purgeFlagsForPages( Array $pageIds ) {
		foreach ( $pageIds as $pageId ) {
			$this->purgeFlagsForPage( $pageId );
		}
	}

	/**
	 * Returns a memcache key for list of flag types on wikia.
	 * default $targeting = 0 for all flag types or other numbers for specific targeting
	 * @param int $targeting @see FlagType::{flag_targeting constants}
	 * @return String A memcache key
	 */
	private function getMemcKeyFlagTypesOnWikia( $targeting = 0 ) {
		$targeting = intval( $targeting );
		return wfMemcKey(
			self::FLAGS_MEMC_KEY_PREFIX,
			FlagsBaseModel::FLAGS_TYPES_TABLE,
			$targeting,
			self::FLAGS_MEMC_VERSION
		);
	}

	/**
	 * Returns a memcache key for data on flag types with and without instances available for the page.
	 * @param int $pageId
	 * @return String A memcache key
	 */
	private function getMemcKeyFlagsOnPage( $pageId ) {
		return wfMemcKey(
			self::FLAGS_MEMC_KEY_PREFIX,
			FlagsBaseModel::FLAGS_TO_PAGES_TABLE,
			$pageId,
			self::FLAGS_MEMC_VERSION
		);
	}
}
