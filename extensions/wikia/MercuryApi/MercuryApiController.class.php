<?php

class MercuryApiController extends WikiaController {

	const PARAM_ARTICLE_ID = 'articleId';
	const PARAM_PAGE = 'page';
	const NUMBER_CONTRIBUTORS = 6;
	const DEFAULT_PAGE = 1;

	private $mercuryApi = null;

	public function __construct() {
		parent::__construct();
		$this->mercuryApi = new MercuryApi();
	}

	/**
	 * @desc Returns number of comments per article
	 *
	 * @throws NotFoundApiException
	 * @throws InvalidParameterApiException
	 */
	public function getArticleCommentsCount() {
		$articleId = $this->request->getInt( self::PARAM_ARTICLE_ID );

		if( $articleId === 0 ) {
			throw new InvalidParameterApiException( self::PARAM_ARTICLE_ID );
		}

		$title = Title::newFromID( $articleId );
		if ( empty( $title ) ) {
			throw new NotFoundApiException( self::PARAM_ARTICLE_ID );
		}

		$count = 0;
		if ( !empty( $this->app->wg->EnableArticleCommentsExt ) ) {
			// Article comments not enabled
			$count = $this->mercuryApi->articleCommentsCount( $title );
		}
		$this->response->setVal( 'count', $count );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	/**
	 * @desc Returns user ids for top contributors
	 *
	 * @throws NotFoundApiException
	 * @throws InvalidParameterApiException
	 */
	public function getTopContributorsPerArticle() {
		$articleId = $this->request->getInt( self::PARAM_ARTICLE_ID );

		if( $articleId === 0 ) {
			throw new InvalidParameterApiException( self::PARAM_ARTICLE_ID );
		}

		$title = Title::newFromID( $articleId );
		if ( empty( $title ) ) {
			throw new NotFoundApiException( self::PARAM_ARTICLE_ID );
		}

		$usersIds = $this->mercuryApi->topContributorsPerArticle( $title, self::NUMBER_CONTRIBUTORS );

		$this->response->setVal( 'items', $usersIds );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
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
		$articleId = $this->request->getInt( self::PARAM_ARTICLE_ID );

		if( $articleId === 0 ) {
			throw new InvalidParameterApiException( self::PARAM_ARTICLE_ID );
		}

		$title = Title::newFromID( $articleId );
		if ( empty( $title ) ) {
			throw new NotFoundApiException( self::PARAM_ARTICLE_ID );
		}

		$page = $this->request->getInt( self::PARAM_PAGE, self::DEFAULT_PAGE );

		$commentsResponse = $this->app->sendRequest( 'ArticleComments', 'WikiaMobileCommentsPage', array(
			'articleID' => $articleId,
			'page' => $page,
			'format' => WikiaResponse::FORMAT_JSON
		) );

		if ( empty( $commentsResponse ) ) {
			throw new BadRequestApiException();
		}

		$commentsData = $commentsResponse->getData();
		$comments = $this->mercuryApi->processArticleComments( $commentsData );

		$this->response->setVal( 'items', $comments );
		$this->response->setVal( 'pagesCount', $commentsData[ 'pagesCount' ] );
		//$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

}
