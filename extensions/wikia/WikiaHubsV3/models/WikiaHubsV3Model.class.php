<?php

/**
 * Hubs Model
 *
 * @author Bartosz "V" Bentkowski
 * @author Damian Jóźwiak
 * @author Łukasz Konieczny
 * @author Sebastian Marzjan
 *
 */

class WikiaHubsV3Model extends WikiaModel {
	const HUB_CANONICAL_LANG = 'en';

	protected $cityId;

	public function setCityId($id) {
		$this->cityId = $id;
	}

	public function getCityId() {
		return $this->cityId;
	}

	public function getVerticalName($cityId) {
		/** @var WikiFactoryHub $wikiFactoryHub */
		$wikiFactoryHub = WikiFactoryHub::getInstance();
		$wikiaHub = $wikiFactoryHub->getCategoryName($cityId);
		return $wikiaHub;
		return wfMessage('hub-' . $wikiaHub['name'])->inContentLanguage()->text();
	}

	public function getCanonicalVerticalName($cityId) {
		/** @var WikiFactoryHub $wikiFactoryHub */
		$wikiFactoryHub = WikiFactoryHub::getInstance();
		$wikiaHub = $wikiFactoryHub->getCategoryName($cityId);
//		/return $wikiaHub;
		return wfMessage('hub-' . $wikiaHub['name'])->inLanguage(self::HUB_CANONICAL_LANG)->text();
	}
}
