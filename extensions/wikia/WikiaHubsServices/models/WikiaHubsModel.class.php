<?php

/**
 * Hubs Model
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

class WikiaHubsModel extends WikiaModel {
	const HUB_CANONICAL_LANG = 'en';

	protected $vertical;
	protected $cityId;

	public function setVertical($vertical) {
		$this->vertical = $vertical;
	}

	public function getVertical() {
		return $this->vertical;
	}

	public function getVerticalName($verticalId) {
		/** @var WikiFactoryHub $wikiFactoryHub */
		$wikiFactoryHub = WikiFactoryHub::getInstance();
		$wikiaHub = $wikiFactoryHub->getCategory($verticalId);
		return wfMessage('hub-' . $wikiaHub['name'])->inContentLanguage()->text();
	}

	public function getCanonicalVerticalName($verticalId) {
		/** @var WikiFactoryHub $wikiFactoryHub */
		$wikiFactoryHub = WikiFactoryHub::getInstance();
		$wikiaHub = $wikiFactoryHub->getCategory($verticalId);
		return wfMessage('hub-' . $wikiaHub['name'])->inLanguage(self::HUB_CANONICAL_LANG)->text();
	}

	public function getCanonicalVerticalNameById($cityId) {
		/** @var WikiFactoryHub $wikiFactoryHub */
		$wikiFactoryHub = WikiFactoryHub::getInstance();
		$wikiaHub = $wikiFactoryHub->getCategoryName($cityId);
		return wfMessage('hub-' . $wikiaHub)->inLanguage(self::HUB_CANONICAL_LANG)->text();
	}

	public function getVerticalId($cityId) {
		$wikiFactoryHub = WikiFactoryHub::getInstance();
		return $wikiFactoryHub->getCategoryId($cityId);
	}
}
