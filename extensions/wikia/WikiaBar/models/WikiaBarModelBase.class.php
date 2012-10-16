<?php

/**
 * Data Model for WikiaBar - Meebo replacement
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */

abstract class WikiaBarModelBase extends WikiaModel {
	protected $lang;
	protected $vertical;

	// id of wiki storing WikiaBar config
	const WIKIA_BAR_CONFIG_WIKI_ID = 177;

	public function setLang($lang) {
		$this->lang = $lang;
	}

	public function getLang() {
		return $this->lang;
	}

	public function setVertical($vertical) {
		$this->vertical = $vertical;
	}

	public function getVertical() {
		return $this->vertical;
	}

	public function mapVerticalToMain($vertical) {
		$mainVertical = WikiFactoryHub::CATEGORY_ID_LIFESTYLE;
		if( in_array($vertical,array(WikiFactoryHub::CATEGORY_ID_GAMING,WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT))) {
			$mainVertical = $vertical;
		}

		return $mainVertical;
    }

	abstract public function getData();
}

