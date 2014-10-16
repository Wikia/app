<?php

class MercuryApiController extends WikiaController {

	const PARAM_ARTICLE_ID = 'id';
	const PARAM_PAGE = 'page';
	const PARAM_ARTICLE_TITLE = 'title';

	const NUMBER_CONTRIBUTORS = 6;
	const DEFAULT_PAGE = 1;

	private $mercuryApi = null;

	public function __construct() {
		parent::__construct();
		$this->mercuryApi = new MercuryApi();
	}

	/**
	 * @desc Returns smart banner config that is stored in WF
	 */
	private function getSmartBannerConfig() {
		if ( !empty( $this->wg->EnableWikiaMobileSmartBanner )
			&& !empty( $this->wg->WikiaMobileSmartBannerConfig )
		) {
			return $this->wg->WikiaMobileSmartBannerConfig;
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
	private function getArticleDetails( $articleId ){
		return $this->sendRequest( 'ArticlesApi', 'getDetails', [ 'ids' => $articleId ] )
			->getData()[ 'items' ][ $articleId ];
	}

	/**
	 * @desc returns an article in simplified json structure
	 *
	 * @param int $articleId
	 * @return array
	 */
	private function getArticleJson( $articleId ) {
		$redirect = $this->request->getVal('redirect');

		return $this->sendRequest( 'ArticlesApi', 'getAsJson', [
			'id' => $articleId,
			'redirect' => $redirect
		] )->getData();
	}

	/**
	 * @desc returns top contributors user details
	 *
	 * @param int[] $ids
	 * @return mixed
	 */
	private function getTopContributorsDetails( Array $ids ) {
		try {
			return $this->sendRequest( 'UserApi', 'getDetails', [ 'ids' => implode( ',', $ids ) ] )
				->getData()[ 'items' ];
		} catch (NotFoundApiException $e) {
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
	private function getNavigationData(){
		return $this->sendRequest( 'NavigationApi', 'getData' )->getData();
	}

	/**
	 * @desc Returns related pages
	 *
	 * @param int $articleId
	 * @param int $limit
	 * @return mixed
	 */
	private function getRelatedPages( $articleId, $limit = 6 ){
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
	private function getTitleFromRequest(){
		$articleId = $this->request->getInt( self::PARAM_ARTICLE_ID, NULL );
		$articleTitle = $this->request->getVal( self::PARAM_ARTICLE_TITLE, NULL );

		if ( !empty( $articleId ) && !empty( $articleTitle ) ) {
			throw new BadRequestApiException( 'Can\'t use id and title in the same request' );
		}

		if ( empty( $articleId ) && empty( $articleTitle ) ) {
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
		$wikiVariables = $this->mercuryApi->getWikiVariables();
		$wikiVariables[ 'navData' ] = $this->getNavigationData();

		// Used to determine GA tracking
		if ( !empty( $this->wg->IsGASpecialWiki ) ) {
			$wikiVariables[ 'isGASpecialWiki' ] = true;
		}

		$smartBannerConfig = $this->getSmartBannerConfig();

		if ( !is_null( $smartBannerConfig ) ) {
			$wikiVariables[ 'smartbanner' ] = $smartBannerConfig;
		}

		$this->response->setVal( 'data', $wikiVariables );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	/**
	 * @throws NotFoundApiException
	 * @throws BadRequestApiException
	 */
	public function getArticle(){
		$title = $this->getTitleFromRequest();
		$articleId = $title->getArticleId();

		$articleAsJson = $this->getArticleJson( $articleId );

		$data = [
			'details' => $this->getArticleDetails( $articleId ),
			'topContributors' => $this->getTopContributorsDetails(
					$this->getTopContributorsPerArticle( $articleId )
				),
			'article' => $articleAsJson,
			'adsContext' => $this->mercuryApi->getAdsContext( $title ),
			'basePath' => $this->wg->Server
		];

		$relatedPages = $this->getRelatedPages( $articleId );
		if ( !empty( $relatedPages ) ) {
			$data[ 'relatedPages' ] = $relatedPages;
		}

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		$this->response->setVal( 'data', $data );
	}
}
