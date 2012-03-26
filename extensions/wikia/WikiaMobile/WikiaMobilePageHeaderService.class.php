<?php
/**
 * WikiaMobile page header
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class  WikiaMobilePageHeaderService extends WikiaService {
	public function index() {
		$this->response->setVal( 'pageTitle', $this->wg->Out->getPageTitle() );
		$this->response->setVal( 'sharingButton', $this->app->renderView( 'WikiaMobileSharingService', 'button' ) );
	}
}
