<?php

/**
 * Data Model for WikiaBar - Meebo replacement
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */

class WikiaBarDataModel extends WikiaBarModelBase {
	public function getData() {
		$this->wf->profileIn(__METHOD__);

		/* Config is stored on community Wiki */
		$wikiaBarConfigMessage = WikiFactory::getVarValueByName('wgWikiaBarConfig', 177, true);

		if (
			!empty($wikiaBarConfigMessage)
			&& !empty($wikiaBarConfigMessage[$this->getVertical()])
			&& !empty($wikiaBarConfigMessage[$this->getVertical()][$this->getLang()])
		) {
			$data = trim($wikiaBarConfigMessage[$this->getVertical()][$this->getLang()]);
		} else {
			$data = false;
		}

		$this->wf->profileOut(__METHOD__);
		return $data;
	}
}

