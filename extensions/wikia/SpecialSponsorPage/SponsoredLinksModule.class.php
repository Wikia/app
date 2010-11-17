<?php

class SponsoredLinksModule extends Module {

	var $sponsoredLinks;

	public function executeIndex() {
		global $wgUser;

		if ( empty($_GET['showads']) && is_object($wgUser) && $wgUser->isLoggedIn() && !$wgUser->getOption('showAds') ) {
			return true;
		}

		if (!AdDisplay::ArticleCanShowAd()) return true;
		wfLoadExtensionMessages('SponsorPage');

		$this->sponsoredLinks = AdDisplay::OutputAdvertisement();
	}
}
