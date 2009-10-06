<?php

class MagCloudCallback extends UnlistedSpecialPage {
	function  __construct() {
		parent::__construct("MagCloudCallback");
	}

	public function execute() {
		global $wgRequest, $wgOut;

		$ud = $wgRequest->getVal("ud",  null);
		if (preg_match("/^[0-9a-z.-]+$/", $ud)) {
			$token   = $wgRequest->getVal("token",   null);
			$success = $wgRequest->getVal("success", 0);
			$wgOut->redirect("http://{$ud}/wiki/Special:WikiaCollection/Publish?token={$token}&success={$success}");
		}

		return;
	}
}
