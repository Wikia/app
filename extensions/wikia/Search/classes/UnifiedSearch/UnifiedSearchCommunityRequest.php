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
	/** @var string */
	private $language;

	public function __construct( Config $config ) {
		$this->query = $config->getQuery();
		$this->page = $config->getPage() - 1;
		$this->limit = $config->getLimit();
		if ( is_array( $config->getLanguageCode() ) ) {
			$this->language = $config->getLanguageCode()[0] ?? null;
		} else {
			$this->language = $config->getLanguageCode();
		}
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

	public function getLanguage(): string {
		return $this->language;
	}
}
