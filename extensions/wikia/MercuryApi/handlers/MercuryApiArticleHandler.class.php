<?php

use Wikia\Factory\ServiceFactory;

class MercuryApiArticleHandler {

	const NUMBER_CONTRIBUTORS = 5;

	/**
	 * @param MercuryApi $mercuryApiModel
	 * @param Article $article
	 *
	 * @return array
	 */
	public static function getArticleData( MercuryApi $mercuryApiModel, Article $article ) {
		$data['topContributors'] = self::getTopContributorsDetails(
			self::getTopContributorsPerArticle( $mercuryApiModel, $article )
		);

		return $data;
	}

	/**
	 * @desc returns article details
	 *
	 * @param Article $article
	 *
	 * @return array
	 * @throws FatalError
	 * @throws MWException
	 * @throws WikiaException
	 */
	public static function getArticleDetails( Article $article ) {
		$articleId = $article->getID();
		$articleDetails = F::app()->sendRequest( 'ArticlesApi', 'getDetails', [ 'ids' => $articleId ] )->getData(
			)['items'][$articleId];

		$articleDetails['abstract'] = htmlspecialchars( $articleDetails['abstract'] );
		$articleDetails['description'] = htmlspecialchars( self::getArticleDescription( $article ) );

		\Hooks::run( 'MercuryArticleDetails', [ $article, &$articleDetails ] );

		return $articleDetails;
	}

	/**
	 * @desc Returns description for the article's meta tag.
	 *
	 * This is mostly copied from the ArticleMetaDescription extension.
	 *
	 * @param Article $article
	 * @param int $descLength
	 *
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
	 *
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

	public static function getFeaturedVideoDetails( Title $title ): array {
		$featuredVideo = ArticleVideoContext::getFeaturedVideoData( $title->getArticleID() );

		if ( !empty( $featuredVideo ) ) {
			$featuredVideoData['provider'] = 'jwplayer';
			$featuredVideoData['embed']['provider'] = 'jwplayer';
			$featuredVideoData['embed']['jsParams']['videoId'] = $featuredVideo['mediaId'];
			$featuredVideoData['embed']['jsParams']['playlist'] = $featuredVideo['playlist'];
			$featuredVideoData['embed']['jsParams']['videoTags'] = $featuredVideo['videoTags'];
			$featuredVideoData['embed']['jsParams']['recommendedVideoPlaylist'] = $featuredVideo['recommendedVideoPlaylist'];
			$featuredVideoData['metadata'] = $featuredVideo['metadata'];
			$featuredVideoData['isDedicatedForArticle'] = $featuredVideo['isDedicatedForArticle'];
			$featuredVideoData['isDedicatedForArticle'] = $featuredVideo['isDedicatedForArticle'];

			if (isset($featuredVideo['impressionsPerSession'])) {
				$featuredVideoData['impressionsPerSession'] = $featuredVideo['impressionsPerSession'];
			}

			return $featuredVideoData;
		}

		return [];
	}

	/**
	 * @desc returns top contributors user details
	 *
	 * @param array $ids
	 *
	 * @return mixed
	 */
	public static function getTopContributorsDetails( Array $ids ) {
		global $wgMemc;

		if ( empty( $ids ) ) {
			return [];
		}

		$cacheKey = wfMemcKey( __METHOD__, ...$ids );
		$userInfo = $wgMemc->get( $cacheKey );

		if ( is_array( $userInfo ) ) {
			return $userInfo;
		}

		$userAttributeGateway = ServiceFactory::instance()->attributesFactory()->userAttributeGateway();
		$usersWithAttributes = $userAttributeGateway->getAllAttributesForMultipleUsers( $ids );

		$userInfo = [];

		foreach ( $ids as $userId ) {
			$userPage = Title::makeTitle( NS_USER, $usersWithAttributes['users'][$userId]['username'] );

			$userInfo[] = [
				'url' => $userPage->getFullURL(),
				'name' =>  $usersWithAttributes['users'][$userId]['username'],
				'avatar' => $usersWithAttributes['users'][$userId]['avatar'] ?? null,
			];
		}

		$wgMemc->set( $cacheKey, $userInfo, 3600 * 4 /* 4 hours */ );

		return $userInfo;
	}

	/**
	 * @desc Returns user ids for top contributors
	 *
	 * @param MercuryApi $mercuryApiModel
	 * @param Article $article
	 *
	 * @return int[]
	 */
	private static function getTopContributorsPerArticle( MercuryApi $mercuryApiModel, Article $article ) {
		return $mercuryApiModel->topContributorsPerArticle(
			$article->getID(),
			self::NUMBER_CONTRIBUTORS
		);
	}
}
