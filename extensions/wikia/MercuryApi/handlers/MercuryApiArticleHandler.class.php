<?php

class MercuryApiArticleHandler {

	const NUMBER_CONTRIBUTORS = 5;

	/**
	 * @param WikiaRequest $request
	 * @param MercuryApi $mercuryApiModel
	 * @param Article $article
	 * @return array
	 */
	public static function getArticleData( WikiaRequest $request, MercuryApi $mercuryApiModel, Article $article ) {
		$data['details'] = self::getArticleDetails( $article );
		$data['article'] = self::getArticleJson( $request, $article );
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

		$articleDetails['abstract'] = htmlspecialchars( $articleDetails['abstract'] );
		$articleDetails['description'] = htmlspecialchars( self::getArticleDescription( $article ) );

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
	 * @param WikiaRequest $request
	 * @param Article $article
	 * @return array
	 */
	public static function getArticleJson( WikiaRequest $request, Article $article ) {
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
	public static function getTopContributorsDetails( Array $ids ) {
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
	 * @param MercuryApi $mercuryApiModel
	 * @param Article $article
	 * @return int[]
	 */
	private static function getTopContributorsPerArticle(MercuryApi $mercuryApiModel, Article $article) {
		return $mercuryApiModel->topContributorsPerArticle(
			$article->getID(),
			self::NUMBER_CONTRIBUTORS
		);
	}

	/**
	 * @desc Returns related pages
	 *
	 * @param Article $article
	 * @param int $limit
	 * @return mixed
	 */
	public static function getRelatedPages( Article $article, $limit = 6 ) {
		if ( class_exists( 'RelatedPages' ) ) {
			return RelatedPages::getInstance()->get( $article->getID(), $limit );
		} else {
			return false;
		}
	}
}
