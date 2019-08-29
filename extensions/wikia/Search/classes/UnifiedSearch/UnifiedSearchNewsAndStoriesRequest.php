<?php

namespace Wikia\Search\UnifiedSearch;

use Wikia\Search\Config;
use Wikia\Search\Query\Select;

class UnifiedSearchNewsAndStoriesRequest {

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

	public static function topResults( Config $config ): self {
		$instance = new self($config);

		$instance->page = 0;

		return $instance;
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
