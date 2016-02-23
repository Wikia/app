<?php

class MercuryApiCategoryHandler {

	public static function getCategoryContent( Title $title ) {
		$categoryPage = CategoryPage::newFromTitle( $title, RequestContext::getMain() );
		return [
			'members' => self::getMembers( $categoryPage ),
			'name' => self::getCategoryName( $title )
		];
	}

	public static function getMembers( $categoryPage, $batchSize = 25 ) {
		$alphabeticalList =  F::app()->sendRequest(
			'WikiaMobileCategoryService',
			'alphabeticalList',
			['categoryPage' => $categoryPage, 'isMercury' => true]
		)->getData();

		$sanitizedAlphabeticalList = ['sections' => [] ];

		foreach ( $alphabeticalList['collections'] as $index => $collection ) {
			$batch = ( $index == $alphabeticalList['requestedIndex'] ) ? $alphabeticalList['requestedBatch'] : 1;
			$itemsBatch = wfPaginateArray( $collection, $batchSize, $batch );
			$currentBatch = $itemsBatch['currentBatch'];
			$nextBatch = $currentBatch + 1;

			$sanitizedAlphabeticalList['sections'][$index] = [
				'items' => $itemsBatch['items'],
				'nextBatch' => $nextBatch,
				'currentBatch' => $currentBatch,
				'total' => $itemsBatch['total'],
				'hasNext' => $itemsBatch['next'] > 0,
				'batchSize' => $batchSize
			];
		}

		return $sanitizedAlphabeticalList;
	}

	public static function hasArticle( Title $title ) {
		return $title->getArticleID() > 0;
	}

	private static function getCategoryName( Title $title ) {
		return $title->getText();
	}
}
