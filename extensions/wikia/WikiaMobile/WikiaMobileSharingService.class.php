<?php
/**
 * Wikia Mobile service for sharing links on social networks
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 * @author Jakub Olek <jakubolek(at)wikia-inc.com>
 */
class WikiaMobileSharingService extends WikiaService{
	public function index(){
		wfProfileIn( __METHOD__ );

		$socialSharingService = SocialSharingService::getInstance();

		$this->setVal( 'networks', $socialSharingService->getNetworks( array(
			'facebook',
			'twitter',
			'plusone',
			'email'
		) ) );

		wfProfileOut( __METHOD__ );
	}

	public function button(){
		if ( $this->wg->Title->getNamespace() == NS_SPECIAL ) {
			$this->skipRendering();
		}
	}
}