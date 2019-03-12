<?php

namespace Wikia\FeedsAndPosts;

use ArticleService;
use ImageServing;
use Title;

class ArticleData {
	public static function getImages(int $articleId, $limit=11): array {
		$imageData = ( new ImageServing( [ $articleId ] ) )->getImages( $limit )[strval( $articleId )] ?? [];

		$urls = array_map(function($imageData) {
			return $imageData['url'];
		}, $imageData);

		return $urls;
	}

	public static function getTextSnippet(Title $title) {
		return htmlspecialchars((new ArticleService($title))->getTextSnippet(300, 350));
	}
}