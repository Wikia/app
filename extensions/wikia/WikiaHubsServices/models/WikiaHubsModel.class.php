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
		return WikiFactoryHub::getInstance()->getVerticalNameMessage( $verticalId )->inContentLanguage()->text();
	}

	public function getCanonicalVerticalName($verticalId) {
		return WikiFactoryHub::getInstance()
			->getVerticalNameMessage( $verticalId )
			->inLanguage( self::HUB_CANONICAL_LANG )
			->text();
	}

	public function getCanonicalVerticalNameById($cityId) {
		return $this->getCanonicalVerticalName( WikiFactoryHub::getInstance()->getVerticalId( $cityId ) );
	}
}
