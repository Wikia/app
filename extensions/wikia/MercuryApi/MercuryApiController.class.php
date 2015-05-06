<?php

use Wikia\Logger\WikiaLogger;

class MercuryApiController extends WikiaController {

	const PARAM_ARTICLE_ID = 'id';
	const PARAM_PAGE = 'page';
	const PARAM_ARTICLE_TITLE = 'title';

	const NUMBER_CONTRIBUTORS = 5;
	const DEFAULT_PAGE = 1;

	const WIKI_VARIABLES_CACHE_TTL = 60;

	private $mercuryApi = null;

	public function __construct() {
		parent::__construct();
		$this->mercuryApi = new MercuryApi();
	}

	/**
	 * @desc Gets smart banner config from WF and cleans it up
	 */
	private function getSmartBannerConfig() {
		if ( !empty( $this->wg->EnableWikiaMobileSmartBanner )
			&& !empty( $this->wg->WikiaMobileSmartBannerConfig )
		) {
			$smartBannerConfig = $this->wg->WikiaMobileSmartBannerConfig;

			unset( $smartBannerConfig[ 'author' ] );

			if ( !empty( $smartBannerConfig[ 'icon' ] )
				&& !isset( parse_url( $smartBannerConfig[ 'icon' ] )[ 'scheme' ] ) // it differs per wiki
			) {
				$smartBannerConfig[ 'icon' ] = $this->wg->extensionsPath . $smartBannerConfig[ 'icon' ];
			}

			$meta = $smartBannerConfig[ 'meta' ];
			unset( $smartBannerConfig[ 'meta' ] );
			$smartBannerConfig[ 'appId' ] = [
				'ios' => str_replace( 'app-id=', '', $meta[ 'apple-itunes-app' ] ),
				'android' => str_replace( 'app-id=', '', $meta[ 'google-play-app' ] ),
			];

			$smartBannerConfig[ 'appScheme' ] = [
				'ios' => $meta[ 'ios-scheme' ],
				'android' => $meta[ 'android-scheme' ]
			];

			return $smartBannerConfig;
		}

		return null;
	}

	/**
	 * @desc Returns user ids for top contributors
	 *
	 * @param int $articleId
	 *
	 * @return int[]
	 */
	private function getTopContributorsPerArticle( $articleId ) {
		$usersIds = $this->mercuryApi->topContributorsPerArticle( $articleId, self::NUMBER_CONTRIBUTORS );
		return $usersIds;
	}

	/**
	 * @desc returns article details
	 *
	 * @param int $articleId
	 * @return mixed
	 */
	private function getArticleDetails( $articleId ) {
		$articleDetails = $this->sendRequest( 'ArticlesApi', 'getDetails', [ 'ids' => $articleId ] )
			->getData()[ 'items' ][ $articleId ];

		$articleDetails[ 'abstract' ] = htmlspecialchars( $articleDetails[ 'abstract' ] );

		return $articleDetails;
	}

	/**
	 * @desc returns an article in simplified json structure
	 *
	 * @param int $articleId
	 * @return array
	 */
	private function getArticleJson( $articleId, Title $title ) {
		$redirect = $this->request->getVal( 'redirect' );

		$articleAsJson = $this->sendRequest( 'ArticlesApi', 'getAsJson', [
			'id' => $articleId,
			'redirect' => $redirect
		] )->getData();

		$articleAsJson[ 'description' ] = htmlspecialchars( $articleAsJson[ 'description' ] );

		$articleType = WikiaPageType::getArticleType( $title );

		if ( !empty( $articleType ) ) {
			$articleAsJson[ 'type' ] = $articleType;
		}

		return $articleAsJson;
	}

	/**
	 * @desc returns top contributors user details
	 *
	 * @param int[] $ids
	 * @return mixed
	 */
	private function getTopContributorsDetails( Array $ids ) {
		if ( empty( $ids ) ) {
			return [];
		}
		try {
			return $this->sendRequest( 'UserApi', 'getDetails', [ 'ids' => implode( ',', $ids ) ] )
				->getData()[ 'items' ];
		} catch ( NotFoundApiException $e ) {
			// getDetails throws NotFoundApiException when no contributors are found
			// and we want the article even if we don't have the contributors
			return [];
		}
	}

	/**
	 * @desc Returns local navigation data for current wiki
	 *
	 * @return array
	 */
	private function getNavigationData() {
		return $this->sendRequest( 'NavigationApi', 'getData' )->getData();
	}

	/**
	 * @desc Returns related pages
	 *
	 * @param int $articleId
	 * @param int $limit
	 * @return mixed
	 */
	private function getRelatedPages( $articleId, $limit = 6 ) {
		if ( class_exists( 'RelatedPages' ) ) {
			return RelatedPages::getInstance()->get( $articleId, $limit );
		} else {
			return false;
		}
	}

	/**
	 * @return Title Article Title
	 * @throws NotFoundApiException
	 * @throws BadRequestApiException
	 */
	private function getTitleFromRequest() {
		$articleId = $this->request->getInt( self::PARAM_ARTICLE_ID, NULL );
		$articleTitle = $this->request->getVal( self::PARAM_ARTICLE_TITLE, NULL );
		$articleTitleValidator = new WikiaValidatorString( [ 'min' => 1, 'required' => true ] );

		if ( !empty( $articleId ) && $articleTitleValidator->isValid( $articleTitle ) ) {
			throw new BadRequestApiException( 'Can\'t use id and title in the same request' );
		}

		if ( empty( $articleId ) && !$articleTitleValidator->isValid( $articleTitle ) ) {
			throw new BadRequestApiException( 'You need to pass title or id of an article' );
		}

		if ( empty( $articleId ) ) {
			$title = Title::newFromText( $articleTitle, NS_MAIN );
		} else {
			$title = Title::newFromId( $articleId, NS_MAIN );
		}

		if ( !$title instanceof Title || !$title->isKnown() ) {
			$title = false;
		}

		if ( empty( $title ) ) {
			throw new NotFoundApiException( 'Unable to find any article' );
		}

		return $title;
	}

	/**
	 * @desc Returns article comments in JSON format
	 *
	 * @throws NotFoundApiException
	 * @throws BadRequestApiException
	 * @throws InvalidParameterApiException
	 */
	public function getArticleComments() {
		$title = $this->getTitleFromRequest();
		$articleId = $title->getArticleId();

		$page = $this->request->getInt( self::PARAM_PAGE, self::DEFAULT_PAGE );

		$commentsResponse = $this->app->sendRequest( 'ArticleComments', 'WikiaMobileCommentsPage', [
			'articleID' => $articleId,
			'page' => $page,
			'format' => WikiaResponse::FORMAT_JSON
		] );

		if ( empty( $commentsResponse ) ) {
			throw new BadRequestApiException();
		}

		$commentsData = $commentsResponse->getData();
		$comments = $this->mercuryApi->processArticleComments( $commentsData );

		$this->response->setVal( 'payload', $comments );
		$this->response->setVal( 'pagesCount', $commentsData[ 'pagesCount' ] );
		$this->response->setVal( 'basePath', $this->wg->Server );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	/**
	 * @desc Returns wiki variables for the current wiki
	 *
	 */
	public function getWikiVariables() {
		global $egFacebookAppId;

		$wikiVariables = $this->mercuryApi->getWikiVariables();

		try {
			$wikiVariables[ 'navData' ] = $this->getNavigationData();
		} catch ( Exception $e ) {
			\Wikia\Logger\WikiaLogger::instance()->error( 'Fallback to empty navigation', [
				'exception' => $e
			] );
			$wikiVariables[ 'navData' ] = [];
		}

		$wikiVariables[ 'vertical' ] = WikiFactoryHub::getInstance()->getWikiVertical( $this->wg->CityId )['short'];
		$wikiVariables[ 'basePath' ] = $this->wg->Server;

		// Used to determine GA tracking
		if ( !empty( $this->wg->IsGASpecialWiki ) ) {
			$wikiVariables[ 'isGASpecialWiki' ] = true;
		}

		if ( !empty( $this->wg->ArticlePath ) ) {
			$wikiVariables[ 'articlePath' ] = str_replace( '$1', '', $this->wg->ArticlePath );
		} else {
			$wikiVariables[ 'articlePath' ] = '/wiki/';
		}

		$smartBannerConfig = $this->getSmartBannerConfig();
		if ( !is_null( $smartBannerConfig ) ) {
			$wikiVariables[ 'smartBanner' ] = $smartBannerConfig;
		}

		if ( !is_null( $egFacebookAppId ) ) {
			$wikiVariables[ 'facebookAppId' ] = $egFacebookAppId;
		}

		$this->response->setVal( 'data', $wikiVariables );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		// cache wikiVariables for 1 minute
		$this->response->setCacheValidity( self:: WIKI_VARIABLES_CACHE_TTL );
	}

	/**
	 * @throws NotFoundApiException
	 * @throws BadRequestApiException
	 */
	public function getArticle() {
		try {
			$title = $this->getTitleFromRequest();
			$articleId = $title->getArticleId();
			$articleAsJson = $this->getArticleJson( $articleId, $title );

			$data = [
				'details' => $this->getArticleDetails( $articleId ),
				'topContributors' => $this->getTopContributorsDetails(
					$this->getTopContributorsPerArticle( $articleId )
				),
				'article' => $articleAsJson
			];

			$relatedPages = $this->getRelatedPages( $articleId );

			if ( !empty( $relatedPages ) ) {
				$data[ 'relatedPages' ] = $relatedPages;
			}

			if ( $title->isMainPage() ) {
				$data[ 'mainPageData' ] = $this->getMainPageData();
			}

		} catch ( WikiaHttpException $exception ) {
			$this->response->setCode( $exception->getCode() );

			$data = [];

			$this->response->setVal( 'exception', [
				'message' => $exception->getMessage(),
				'code' => $exception->getCode(),
				'details' => $exception->getDetails()
			] );

			$title = $this->wg->Title;
		}

		$data['adsContext'] = $this->mercuryApi->getAdsContext( $title );

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );

		$this->response->setVal( 'data', $data );
	}

	/**
	 * @desc HG-377: Returns search suggestions
	 *
	 * @throws NotFoundApiException
	 * @throws MissingParameterApiException
	 */
	public function getSearchSuggestions() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setValues(
			$this->sendRequest( 'SearchSuggestionsApi', 'getList', $this->request->getParams() )->getData()
		);
	}

	private function getMainPageData() {
		$mainPageData = [];
		$curatedContent = $this->getCuratedContentData();

		if ( !empty( $curatedContent[ 'sections' ] ) ) {
			$mainPageData[ 'curatedContent' ] = $curatedContent[ 'sections' ];
		}

		if ( !empty( $curatedContent[ 'featured' ] ) ) {
			$mainPageData[ 'featuredContent' ] = $curatedContent[ 'featured' ];
		}

		return $mainPageData;
	}

	public function getCuratedContentSection() {
		$section = $this->getVal( 'section' );

		if ( empty( $section ) ) {
			$this->response->setVal( 'items', false );
		} else {
			$data = $this->getCuratedContentData( $section );

			$this->response->setFormat( 'json' );
			$this->response->setVal( 'items', $data );
		}
	}

	private function getCuratedContentData( $section = null ) {
		$params = [];
		$data = [];

		if ( $section ) {
			$params[ 'section' ] = $section;
		}

		try {
			$rawData = $this->sendRequest( 'CuratedContent', 'getList', $params )->getData();
			$data = $this->mercuryApi->processCuratedContent( $rawData );
		} catch ( NotFoundApiException $ex ) {
			WikiaLogger::instance()->info( 'Curated content and categories are empty' );
		}
		return $data;
	}
}
