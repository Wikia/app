<?php
/**
 * Class definition for Wikia\Search\QueryService\DependencyContainer
 */
namespace Wikia\Search\QueryService;

use Solarium_Client;
use Wikia\Search\Config;
use Wikia\Search\MediaWikiService;
use Wikia\Search\Traits\ArrayConfigurableTrait;

/**
 * Used to encapsulate the dependencies that must be injected into the different query services.
 * Provides a fixed schema for injected dependencies in the QueryService namespace.
 * Used together with Factory to encapsulate the logic of instantiating different QueryService classes.
 *
 * @author relwell
 * @package Search
 * @subpackage QueryService
 */
class DependencyContainer {
	use ArrayConfigurableTrait;

	/**
	 * Used to handle all non-primitive MediaWiki logic.
	 *
	 * @var \Wikia\Search\MediaWikiService
	 */
	protected $service;

	/**
	 * Used to handle query abstraction as well as instantiation flags in the factory.
	 *
	 * @var \Wikia\Search\Config
	 */
	protected $config;

	/**
	 * Required to connect to Solr.
	 *
	 * @var \Solarium_Client
	 */
	protected $client;

	/**
	 * Implements the ArrayConfigurableTrait::configureByArray method to store attribute values.
	 *
	 * @param array $dependencies an associative array of attribute to value.
	 */
	public function __construct( array $dependencies = [] ) {
		$this->service = new MediaWikiService();
		$this->configureByArray( $dependencies );
	}

	/**
	 * Accessor for mw service.
	 *
	 * @return MediaWikiService
	 */
	public function getService(): MediaWikiService {
		return $this->service;
	}

	/**
	 * Mutator for mw service.
	 *
	 * @param \Wikia\Search\MediaWikiService $service
	 *
	 * @return DependencyContainer
	 */
	public function setService( MediaWikiService $service ) {
		$this->service = $service;

		return $this;
	}

	/**
	 * Accessor for config.
	 *
	 * @return \Wikia\Search\Config
	 */
	public function getConfig() {
		return $this->config;
	}

	/**
	 * Mutator for config.
	 *
	 * @param \Wikia\Search\Config $config
	 *
	 * @return DependencyContainer
	 */
	public function setConfig( Config $config ) {
		$this->config = $config;

		return $this;
	}

	/**
	 * Accessor for client.
	 *
	 * @return \Solarium_Client
	 */
	public function getClient() {
		return $this->client;
	}

	/**
	 * Mutator for client.
	 *
	 * @param Solarium_Client $client
	 *
	 * @return DependencyContainer
	 */
	public function setClient( \Solarium_Client $client ) {
		$this->client = $client;

		return $this;
	}
}
