<?php

/**
 * Redirect Service
 *
 * If mapping from old title to new title is set in redirects array,
 * then redirection with given HTTP status code is made.
 *
 * If redirects array is not set, $wgRedirectPages array from WikiFactory will be set as default.
 *
 * Examples:
 *
 * 		Redirects for:
 * 			- http://muppet.wikia.com/wiki/Old_title
 * 			- http://wikia.com/WAM/Next_Old_title
 *
 * 		$this->redirects = array(
 * 					'old title' => 'new title'
 * 					'next old title' => 'next new title'
 * 				);
 *
 * If page type is set, it expects multidimensional array with page type on first level.
 *
 *		$this->redirects = array(
 * 					'wam' => array(
 * 						'old title' => 'new title'
 * 					),
 * 					'hubs' => array(
 * 						'other old title' => 'new title'
 * 					)
 * 				);
 */

class RedirectService extends WikiaService {

	const DEFAULT_HTTP_STATUS = 301;

	/**
	 * Number of segments in url path
	 */
	private $level = 0;

	/**
	 * Url path segments in array
	 */
	private $pathSegments;

	/**
	 * Array which map old title to new title
	 */
	private $redirects;

	/**
	 * HTTP status code
	 */
	private $status;

	/**
	 * Page type for multidimensional arrays with redirect mapping
	 */
	private $pageType;

	public function __construct( $pageType = null, $status = null ) {
		if ( !is_null( $status ) && is_numeric( $status ) ) {
			$this->status = $status;
		} else {
			$this->status = self::DEFAULT_HTTP_STATUS;
		}
		$this->redirects = [];
		$this->pageType = $pageType;
	}

	/**
	 * Get array which map old title to new title.
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

		if ( isset( $this->pageType )
			&& isset( $this->redirects[ $this->pageType ] )
			&& is_array( $this->redirects[ $this->pageType ]) )
		{
			return $this->redirects[ $this->pageType ];
		}

		return $this->redirects;
	}

	/**
	 * Set redirects array
	 *
	 * @param array $redirects
	 */
	public function setRedirects(Array $redirects ) {
		$this->redirects = $redirects;
	}

	/**
	 * Redirect to new page, if it's found in redirects mapping array
	 * Redirection is made with given HTTP status code
	 *
	 * @param Title $title
	 */
	public function redirect( Title $title ) {
		global $wgOut;

		$this->getUrlPathSegments( $title );

		$newTitle = $this->getNewTitle();

		if ( !is_null( $newTitle ) ) {
			$wgOut->redirect( $newTitle->getLocalURL(), $this->status );
		}
	}

	/**
	 * Redirect to given url, if it's found in redirects mapping array
	 * Redirection is made with given HTTP status code
	 *
	 * @param Title $title
	 */
	public function redirectToUrl( Title $title ) {
		global $wgOut;

		$this->getUrlPathSegments( $title );

		$url = $this->getRedirectURL();

		if ( !is_null( $url ) ) {
			$wgOut->redirect( $url, $this->status );
		}
	}

	/**
	 * Get new title.
	 * If mapping from old title to new title exists in redirects array, the new title is returned
	 *
	 * @return null|Title
	 */
	private function getNewTitle() {
		$newTitle = null;

		$titleText = mb_strtolower( $this->pathSegments[ $this->level - 1 ] );

		$redirects = $this->prepareRedirects();

		if ( isset( $redirects[$titleText] ) ) {
			$newTitle = $this->getTitleFromText( $this->prepareTitleText( $redirects[$titleText] ) );

			if ( !$newTitle instanceof Title ) {
				return null;
			}
		}

		return $newTitle;
	}

	/**
	 * Get url to redirect.
	 * If mapping from old title to url exists in redirects array, url is returned
	 *
	 * @return null|Title
	 */
	private function getRedirectURL() {
		$url = null;

		$titleText = mb_strtolower( $this->pathSegments[ $this->level - 1 ] );

		$redirects = $this->prepareRedirects();

		if ( isset( $redirects[$titleText] ) ) {
			$url = $redirects[$titleText];
		}

		return $url;
	}

	/**
	 * Gets title from text
	 *
	 * @param $text
	 * @return null|Title
	 */
	private function getTitleFromText( $text ) {
		return Title::newFromText( $text );
	}

	/**
	 * Prepare redirects array keys
	 *
	 * @return array
	 */
	private function prepareRedirects() {
		$out = [];
		$redirects = $this->getRedirects();

		foreach ( $redirects as $redirectFrom => $redirectTo ) {
			$out[ mb_strtolower( $redirectFrom ) ] = $redirectTo;
		}

		return $out;
	}

	/**
	 * Make path with new title
	 *
	 * @param $titleText new title
	 * @return string
	 */
	private function prepareTitleText( $titleText ) {
		$this->pathSegments[ $this->level - 1 ] = $titleText;
		$newTitleText = implode( '/', $this->pathSegments );

		return $newTitleText;
	}

	/**
	 * Get url path segments as an array from (old) title
	 *
	 * @param Title $title
	 */
	private function getUrlPathSegments( Title $title ) {
		$titleText = $title->getText();
		$this->pathSegments = explode( '/', $titleText );
		$this->level = count( $this->pathSegments );

		if ( empty( $this->pathSegments[ $this->level - 1 ] ) ) {
			array_pop( $this->pathSegments );
			$this->level--;
		}
	}

}
