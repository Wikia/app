<?php

namespace Flags;

use Flags\Models\FlagsBaseModel;

class FlagsCache {
	const FLAGS_MEMC_KEY_PREFIX = 'flagsData';
	const FLAGS_MEMC_VERSION = '1.0';

	private $memcache;

	function __construct() {
		$this->memcache = \F::app()->wg->Memc;
	}

	/**
	 * Cache flag types on a wikia
	 */

	/**
	 * @param $wikiId
	 * @return Mixed
	 */
	public function getFlagTypesForWikia() {
		return $this->memcache->get( $this->getMemcKeyFlagTypesOnWikia() );
	}

	public function setFlagTypesForWikia( $flagTypes ) {
		$this->memcache->set(
			$this->getMemcKeyFlagTypesOnWikia(),
			$flagTypes,
			\WikiaResponse::CACHE_LONG
		);
	}

	public function purgeFlagTypesForWikia() {
		$this->memcache->delete( $this->getMemcKeyFlagTypesOnWikia() );
	}

	/**
	 * Cache flags instances on a page
	 */

	/**
	 * @param $wikiId
	 * @return Mixed
	 */
	public function getFlagsForPage( $pageId ) {
		return $this->memcache->get( $this->getMemcKeyFlagsOnPage( $pageId ) );
	}

	public function setFlagsForPage( $pageId, $flags ) {
		$this->memcache->set(
			$this->getMemcKeyFlagsOnPage( $pageId ),
			$flags,
			\WikiaResponse::CACHE_LONG
		);
	}

	public function purgeFlagsForPage( $pageId ) {
		$this->memcache->delete( $this->getMemcKeyFlagsOnPage( $pageId ) );
	}

	/**
	 * @param $wikiId
	 * @return String
	 */
	private function getMemcKeyFlagTypesOnWikia() {
		return wfMemcKey(
			self::FLAGS_MEMC_KEY_PREFIX,
			FlagsBaseModel::FLAGS_TYPES_TABLE,
			self::FLAGS_MEMC_VERSION
		);
	}

	private function getMemcKeyFlagsOnPage( $pageId ) {
		return wfMemcKey(
			self::FLAGS_MEMC_KEY_PREFIX,
			FlagsBaseModel::FLAGS_TO_PAGES_TABLE,
			$pageId,
			self::FLAGS_MEMC_VERSION
		);
	}
}
