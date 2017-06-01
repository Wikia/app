<?php

class MercuryApiCategoryModel {

	const CATEGORY_MEMBERS_PER_PAGE = 200;

	public static function getMembersGroupedByFirstLetter( string $categoryDBKey, int $page ): array {
		return WikiaDataAccess::cache(
			MercuryApiCategoryCacheHelper::getCacheKeyForMethod(
				$categoryDBKey,
				__METHOD__ . '-' . $page
			),
			MercuryApiCategoryCacheHelper::CACHE_TTL,
			function () use ( $categoryDBKey, $page ) {
				$offset = ( $page - 1 ) * self::CATEGORY_MEMBERS_PER_PAGE;
				$membersTitles = self::getAlphabeticalList(
					$categoryDBKey,
					self::CATEGORY_MEMBERS_PER_PAGE,
					$offset
				);
				$membersGrouped = [];

				foreach ( $membersTitles as $memberTitle ) {
					$titleText = $memberTitle->getText();
					$firstLetter = mb_substr( $titleText, 0, 1, 'utf-8' );

					if ( !mb_check_encoding( $firstLetter, 'utf-8' ) ) {
						\Wikia\Logger\WikiaLogger::instance()->error(
							'Category member title has broken UTF-8 character',
							[
								'articleId' => $memberTitle->getArticleID(),
								'dbKey' => $memberTitle->getDBkey()
							]
						);

						continue;
					}

					if ( !isset( $membersGrouped[$firstLetter] ) ) {
						$membersGrouped[$firstLetter] = [];
					}

					array_push( $membersGrouped[$firstLetter], [
						'title' => $titleText,
						'url' => $memberTitle->getLocalURL(),
						'isCategory' => $memberTitle->inNamespace( NS_CATEGORY )
					] );
				}

				return $membersGrouped;
			}
		);
	}

	/**
	 * @param $categoryDBKey
	 * @param $limit
	 * @param $offset
	 *
	 * @return Title[]
	 */
	private static function getAlphabeticalList( string $categoryDBKey, int $limit, int $offset ): array {
		return TitleBatch::newFromConds(
			'categorylinks',
			[ 'cl_to' => $categoryDBKey ],
			__METHOD__,
			[
				'ORDER BY' => 'page_title',
				'LIMIT' => $limit,
				'OFFSET' => $offset
			],
			[ 'categorylinks' => [ 'INNER JOIN', 'cl_from = page_id' ] ]
		)->getAll();
	}

	/**
	 * @TODO Remove after XW-2583 is released
	 * @param $title
	 * @param int $batchSize
	 *
	 * @return array
	 */
	public static function getCategoryMembersLegacy( $title, $batchSize = 25 ): array {
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
	 * @param string $categoryDBKey
	 *
	 * @return int
	 */
	public static function getNumberOfPagesAvailable( string $categoryDBKey ): int {
		return WikiaDataAccess::cache(
			MercuryApiCategoryCacheHelper::getCacheKeyForMethod(
				$categoryDBKey,
				__METHOD__
			),
			MercuryApiCategoryCacheHelper::CACHE_TTL,
			function () use ( $categoryDBKey ) {
				$dbr = wfGetDB( DB_SLAVE );

				$numberOfPages = $dbr->select(
					[ 'page', 'categorylinks' ],
					[ 'COUNT(page_id) as count' ],
					[ 'cl_to' => $categoryDBKey ],
					__METHOD__,
					[],
					[ 'categorylinks' => [ 'INNER JOIN', 'cl_from = page_id' ] ]
				);

				return ceil( $numberOfPages->fetchObject()->count / self::CATEGORY_MEMBERS_PER_PAGE );
			}
		);
	}

	/**
	 * @param Title $title
	 * @param int $page
	 *
	 * @return array
	 */
	public static function getPagination( Title $title, int $page ): array {
		$pages = self::getNumberOfPagesAvailable( $title->getDBkey() );

		$nextPage = self::getNextPage( $page, $pages );
		$nextPageUrl = $nextPage > 0 ? self::getPageUrl( $title, $nextPage ) : null;

		$prevPage = self::getPrevPage( $page );
		$prevPageUrl = $prevPage > 0 ? self::getPageUrl( $title, $prevPage ) : null;

		return [
			'nextPage' => $nextPage,
			'nextPageUrl' => $nextPageUrl,
			'prevPage' => $prevPage,
			'prevPageUrl' => $prevPageUrl
		];
	}

	private static function getNextPage( int $page, int $pages ) {
		if ( $page >= $pages ) {
			return null;
		} else {
			return $page + 1;
		}
	}

	private static function getPrevPage( int $page ) {
		if ( $page <= 1 ) {
			return null;
		} else {
			return $page - 1;
		}
	}

	/**
	 * @param Title $title
	 * @param int $page
	 *
	 * @return String
	 */
	private static function getPageUrl( Title $title, int $page ): string {
		$params = [];

		// We don't want to have ?page=1, it's implicit
		if ( $page > 1 ) {
			$params['page'] = $page;
		}

		return $title->getLocalURL( $params );
	}
}
