<?php

class MercuryApiCategoryHandler {

	const PARAM_CATEGORY_MEMBERS_PAGE = 'categoryMembersPage';

	const TRENDING_ARTICLES_COUNT = 6;

	private static $categoryModel;

	/**
	 * @return MercuryApiCategoryModel
	 */
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

		if ( empty( $membersGrouped ) ) {
			throw new NotFoundApiException( 'Category has no members' );
		}

		$pages = $categoryModel::getNumberOfPagesAvailable( $categoryDBKey );

		$nextPage = $categoryModel::getNextPage( $page, $pages );
		$nextPageUrl = $nextPage > 0 ? self::getPageUrl( $title, $nextPage ) : null;

		$prevPage = $categoryModel::getPrevPage( $page );
		$prevPageUrl = $prevPage > 0 ? self::getPageUrl( $title, $prevPage ) : null;

		return [
			// TODO Remove after XW-2583 is released
			'members' => $categoryModel::getCategoryMembersLegacy( $title ),
			'membersGrouped' => $membersGrouped,
			'nextPage' => $nextPage,
			'nextPageUrl' => $nextPageUrl,
			'prevPage' => $prevPage,
			'prevPageUrl' => $prevPageUrl,
			'trendingArticles' => $mercuryApiModel->getTrendingArticlesData(
				self::TRENDING_ARTICLES_COUNT,
				$title
			),
		];
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
	 * @param int $page
	 *
	 * @return String
	 */
	private static function getPageUrl( Title $title, int $page ) {
		$params = [];

		// We don't want to have ?page=1, it's implicit
		if ( $page > 1 ) {
			$params['page'] = $page;
		}

		return $title->getLocalURL( $params );
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
