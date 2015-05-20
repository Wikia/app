<?php

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
	 * Cache flag types on a wikia
	 */

	/**
	 * @param $wikiId
	 * @return Mixed
	 */
	public function getFlagTypesForWikia( $wikiId ) {
		return $this->memcache->get( $this->getMemcKeyFlagTypesOnWikia( $wikiId ) );
	}

	public function setFlagTypesForWikia( $wikiId, $flagTypes ) {
		$this->memcache->set(
			$this->getMemcKeyFlagTypesOnWikia( $wikiId ),
			$flagTypes,
			\WikiaResponse::CACHE_LONG
		);
	}

	public function purgeFlagTypesForWikia( $wikiId ) {
		$this->memcache->delete( $this->getMemcKeyFlagTypesOnWikia( $wikiId ) );
	}

	/**
	 * Cache flags instances on a page
	 */

	/**
	 * @param $wikiId
	 * @return Mixed
	 */
	public function getFlagsForPageForRender( $wikiId, $pageId ) {
		return $this->memcache->get( $this->getMemcKeyFlagsOnPageForRender( $wikiId, $pageId ) );
	}

	public function setFlagsForPageForRender( $wikiId, $pageId, $flags ) {
		$this->memcache->set(
			$this->getMemcKeyFlagsOnPageForRender( $wikiId, $pageId ),
			$flags,
			\WikiaResponse::CACHE_LONG
		);
	}

	public function purgeFlagsForPageForRender( $wikiId, $pageId ) {
		$this->memcache->delete( $this->getMemcKeyFlagsOnPageForRender( $wikiId, $pageId ) );
	}

	/**
	 * Cache flags types with and without instances for the edit form
	 */
	public function getFlagsForPageForEdit( $wikiId, $pageId ) {
		return $this->memcache->get( $this->getMemcKeyFlagsOnPageForEdit( $wikiId, $pageId ) );
	}

	public function setFlagsForPageForEdit( $wikiId, $pageId, $flags ) {
		$this->memcache->set(
			$this->getMemcKeyFlagsOnPageForEdit( $wikiId, $pageId ),
			$flags,
			\WikiaResponse::CACHE_LONG
		);
	}

	public function purgeFlagsForPageForEdit( $wikiId, $pageId ) {
		$this->memcache->delete( $this->getMemcKeyFlagsOnPageForEdit( $wikiId, $pageId ) );
	}

	/**
	 * @param $wikiId
	 * @return String
	 */
	private function getMemcKeyFlagTypesOnWikia( $wikiId ) {
		return wfMemcKey(
			self::FLAGS_MEMC_KEY_PREFIX,
			FlagsBaseModel::FLAGS_TYPES_TABLE,
			$wikiId,
			self::FLAGS_MEMC_VERSION
		);
	}

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