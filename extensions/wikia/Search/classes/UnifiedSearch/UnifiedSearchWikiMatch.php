<?php

declare( strict_types=1 );

namespace Wikia\Search\UnifiedSearch;

use Wikia\Search\Result;

final class UnifiedSearchWikiMatch {

	/** @var string */
	private $searchQuery;
	/** @var UnifiedSearchResultItem */
	private $result;

	public function __construct( UnifiedSearchResultItem $result, string $searchQuery) {

		$this->searchQuery = $searchQuery;
		$this->result = $result;
	}

	public function getResult(): UnifiedSearchResultItem {
		return $this->result;
	}

	public function getSearchQuery(): string {
		return $this->searchQuery;
	}
}
