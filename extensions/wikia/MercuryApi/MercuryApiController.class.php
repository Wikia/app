<?php

class MercuryApiController extends WikiaController {

	const PARAM_ARTICLE_ID = 'articleId';
	const PARAM_PAGE = 'page';
	const NUMBER_CONTRIBUTORS = 6;
	const DEFAULT_PAGE = 1;

	private $mercuryApi = null;
	private $Annotation = null;

	public function __construct() {
		parent::__construct();
		$this->mercuryApi = new MercuryApi();
		$this->Annotation = new MercuryAnnotation();
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

	/**
	 * Do an edit on a snippet of text.
	 */
	public function editSnippet() {
		$articleId = $this->getVal("articleId");
		$origText = $this->getVal("origText");
		$edit = $this->getVal("edit");

		$response = $this->mercuryApi->editSnippet( $articleId, $origText, $edit );

		$this->setVal("response", $response);
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	/**
	 * Get all the annotations for a given article and annotation id
	 */
	public function getAnnotationComments() {
		$annotationId = $this->getVal( "annotationId" );
		$articleId = $this->getVal( "articleId" );

		$response = $this->Annotation->getAnnotations( $articleId, $annotationId );

		$this->setVal("data", $response);
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	/**
	 * Save a new comment on an existing annotation
	 */
	public function setAnnotationComment() {
		$annotationId = $this->getVal( "annotationId" );
		$articleId = $this->getVal( "articleId" );
		$comment = $this->getVal( "comment" );

		$response = $this->Annotation->setAnnotation( $articleId, $annotationId, $comment );

		$this->setVal("data", $response);
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

	}

	/**
	 * Create a new annotation and save the first comment
	 */
	public function createAnnotation() {
		$annotationId = $this->getVal( "annotationId" );
		$articleId = $this->getVal( "articleId" );
		$origText = $this->getVal("origText");
		$newText = "<span class='annotation' id='$annotationId'>" . $origText . "</span>";
		$comment = $this->getVal( "comment" );

		$editResponse = $this->mercuryApi->editSnippet( $articleId, $origText, $newText );
		if ( $editResponse['success'] ) {
			$annotateResponse = $this->Annotation->setAnnotation( $articleId, $annotationId, $comment );
			$this->setVal( "data", $annotateResponse );
		} else {
			$this->setVal( "data", $editResponse );
		}

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

}
