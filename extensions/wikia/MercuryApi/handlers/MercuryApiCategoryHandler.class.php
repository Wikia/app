<?php

class MercuryApiCategoryHandler {
	/**
	 * @var WikiaMobileCategoryService
	 */
	private $categoryService = null;
	private $title = null;
	private $categoryPage = null;

	public function __construct($title) {
		$this->categoryService = new WikiaMobileCategoryService();
		$this->title = $title;
		$this->categoryPage = CategoryPage::newFromTitle($title, RequestContext::getMain());
	}

	public function getCategoryContent() {
		return [
			'members' => $this->getMembers(),
			'exhibition' => $this->getExhibition(),
			'content' => $this->getContent()
		];
	}

	public function getMembers() {
		$alphabeticalList =  F::app()->sendRequest(
			'WikiaMobileCategoryService',
			'alphabeticalList',
			['categoryPage' => $this->categoryPage]
		)->getData();

		$sanitizedAlphabeticalList = ['collections' => [] ];

		foreach ( $alphabeticalList['collections'] as $index => $collection ) {
			$batch = ( $index == $alphabeticalList['requestedIndex'] ) ? $alphabeticalList['requestedBatch'] : 1;
			$itemsBatch = wfPaginateArray( $collection, WikiaMobileCategoryModel::BATCH_SIZE, $batch );
			$currentBatch = $itemsBatch['currentBatch'];
			$nextBatch = $currentBatch + 1;
			$prevBatch = $currentBatch - 1;

			$sanitizedAlphabeticalList['collections'][rawurlencode( $index )] = [
				'items' => $itemsBatch['items'],
				'nextBatch' => $nextBatch,
				'currentBatch' => $currentBatch,
				'prevBatch' => $prevBatch,
				'total' => $itemsBatch['total'],
				'hasNext' => $itemsBatch['next'] > 0
			];
		}

		return $sanitizedAlphabeticalList;
	}

	public function getExhibition() {
		return F::app()->sendRequest(
			'WikiaMobileCategoryService',
			'categoryExhibition',
			['categoryPage' => $this->categoryPage]
		)->getData();
	}

	public function getContent() {
		return null;
	}
}
