<?php

use Wikia\Paginator\Paginator;

class InsightsPaginator {
	const INSIGHTS_LIST_MAX_LIMIT = 100;

	/** @var int Counted shift based on pagination page number and limit of items per page */
	private $offset = 0;
	/** @var int Number of items per pagination page */
	private $limit = self::INSIGHTS_LIST_MAX_LIMIT;
	/** @var int Number of all items in model - used for pagination */
	private $total;
	/** @var int Number of current pagination page */
	private $page = 1;
	private $subpage;
	private $params = [];

	public function __construct( $subpage, $params ) {
		$this->subpage = $subpage;
		if ( isset( $params['page'] ) ) {
			$this->page = $params['page'];
		}
		$this->params = $this->filterParams( $params );
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
		$url = urldecode( InsightsHelper::getSubpageLocalUrl( $this->subpage, $this->getParams() ) );

		$paginator = new Paginator( $this->getTotal(), $this->getLimit(), $url );
		$paginator->setActivePage( $this->getPage() );
		$paginatorBar = $paginator->getBarHTML();

		return $paginatorBar;
	}

	/**
	 * Overrides the default values used for pagination
	 *
	 * @param array $params An array of URL parameters
	 */
	private function preparePaginationParams() {
		if ( isset( $this->params['limit'] ) && $this->params['limit'] <= self::INSIGHTS_LIST_MAX_LIMIT ) {
			$this->limit = intval( $this->params['limit'] );
		}

		$this->offset = ( $this->page - 1 ) * $this->limit;
	}

	private function filterParams( $params ) {
		unset( $params['page'] );

		return $params;
	}
}
