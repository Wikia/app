<?php

class HotSpotsModule extends Module {

	var $data;

	public function executeIndex($params) {
		global $wgUser, $wgTitle, $wgOut, $wgStylePath;
		wfProfileIn(__METHOD__);

		// add CSS for this module
		$wgOut->addStyle(wfGetSassUrl("skins/oasis/css/modules/HotSpots.scss"));

		$hotSpotsProvider = new HotSpotsProvider();
		$this->data = $hotSpotsProvider->get();
		//$hotSpotsRenderer = new HotSpotsRenderer();
		//$this->html = $hotSpotsRenderer->render($hotSpotsData);

		wfProfileOut(__METHOD__);
	}

}