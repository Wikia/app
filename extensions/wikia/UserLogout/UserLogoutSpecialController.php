<?php

class UserLogoutSpecialController extends WikiaSpecialPageController {
	public function __construct() {
		parent::__construct( 'Userlogout' );
	}

	public function index() {
		$this->setHeaders();

		$referer = $this->getContext()->getRequest()->getHeader('REFERER');
		$redirectUrl = 'http://www.wikia.com/';

		if ( isset( $referer ) ) {
			$parsedReferer = parse_url( $referer );
			$redirectUrl = $this->getHostname( $parsedReferer );
			if ( strpos( $parsedReferer['path'], '/d' ) === 0 ) {
				$redirectUrl .= '/d';
			}
		}

		$langCode = $this->getLanguage()->getCode();

		$designSystemLinks = DesignSystemSharedLinks::getInstance();
		$logoutUrl = $designSystemLinks->getHref( 'user-logout', $langCode );

		$this->setVal( 'logoutUrl', $logoutUrl );
		$this->setVal( 'redirectUrl', $redirectUrl );
	}

	/**
	 * @param $parsedUrl
	 * @return string hostname url
	 */
	protected function getHostname( array $parsedUrl ): string {
		$scheme = isset( $parsedUrl['scheme'] ) ? $parsedUrl['scheme'] . '://' : '';
		$host = isset( $parsedUrl['host'] ) ? $parsedUrl['host'] : '';
		$port = isset( $parsedUrl['port'] ) ? ':' . $parsedUrl['port'] : '';

		return "$scheme$host$port";
	}
}
