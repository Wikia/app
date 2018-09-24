<?php

class SafariStorageAccessPoCController extends WikiaSpecialPageController {
	const COOKIE_NAME = 'SafariPoCCookie';
	const IFRAME_TEMPLATE_PATH = __DIR__ . '/templates/iframe.mustache';

	public function __construct() {
		parent::__construct( 'SafariStorageAccessPoC' );
	}

	private function isFandomRequest() {
		global $wgRequest, $wgFandomBaseDomain;
		$host = parse_url( $wgRequest->getFullRequestURL(), PHP_URL_HOST );
		$host = wfNormalizeHost( $host );
		return wfGetBaseDomainForHost( $host ) === $wgFandomBaseDomain;
	}

	private function action_frame() {
		global $wgEditPageFrameOptions;
		$wgEditPageFrameOptions = 'allow-from *.wikia-dev.pl/';
		$output = \RequestContext::getMain()->getOutput();
		$output->setArticleBodyOnly( true );


		$output->addHTML( MustacheService::getInstance()->render(
			self::IFRAME_TEMPLATE_PATH, []
		) );
		return false;
	}

	public function index() {
		global $wgRequest;

		if ( $this->request->getVal('action') === 'frame' ) {
			return $this->action_frame();
		}


		$this->specialPage->setHeaders();

		$this->response->addAsset( 'storage_access_js' );
		$this->cookieName = self::COOKIE_NAME;
		$this->cookieDomain = '.wikia-dev.pl';
		$this->cookieExpires = 'Sun, 17-Jan-2038 19:14:07 GMT';
		$this->cookieSet = !empty( $_COOKIE[ self::COOKIE_NAME ] );

		if ( !$this->isFandomRequest() ) {
			if ( !$this->cookieSet ) {
				$this->showSetCookieButton = true;
			}
		} else {
			if ( !$this->cookieSet ) {
				$this->showSyncFrame = true;
				$this->frameUrl = wfHttpToHttps(
					GlobalTitle::newFromText( 'SafariStorageAccessPoC', NS_SPECIAL, 831 )->getFullURL('action=frame' )
				);
			}
		}

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

	}
}
