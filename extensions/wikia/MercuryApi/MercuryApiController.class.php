<?php

class MercuryApiController extends WikiaController {

	const PARAM_ARTICLE_ID = 'articleId';
	const PARAM_PAGE = 'page';
	const NUMBER_CONTRIBUTORS = 6;
	const DEFAULT_PAGE = 1;

	const ARTICLE_ID_PARAMETER_NAME = "id";
	const ARTICLE_TITLE_PARAMETER_NAME = "title";

	private $mercuryApi = null;

	public function __construct() {
		parent::__construct();
		$this->mercuryApi = new MercuryApi();
	}

	/**
	 * @desc Returns user ids for top contributors
	 *
	 * @throws NotFoundApiException
	 * @throws InvalidParameterApiException
	 */
	public function getTopContributorsPerArticle( $title = null ) {
		if( is_null( $title ) ) {
			$articleId = $this->request->getInt( self::PARAM_ARTICLE_ID );

			if( $articleId === 0 ) {
				throw new InvalidParameterApiException( self::PARAM_ARTICLE_ID );
			}

			$title = Title::newFromID( $articleId );
			if ( empty( $title ) ) {
				throw new NotFoundApiException( self::PARAM_ARTICLE_ID );
			}
		}

		$usersIds = $this->mercuryApi->topContributorsPerArticle( $title, self::NUMBER_CONTRIBUTORS );

		return $usersIds;
	}

	/**
	 * @desc Returns theme settings for the current wiki
	 */
	public function getWikiSettings() {
		$theme = $this->mercuryApi->getWikiSettings();
		$this->response->setVal( 'settings', $theme );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	/**
	 * @desc Returns article comments in JSON format
	 *
	 * @throws NotFoundApiException
	 * @throws BadRequestApiException
	 * @throws InvalidParameterApiException
	 */
	public function getArticleComments() {
		$articleId = $this->request->getInt( self::PARAM_ARTICLE_ID, 0 );

		if( $articleId === 0 ) {
			throw new InvalidParameterApiException( self::PARAM_ARTICLE_ID );
		}

		$title = Title::newFromID( $articleId );
		if ( !( $title instanceof Title ) ) {
			throw new NotFoundApiException( self::PARAM_ARTICLE_ID );
		}

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
		$this->response->setVal( 'pagesCount', $commentsData['pagesCount'] );
		$this->response->setVal( 'basePath', $this->wg->Server );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	public function getArticleDetails( $articleId ){
		return $this->sendRequest( 'ArticlesApi', 'getDetails', ['ids' => $articleId] )->getData()['items'][$articleId];
	}

	public function getArticleJson( $articleId ) {
		return $this->sendRequest( 'ArticlesApi', 'getAsJson', ['id' => $articleId] )->getData();
	}

	public function getTopContributorsDetails( $ids ) {
		return $this->sendRequest( 'UserApi', 'getDetails', ['ids' => implode(',', $ids)] )->getData()['items'];
	}

	public function getRelatedPages( $articleId, $limit = 6 ){
		return RelatedPages::getInstance()->get( $articleId, $limit );
	}

	public function getArticle(){
		$title = null;

		$articleId = $this->request->getInt(self::ARTICLE_ID_PARAMETER_NAME, NULL);
		$articleTitle = $this->request->getVal(self::ARTICLE_TITLE_PARAMETER_NAME, NULL);

		if ( !empty( $articleId ) && !empty( $articleTitle ) ) {
			throw new BadRequestApiException( 'Can\'t use id and title in the same request' );
		}

		if ( empty( $articleId ) && empty( $articleTitle ) ) {
			throw new BadRequestApiException( 'You need to pass title or id of an article' );
		}

		if ( !empty( $articleId ) ) {
			$article = Article::newFromID( $articleId );
		} else {
			$title = Title::newFromText( $articleTitle, NS_MAIN );

			if ( $title instanceof Title && $title->exists() ) {
				$article = Article::newFromTitle( $title, RequestContext::getMain() );
				$articleId = $title->getArticleId();
			}
		}

		if ( empty( $article ) ) {
			throw new NotFoundApiException( "Unable to find any article" );
		}

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		$userIds = $this->getTopContributorsPerArticle( $title );

		$this->response->setVal( 'data', [
			'details' => $this->getArticleDetails( $articleId ),
			'topContributors' => $this->getTopContributorsDetails( $userIds ),
			'article' => $this->getArticleJson( $articleId ),
			'relatedPages' => $this->getRelatedPages( $articleId ),
			'basePath' => $this->wg->Server
		]);
	}
}
