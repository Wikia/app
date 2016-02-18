<?php

class MercuryApiArticleHandler {

	/**
	 * @param Article $article
	 * @param WikiaRequest $request
	 * @param MercuryApi $mercuryApiModel
	 * @return array
	 */
	public static function getArticleData( Article $article, WikiaRequest $request, MercuryApi $mercuryApiModel ) {
		$data['details'] = self::getArticleDetails( $article );
		$data['article'] = self::getArticleJson( $article, $request );
		$data['topContributors'] = self::getTopContributorsDetails(
			self::getTopContributorsPerArticle( $mercuryApiModel, $article )
		);
		$relatedPages = self::getRelatedPages( $article );

		if ( !empty( $relatedPages ) ) {
			$data['relatedPages'] = $relatedPages;
		}

		return $data;
	}

	/**
	 * @desc returns article details
	 *
	 * @param Article $article
	 * @return mixed
	 */
	public static function getArticleDetails( Article $article ) {
		$articleId = $article->getID();
		$articleDetails = F::app()
			->sendRequest( 'ArticlesApi', 'getDetails', [ 'ids' => $articleId ] )
			->getData()['items'][$articleId];

		$description = self::getArticleDescription( $article );

		$articleDetails['abstract'] = htmlspecialchars( $articleDetails['abstract'] );
		$articleDetails['description'] = htmlspecialchars( $description );

		return $articleDetails;
	}

	/**
	 * @desc Returns description for the article's meta tag.
	 *
	 * This is mostly copied from the ArticleMetaDescription extension.
	 *
	 * @param Article $article
	 * @param int $descLength
	 * @return string
	 * @throws WikiaException
	 */
	public static function getArticleDescription( Article $article, $descLength = 100 ) {
		$title = $article->getTitle();
		$sMessage = null;

		if ( $title->isMainPage() ) {
			// we're on Main Page, check MediaWiki:Description message
			$sMessage = wfMessage( 'Description' )->text();
		}

		if ( ( $sMessage == null ) || wfEmptyMsg( 'Description', $sMessage ) ) {
			$articleService = new ArticleService( $article );
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
	 * @param Article $article
	 * @param WikiaRequest $request
	 * @return array
	 */
	public static function getArticleJson( Article $article, WikiaRequest $request ) {
		$redirect = $request->getVal( 'redirect' );
		$sections = $request->getVal( 'sections', '' );

		return F::app()->sendRequest(
			'ArticlesApi',
			'getAsJson',
			[
				'id' => $article->getID(),
				'redirect' => $redirect,
				'sections' => $sections
			]
		)->getData();
	}

	/**
	 * @desc returns top contributors user details
	 *
	 * @param array $ids
	 * @return mixed
	 */
	private static function getTopContributorsDetails( Array $ids ) {
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
	 * @param $mercuryApiModel
	 * @param $article
	 * @return int[]
	 */
	private static function getTopContributorsPerArticle( MercuryApi $mercuryApiModel, Article $article ) {
		return $mercuryApiModel->topContributorsPerArticle(
			$article->getID(),
			MercuryApiController::NUMBER_CONTRIBUTORS
		);
	}

	/**
	 * @desc Returns related pages
	 *
	 * @param Article $article
	 * @param int $limit
	 * @return mixed
	 */
	private static function getRelatedPages( Article $article, $limit = 6 ) {
		if ( class_exists( 'RelatedPages' ) ) {
			return RelatedPages::getInstance()->get( $article->getID(), $limit );
		} else {
			return false;
		}
	}
}
