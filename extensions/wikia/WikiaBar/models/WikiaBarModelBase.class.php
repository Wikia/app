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
        if(!in_array($vertical,array(WikiFactoryHub::CATEGORY_ID_GAMING,WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT))) {
            return WikiFactoryHub::CATEGORY_ID_LIFESTYLE;
        } else {
			return $vertical;
		}
    }

	abstract public function getData();
}

