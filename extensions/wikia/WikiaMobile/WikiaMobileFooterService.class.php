<?php
/**
 * WikiaMobile Footer
 *
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 */
class WikiaMobileFooterService extends WikiaService {
	static $skipRendering = false;

	static function setSkipRendering( $value = false ){
		self::$skipRendering = $value;
	}

	public function index(){
		global $wgLang;

		if ( self::$skipRendering ) {
			return false;
		}

		$this->response->setVal( 'copyrightLink', $this->getLinkFromMessage( 'wikiamobile-footer-link-licencing' ) );
		$this->response->setVal( 'links', array(
			$this->getLinkFromMessage( 'wikiamobile-footer-link-videogames' ),
			$this->getLinkFromMessage( 'wikiamobile-footer-link-entertainment' ),
			$this->getLinkFromMessage( 'wikiamobile-footer-link-lifestyle' )
		) );

		//get skin name from user preferences or default one
		$this->response->setVal( 'defaultSkin', urlencode( $this->wg->User->getOption( 'skin' ) ) );
		$this->response->setVal( 'privacyLink', $this->getLinkFromMessage( 'wikiamobile-footer-link-privacy' ) );
		$this->response->setVal( 'feedbackLink', SpecialPage::getTitleFor( 'Contact' )->getLocalURL() );
		$this->response->setVal( 'centralUrl', ( new WikiaLogoHelper() )->getCentralUrlForLang( $wgLang->getCode() ) );
		return true;
	}

	private function getLinkFromMessage( $msgName ){
		//I guess this is more of a cleanup function to remove unneeded markup?
		return str_replace(
			array( '<p>', '</p>' ),
			'',
			wfMsgExt( $msgName , array( 'parse' ) )
		);
	}
}
