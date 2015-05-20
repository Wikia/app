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

class FlagsCache {
	const FLAGS_MEMC_KEY_PREFIX = 'flagsData';
	const FLAGS_MEMC_KEY_FOR_RENDER = 'forRender';
	const FLAGS_MEMC_KEY_FOR_EDIT = 'forEdit';
	const FLAGS_MEMC_VERSION = '1.0';

	private $memcache;

	function __construct() {
		$this->memcache = \F::app()->wg->Memc;
	}

	/**
	 * Cache all types of flags for a wikia.
	 */

	/**
	 * Tries to get all types of flags available for the wikia from memcache.
	 * @param int $wikiId
	 * @return array|bool An array if the data is cached, false otherwise.
	 */
	public function getFlagTypesForWikia( $wikiId ) {
		return $this->memcache->get( $this->getMemcKeyFlagTypesOnWikia( $wikiId ) );
	}

	/**
	 * Saves all types of flags in the memcache.
	 * @param int $wikiId
	 * @param array $flagTypes
	 */
	public function setFlagTypesForWikia( $wikiId, Array $flagTypes ) {
		$this->memcache->set(
			$this->getMemcKeyFlagTypesOnWikia( $wikiId ),
			$flagTypes,
			\WikiaResponse::CACHE_LONG
		);
	}

	/**
	 * Purges the data on types of flags for the given wikia.
	 * @param int $wikiId
	 */
	public function purgeFlagTypesForWikia( $wikiId ) {
		$this->memcache->delete( $this->getMemcKeyFlagTypesOnWikia( $wikiId ) );
	}

	/**
	 * Cache flags instances on a page.
	 */

	/**
	 * Tries to get all instances of flag types for the given page from memcache.
	 * @param int $wikiId
	 * @return array|bool An array if the data is cached, false otherwise.
	 */
	public function getFlagsForPageForRender( $wikiId, $pageId ) {
		return $this->memcache->get( $this->getMemcKeyFlagsOnPageForRender( $wikiId, $pageId ) );
	}

	/**
	 * Saves all instances of flags for the page in the memcache.
	 * @param int $wikiId
	 * @param int $pageId
	 * @param array $flags
	 */
	public function setFlagsForPageForRender( $wikiId, $pageId, $flags ) {
		$this->memcache->set(
			$this->getMemcKeyFlagsOnPageForRender( $wikiId, $pageId ),
			$flags,
			\WikiaResponse::CACHE_LONG
		);
	}

	/**
	 * Purges the data on instances of flags for the given page.
	 * @param int $wikiId
	 * @param int $pageId
	 */
	public function purgeFlagsForPageForRender( $wikiId, $pageId ) {
		$this->memcache->delete( $this->getMemcKeyFlagsOnPageForRender( $wikiId, $pageId ) );
	}

	/**
	 * Cache flags types with and without instances for the edit form
	 */

	/**
	 * Tries to get all flag types but with the instances for the given page from memcache.
	 * @param int $wikiId
	 * @param int $pageId
	 * @return array|bool An array if the data is cached, false otherwise.
	 */
	public function getFlagsForPageForEdit( $wikiId, $pageId ) {
		return $this->memcache->get( $this->getMemcKeyFlagsOnPageForEdit( $wikiId, $pageId ) );
	}

	/**
	 *  Saves all types of flags marking the ones with instances for the page in the memcache.
	 * @param int $wikiId
	 * @param int $pageId
	 * @param array $flags
	 */
	public function setFlagsForPageForEdit( $wikiId, $pageId, $flags ) {
		$this->memcache->set(
			$this->getMemcKeyFlagsOnPageForEdit( $wikiId, $pageId ),
			$flags,
			\WikiaResponse::CACHE_LONG
		);
	}

	/**
	 * Purges the data on types of flags with and without instances for the given page.
	 * @param int $wikiId
	 * @param int $pageId
	 */
	public function purgeFlagsForPageForEdit( $wikiId, $pageId ) {
		$this->memcache->delete( $this->getMemcKeyFlagsOnPageForEdit( $wikiId, $pageId ) );
	}

	/**
	 * Returns a memcache key for data on all types of flags for the wikia.
	 * @param int $wikiId
	 * @return String A memcache key
	 */
	private function getMemcKeyFlagTypesOnWikia( $wikiId ) {
		return wfMemcKey(
			self::FLAGS_MEMC_KEY_PREFIX,
			FlagsBaseModel::FLAGS_TYPES_TABLE,
			$wikiId,
			self::FLAGS_MEMC_VERSION
		);
	}

	/**
	 * Returns a memcache key for data on instances of flags for the given page.
	 * @param int $wikiId
	 * @param int $pageId
	 * @return String A memcache key
	 */
	private function getMemcKeyFlagsOnPageForRender( $wikiId, $pageId ) {
		return wfMemcKey(
			self::FLAGS_MEMC_KEY_PREFIX,
			FlagsBaseModel::FLAGS_TO_PAGES_TABLE,
			$wikiId,
			$pageId,
			self::FLAGS_MEMC_KEY_FOR_RENDER,
			self::FLAGS_MEMC_VERSION
		);
	}

	/**
	 * Returns a memcache key for data on flag types with and without instances available for the page.
	 * @param int $wikiId
	 * @param int $pageId
	 * @return String A memcache key
	 */
	private function getMemcKeyFlagsOnPageForEdit( $wikiId, $pageId ) {
		return wfMemcKey(
			self::FLAGS_MEMC_KEY_PREFIX,
			FlagsBaseModel::FLAGS_TO_PAGES_TABLE,
			$wikiId,
			$pageId,
			self::FLAGS_MEMC_KEY_FOR_EDIT,
			self::FLAGS_MEMC_VERSION
		);
	}
}
