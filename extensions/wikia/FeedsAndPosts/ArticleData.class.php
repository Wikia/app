<?php

namespace Wikia\FeedsAndPosts;

use ArticleService;
use ImageServing;

class ArticleData {
	public static function getImages(int $articleId, $limit=11): array {
		$imageData = (new ImageServing([$articleId]))->getImages($limit)[strval($articleId)] ?? [];

		$urls = array_map(function($imageData) {
			return $imageData['url'];
		}, $imageData);

		return $urls;
	}

	public static function getTextSnippet(int $articleId) {
		return htmlspecialchars((new ArticleService($articleId))->getTextSnippet(300, 350));
	}

	public static function getArticleTitle(int $articleId) {
		return \Title::newFromID($articleId)->getText();
	}
}