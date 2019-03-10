<?php
/**
 * Created by PhpStorm.
 * User: ryba
 * Date: 10/03/2019
 * Time: 15:20
 */

namespace Wikia\FeedsAndPosts;

use ImageServing;

class ArticleData {
	public static function getImages(int $articleId, $limit=11): array {
		$imageData = (new ImageServing([$articleId]))->getImages($limit)[strval($articleId)] ?? [];

		$urls = array_map(function($imageData) {
			return $imageData['url'];
		}, $imageData);

		return $urls;
	}
}