<?php

class MercuryApiCategoryHandler {

	const PARAM_CATEGORY_MEMBERS_PAGE = 'categoryMembersPage';

	const TRENDING_ARTICLES_COUNT = 6;

	private static $categoryModel;

	private static function getCategoryModel() {
		if ( !self::$categoryModel instanceof MercuryApiCategoryModel ) {
			self::$categoryModel = new MercuryApiCategoryModel();
		}

		return self::$categoryModel;
	}

	/**
	 * @param Title $title
	 * @param int $page
	 * @param MercuryApi $mercuryApiModel
	 *
	 * @return array
	 * @throws NotFoundApiException
	 */
	public static function getCategoryPageData( Title $title, int $page, MercuryApi $mercuryApiModel ) {
		$categoryDBKey = $title->getDBkey();
		$categoryModel = self::getCategoryModel();
		$membersGrouped = $categoryModel::getMembersGroupedByFirstLetter( $categoryDBKey, $page );
		$pages = $categoryModel::getNumberOfPagesAvailable( $categoryDBKey );

		if ( empty( $membersGrouped ) ) {
			throw new NotFoundApiException( 'Category has no members' );
		}

		return [
			// TODO Remove after XW-2583 is released
			'members' => self::getCategoryMembersLegacy( $title ),
			'membersGrouped' => $membersGrouped,
			'pages' => $pages,
			'nextPage' => $categoryModel::getNextPage( $page, $pages ),
			'prevPage' => $categoryModel::getPrevPage( $page ),
			'trendingArticles' => $mercuryApiModel->getTrendingArticlesData(
				self::TRENDING_ARTICLES_COUNT,
				$title
			),
		];
	}

	/**
	 * @TODO Remove after XW-2583 is released
	 * @param $title
	 * @param int $batchSize
	 *
	 * @return array
	 */
	public static function getCategoryMembersLegacy( $title, $batchSize = 25 ) {
		$categoryPage = CategoryPage::newFromTitle( $title, RequestContext::getMain() );

		$alphabeticalList = F::app()->sendRequest(
			'WikiaMobileCategoryService',
			'alphabeticalList',
			[ 'categoryPage' => $categoryPage, 'format' => 'json' ]
		)->getData();

		$sanitizedAlphabeticalList = [ 'sections' => [] ];

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

	/**
	 * @param Title $title
	 * @param int $page
	 *
	 * @return array
	 * @throws NotFoundApiException
	 */
	public static function getCategoryMembers( Title $title, int $page ) {
		$categoryDBKey = $title->getDBkey();
		$categoryModel = self::getCategoryModel();
		$pages = $categoryModel::getNumberOfPagesAvailable( $categoryDBKey );
		$members = $categoryModel::getMembersGroupedByFirstLetter( $categoryDBKey, $page );

		if ( empty( $members ) ) {
			throw new NotFoundApiException( 'Category has no members' );
		}

		return [
			'members' => $members,
			'nextPage' => $categoryModel::getNextPage( $page, $pages ),
			'prevPage' => $categoryModel::getPrevPage( $page ),
		];
	}

	/**
	 * @param WikiaRequest $request
	 *
	 * @return int
	 * @throws BadRequestApiException
	 */
	public static function getCategoryMembersPageFromRequest( WikiaRequest $request ) {
		$intValidator = new WikiaValidatorInteger( [ 'min' => 1 ] );
		$page = $request->getInt( self::PARAM_CATEGORY_MEMBERS_PAGE, 1 );

		if ( !$intValidator->isValid( $page ) ) {
			throw new BadRequestApiException( 'Category members page should be a positive intenger' );
		}

		return $page;
	}

	/**
	 * @param Title $title
	 *
	 * @return array
	 */
	public static function getCategoryMockedDetails( Title $title ) {
		return [
			'description' => '',
			'id' => $title->getArticleID(),
			'title'=> $title->getText(),
			'url' => $title->getLocalURL()
		];
	}
}
