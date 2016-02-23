<?php

class MercuryApiCategoryHandler {

	public static function getCategoryContent(Title $title) {
		$categoryPage = CategoryPage::newFromTitle($title, RequestContext::getMain());
		return [
			'members' => self::getMembers($categoryPage),
			'exhibition' => self::getExhibition($categoryPage),
			'name' => self::getCategoryName($title)
		];
	}

	public static function getMembers($categoryPage) {
		$alphabeticalList =  F::app()->sendRequest(
			'WikiaMobileCategoryService',
			'alphabeticalList',
			['categoryPage' => $categoryPage]
		)->getData();

		$sanitizedAlphabeticalList = ['collections' => [] ];

		foreach ( $alphabeticalList['collections'] as $index => $collection ) {
			$batch = ( $index == $alphabeticalList['requestedIndex'] ) ? $alphabeticalList['requestedBatch'] : 1;
			$itemsBatch = wfPaginateArray( $collection, WikiaMobileCategoryModel::BATCH_SIZE, $batch );
			$currentBatch = $itemsBatch['currentBatch'];
			$nextBatch = $currentBatch + 1;

			$sanitizedAlphabeticalList['collections'][$index] = [
				'items' => $itemsBatch['items'],
				'nextBatch' => $nextBatch,
				'currentBatch' => $currentBatch,
				'total' => $itemsBatch['total'],
				'hasNext' => $itemsBatch['next'] > 0,
				'batchSize' => WikiaMobileCategoryModel::BATCH_SIZE
			];
		}

		return $sanitizedAlphabeticalList;
	}

	public static function getExhibition($categoryPage) {
		return F::app()->sendRequest(
			'WikiaMobileCategoryService',
			'categoryExhibition',
			['categoryPage' => $categoryPage]
		)->getData();
	}

	public static function hasArticle(Title $title) {
		return $title->getArticleID() > 0;
	}

	private static function getCategoryName(Title $title) {
		return $title->getText();
	}
}
