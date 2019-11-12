<?php

class LicenseController extends WikiaController {

	public function index() {
		global $wgRightsText, $wgRightsUrl;

		$licenseLink = F::app()->renderPartial('License', 'Link', [ 'licenseUrl' => $wgRightsUrl, 'licenseText' => $wgRightsText ] );
		$description = wfMessage('license-description')->inContentLanguage()->rawParams( $licenseLink )->escaped();

		d($description);

		$this->setVal( 'licenseDescription', $description );
	}
}
