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

    public function getTitleEditUrl(){
        $editLink = '';
        $isLoggedIn = !F::app()->getGlobal( 'wgUser' )->isAnon();
        $wgRequest = F::app()->getGlobal( 'wgRequest' );
        $isEditPage = $wgRequest->getVal('action');
        $isPreview = ($wgRequest->getVal('method') == 'preview' );


        if( $isLoggedIn && !$isEditPage && !$isPreview){
            $editLink = '<a href=\'';
            $editLink .= F::app()->getGlobal( 'wgTitle' )->getEditUrl();
            $editLink .= '&section=0';
            $editLink .= '\' class=\'edit-link\'>Edit</a>';
        }
        return $editLink;
    }

	public function index() {

		if(self::$skipRendering) return false;

		$this->response->setVal( 'pageTitle', $this->wg->Out->getPageTitle() );
		$this->response->setVal( 'editButton', $this->getTitleEditUrl() );

		return true;
	}
}
