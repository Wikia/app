<?php

class MercuryApiCategoryHandler {

	const PARAM_CATEGORY_MEMBERS_FROM = 'categoryMembersFrom';
	const PARAM_CATEGORY_MEMBERS_PAGE = 'categoryMembersPage';

	const TRENDING_ARTICLES_LIMIT = 8;

	private static $categoryModel;

	private static function getCategoryModel( Title $title, $from ): CategoryPage3Model {
		if ( !self::$categoryModel instanceof CategoryPage3Model ) {
			self::$categoryModel = new CategoryPage3Model( $title, $from );
			self::$categoryModel->loadData();
			self::$categoryModel->loadImages( 40, 30 );
		}

		return self::$categoryModel;
	}

	/**
	 * @deprecated
	 * @return MercuryApiCategoryModel
	 */
	private static function getDeprecatedCategoryModel(): MercuryApiCategoryModel {
		if ( !self::$categoryModel instanceof MercuryApiCategoryModel ) {
			self::$categoryModel = new MercuryApiCategoryModel();
		}

		return self::$categoryModel;
	}

	/**
	 * @param Title $title
	 * @param string $from
	 * @param int $page
	 * @param MercuryApi $mercuryApiModel
	 *
	 * @return array
	 * @throws NotFoundApiException
	 */
	public static function getCategoryPageData( Title $title, $from, int $page, MercuryApi $mercuryApiModel ): array {
		$categoryModel = self::getCategoryModel( $title, $from );

		if ( $categoryModel->getTotalNumberOfMembers() === 0 ) {
			throw new NotFoundApiException( 'Category has no members' );
		}

		$deprecatedCategoryModel = self::getDeprecatedCategoryModel();

		return array_merge(
			[
				'members' => $categoryModel->getMembersGroupedByChar(),
				// TODO Remove after SEO-670 is released on mobile-wiki and no cached JS tries to use it anymore
				'membersGrouped' => $deprecatedCategoryModel::getMembersGroupedByFirstLetter( $title->getDBkey(), $page ),
				'pagination' => $categoryModel->getPagination()->toArray(),
				'totalNumberOfMembers' => $categoryModel->getTotalNumberOfMembers(),
				'trendingArticles' => $mercuryApiModel->getTrendingArticlesData(
					self::TRENDING_ARTICLES_LIMIT,
					$title,
					true
				)
			],
			// TODO Remove after SEO-670 is released on mobile-wiki and no cached JS tries to use it anymore
			$deprecatedCategoryModel::getPagination( $title, $page )
		);
	}

	/**
	 * @param Title $title
	 * @param string $from
	 * @param int $page
	 * @return array
	 * @throws NotFoundApiException
	 */
	public static function getCategoryMembers( Title $title, $from, int $page ): array {
		$categoryModel = self::getCategoryModel( $title, $from );

		if ( $categoryModel->getTotalNumberOfMembers() === 0 ) {
			throw new NotFoundApiException( 'Category has no members' );
		}

		$deprecatedCategoryModel = self::getDeprecatedCategoryModel();

		return array_merge(
			[
				'members' => $categoryModel->getMembersGroupedByChar(),
				// TODO Remove after SEO-670 is released on mobile-wiki and no cached JS tries to use it anymore
				'membersGrouped' => $deprecatedCategoryModel::getMembersGroupedByFirstLetter( $title->getDBkey(), $page ),
				'pagination' => $categoryModel->getPagination()->toArray()
			],
			// TODO Remove after SEO-670 is released on mobile-wiki and no cached JS tries to use it anymore
			$deprecatedCategoryModel::getPagination( $title, $page )
		);
	}

	public static function getCategoryMembersFromFromRequest( WikiaRequest $request ) {
		return $request->getVal( self::PARAM_CATEGORY_MEMBERS_FROM, null );
	}

	/**
	 * @deprecated Remove after SEO-670 is released on mobile-wiki and no cached code tries to use it anymore
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
			'title' => $title->getText(),
			'url' => $title->getLocalURL()
		];
	}
}
