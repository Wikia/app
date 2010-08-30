<?php

class CommunityCornerModule extends Module {

	var $isAdmin;

	public function executeIndex($params) {
		global $wgUser;
		wfProfileIn(__METHOD__);

		$this->isAdmin = $wgUser->isAllowed('editinterface');

		wfProfileOut(__METHOD__);
	}

}