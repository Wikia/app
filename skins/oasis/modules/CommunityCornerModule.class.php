<?php

class CommunityCornerModule extends Module {

	var $isAdmin;

	public function executeIndex($params) {
		global $wgUser, $wgOut;
		wfProfileIn(__METHOD__);

		// add CSS for this module
		$wgOut->addStyle(wfGetSassUrl("skins/oasis/css/modules/CommunityCorner.scss"));

		$this->isAdmin = $wgUser->isAllowed('editinterface');

		wfProfileOut(__METHOD__);
	}

}