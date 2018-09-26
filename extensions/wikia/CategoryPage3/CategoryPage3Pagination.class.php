<?php

class CategoryPage3Pagination {
	/** @var string */
	private $firstPageUrl;

	/** @var string */
	private $lastPageKey;

	/** @var string */
	private $lastPageUrl;

	/** @var string */
	private $nextPageKey;

	/** @var string */
	private $nextPageUrl;

	/** @var string */
	private $prevPageKey;

	/** @var string */
	private $prevPageUrl;

	/** @var bool */
	private $isPrevPageTheFirstPage;

	/** @var Title */
	private $title;

	public function __construct( Title $title ) {
		$this->firstPageUrl = null;
		$this->lastPageKey = null;
		$this->nextPageKey = null;
		$this->prevPageKey = null;
		$this->isPrevPageTheFirstPage = false;
		$this->title = $title;
	}

	/**
	 * @return bool
	 */
	public function isEmpty(): bool {
		return empty( $this->firstPageUrl ) &&
			empty( $this->lastPageUrl ) &&
			empty( $this->nextPageUrl ) &&
			empty( $this->prevPageUrl );
	}

	/**
	 * @return string
	 */
	public function getFirstPageUrl() {
		return $this->firstPageUrl;
	}

	/**
	 * @return string
	 */
	public function getNextPageKey() {
		return $this->nextPageKey;
	}

	/**
	 * @param string $nextPageKey
	 */
	public function setNextPageKey( string $nextPageKey ) {
		$this->nextPageKey = $nextPageKey;
		$this->nextPageUrl = $this->title->getFullURL( [
			'from' => $nextPageKey
		] );
	}

	/**
	 * @return string
	 */
	public function getNextPageUrl() {
		return $this->nextPageUrl;
	}

	/**
	 * @return string
	 */
	public function getLastPageKey() {
		return $this->lastPageKey;
	}

	/**
	 * @param string $lastPageKey
	 */
	public function setLastPageKey( string $lastPageKey ) {
		$this->lastPageKey = $lastPageKey;

		if ( $this->getNextPageKey() !== $lastPageKey ) {
			$this->lastPageUrl = $this->title->getFullURL( [
				'from' => $lastPageKey
			] );
		}
	}

	/**
	 * @return string
	 */
	public function getLastPageUrl() {
		return $this->lastPageUrl;
	}

	/**
	 * @param string $lastPageUrl
	 */
	public function setLastPageUrl( string $lastPageUrl ) {
		$this->lastPageUrl = $lastPageUrl;
	}

	/**
	 * @return string
	 */
	public function getPrevPageKey() {
		return $this->prevPageKey;
	}

	/**
	 * @param string $prevPageKey
	 */
	public function setPrevPageKey( string $prevPageKey ) {
		$this->prevPageKey = $prevPageKey;

		if ( $this->isPrevPageTheFirstPage() ) {
			$this->prevPageUrl = $this->title->getFullURL();
		} else {
			$this->prevPageUrl = $this->title->getFullURL( [
				'from' => $prevPageKey
			] );
		}
	}

	/**
	 * @return string
	 */
	public function getPrevPageUrl() {
		return $this->prevPageUrl;
	}

	/**
	 * @return bool
	 */
	public function isPrevPageTheFirstPage(): bool {
		return $this->isPrevPageTheFirstPage;
	}

	/**
	 * @param bool $isPrevPageTheFirstPage
	 */
	public function setIsPrevPageTheFirstPage( bool $isPrevPageTheFirstPage ) {
		$this->isPrevPageTheFirstPage = $isPrevPageTheFirstPage;
	}
}
