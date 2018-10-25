<?php

class CategoryPage3Pagination {
	/** @var string */
	private $from;

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

	public function __construct( Title $title, $from ) {
		$this->from = $from;
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
		return empty( $this->nextPageUrl ) &&
			empty( $this->prevPageUrl );
	}

	/**
	 * @return string
	 */
	public function getFirstPageUrl() {
		if ( empty ( $this->from ) || $this->isPrevPageTheFirstPage ) {
			return null;
		}

		return $this->title->getFullURL();
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
	 * @param string $prevPageKey
	 */
	public function setPrevPageKey( string $prevPageKey ) {
		$this->prevPageKey = $prevPageKey;

		if ( $this->isPrevPageTheFirstPage ) {
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
	 * @param bool $isPrevPageTheFirstPage
	 */
	public function setIsPrevPageTheFirstPage( bool $isPrevPageTheFirstPage ) {
		$this->isPrevPageTheFirstPage = $isPrevPageTheFirstPage;
	}

	public function toArray() {
		return [
			'isPrevPageTheFirstPage' => $this->isPrevPageTheFirstPage,
			'firstPageUrl' => $this->getFirstPageUrl(),
			'prevPageKey' => $this->prevPageKey,
			'prevPageUrl' => $this->getPrevPageUrl(),
			'nextPageKey' => $this->nextPageKey,
			'nextPageUrl' => $this->getNextPageUrl(),
			'lastPageKey' => $this->lastPageKey,
			'lastPageUrl' => $this->getLastPageUrl()
		];
	}
}
