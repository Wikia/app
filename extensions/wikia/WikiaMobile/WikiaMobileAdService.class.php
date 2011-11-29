<?php
/**
 * WikiaMobile Ads Service
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 */
class WikiaMobileAdService extends WikiaService {
				
	public function index() {
		$this->response->setVal( 'adSlot', AdEngine::getInstance()->getAd( 'MOBILE_TOP_LEADERBOARD' ) );
	}
}