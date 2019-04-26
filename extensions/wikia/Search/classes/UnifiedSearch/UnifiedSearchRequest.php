<?php

namespace Wikia\Search\UnifiedSearch;

use Wikia\Search\Config;
use Wikia\Search\Query\Select;

class UnifiedSearchRequest {

	/** @var Select */
	private $query;

	/** @var string */
	private $languageCode;
	/** @var integer */
	private $wikiId;
	/** @var array */
	private $namespaces = [];

	/** @var integer */
	private $page;
	/** @var integer */
	private $limit;
	/** @var integer */
	private $offset;

	public function __construct( Config $config ) {
		$this->query = $config->getQuery();
		$this->languageCode = $config->getLanguageCode();
		$this->wikiId = $config->getWikiId();
		$this->page = $config->getPage();
		$this->limit = $config->getLimit();
		$this->offset = $config->getStart();
		$this->namespaces = $config->getNamespaces();
	}

	/**
	 * @return Select
	 */
	public function getQuery(): Select {
		return $this->query;
	}

	/**
	 * @return string
	 */
	public function getLanguageCode(): string {
		return $this->languageCode;
	}

	/**
	 * @return int
	 */
	public function getWikiId(): int {
		return $this->wikiId;
	}

	/**
	 * @return array
	 */
	public function getNamespaces(): array {
		return $this->namespaces;
	}
}
