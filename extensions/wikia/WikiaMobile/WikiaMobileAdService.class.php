<?php
/**
 * WikiaMobile Ads Service
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 */
class WikiaMobileAdService extends WikiaService {

	public function shouldLoadAssets() {
		// Append ad code for anonymous users
		// They'll get the ad eventually
		return $this->wg->user->isAnon();
	}

	public function shouldShowAds() {
		// Show ads only for anon users on all but special pages
		// TODO: unify with desktop logic, like this:
		// AdEngine2Controller::getAdLevelForPage() === AdEngine2Controller::LEVEL_ALL
        return $this->wg->EnableAdEngineExt && $this->shouldLoadAssets() && !$this->wg->Title->isSpecialPage() && $this->wg->Request->getVal('action') !== 'edit';
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
