<?php
/**
 * WikiaMobile Ads Service
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 */
class WikiaMobileAdService extends WikiaService {
				
	public function index() {
		$this->wf->profileIn( __METHOD__ );

		if ( !$this->wg->Title->isSpecialPage() ) {
			$this->response->setVal( 'adSlot', AdEngine::getInstance()->getAd( 'MOBILE_TOP_LEADERBOARD' ) );
		} else {
			$this->skipRendering();
		}

		$this->wf->profileOut( __METHOD__ );
	}
}