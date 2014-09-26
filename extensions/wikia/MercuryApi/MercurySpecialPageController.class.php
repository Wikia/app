<?php
/**
 * Class MercurySpecialPageController
 *
 * TODO: This is a temporary page, remove once the testing period is over.
 */
class MercurySpecialPageController extends WikiaSpecialPageController {

	const PAGE_NAME = 'Mercury';
	const PAGE_RESTRICTION = 'lookupuser';
	const COOKIE_NAME = 'wk_mercury';
	const OPT_IN = 1;
	const COOKIE_EXPIRE_DAYS = 7;

	public function __construct() {
		parent::__construct( self::PAGE_NAME, self::PAGE_RESTRICTION, false );
	}

	public function index() {
		global $wgUser;

		if( !$wgUser->isAllowed( self::PAGE_RESTRICTION ) ) {
			$this->displayRestrictionError();
			return;
		}

		$opt = $this->request->getVal( 'opt' );
		if ( !empty( $opt ) ) {
			if ( $opt === 'in' ) {
				$this->request->setCookie( self::COOKIE_NAME, self::OPT_IN, time() + 86400 * self::COOKIE_EXPIRE_DAYS );
			} elseif ( $opt === 'out' ) {
				$this->request->setCookie( self::COOKIE_NAME, '', time() - 3600 );
			}
			$this->response->redirect( SpecialPage::getTitleFor( self::PAGE_NAME )->getFullUrl() );
		}

		$cookie = $this->request->getCookie( self::COOKIE_NAME );
		if ( !empty( $cookie ) && $cookie == self::OPT_IN ) {
			// OPTED IN
			$this->setVal( 'buttonAction', 'out' );
			$this->setVal( 'buttonLabel', 'Opt out' );
		} else {
			$this->setVal( 'buttonAction', 'in' );
			$this->setVal( 'buttonLabel', 'Opt in' );
		}

		$this->setVal( 'pageName', self::PAGE_NAME );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}
}
