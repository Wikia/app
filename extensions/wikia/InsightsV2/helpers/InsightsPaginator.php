<?php

class InsightsPaginator {
	const INSIGHTS_LIST_MAX_LIMIT = 100;

	/** @var int Counted shift based on pagination page number and limit of items per page */
	private $offset = 0;
	/** @var int Number of items per pagination page */
	private $limit = self::INSIGHTS_LIST_MAX_LIMIT;
	/** @var int Number of all items in model - used for pagination */
	private $total;
	/** @var int Number of current pagination page */
	private $page = 0;
	private $subpage;
	private $params = [];

	public function __construct( $subpage, $params ) {
		$this->subpage = $subpage;
		$this->params = $params;
		$this->total = ( new InsightsCountService() )->getCount( $this->subpage );

		$this->preparePaginationParams();
	}

	public function getTotal() {
		return $this->total;
	}

	public function getLimit() {
		return $this->limit;
	}

	public function getOffset() {
		return $this->offset;
	}

	public function getPage() {
		return $this->page;
	}

	public function getParams() {
		return $this->params;
	}

	/**
	 * Set size of full data set of model
	 * @param int $total
	 */
	public function setTotal( $total) {
		$this->total = $total;
	}

	public function setParams( Array $params ) {
		$this->params = $params;
	}

	/**
	 * Prepare pagination
	 */
	public function getPagination() {
		$params = array_merge( $this->getParams(), [ 'page' => '%s' ] );
		$url = urldecode( InsightsHelper::getSubpageLocalUrl( $this->subpage, $params ) );

		$paginator = Paginator::newFromCount( $this->getTotal(), $this->getLimit() );
		$paginator->setActivePage( $this->getPage() + 1 );
		$paginatorBar = $paginator->getBarHTML( $url );

		return $paginatorBar;
	}

	/**
	 * Overrides the default values used for pagination
	 *
	 * @param array $params An array of URL parameters
	 */
	private function preparePaginationParams() {
		if ( isset( $this->params['limit'] ) ) {
			if ( $this->params['limit'] <= self::INSIGHTS_LIST_MAX_LIMIT ) {
				$this->limit = intval( $this->params['limit'] );
			} else {
				$this->limit = self::INSIGHTS_LIST_MAX_LIMIT;
			}
		}

		if ( isset( $this->params['page'] ) ) {
			$page = intval( $this->params['page'] );
			// TODO: migrate to 1-indexed pagination
			$this->page = --$page;
			$this->offset = $this->page * $this->limit;
		}
	}
}
