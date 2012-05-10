<?php

class HotSpotsController extends WikiaController {

	public function executeIndex($params) {
		wfProfileIn(__METHOD__);

		// add CSS for this module
		$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL("skins/oasis/css/modules/HotSpots.scss"));

		$hotSpotsProvider = new HotSpotsProvider();
		$this->data = $hotSpotsProvider->get();
		//$hotSpotsRenderer = new HotSpotsRenderer();
		//$this->html = $hotSpotsRenderer->render($hotSpotsData);

		wfProfileOut(__METHOD__);
	}
}