<?php
/**
 * Class definition for Wikia\Search\Match\AbstractMatch
 * @author relwell
 */
namespace Wikia\Search\Match;
use Wikia\Search\MediaWikiService;
/**
 * Provides a common API for matches, regardless of implementation.
 * Matches encapsulate classes that model data that directly correlates to a search term, given a domain.
 * A match should know how to instantiate a single Result relating to its data.
 * @author relwell
 * @abstract
 * @package Search
 * @subpackage Match
 */
abstract class AbstractMatch
{
	/**
	 * Can be wiki id, article id, etc.
	 * @var int
	 */
	protected $id;

	/**
	 * @var string Search string
	 */
	protected $term;


	/**
	 * Encapsulates appropriate logic.
	 * @var MediaWikiService
	 */
	protected $service;
	
	/**
	 * Memoization cache for getResult method
	 * @var WikiaSearchResult
	 */
	protected $result;
	
	/**
	 * Dependency-injects an ID and MW service.
	 * @param int $id
	 * @param MediaWikiService $service
	 */
	public function __construct( $id, MediaWikiService $service, $term = '' ) {
		$this->term = $term;
		$this->id = $id;
		$this->service = $service;
	}
	
	/**
	 * This wraps the createResult method to allow us to memoize its return value.
	 * @return Wikia\Search\Result
	 */
	public function getResult() {
		if ( $this->result === null ) {
			$this->result = $this->createResult();
		}
		return $this->result;
	}
	
	/**
	 * Returns the ID, whatever it may be.
	 * @return number
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Each implementation must have its own logic for creating a result, based on the data its match encapsulates.
	 * @return WikiaSearchResult
	 */
	abstract protected function createResult();
}