<?php

class MercuryApiController extends WikiaController {

	const PARAM_ARTICLE_ID = 'articleId';
	const PARAM_PAGE = 'page';
	const NUMBER_CONTRIBUTORS = 6;

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

		$count = $this->mercuryApi->articleCommentsCount( $title );

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

	public function getArticleComments() {
		$articleId = $this->request->getInt( self::PARAM_ARTICLE_ID );

		if( $articleId === 0 ) {
			throw new InvalidParameterApiException( self::PARAM_ARTICLE_ID );
		}

		$page = $this->request->getInt( self::PARAM_PAGE, 1 );

		$comments = $this->mercuryApi->getArticleComments( $this->app, $articleId, $page );

		$this->response->setVal( 'items', $comments );

		//$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

}
