<?php
/**
 * Wikia Mobile service for sharing links on social networks
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 * @author Jakub Olek <jakubolek(at)wikia-inc.com>
 */
class WikiaMobileSharingService extends WikiaService{
	public function index(){
		$this->wf->profileIn( __METHOD__ );


		/**
		 * @var $socialSharingService SocialSharingService
		 */
		$socialSharingService = F::build( 'SocialSharingService' );

		$this->setVal( 'networks', $socialSharingService->getNetworks( array(
			'facebook',
			'twitter',
			'plusone',
			'email'
		) ) );

		$this->wf->profileOut( __METHOD__ );
	}

	public function button(){
		if ( $this->wg->Title->getNamespace() == NS_SPECIAL ) {
			$this->skipRendering();
		}
	}
}