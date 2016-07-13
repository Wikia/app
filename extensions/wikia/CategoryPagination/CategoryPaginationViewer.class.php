<?php

use Wikia\Paginator\Paginator;

class CategoryPaginationViewer extends CategoryViewer {
	private $page;
	private $counts;
	/** @var Paginator[] */
	private $paginators = [];

	public function __construct( $title, IContextSource $context, $page ) {
		parent::__construct( $title, $context );

		$this->page = $page;

		$cat = Category::newFromTitle( $this->title );
		$this->counts = [
			'file' => $cat->getFileCount(),
			'subcat' => $cat->getSubcatCount(),
			'page' => $cat->getPageCount() - $cat->getFileCount() - $cat->getSubcatCount(),
		];

		$url = $this->title->getLocalURL();

		foreach ( array_keys( $this->from ) as $type ) {
			$this->from[$type] = $this->getActualFrom( $type, $page );
			$this->paginators[$type] = new Paginator( $this->counts[$type], $this->limit, $url );
			$this->paginators[$type]->setActivePage( $this->page );
		}

		$context->getOutput()->addHeadItem( 'Paginator', $this->getPaginationHeadItem() );
	}

	private function getPaginationHeadItem() {
		$numPages = -1;
		$maxPaginator = null;
		foreach ( $this->paginators as $paginator ) {
			if ( $paginator->getPagesCount() > $numPages ) {
				$numPages = $paginator->getPagesCount();
				$maxPaginator = $paginator;
			}
		}
		if ( $maxPaginator ) {
			return $maxPaginator->getHeadItem();
		}
		return '';
	}

	/**
	 * Select the first page matching given type and page number and return the human-readable
	 * sort key associated with it
	 *
	 * This value is passed to the original CategoryViewer code as the $this->from member.
	 * The DB is called, but the query uses the proper index and therefor is super fast (< 10ms),
	 * so there's no need to cache.
	 */
	private function getActualFrom( $type, $page ) {
		$dbr = wfGetDB( DB_SLAVE, 'category' );

		// if beyond the last page, show the last page instead
		$totalPages = ceil( $this->counts[$type] / $this->limit );
		if ( $page > $totalPages && $totalPages >= 1 ) {
			$page = $totalPages;
		}

		$conditions = [
			'cl_to' => $this->title->getDBkey(),
			'cl_type' => $type,
		];

		$res = $dbr->select(
			[ 'page', 'categorylinks' ],
			[ 'page.*', 'cl_sortkey_prefix' ],
			$conditions,
			__METHOD__,
			[
				'USE INDEX' => array( 'categorylinks' => 'cl_sortkey' ),
				'LIMIT' => 1,
				'OFFSET' => ( $page - 1 ) * $this->limit,
				'ORDER BY' => 'cl_sortkey',
			],
			[ 'categorylinks' => [ 'INNER JOIN', 'cl_from = page_id' ] ]
		);
		$row = $res->fetchObject();

		if ( $row ) {
			$title = Title::newFromRow( $row );
			$humanSortKey = $title->getCategorySortkey( $row->cl_sortkey_prefix );
			return $humanSortKey;
		}

		return null;
	}

	public function getSectionPagingLinks( $type ) {
		// This method is called twice. Once for the pagination at the top of the section
		// and the second time for the pagination at the bottom. We only want to output
		// the pagination at the bottom: the second time this method is called for given type

		static $wasCalled = [];
		if ( isset( $wasCalled[$type] ) ) {
			return $this->paginators[$type]->getBarHTML();
		}
		$wasCalled[$type] = true;
	}
}
