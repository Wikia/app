<?php

class MercuryApiCategoryHandler {

	public static function getCategoryContent( Title $title ) {
		$categoryPage = CategoryPage::newFromTitle( $title, RequestContext::getMain() );
		return [
			'members' => self::getMembers( $categoryPage )
		];
	}

	public static function getMembers( $categoryPage, $batchSize = 25 ) {
		$alphabeticalList =  F::app()->sendRequest(
			'WikiaMobileCategoryService',
			'alphabeticalList',
			['categoryPage' => $categoryPage, 'format' => 'json']
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

	public static function hasArticle( $request, $article ) {
		if ( $article instanceof Article && $article->getID() > 0 ) {
			$data = MercuryApiArticleHandler::getArticleJson($request, $article);
			return !empty( $data['content'] ) && strlen( $data['content'] ) > 0;
		} else {
			return false;
		}
	}

	public static function getCategoryMockedDetails( Title $title ) {
		return [
			'description' => '',
			'id' => $title->getArticleID(),
			'title'=> $title->getText(),
			'url' => $title->getLocalURL()
		];
	}
}
