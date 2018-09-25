<?php
use Wikia\Factory\ServiceFactory;
use \Wikia\Service\User\Auth\CookieHelper;

/*
 * Safari usage (only on Polish devboxes)
 * 1. Go to muppet wiki and sign in
 * 2. Visit https://mechprivate.mech.fandom-dev.pl/wiki/Special:SafariStorageAccessPoC
 * 3. The iframe should allow you to transfer access_token cookie from wikia-dev.pl domain to fandom-dev.pl
 */

class SafariStorageAccessPoCController extends WikiaSpecialPageController {
	const COOKIE_NAME = 'SafariPoCCookie';
	const IFRAME_TEMPLATE_PATH = __DIR__ . '/templates/iframe.mustache';
	const LOGIN_TEMPLATE_PATH = __DIR__ . '/templates/login.mustache';


	public function __construct() {
		parent::__construct( 'SafariStorageAccessPoC' );
	}

	public function index() {
		global $wgUser;

		// handle the cors headers
		if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
			return $this->request_options();
		}

		// route the actions
		if ( $this->request->getVal('action') === 'frame' ) {
			return $this->action_frame();
		}

		if ( $this->request->getVal('action') === 'session' ) {
			return $this->action_session();
		}

		if ( $this->request->getVal('action') === 'login' ) {
			return $this->action_login();
		}

		// Render the iframe...
		$this->isAnon = $wgUser->isAnon();

		$this->specialPage->setHeaders();

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

	}

	/*
	 * add js global needed when creating an iframe
	 */
	public static function addSafariPoCVars( array &$vars, &$scripts ) {
		$vars['wgSafariPoCUrl'] = wfHttpToHttps(
			GlobalTitle::newFromText(
				'SafariStorageAccessPoC', NS_SPECIAL, 831
			)->getFullURL('action=frame' )
		);
	}


	/**
	 * @return bool true if we're on a fandom domain wiki
	 */
	private function isFandomRequest() {
		global $wgRequest, $wgFandomBaseDomain;
		$host = parse_url( $wgRequest->getFullRequestURL(), PHP_URL_HOST );
		$host = wfNormalizeHost( $host );
		return wfGetBaseDomainForHost( $host ) === $wgFandomBaseDomain;
	}

	/**
	 * emit CORS headers when the request method is OPTIONS
	 */
	private function request_options() {
		$output = \RequestContext::getMain()->getOutput();
		$output->setArticleBodyOnly( true );
		header('access-control-allow-credentials: true' );
		header('access-control-allow-headers: Origin,Content-Type,Accept,X-Wikia-AutoLogin,X-Wikia-AccessToken,X-Proof-Of-Work,Cache-Control,Referer,User-Agent,X-Wikia-CookieSyncer');
		header('access-control-allow-methods: POST,GET,OPTIONS,PUT,DELETE,PATCH');

/*
		if ($this->isFandomRequest()) {
			header('access-control-allow-origin: https://muppet.mech.wikia-dev.pl');
		} else {
			header('access-control-allow-origin: https://mechprivate.mech.fandom-dev.pl');

		}
*/
		if ( !empty($_SERVER['HTTP_ORIGIN'])) {
			if (endsWith($_SERVER['HTTP_ORIGIN'], '.fandom-dev.pl') ||
				endsWith($_SERVER['HTTP_ORIGIN'], '.wikia-dev.pl')) {
				header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
			}
		}

		return false;
	}

	/*
	 * Renders the content of the iframe.
	 * If $wgSafariStorageAccessPoCPassiveSync it set and the iframe received the auth cookie, just do the passive login immediately.
	 * Otherwise display a button that will call the 'session' endpoint - we hope that one will get the cookie
	 */
	private function action_frame() {
		global $wgEditPageFrameOptions, $wgSafariStorageAccessPoCPassiveSync;
		$wgEditPageFrameOptions = '';
		header( "Content-Security-Policy: frame-ancestors 'self' https://*.fandom-dev.pl https://*.wikia-dev.pl;" );
		$output = \RequestContext::getMain()->getOutput();
		$output->setArticleBodyOnly( true );

		if ( $wgSafariStorageAccessPoCPassiveSync ) {
			$cookieHelper = ServiceFactory::instance()->heliosFactory()->cookieHelper();
			$token = $cookieHelper->getAccessToken( \RequestContext::getMain()->getRequest() );
			if ($token) {
				// we got the cookie on wikia domain, go straight to the `login` endpoint and set the cookie on fandom domain
				$url = wfHttpToHttps(
					GlobalTitle::newFromText(
						'SafariStorageAccessPoC', NS_SPECIAL, 1657065
					)->getFullURL('action=login&token='.$token.'&postMessage=1' ));
				$output->redirect( $url, 302);
				return false;
			}
		}

		$output->addHTML( MustacheService::getInstance()->render(
			self::IFRAME_TEMPLATE_PATH, [
				'sessionUrl' => Title::newFromText('SafariStorageAccessPoC', NS_SPECIAL)->getFullURL('action=session'),
				'cookieDoneDomain' => $this->isFandomRequest() ? '.fandom-dev.pl' : '.wikia-dev.pl'
			]
		) );
		return false;
	}

	/**
	 * Ajax POST endpoint called by the iframe JS after pressing the button.
	 * Hopefully receives the access_token and redirects the request to the 'login' endpoint.
	 */
	private function action_session() {
		global $wgUser;

		$output = \RequestContext::getMain()->getOutput();
		$output->setArticleBodyOnly( true );

		if ( $wgUser->isAnon() ) {
			$output->setStatusCode(401);
		}
		$cookieHelper = ServiceFactory::instance()->heliosFactory()->cookieHelper();

		$token = $cookieHelper->getAccessToken( \RequestContext::getMain()->getRequest() );


		$url = wfHttpToHttps(
			GlobalTitle::newFromText(
				'SafariStorageAccessPoC', NS_SPECIAL, 1657065
			)->getFullURL('action=login&token='.$token ));
		$output->redirect( $url, 302);

		return false;
	}

	/*
	 * Simply get the cookie form query params and set it on fandom domain.
	 */
	private function action_login() {
		global $wgEditPageFrameOptions;
		$wgEditPageFrameOptions = '';
		header( "Content-Security-Policy: frame-ancestors 'self' https://*.fandom-dev.pl https://*.wikia-dev.pl;" );

		$output = \RequestContext::getMain()->getOutput();
		$output->setArticleBodyOnly( true );

		//header('access-control-allow-origin: https://muppet.mech.wikia-dev.pl');
		header('access-control-allow-credentials: true' );

		header('Set-Cookie: autologin_done=1; domain=.fandom-dev.pl; path=/; expires=Thu, 24 Sep 2019 09:17:26 GMT;', false );
		header('Set-Cookie: access_token='.$_REQUEST['token'].'; domain=.fandom-dev.pl; path=/; expires=Thu, 24 Sep 2019 09:17:26 GMT;Secure;HttpOnly', false );

		if ( !empty($_REQUEST['postMessage'])) {

			$output->addHTML( MustacheService::getInstance()->render(
				self::LOGIN_TEMPLATE_PATH, [
					'cookieDoneDomain' => $this->isFandomRequest() ? '.fandom-dev.pl' : '.wikia-dev.pl'
				]
			) );
		}

		return false;
	}

}
