<?php

class MercuryApiCategoryHandler {

	const PARAM_CATEGORY_MEMBERS_PAGE = 'categoryMembersPage';

	const TRENDING_ARTICLES_LIMIT = 6;

	private static $categoryModel;

	/**
	 * @return MercuryApiCategoryModel
	 */
	private static function getCategoryModel(): MercuryApiCategoryModel {
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
	public static function getCategoryPageData( Title $title, int $page, MercuryApi $mercuryApiModel ): array {
		$categoryDBKey = $title->getDBkey();
		$categoryModel = self::getCategoryModel();
		$membersGrouped = $categoryModel::getMembersGroupedByFirstLetter( $categoryDBKey, $page );

		if ( empty( $membersGrouped ) ) {
			throw new NotFoundApiException( 'Category has no members' );
		}

		return array_merge(
			[
				// TODO Remove after XW-2583 is released
				'members' => $categoryModel::getCategoryMembersLegacy( $title ),
				'membersGrouped' => $membersGrouped,
				'trendingArticles' => $mercuryApiModel->getTrendingArticlesData(
					self::TRENDING_ARTICLES_LIMIT,
					$title
				),
			],
			$categoryModel::getPagination( $title, $page )
		);
	}

	/**
	 * @param Title $title
	 * @param int $page
	 *
	 * @return array
	 * @throws NotFoundApiException
	 */
	public static function getCategoryMembers( Title $title, int $page ): array {
		$categoryModel = self::getCategoryModel();
		$membersGrouped = $categoryModel::getMembersGroupedByFirstLetter( $title->getDBkey(), $page );

		if ( empty( $membersGrouped ) ) {
			throw new NotFoundApiException( 'Category has no members' );
		}

		return array_merge(
			[ 'membersGrouped' => $membersGrouped ],
			$categoryModel::getPagination( $title, $page )
		);
	}

	/**
	 * @param WikiaRequest $request
	 *
	 * @return int
	 * @throws BadRequestApiException
	 */
	public static function getCategoryMembersPageFromRequest( WikiaRequest $request ): int {
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
	public static function getCategoryMockedDetails( Title $title ): array {
		return [
			'description' => '',
			'id' => $title->getArticleID(),
			'title'=> $title->getText(),
			'url' => $title->getLocalURL()
		];
	}
}
