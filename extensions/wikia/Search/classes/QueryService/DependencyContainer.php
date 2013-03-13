<?php
/**
 * Class definition for Wikia\Search\QueryService\DependencyContainer
 */
namespace Wikia\Search\QueryService;
use \Wikia\Search\Traits, \Solarium_Client, \Wikia\Search\Config, \Wikia\Search\MediaWikiInterface, \Wikia\Search\ResultSet;
/**
 * Used to encapsulate the dependencies that must be injected into the different query services.
 * Provides a fixed schema for injected dependencies in the QueryService namespace.
 * Used together with Factory to encapsulate the logic of instantiating different QueryService classes.
 * @author relwell
 * @package Search
 * @subpackage QueryService
 */
class DependencyContainer
{
	use Traits\ArrayConfigurable;
	
	/**
	 * Used to handle all non-primitive MediaWiki logic.
	 * @var \Wikia\Search\MediaWikiInterface
	 */
	protected $interface;
	
	/**
	 * Used to handle query abstraction as well as instantiation flags in the factory.
	 * @var \Wikia\Search\Config
	 */
	protected $config;
	
	/**
	 * Used to dependency-inject the ResultSet factory for GroupingSets.
	 * @var \Wikia\Search\ResultSet\Factory
	 */
	protected $resultSetFactory;
	
	/**
	 * Required to connect to Solr.
	 * @var \Solarium_Client
	 */
	protected $client; 
	
	/**
	 * Implements the ArrayConfigurable::configureByArray trait method to store attribute values.
	 * @param array $dependencies an associative array of attribute to value.
	 */
	public function __construct( array $dependencies = array() ) {
		$this->resultSetFactory = new ResultSet\Factory;
		$this->interface = new MediaWikiInterface;
		$this->configureByArray( $dependencies );
	}
	
	/**
	 * Accessor for interface.
	 * @return the $interface
	 */
	public function getInterface() {
		return $this->interface;
	}

	/**
	 * Mutator for interface.
	 * @param \Wikia\Search\MediaWikiInterface $interface
	 * @return \Wikia\Search\QueryService\DependencyContainer
	 */
	public function setInterface( MediaWikiInterface $interface) {
		$this->interface = $interface;
		return $this;
	}

	/**
	 * Accessor for config.
	 * @return the $config
	 */
	public function getConfig() {
		return $this->config;
	}

	/**
	 * Mutator for config.
	 * @param \Wikia\Search\Config $config
	 * @return \Wikia\Search\QueryService\DependencyContainer
	 */
	public function setConfig( Config $config) {
		$this->config = $config;
		return $this;
	}

	/**
	 * Accessor for client.
	 * @return the $client
	 */
	public function getClient() {
		return $this->client;
	}

	/**
	 * Mutator for client.
	 * @param Solarium_Client $client
	 * @return \Wikia\Search\QueryService\DependencyContainer
	 */
	public function setClient( \Solarium_Client $client) {
		$this->client = $client;
		return $this;
	}
	
	/**
	 * Accessor for resultsetfactory.
	 * @return the $resultSetFactory
	 */
	public function getResultSetFactory() {
		return $this->resultSetFactory;
	}

	/**
	 * Mutator for resultsetfactory.
	 * @param \Wikia\Search\ResultSet\Factory $resultSetFactory
	 */
	public function setResultSetFactory( \Wikia\Search\ResultSet\Factory $resultSetFactory ) {
		$this->resultSetFactory = $resultSetFactory;
		return $this;
	}

}