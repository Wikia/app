<?php

namespace Wikia\FeedsAndPosts;

class TopArticles extends MediaWikiAPI {

	const LIMIT = 12;

	const IMAGE_WIDTH = 80;
	const IMAGE_RATIO = 4 / 3;

	public function get() {
		$cacheTTL = 3600; // an hour

		return \WikiaDataAccess::cache( wfMemcKey( 'feeds-top-articles' ), $cacheTTL, function () {
			$responseData = [];
			$mainPageId = \Title::newMainPage()->getArticleID();
			$model = new \InsightsPopularPagesModel();
			var_dump( 'getTopArticles' );
			var_dump( $model );
			$insightData =
				( new \InsightsContext( $model ) )->getContent();

			var_dump( $insightData );
			die();

			foreach ( $insightData as $articleId => $articleData ) {
				if ( count( $responseData ) === self::LIMIT ) {
					break;
				}

				$title = $articleData['link']['title'];

				if ( $mainPageId !== $articleId ) {
					$responseData[] = [
						'title' => $title,
						'url' => $articleData['link']['url'],
						'image' => $this->getImage( $title, self::IMAGE_WIDTH, self::IMAGE_RATIO ),
					];
				}
			}

			return $responseData;
		} );
	}

}
