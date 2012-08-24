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
		$message = Message::newFromKey('WikiaBar/' . $this->getVertical() . '/' . $this->getLang());
		if($message->exists()) {
			$data = $message->text();
		} else {
			$data = null;
		}
		$this->wf->profileOut(__METHOD__);

		return $data;
	}
}

