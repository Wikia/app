<?php

class CategoryPage3Model {
	const ITEMS_PER_PAGE_LIMIT = 200;

	/** @var Category */
	private $category;

	/** @var Collation */
	private $collation;

	/** @var string */
	private $from;

	/** @var array */
	private $members;

	/** @var CategoryPage3Pagination */
	private $pagination;

	/** @var Title */
	private $title;

	public function __construct( Title $title, $from ) {
		$this->category = Category::newFromTitle( $title );
		$this->collation = Collation::singleton();
		$this->from = $from;
		$this->members = [];
		$this->pagination = new CategoryPage3Pagination( $title );
		$this->title = $title;
	}

	/**
	 * @throws FatalError
	 * @throws MWException
	 */
	public function loadData() {
		$dbr = wfGetDB( DB_SLAVE, 'category' );

		$results = $this->runQuery( $dbr );
		$this->addPagesFromDbResults( $results );
		$this->findPrevPage( $dbr );

		if ( $this->pagination->getNextPageKey() ) {
			$this->findLastPage( $dbr );
		}
	}

	public function getMembers(): array {
		return $this->members;
	}

	public function getPagination(): CategoryPage3Pagination {
		return $this->pagination;
	}

	/**
	 * @param $dbr
	 * @return array
	 * @throws FatalError
	 * @throws MWException
	 */
	private function getExtraConditionsForQuery( DatabaseMysqli $dbr ): array {
		$extraConds = [];

		if ( $this->from !== null ) {
			// Get the sortkeys.
			// Note that if the collation in the database differs from the one
			// set in $wgCategoryCollation, pagination might go totally haywire.
			$extraConds[] =
				'cl_sortkey >= ' . $dbr->addQuotes( $this->collation->getSortKey( $this->from ) );
		}

		// Allow other extensions to add more conditions, e.g. exclude namespaces
		Hooks::run( 'CategoryPage3::beforeCategoryData', [ &$extraConds ] );

		return $extraConds;
	}

	/**
	 * @param DatabaseMysqli $dbr
	 * @return ResultWrapper
	 * @throws FatalError
	 * @throws MWException
	 */
	private function runQuery( DatabaseMysqli $dbr ): ResultWrapper {
		$extraConditions = $this->getExtraConditionsForQuery( $dbr );

		return $dbr->select(
			[ 'page', 'categorylinks', 'category' ],
			[
				'page_id', 'page_title', 'page_namespace', 'page_len',
				'page_is_redirect', 'cl_sortkey', 'cat_id', 'cat_title',
				'cat_subcats', 'cat_pages', 'cat_files',
				'cl_sortkey_prefix', 'cl_collation'
			],
			array_merge( [ 'cl_to' => $this->title->getDBkey() ], $extraConditions ),
			__METHOD__,
			[
				'USE INDEX' => [ 'categorylinks' => 'cl_sortkey' ],
				'LIMIT' => static::ITEMS_PER_PAGE_LIMIT + 1,
				'ORDER BY' => 'cl_sortkey',
			],
			[
				'categorylinks' => [ 'INNER JOIN', 'cl_from = page_id' ],
				'category' => [ 'LEFT JOIN', 'cat_title = page_title AND page_namespace = ' . NS_CATEGORY ]
			]
		);
	}

	private function addPage( Title $title, $sortkey ) {
		global $wgContLang;

		$link = Linker::link( $title );

		$firstChar = $wgContLang->convert( $this->collation->getFirstLetter( $sortkey ) );

		if ( !isset( $this->members[ $firstChar ] ) ) {
			$this->members[ $firstChar ] = [];
		}

		$this->members[ $firstChar ][] = $link;
	}

	private function findPrevPage( DatabaseMysqli $dbr ) {
		if ( $this->from === null ) {
			return;
		}

		$res = $dbr->select(
			[ 'page', 'categorylinks' ],
			[
				'page_id', 'page_title', 'page_namespace', 'page_len', 'page_is_redirect',
				'cl_sortkey_prefix', 'cl_collation'
			],
			[
				'cl_to' => $this->title->getDBkey(),
				'cl_sortkey < ' . $dbr->addQuotes( $this->collation->getSortKey( $this->from ) )
			],
			__METHOD__,
			[
				'USE INDEX' => [ 'categorylinks' => 'cl_sortkey' ],
				'LIMIT' => static::ITEMS_PER_PAGE_LIMIT + 1,
				'ORDER BY' => 'cl_sortkey DESC',
			],
			[
				'categorylinks' => [ 'INNER JOIN', 'cl_from = page_id' ],
			]
		);

		$lastRow = null;
		$count = 0;
		$this->pagination->setIsPrevPageTheFirstPage( true );

		foreach ( $res as $row ) {
			if ( ++$count > static::ITEMS_PER_PAGE_LIMIT ) {
				$this->pagination->setIsPrevPageTheFirstPage( false );
				break;
			}

			$lastRow = $row;
		}

		// Happens when `from` is used but there is no previous page
		if ( $lastRow === null ) {
			return;
		}

		$title = Title::newFromRow( $lastRow );
		$this->pagination->setPrevPageKey( $this->getHumanSortkey( $lastRow, $title ) );
	}

	private function findLastPage( DatabaseMysqli $dbr ) {
		$totalCount = $dbr->selectField(
			'categorylinks',
			'count(0)',
			[
				'cl_to' => $this->title->getDBkey()
			],
			__METHOD__
		);

		$lastPageMembersCount = $totalCount % static::ITEMS_PER_PAGE_LIMIT;

		$res = $dbr->select(
			[ 'page', 'categorylinks' ],
			[
				'page_id', 'page_title', 'page_namespace', 'page_len', 'page_is_redirect',
				'cl_sortkey_prefix', 'cl_collation'
			],
			[
				'cl_to' => $this->title->getDBkey()
			],
			__METHOD__,
			[
				'USE INDEX' => [ 'categorylinks' => 'cl_sortkey' ],
				'LIMIT' => $lastPageMembersCount,
				'ORDER BY' => 'cl_sortkey DESC',
			],
			[
				'categorylinks' => [ 'INNER JOIN', 'cl_from = page_id' ],
			]
		);

		$lastRow = null;

		foreach ( $res as $row ) {
			$lastRow = $row;
		}

		$title = Title::newFromRow( $lastRow );
		$this->pagination->setLastPageKey( $this->getHumanSortkey( $lastRow, $title ) );
	}

	private function addPagesFromDbResults( ResultWrapper $results ) {
		$count = 0;

		foreach ( $results as $row ) {
			$title = Title::newFromRow( $row );
			$humanSortkey = $this->getHumanSortkey( $row, $title );

			if ( ++$count > static::ITEMS_PER_PAGE_LIMIT ) {
				$this->pagination->setNextPageKey( $humanSortkey );
				break;
			}

			$this->addPage( $title, $humanSortkey );
		}
	}

	private function getHumanSortkey( $row, Title $title ) {
		if ( $row->cl_collation === '' ) {
			// Hack to make sure that while updating from 1.16 schema
			// and db is inconsistent, that the sky doesn't fall.
			// See r83544. Could perhaps be removed in a couple decades...
			$humanSortkey = $row->cl_sortkey;
		} else {
			$humanSortkey = $title->getCategorySortkey( $row->cl_sortkey_prefix );
		}

		return $humanSortkey;
	}
}
