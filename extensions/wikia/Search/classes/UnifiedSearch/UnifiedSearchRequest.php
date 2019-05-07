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

	/** @var boolean */
	private $imageOnly;
	/** @var boolean */
	private $videoOnly;

	/** @var integer */
	private $page;
	/** @var integer */
	private $limit;


	public function __construct( Config $config ) {
		$this->query = $config->getQuery();
		$this->languageCode = $config->getLanguageCode();
		$this->wikiId = $config->getWikiId();
		$this->page = $config->getPage() - 1;
		$this->limit = $config->getLimit();
		$this->namespaces = $config->getNamespaces();
		$this->imageOnly = $config->isImageOnly();
		$this->videoOnly = $config->isVideoOnly();
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

	/**
	 * @return bool
	 */
	public function isImageOnly(): bool {
		return $this->imageOnly;
	}

	/**
	 * @return bool
	 */
	public function isVideoOnly(): bool {
		return $this->videoOnly;
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
