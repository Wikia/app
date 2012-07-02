<?php
class HuluVideoPanelController extends WikiaController {
	
	public function executeIndex() {
		wfProfileIn(__METHOD__);
		$this->partnerId = "Wikia";
		$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('skins/oasis/css/modules/HuluVideoPanel.scss'));
		wfProfileOut( __METHOD__ );
	}
}
