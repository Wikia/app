<?php

/**
 * Redirect Service
 *
 * If mapping from old title to new title or url is set in redirects array,
 * then redirection with given HTTP status code is made.
 *
 * If redirects array is not set, $wgRedirectPages array from WikiFactory will be set as default.
 *
 * Examples:
 *
 * If page type is set, it expects multidimensional array with page type on first level.
 *
 *		$this->redirects = array(
 * 					'wam' => array(
 * 						'old title' => 'new title'
 * 					),
 * 					'hubs' => array(
 * 						'Video Games' => 'http://gaming.wikia.com'
 * 					)
 * 				);
 */

class RedirectService extends WikiaService {

	const DEFAULT_HTTP_STATUS = 301;

	/**
	 * Array which map old title to new title
	 */
	private $redirects;

	/**
	 * HTTP status code
	 */
	private $httpStatus;

	/**
	 * Page type for multidimensional arrays with redirect mapping
	 */
	private $pageType;

	/**
	 * Check if redirect array was already formatted
	 */
	private $isFormatted;

	public function __construct( $pageType, $httpStatus = null ) {
		if ( !is_null( $httpStatus ) && is_numeric( $httpStatus ) ) {
			$this->httpStatus = $httpStatus;
		} else {
			$this->httpStatus = self::DEFAULT_HTTP_STATUS;
		}
		$this->isFormatted = false;
		$this->redirects = [];
		$this->pageType = mb_strtolower( $pageType );
	}

	/**
	 * Get array which map old title to new title or url.
	 * If redirects array is not set, $wgRedirectPages array from WikiFactory will be set as default
	 *
	 * If page type is set, it expects multidimensional array with page type on first level
	 *
	 * @return Array with redirects
	 */
	public function getRedirects() {
		if ( empty( $this->redirects ) ) {
			global $wgRedirectPages;

			if ( !empty( $wgRedirectPages ) ) {
				$this->redirects = $wgRedirectPages;
			}
		}

		if ( !$this->isFormatted ) {
			$this->redirects = $this->prepareRedirects();
		}


		if ( !empty( $this->pageType ) ) {
			if (
				isset( $this->redirects[ $this->pageType ] )
				&& is_array( $this->redirects[ $this->pageType ])
			) {
				return $this->redirects[ $this->pageType ];
			} else {
				//If we don't find redirects for this pageType
				$this->redirects = [];
			}
		}

		return $this->redirects;
	}

	/**
	 * Set redirects array
	 *
	 * @param array $redirects
	 */
	public function setRedirects( Array $redirects ) {
		$this->redirects = $redirects;
		$this->isFormatted = false;
	}

	/**
	 * Redirect to new page, if it's found in redirects mapping array
	 * Redirection is made with given HTTP status code
	 *
	 * @param Title $title
	 */
	public function redirectIfURLExists() {
		global $wgOut;

		$url = $this->getRedirectUrl();

		if ( !is_null( $url ) ) {
			$wgOut->redirect( $url, $this->httpStatus );
		}
	}

	/**
	 * Get url to redirect.
	 * If mapping from old title to new title or url exists in redirects array, url is returned
	 *
	 * @return null|Title
	 */
	private function getRedirectURL() {
		global $wgTitle;

		// SOC-2909
		if ( empty( $wgTitle ) ) return null;

		$url = null;
		$titleText = mb_strtolower( $wgTitle->getText() );
		$redirects = $this->getRedirects();

		if ( isset( $redirects[$titleText] ) ) {
			$redirectTo = $redirects[$titleText];

			if ( strpos( $redirectTo, 'http' ) === 0  ) {
				$url = $redirectTo;
			} else {
				$redirectTo = $this->getTitleFromText( $redirectTo );
				if ( $redirectTo instanceof Title ) {
					$url = $redirectTo->getLocalURL();
				}
			}
		}

		return $url;
	}

	/**
	 * Prepare redirects array keys
	 *
	 * @return array
	 */
	private function prepareRedirects() {
		$out = [];

		foreach ( $this->redirects as $key => $value ) {
			$keyLower = mb_strtolower( $key );
			if ( is_array( $value ) ) {
				foreach( $value as $from => $to ) {
					$out[ $keyLower ][ mb_strtolower( $from ) ] = $to;
				}
			} else {
				$out[ $keyLower ] = $value;
			}
		}

		$this->isFormatted = true;

		return $out;
	}

	/**
	 * Gets title from text
	 *
	 * @param $text
	 * @return null|Title
	 */
	protected function getTitleFromText( $text ) {
		return Title::newFromText( $text );
	}
}
