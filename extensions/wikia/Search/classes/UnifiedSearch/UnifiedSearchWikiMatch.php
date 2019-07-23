<?php

declare( strict_types=1 );

namespace Wikia\Search\UnifiedSearch;

use Wikia\Search\Result;

final class UnifiedSearchWikiMatch {

	/** @var string */
	private $searchQuery;
	/** @var Result */
	private $result;

	public function __construct( array $result, string $searchQuery) {

		$this->searchQuery = $searchQuery;
		$this->result = new Result($result);
	}

	public function getResult(): Result {
		return $this->result;
	}

	public function getSearchQuery(): string {
		return $this->searchQuery;
	}
}
