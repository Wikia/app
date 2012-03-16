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

		$this->setVal( 'networks', F::build( 'SocialSharingService' )->getNetworks( array(
			'facebook',
			'twitter',
			'plusone',
			'email'
		) ) );

		$this->wf->profileOut( __METHOD__ );
	}

	public function button(){
		if ( $this->wg->title->getNamespace() == NS_SPECIAL ) {
			$this->skipRendering();
		}
	}
}