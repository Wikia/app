<?php

/**
 * CuratedContent mobile app API controller
 */
class CuratedContentController extends WikiaController {
	const API_VERSION = 1;
	const API_REVISION = 1;
	const API_MINOR_REVISION = 1;
	const APP_NAME = 'CuratedContent';
	const SKIN_NAME = 'wikiamobile';
	const LIMIT = 25;
	const CURATED_CONTENT_WG_VAR_ID_PROD = 1460;

	const NEW_API_VERSION = 1;

	const ASSETS_PATH = '/extensions/wikia/CuratedContent/assets/CuratedContentAssets.json';

	/**
	 * @var $mModel CuratedContentModel
	 */
	private $mModel = null;
	private $mPlatform = null;

	// Make sure this is updated as in CuratedContent.js

	function init() {
		$requestedVersion = $this->request->getInt( 'ver', self::API_VERSION );
		$requestedRevision = $this->request->getInt( 'rev', self::API_REVISION );

		if ( $requestedVersion != self::API_VERSION || $requestedRevision != self::API_REVISION ) {
			throw new CuratedContentWrongAPIVersionException();
		}

		$this->mModel = new CuratedContentModel();
		$this->mPlatform = $this->request->getVal( 'os' );
	}

	/**
	 * @brief Api entry point to get a page and globals and messages that are relevant to the page
	 *
	 * @example wikia.php?controller=CuratedContent&method=getPage&page={Title}
	 */
	public function getPage() {
		global $wgTitle;

		// This will always return json
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );

		// set mobile skin as this is based on it
		RequestContext::getMain()->setSkin( Skin::newFromKey( 'wikiamobile' ) );

		$titleName = $this->getVal( 'page' );

		$title = Title::newFromText( $titleName );

		if ( $title instanceof Title ) {
			RequestContext::getMain()->setTitle( $title );
			$wgTitle = $title;

			$revId = $title->getLatestRevID();
			$articleId = $title->getArticleID();

			if ( $revId > 0 ) {
				try {
					$relatedPages = $this->app->sendRequest(
						'RelatedPagesApi',
						'getList',
						[ 'ids' => [ $articleId ] ]
					)->getVal( 'items' )[$articleId];

					if ( !empty( $relatedPages ) ) {
						$this->response->setVal( 'relatedPages', $relatedPages );
					}
				} catch ( NotFoundApiException $error ) {
					// If RelatedPagesApi is not available don't throw it to app
				}

				$this->response->setVal(
					'html',
					$this->sendSelfRequest(
						'renderPage',
						[ 'page' => $titleName ]
					)->toString()
				);

				$this->response->setVal(
					'revisionid',
					$revId
				);
			} else {
				throw new NotFoundApiException( 'Revision ID = 0' );
			}
		} else {
			throw new NotFoundApiException( 'Title not found' );
		}
	}

	/**
	 * API to get data from Curated Content Management Tool in json
	 *
	 * make sure that name of this function is aligned
	 * with what is in onCuratedContentSave to purge varnish correctly
	 *
	 * @return {}
	 *
	 * getList - list of sections on a wiki or list of all items if GGCMT was not used (this will be cached)
	 * getList&offset='' - next page of items if no sections were given
	 * getList&section='' - list of all members of a given section
	 *
	 */
	/**
	 * @brief this is a function that return rendered article
	 *
	 * @requestParam String title of a page
	 */
	public function renderPage() {
		wfProfileIn( __METHOD__ );

		$titleName = $this->request->getVal( 'page' );

		$html = ApiService::call(
			[
				'action' => 'parse',
				'page' => $titleName,
				'prop' => 'text',
				'redirects' => 1,
				'useskin' => 'wikiamobile'
			]
		);

		$this->response->setVal( 'globals', Skin::newFromKey( 'wikiamobile' )->getTopScripts() );
		$this->response->setVal( 'messages', JSMessages::getPackages( [ 'CuratedContent' ] ) );
		$this->response->setVal( 'title', Title::newFromText( $titleName )->getText() );
		// TODO: Remove 'infoboxFixSectionReplace', it's temporary fix for mobile aps
		// See: DAT-2864 and DAT-2859
		$this->response->setVal( 'html', $this->infoboxFixSectionReplace( $html['parse']['text']['*'] ) );

		wfProfileOut( __METHOD__ );
	}

	public function infoboxFixSectionReplace( $html ) {
		$matches = [ ];
		preg_match_all( "/<aside class=\"portable-infobox.+?>(.+?)<\\/aside>/ms", $html, $matches );
		if ( isset( $matches[1] ) ) {
			foreach ( $matches[1] as $to_replace ) {
				$new_markup = str_replace( '<section', '<div', $to_replace );
				$new_markup = str_replace( '</section', '</div', $new_markup );
				$html = str_replace( $to_replace, $new_markup, $html );
			}
		}

		return $html;
	}

	/**
	 * @brief helper function to build a CuratedContentSpecial Preview
	 * it returns a page and all 'global' assets
	 */
	public function renderFullPage() {
		global $IP;

		wfProfileIn( __METHOD__ );

		$resources = json_decode( file_get_contents( $IP . self::ASSETS_PATH ) );

		$scripts = '';

		foreach ( $resources->scripts as $s ) {
			$scripts .= $s;
		}

		// getPage sets cache for a response for 24 hours
		$page = $this->sendSelfRequest(
			'getPage',
			[ 'page' => $this->getVal( 'page' ) ]
		);

		$this->response->setVal( 'html', $page->getVal( 'html' ) );
		$this->response->setVal( 'js', $scripts );
		$this->response->setVal( 'css', $resources->styles );

		wfProfileOut( __METHOD__ );
	}
}