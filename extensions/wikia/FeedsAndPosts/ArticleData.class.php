<?php

namespace Wikia\FeedsAndPosts;

use ArticleService;
use ImageServing;
use Title;
use WikiaDataAccess;

class ArticleData {
	public static function getImages( int $articleId, $limit = 11 ): array {
		return WikiaDataAccess::cache(
			wfMemcKey('feeds', 'article-images', $articleId),
			10800, // 3h
			function () use ( $articleId, $limit ) {
				$imageData = ( new ImageServing( [ $articleId ] ) )->getImages( $limit )[strval( $articleId )] ?? [];

				$urls = array_map(function($imageData) {
					return $imageData['url'];
				}, $imageData);

				return $urls;
			}
		);
	}

	public static function getTextSnippet( Title $title ) {
		return ( new ArticleService( $title ) )->getTextSnippet( 300, 350 );
	}
}