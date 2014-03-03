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
	const HUB_PAGE_NAME_VAR = 'wgWikiaHubPageName';

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

	public function getVerticalNameById($cityId) {
		$hubName = $this->getHubPageName( $cityId, $this->wg->ContLang );
		return $hubName;
	}

	public function getCanonicalVerticalNameById($cityId) {
		$hubName = $this->getHubPageName( $cityId, self::HUB_CANONICAL_LANG );
		return $hubName;
	}

	public function getHubPageName($cityId, $langCode) {
		$hubPages = WikiFactory::getVarValueByName(self::HUB_PAGE_NAME_VAR, $cityId);

		if ( isset( $hubPages[$langCode] ) ) {
			return $hubPages[$langCode];
		} elseif ( isset( $hubPages[self::HUB_CANONICAL_LANG]) ) {
			return $hubPages[self::HUB_CANONICAL_LANG];
		} else {
			/** @var WikiFactoryHub $wikiFactoryHub */
			$wikiFactoryHub = WikiFactoryHub::getInstance();
			$wikiaHub = $wikiFactoryHub->getCategoryName($cityId);
			return wfMessage('hub-' . $wikiaHub)->inContentLanguage()->text();
		}
	}

	public function getVerticalId($cityId) {
		$wikiFactoryHub = WikiFactoryHub::getInstance();
		return $wikiFactoryHub->getCategoryId($cityId);
	}
}
