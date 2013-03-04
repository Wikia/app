<?php
/**
 * Class definition for Wikia\Search\QueryService\DependencyContainer
 */
namespace Wikia\Search\QueryService;
use \Wikia\Search\Traits, \Solarium_Client, \Wikia\Search\Config, \Wikia\Search\MediaWikiInterface, \Wikia\Search\ResultSet;

class DependencyContainer
{
	use Traits\ArrayConfigurable;
	
	/**
	 * @var \Wikia\Search\MediaWikiInterface
	 */
	protected $interface;
	
	/**
	 * @var \Wikia\Search\Config
	 */
	protected $config;
	
	/**
	 * @var \Wikia\Search\ResultSet\Factory
	 */
	protected $resultSetFactory;
	
	/**
	 * @var \Solarium_Client
	 */
	protected $client; 
	
	public function __construct( array $dependencies ) {
		$this->resultSetFactory = ResultSet\Factory::getInstance();
		$this->interface = MediaWikiInterface::getInstance();
		$this->configureByArray( $dependencies );
	}
	
	/**
	 * @return the $interface
	 */
	public function getInterface() {
		return $this->interface;
	}

	/**
	 * @param \Wikia\Search\MediaWikiInterface $interface
	 * @return \Wikia\Search\QueryService\DependencyContainer
	 */
	public function setInterface( MediaWikiInterface $interface) {
		$this->interface = $interface;
		return $this;
	}

	/**
	 * @return the $config
	 */
	public function getConfig() {
		return $this->config;
	}

	/**
	 * @param \Wikia\Search\Config $config
	 * @return \Wikia\Search\QueryService\DependencyContainer
	 */
	public function setConfig( Config $config) {
		$this->config = $config;
		return $this;
	}

	/**
	 * @return the $client
	 */
	public function getClient() {
		return $this->client;
	}

	/**
	 * @param Solarium_Client $client
	 * @return \Wikia\Search\QueryService\DependencyContainer
	 */
	public function setClient( \Solarium_Client $client) {
		$this->client = $client;
		return $this;
	}
	
	/**
	 * @return the $resultSetFactory
	 */
	public function getResultSetFactory() {
		return $this->resultSetFactory;
	}

	/**
	 * @param \Wikia\Search\ResultSet\Factory $resultSetFactory
	 */
	public function setResultSetFactory( \Wikia\Search\ResultSet\Factory $resultSetFactory ) {
		$this->resultSetFactory = $resultSetFactory;
		return $this;
	}

}