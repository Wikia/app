<?php

namespace Wikia\Search\UnifiedSearch;

use Wikia\Search\Config;
use Wikia\Search\Query\Select;

class UnifiedSearchPageRequest {

	/** @var Select */
	private $query;

	/** @var string */
	private $languageCode;
	/** @var integer|null */
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

	/** @var bool */
	private $isInternalScope = false;

	public function __construct( Config $config ) {
		$this->query = $config->getQuery();
		$this->languageCode = $config->getLanguageCode();
		$this->wikiId = $config->getWikiId();
		$this->isInternalScope = $config->isInternalScope();
		$this->page = $config->getPage() - 1;
		$this->limit = $config->getLimit();
		$this->namespaces = $config->getNamespaces();
		$this->imageOnly = $config->isImageOnly();
		$this->videoOnly = $config->isVideoOnly();
	}

	public function getQuery(): Select {
		return $this->query;
	}

	public function getLanguageCode(): string {
		return $this->languageCode;
	}

	/** @return null|int */
	public function getWikiId() {
		return $this->wikiId;
	}

	public function getNamespaces(): array {
		return $this->namespaces;
	}

	public function isImageOnly(): bool {
		return $this->imageOnly;
	}

	public function isVideoOnly(): bool {
		return $this->videoOnly;
	}

	public function getPage(): int {
		return $this->page;
	}

	public function getLimit(): int {
		return $this->limit;
	}

	public function isInternalScope(): bool {
		return $this->isInternalScope;
	}
}
