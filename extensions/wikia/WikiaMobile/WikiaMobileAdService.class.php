<?php
/**
 * WikiaMobile Ads Service
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 */
class WikiaMobileAdService extends WikiaService {


	public function shouldShowAds() {
		return AdEngine2Service::areAdsShowableOnPage();
	}

	public function floating() {
		return $this->shouldShowAds();
	}

	public function topLeaderBoard() {
		return $this->shouldShowAds();
	}

	public function inContent() {
		return $this->shouldShowAds();
	}

	public function modalInterstitial() {
		return $this->shouldShowAds();
	}
}
