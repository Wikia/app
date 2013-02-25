<?php

namespace Wikia\Search\Match;
use Wikia\Search\MediaWikiInterface;

abstract class AbstractMatch
{
	/**
	 * Can be wiki id, article id, etc.
	 * @var int
	 */
	protected $id;

	/**
	 * Encapsulates appropriate logic.
	 * @var MediaWikiInterface
	 */
	protected $interface;
	
	/**
	 * @var WikiaSearchResult
	 */
	protected $result;
	
	/**
	 * Dependency-injects an ID and interface.
	 * @param int $id
	 * @param MediaWikiInterface $interface
	 */
	public function __construct( $id, MediaWikiInterface $interface ) {
		$this->id = $id;
		$this->interface = $interface;
	}
	
	/**
	 * @return Wikia\Search\Result
	 */
	public function getResult() {
		if ( $this->result === null ) {
			$this->result = $this->createResult();
		}
		return $this->result;
	}
	
	/**
	 * @return number
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @return WikiaSearchResult
	 */
	abstract protected function createResult();
}