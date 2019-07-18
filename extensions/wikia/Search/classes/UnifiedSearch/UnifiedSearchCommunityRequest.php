<?php

namespace Wikia\Search\UnifiedSearch;

use Wikia\Search\Config;
use Wikia\Search\Query\Select;

class UnifiedSearchCommunityRequest {

	/** @var Select */
	private $query;

	/** @var integer */
	private $page;
	/** @var integer */
	private $limit;


	public function __construct( Config $config ) {
		$this->query = $config->getQuery();
		$this->page = $config->getPage() - 1;
		$this->limit = $config->getLimit();
	}

	/**
	 * @return Select
	 */
	public function getQuery(): Select {
		return $this->query;
	}

	/**
	 * @return int
	 */
	public function getPage(): int {
		return $this->page;
	}

	/**
	 * @return int
	 */
	public function getLimit(): int {
		return $this->limit;
	}
}
