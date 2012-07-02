<?php
/**
 * Encapsulates the result of a book information request
 * including response status and the book information itself
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */

class BookInformationResult {
	const RESPONSE_OK = 0;
	const RESPONSE_NOSUCHITEM = 1;
	const RESPONSE_TIMEOUT = 2;
	const RESPONSE_FAILED = 3;

	private $response = self::RESPONSE_FAILED;

	private $title = false;
	private $author = false;
	private $publisher = false;
	private $year = false;

	private $provider = false;
	private $purchase = false;

	public function __construct( $code, $title = false, $author = false, $publisher = false, $year = false ) {
		$this->response = $code;
		$this->title = $title;
		$this->author = $author;
		$this->publisher = $publisher;
		$this->year = $year;
	}

	public function setProviderData( $provider, $purchase = false ) {
		$this->provider = $provider;
		$this->purchase = $purchase;
	}

	public function getResponseCode() {
		return $this->response;
	}

	public function getTitle() {
		return $this->title;
	}

	public function getAuthor() {
		return $this->author;
	}

	public function getPublisher() {
		return $this->publisher;
	}

	public function getYear() {
		return $this->year;
	}

	public function getProviderLink() {
		return $this->provider;
	}

	public function getPurchaseLink() {
		return $this->purchase;
	}

	public function isCacheable() {
		return $this->response == self::RESPONSE_OK
			|| $this->response == self::RESPONSE_NOSUCHITEM;
	}
}
