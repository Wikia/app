<?php

class MercuryApiCategoryHandler {
	const PARAM_CATEGORY_MEMBERS_PAGE = 'categoryMembersPage';

	const CATEGORY_MEMBERS_PER_PAGE = 10;
	const TRENDING_ARTICLES_COUNT = 6;

	/**
	 * @param Title $title
	 * @param int $page
	 * @param MercuryApi $mercuryApiModel
	 *
	 * @return array
	 */
	public static function getCategoryContent( Title $title, int $page, MercuryApi $mercuryApiModel ) {
		$categoryDBKey = $title->getDBkey();

		return [
			'trendingArticles' => $mercuryApiModel->getTrendingArticlesData(
				self::TRENDING_ARTICLES_COUNT,
				$title
			),
			'members' => self::getMembersGroupedByFirstLetter( $categoryDBKey, $page ),
			'pages' => self::getNumberOfPagesAvailable( $categoryDBKey )
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
	 * @param string $categoryDBKey
	 * @param int $page
	 *
	 * @return array
	 */
	private static function getMembersGroupedByFirstLetter( string $categoryDBKey, int $page ) {
		$offset = $page * self::CATEGORY_MEMBERS_PER_PAGE;
		$membersTitles = self::getAlphabeticalList(
			$categoryDBKey,
			self::CATEGORY_MEMBERS_PER_PAGE,
			$offset
		);
		$membersGrouped = [];

		foreach ( $membersTitles as $memberTitle ) {
			$titleText = $memberTitle->getText();
			$firstLetter = mb_substr( $titleText, 0, 1, 'utf-8' );

			if ( !$membersGrouped[$firstLetter] ) {
				$membersGrouped[$firstLetter] = [];
			}

			array_push( $membersGrouped[$firstLetter], [
				'title' => $titleText,
				'isCategory' => $memberTitle->inNamespace( NS_CATEGORY )
			] );
		}

		return $membersGrouped;
	}

	/**
	 * @param $categoryDBKey
	 * @param $limit
	 * @param $offset
	 *
	 * @return Title[]
	 */
	private static function getAlphabeticalList( string $categoryDBKey, int $limit, int $offset ) {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			[ 'page', 'categorylinks' ],
			[ 'page_id', 'page_title' ],
			[ 'cl_to' => $categoryDBKey ],
			__METHOD__,
			[
				'ORDER BY' => 'page_title',
				'LIMIT' => $limit,
				'OFFSET' => $offset
			],
			[ 'categorylinks' => [ 'INNER JOIN', 'cl_from = page_id' ] ]
		);

		$pages = [];
		while ( $row = $res->fetchObject( $res ) ) {
			$title = Title::newFromID( $row->page_id );

			if ( $title instanceof Title) {
				array_push( $pages, $title );
			}
		}

		return $pages;
	}

	/**
	 * @param string $categoryDBKey
	 *
	 * @return int
	 */
	private static function getNumberOfPagesAvailable( string $categoryDBKey ) {
		$dbr = wfGetDB( DB_SLAVE );

		$numberOfPages = $dbr->select(
			[ 'page', 'categorylinks' ],
			[ 'COUNT(page_id) as count' ],
			[ 'cl_to' => $categoryDBKey ],
			__METHOD__,
			[],
			[ 'categorylinks' => [ 'INNER JOIN', 'cl_from = page_id' ] ]
		);

		return floor( $numberOfPages->fetchObject()->count / self::CATEGORY_MEMBERS_PER_PAGE );
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
