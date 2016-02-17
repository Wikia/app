<?php

class MercuryApiArticleHandler {
	/**
	 * @var Article|null
	 */
	private $article = null;
	private $request = null;
	private $mercuryApi = null;
	private $articleId = null;

	public function __construct( Article $article, WikiaRequest $request, MercuryApi $mercuryApi ) {
		$this->article = $article;
		$this->request = $request;
		$this->mercuryApi = $mercuryApi;
		$this->articleId = $this->article->getID();
	}

	/**
	 * @return array
	 * @throws NotFoundApiException
	 */
	public function getArticleData() {

		$data['details'] = $this->getArticleDetails();
		$data['article'] = $this->getArticleJson();
		$data['topContributors'] = $this->getTopContributorsDetails(
			$this->getTopContributorsPerArticle()
		);
		$relatedPages = $this->getRelatedPages();

		if ( !empty( $relatedPages ) ) {
			$data['relatedPages'] = $relatedPages;
		}

		return $data;
	}

	/**
	 * @desc returns article details
	 *
	 * @return mixed
	 */
	public function getArticleDetails() {
		$articleId = $this->article->getID();
		$articleDetails = F::app()
			->sendRequest( 'ArticlesApi', 'getDetails', [ 'ids' => $articleId ] )
			->getData()['items'][$articleId];

		$description = $this->getArticleDescription();

		$articleDetails['abstract'] = htmlspecialchars( $articleDetails['abstract'] );
		$articleDetails['description'] = htmlspecialchars( $description );

		return $articleDetails;
	}

	/**
	 * @desc Returns description for the article's meta tag.
	 *
	 * This is mostly copied from the ArticleMetaDescription extension.
	 *
	 * @param int $descLength
	 *
	 * @return string
	 * @throws NotFoundApiException
	 */
	private function getArticleDescription( $descLength = 100 ) {
		$title = $this->article->getTitle();
		$sMessage = null;

		if ( $title->isMainPage() ) {
			// we're on Main Page, check MediaWiki:Description message
			$sMessage = wfMessage( 'Description' )->text();
		}

		if ( ( $sMessage == null ) || wfEmptyMsg( 'Description', $sMessage ) ) {
			$articleService = new ArticleService( $this->article );
			$description = $articleService->getTextSnippet( $descLength );
		} else {
			// MediaWiki:Description message found, use it
			$description = $sMessage;
		}

		return $description;
	}

	/**
	 * @desc returns an article in simplified json structure
	 *
	 * @return array
	 */
	private function getArticleJson() {
		$redirect = $this->request->getVal( 'redirect' );
		$sections = $this->request->getVal( 'sections', '');

		return F::app()
			->sendRequest(
				'ArticlesApi',
				'getAsJson',
				[
					'id' => $this->articleId,
					'redirect' => $redirect,
					'sections' => $sections
				]
			)
			->getData();
	}

	/**
	 * @desc returns top contributors user details
	 *
	 * @param array $ids
	 * @return mixed
	 */
	private function getTopContributorsDetails( Array $ids ) {
		if ( empty( $ids ) ) {
			return [ ];
		}

		try {
			return F::app()->sendRequest( 'UserApi', 'getDetails', [ 'ids' => implode( ',', $ids ) ] )
				->getData()['items'];
		} catch ( NotFoundApiException $e ) {
			// getDetails throws NotFoundApiException when no contributors are found
			// and we want the article even if we don't have the contributors
			return [ ];
		}
	}

	/**
	 * @desc Returns user ids for top contributors
	 *
	 * @return int[]
	 */
	private function getTopContributorsPerArticle() {
		return $this->mercuryApi->topContributorsPerArticle( $this->articleId, MercuryApiController::NUMBER_CONTRIBUTORS );
	}

	/**
	 * @desc Returns related pages
	 *
	 * @param int $limit
	 *
	 * @return mixed
	 */
	private function getRelatedPages( $limit = 6 ) {
		if ( class_exists( 'RelatedPages' ) ) {
			return RelatedPages::getInstance()->get( $this->articleId, $limit );
		} else {
			return false;
		}
	}
}
