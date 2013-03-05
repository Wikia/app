<?php
/**
 * Class definition for \Wikia\Search\ResultSet\DependencyContainer
 */
namespace Wikia\Search\ResultSet;
use \Wikia\Search\Config, \Solarium_Result_Select, \Wikia\Search\MediaWikiInterface, \Wikia\Search\Traits, \Wikia\Search\Match\Wiki;
/**
 * This allows us to encapsulate all dependencies and send a single object to Wikia\Search\ResultSet\Factory
 * @author relwell
 */
class DependencyContainer
{
	use Traits\ArrayConfigurable;
	
	/**
	 * Search Config
	 * @var Wikia\Search\Config
	 */
	protected $config;
	
	/**
	 * Solarium Result
	 * @var Solarium_Result_Select
	 */
	protected $result;
	
	/**
	 * MediaWikiInterface
	 * @var MediaWikiInterface
	 */
	protected $interface;
	
	/**
	 * Metaposition is for Groupings
	 * @var int
	 */
	protected $metaposition;
	
	/**
	 * Parent is also for Groupings
	 * @var GroupingSet
	 */
	protected $parent;
	
	/**
	 * Wiki match, lets us know if we need to use the "match" grouping wrapper.
	 *@var Match
	 */
	protected $wikiMatch;

	/**
	 * Constructor class. Basically allows us to pre-populate the $interface property and configure by array rather than separate invocations.
	 * @param array $dependencies optional method of prepopulating the dependencies. Can also call mutators.
	 */
	public function __construct( array $dependencies = array() ) {
		$this->setInterface( MediaWikiInterface::getInstance() )
		     ->configureByArray( $dependencies );
	}
	
	/**
	 * @return Wikia\Search\Config
	 */
	public function getConfig() {
		return $this->config;
	}

	/**
	 * @return Solarium_Result_Select
	 */
	public function getResult() {
		return $this->result;
	}

	/**
	 * @return \Wikia\Search\MediaWikiInterface
	 */
	public function getInterface() {
		return $this->interface;
	}

	/**
	 * @return number
	 */
	public function getMetaposition() {
		return $this->metaposition;
	}

	/**
	 * @return \Wikia\Search\ResultSet\GroupingSet
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * @param WikiaSearchConfig $config
	 * @return DependencyContainer
	 */
	public function setConfig( Config $config ) {
		$this->config = $config;
		return $this;
	}

	/**
	 * @param Solarium_Result_Select $result
	 * @return DependencyContainer
	 */
	public function setResult( Solarium_Result_Select $result ) {
		$this->result = $result;
		return $this;
	}

	/**
	 * @param MediaWikiInterface $interface
	 * @return DependencyContainer
	 */
	public function setInterface( MediaWikiInterface $interface ) {
		$this->interface = $interface;
		return $this;
	}

	/**
	 * @param int $metaposition
	 * @return DependencyContainer
	 */
	public function setMetaposition( $metaposition ) {
		$this->metaposition = $metaposition;
		return $this;
	}

	/**
	 * @param GroupingSet $parent
	 * @return DependencyContainer
	 */
	public function setParent( GroupingSet $parent ) {
		$this->parent = $parent;
		return $this;
	}
	
	
	/**
	 * @return the $wikiMatch
	 */
	public function getWikiMatch() {
		return $this->wikiMatch;
	}

	/**
	 * @param \Wikia\Search\ResultSet\Match $wikiMatch
	 */
	public function setWikiMatch( Wiki $wikiMatch ) {
		$this->wikiMatch = $wikiMatch;
		return $this;
	}
	
}