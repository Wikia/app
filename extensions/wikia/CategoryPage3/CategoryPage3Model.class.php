<?php

class CategoryPage3Model {
	const DEFAULT_MEMBERS_PER_PAGE_LIMIT = 200;

	/** @var Category */
	private $category;

	/** @var Collation */
	private $collation;

	/** @var DatabaseMysqli */
	private $dbr;

	/** @var string */
	private $from;

	/** @var CategoryPage3Member[] */
	private $members;

	/** @var int */
	private $membersPerPageLimit;

	/** @var CategoryPage3Pagination */
	private $pagination;

	/** @var Title */
	private $title;

	/** @var int */
	private $totalNumberOfMembers;

	public function __construct( Title $title, $from ) {
		$this->category = Category::newFromTitle( $title );
		$this->collation = Collation::singleton();
		$this->from = $from;
		$this->members = [];
		$this->membersPerPageLimit = static::DEFAULT_MEMBERS_PER_PAGE_LIMIT;
		$this->pagination = new CategoryPage3Pagination( $title, $from );
		$this->title = $title;
		$this->totalNumberOfMembers = 0;
	}

	/**
	 * @throws FatalError
	 * @throws MWException
	 */
	public function loadData() {
		$this->dbr = wfGetDB( DB_SLAVE, 'category' );

		$this->findTotalNumberOfMembers();
		$results = $this->getMembersFromDB();

		if ( $results->numRows() === 0 && $this->totalNumberOfMembers > 0 ) {
			// `from` is larger than the last item, let's show the last page instead
			$this->from = $this->getLastPageKey();
			$results = $this->getMembersFromDB();
		}

		$this->addPagesFromDbResults( $results );
		$this->findPrevPage();

		if ( $this->pagination->getNextPageKey() ) {
			$this->pagination->setLastPageKey( $this->getLastPageKey() );
		}
	}

	/**
	 * @param $thumbWidth
	 * @param $thumbHeight
	 */
	public function loadImages( $thumbWidth, $thumbHeight ) {
		$pageIds = array_keys(
			array_filter(
				$this->members,
				function ( $member ) {
					/** @var CategoryPage3Member $member */
					return !$member->isSubcategory();
				}
			)
		);
		$imageServing = new ImageServing( $pageIds, $thumbWidth, [ 'w' => $thumbWidth, 'h' => $thumbHeight ] );

		foreach ( $imageServing->getImages( 1 ) as $pageId => $images ) {
			$member = $this->members[ $pageId ];
			$member->setImage( $images[0]['url'] );
		}
	}

	public function getMembers(): array {
		return $this->members;
	}

	public function getMembersGroupedByChar(): array {
		$membersGroupedByChar = [];

		foreach ( $this->members as $member ) {
			$firstChar = $member->getFirstChar();

			if ( !isset( $membersGroupedByChar[ $firstChar ] ) ) {
				$membersGroupedByChar[ $firstChar ] = [];
			}

			$membersGroupedByChar[ $firstChar ][] = $member;
		}

		return $membersGroupedByChar;
	}

	public function getPagination(): CategoryPage3Pagination {
		return $this->pagination;
	}

	public function getTotalNumberOfMembers(): int {
		return $this->totalNumberOfMembers;
	}

	/**
	 * @return array
	 * @throws FatalError
	 * @throws MWException
	 */
	private function getExtraConditionsForQuery(): array {
		$extraConds = [];

		if ( $this->from !== null ) {
			// Get the sortkeys.
			// Note that if the collation in the database differs from the one
			// set in $wgCategoryCollation, pagination might go totally haywire.
			$extraConds[] =
				'cl_sortkey >= ' . $this->dbr->addQuotes( $this->collation->getSortKey( $this->from ) );
		}

		// Allow other extensions to add more conditions, e.g. exclude namespaces
		Hooks::run( 'CategoryPage3::beforeCategoryData', [ &$extraConds ] );

		return $extraConds;
	}

	/**
	 * @return ResultWrapper
	 * @throws FatalError
	 * @throws MWException
	 */
	private function getMembersFromDB(): ResultWrapper {
		$extraConditions = $this->getExtraConditionsForQuery();

		return $this->dbr->select(
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
				'LIMIT' => $this->membersPerPageLimit + 1,
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

		$firstChar = $wgContLang->convert( $this->collation->getFirstLetter( $sortkey ) );
		$this->members[ $title->getArticleID() ] = new CategoryPage3Member( $title, $firstChar );
	}

	private function findTotalNumberOfMembers() {
		$totalNumberOfMembers = WikiaDataAccess::cache(
			$this->getMemcacheKey( __METHOD__ ),
			WikiaResponse::CACHE_STANDARD,
			[ $this, 'getTotalNumberOfMembersFromDB' ]
		);

		$this->totalNumberOfMembers = $totalNumberOfMembers;
	}

	public function getTotalNumberOfMembersFromDB() {
		return $this->dbr->selectField(
			'categorylinks',
			'count(0)',
			[
				'cl_to' => $this->title->getDBkey()
			],
			__METHOD__
		);
	}

	private function findPrevPage() {
		if ( $this->from === null ) {
			return;
		}

		$res = $this->dbr->select(
			[ 'page', 'categorylinks' ],
			[
				'page_id', 'page_title', 'page_namespace', 'page_len', 'page_is_redirect',
				'cl_sortkey_prefix', 'cl_collation'
			],
			[
				'cl_to' => $this->title->getDBkey(),
				'cl_sortkey < ' . $this->dbr->addQuotes( $this->collation->getSortKey( $this->from ) )
			],
			__METHOD__,
			[
				'USE INDEX' => [ 'categorylinks' => 'cl_sortkey' ],
				'LIMIT' => $this->membersPerPageLimit + 1,
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
			if ( ++$count > $this->membersPerPageLimit ) {
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

	private function getLastPageKey() {
		return WikiaDataAccess::cache(
			$this->getMemcacheKey( __METHOD__ ),
			WikiaResponse::CACHE_STANDARD,
			[ $this, 'getLastPageKeyFromDB' ]
		);
	}

	public function getLastPageKeyFromDB() {
		$lastPageMembersCount = $this->totalNumberOfMembers % $this->membersPerPageLimit;

		// For example totalNumberOfMembers = 400 and membersPerPageLimit = 200
		if ( $lastPageMembersCount === 0 ) {
			$lastPageMembersCount = $this->membersPerPageLimit;
		}

		$res = $this->dbr->select(
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

		return $this->getHumanSortkey( $lastRow, $title );
	}

	private function addPagesFromDbResults( ResultWrapper $results ) {
		$count = 0;

		foreach ( $results as $row ) {
			$title = Title::newFromRow( $row );
			$humanSortkey = $this->getHumanSortkey( $row, $title );

			if ( ++$count > $this->membersPerPageLimit ) {
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

	private function getMemcacheKey( String $method ): String {
		return wfMemcKey(
			$method,
			$this->title->getDBkey(),
			CategoryPage3CacheHelper::getTouched( $this->title )
		);
	}

	/**
	 * To be used in tests
	 * @param int $membersPerPageLimit
	 */
	public function setMembersPerPageLimit( int $membersPerPageLimit ) {
		$this->membersPerPageLimit = $membersPerPageLimit;
	}
}
