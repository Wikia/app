<?php
/**
 * WikiaMobile page header
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class  WikiaMobilePageHeaderService extends WikiaService {
	static $skipRendering = false;

	static function setSkipRendering( $value = false ){
		self::$skipRendering = $value;
	}

	public function index() {

		if(self::$skipRendering) return false;

		$this->response->setVal( 'pageTitle', $this->wg->Out->getPageTitle() );
		$this->response->setVal( 'sharingButton', $this->app->renderView( 'WikiaMobileSharingService', 'button' ) );
		return true;
	}
}
