<?php

class GCSRecoveryProvider {

	public function getInlineCode() {
		if ( !$this->isEnabled() ) {
			return '<!-- GCS disabled -->';
		}
		$template = file_get_contents(__DIR__ . '/../template/inline/gcs.html');

		return $template;
	}

	private function isEnabled() {
		global $wgAdDriverUseGCS, $wgEnableAdEngineExt, $wgShowAds;

		return $wgAdDriverUseGCS &&
			$wgEnableAdEngineExt &&
			$wgShowAds &&
			AdEngine2Service::areAdsShowableOnPage();
	}

}
