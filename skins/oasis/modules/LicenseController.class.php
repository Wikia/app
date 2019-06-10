<?php

class LicenseController extends WikiaController {

	public function executeIndex() {
		global $wgRightsText, $wgRightsUrl;

		$license = Html::element( 'a', [ 'href' => $wgRightsUrl ], $wgRightsText );
		$description = wfMessage('license-description')->inContentLanguage()->rawParams($license)->escaped();

		$this->setVal('licenseDescription', $description);
	}
}