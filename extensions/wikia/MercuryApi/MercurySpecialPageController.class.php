<?php
/**
 * Class MercurySpecialPageController
 *
 * TODO: This is a temporary page, remove once the testing period is over.
 */
class MercurySpecialPageController extends WikiaSpecialPageController {

	const PAGE_NAME = 'Mercury';
	const COOKIE_NAME = 'useskin';
	const OPT_IN = 'mercury';
	const COOKIE_EXPIRE_DAYS = 7;

	public function __construct() {
		parent::__construct( self::PAGE_NAME, '', false );
	}

	public function index() {
		global $wgCookiePath, $wgCookieDomain;

		$opt = $this->request->getVal( 'opt' );
		if ( !empty( $opt ) ) {
			if ( $opt === 'in' ) {
				$this->request->setCookie(
					self::COOKIE_NAME,
					self::OPT_IN,
					time() + 86400 * self::COOKIE_EXPIRE_DAYS,
					$wgCookiePath,
					$wgCookieDomain
				);
			} elseif ( $opt === 'out' ) {
				$this->request->setCookie(
					self::COOKIE_NAME,
					'',
					time() - 3600,
					$wgCookiePath,
					$wgCookieDomain
				);
			}
			$this->response->redirect( SpecialPage::getTitleFor( self::PAGE_NAME )->getFullUrl() );
		}

		$cookie = $this->request->getCookie( self::COOKIE_NAME );
		if ( !empty( $cookie ) && $cookie == self::OPT_IN ) {
			// OPTED IN
			$this->setVal( 'buttonAction', 'out' );
			$this->setVal( 'buttonLabel', wfMessage('mercury-opt-out-label')->text() );
		} else {
			$this->setVal( 'buttonAction', 'in' );
			$this->setVal( 'buttonLabel', wfMessage('mercury-opt-in-label')->text() );
		}

		$this->setVal( 'pageName', self::PAGE_NAME );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}
}
