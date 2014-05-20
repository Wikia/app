<?php

class MercuryApiController extends WikiaController {

	const PARAM_ARTICLE_ID = 'articleId';

	public function __construct() {
		parent::__construct();
	}

	public function getCommentsPerArticleCount() {
		$articleId = $this->request->getInt( self::PARAM_ARTICLE_ID );

		if( $articleId === 0 ) {
			throw new InvalidParameterApiException( self::PARAM_ARTICLE_ID );
		}

		$title = Title::newFromID( $articleId );
		if ( empty( $title ) ) {
			throw new NotFoundApiException( self::PARAM_ARTICLE_ID );
		}

		$articleCommentList = new ArticleCommentList();
		$articleCommentList->setTitle( $title );
		$count = $articleCommentList->getCountAll();

		$this->response->setVal( 'count', $count );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}
} 