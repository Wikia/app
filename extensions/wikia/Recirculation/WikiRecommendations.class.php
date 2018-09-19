<?php

use Swagger\Client\WikiRecommendations\Models\Wiki;
use Wikia\Search\TopWikiArticles;

class WikiRecommendations {

	const THUMBNAIL_WIDTH = 100;
	const THUMBNAIL_RATIO = 16 / 9;
	const WIKI_RECOMMENDATIONS_LIMIT = 3;

	public static function getRecommendedWikis( $contentLanguage ) {
		$recommendations = WikiRecommendationsService::getWikiRecommendationsForLanguage(
			$contentLanguage,
			self::WIKI_RECOMMENDATIONS_LIMIT
		);

		$index = 1;
		$processedRecommendations = [];

		/* @var $recommendation Wiki */
		foreach ( $recommendations as $recommendation ) {
			$processedRecommendations[] = [
				'index' => $index,
				'url' => $recommendation->getMainpageUrl(),
				'title' => $recommendation->getWikiName(),
				'thumbnailUrl' => self::getThumbnailUrl( $recommendation->getThumbnailUrl() ),
			];

			$index++;
		}

		return $processedRecommendations;
	}

	private static function getThumbnailUrl( $url ) {
		try {
			return VignetteRequest::fromUrl( $url )->zoomCrop()->width( self::THUMBNAIL_WIDTH )->height(
				floor( self::THUMBNAIL_WIDTH / self::THUMBNAIL_RATIO )
			)->url();
		} catch ( Exception $exception ) {
			\Wikia\Logger\WikiaLogger::instance()->warning(
				"Invalid thumbnail url provided for explore-wikis module inside mixed content footer",
				[
					'thumbnailUrl' => $url,
					'message' => $exception->getMessage(),
				]
			);

			return '';
		}
	}

	public static function getPopularArticles() {
		global $wgCityId;

		$topWikiArticles = TopWikiArticles::getArticlesWithCache( $wgCityId, false );
		// do not show itself
		$topWikiArticles = array_filter(
			$topWikiArticles,
			function ( $item ) {
				return $item['id'] !== RequestContext::getMain()->getTitle()->getArticleID();
			}
		);
		// show max 3 elements
		$topWikiArticles = array_slice( $topWikiArticles, 0, 3 );
		// add index to items to render it by mustache template
		$index = 1;
		foreach ( $topWikiArticles as &$wikiArticle ) {
			$wikiArticle['index'] = $index;
			$index++;
		}

		return $topWikiArticles;
	}
}
