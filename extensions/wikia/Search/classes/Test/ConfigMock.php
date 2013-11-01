<?php


namespace Wikia\Search\Test;


use Wikia\Search\Config;

class ConfigMock extends Config {
	/**
	 * @var string
	 */
	protected $query;
	/**
	 * @var int
	 */
	protected $limit;
	/**
	 * @var int
	 */
	protected $page;
	/**
	 * @var string
	 */
	protected $rank;
	/**
	 * @var boolean
	 */
	protected $interWiki;
	/**
	 * @var boolean
	 */
	protected $commercialUse;
	/**
	 * @var string
	 */
	protected $languageCode;
	/**
	 * @var boolean
	 */
	protected $onWiki;
	/**
	 * @var int[]
	 */
	protected $namespaces;

	/**
	 * @param boolean $commercialUse
	 * @return $this
	 */
	public function setCommercialUse($commercialUse) {
		$this->commercialUse = $commercialUse;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function getCommercialUse() {
		return $this->commercialUse;
	}

	/**
	 * @param boolean $interWiki
	 * @return $this
	 */
	public function setInterWiki($interWiki) {
		$this->interWiki = $interWiki;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function getInterWiki() {
		return $this->interWiki;
	}

	/**
	 * @param string $languageCode
	 * @return $this
	 */
	public function setLanguageCode($languageCode) {
		$this->languageCode = $languageCode;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getLanguageCode() {
		return $this->languageCode;
	}

	/**
	 * @param int $limit
	 * @return $this
	 */
	public function setLimit($limit) {
		$this->limit = $limit;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getLimit() {
		return $this->limit;
	}

	public function setNamespaces($namespaces) {
		$this->namespaces = $namespaces;
		return $this;
	}

	public function getNamespaces() {
		return $this->namespaces;
	}

	/**
	 * @param boolean $onWiki
	 * @return $this
	 */
	public function setOnWiki($onWiki) {
		$this->onWiki = $onWiki;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function getOnWiki() {
		return $this->onWiki;
	}

	/**
	 * @param string $query
	 * @return $this
	 */
	public function setQuery($query) {
		$this->query = $query;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getQuery() {
		return $this->query;
	}

	/**
	 * @param string $rank
	 * @return $this
	 */
	public function setRank($rank) {
		$this->rank = $rank;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getRank() {
		return $this->rank;
	}

	/**
	 * @param int $page
	 */
	public function setPage($page) {
		$this->page = $page;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getPage() {
		return $this->page;
	}

}
