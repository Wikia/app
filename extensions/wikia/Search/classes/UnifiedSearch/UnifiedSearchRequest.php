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

	/** @var integer */
	private $page;
	/** @var integer */
	private $limit;
	/** @var integer */
	private $offset;
	/** @var array */
	private $namespaces = [];

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
}
