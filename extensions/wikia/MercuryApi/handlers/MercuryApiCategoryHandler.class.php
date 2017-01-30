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
		$members = $categoryModel->getMembersGroupedByFirstLetter( $categoryDBKey, $page );

		if ( empty( $members ) ) {
			throw new NotFoundApiException( 'Category has no members' );
		}

		return [
			'trendingArticles' => $mercuryApiModel->getTrendingArticlesData(
				self::TRENDING_ARTICLES_COUNT,
				$title
			),
			'members' => $members,
			'pages' => $categoryModel->getNumberOfPagesAvailable( $categoryDBKey )
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
		$members = self::getCategoryModel()->getMembersGroupedByFirstLetter( $title->getDBkey(), $page );

		if ( empty( $members ) ) {
			throw new NotFoundApiException( 'Category has no members' );
		}

		return [
			'members' => $members
		];
	}

	/**
	 * @param WikiaRequest $request
	 *
	 * @return int
	 * @throws BadRequestApiException
	 */
	public static function getCategoryMembersPageFromRequest( WikiaRequest $request ) {
		$intValidator = new WikiaValidatorInteger( [ 'min' => 0 ] );
		$page = $request->getInt( self::PARAM_CATEGORY_MEMBERS_PAGE, 0 );

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
