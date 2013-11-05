<?php
/**
 * Class definition for Wikia\Search\QueryService\Factory
 * @author relwell
 */
namespace Wikia\Search\QueryService;
use \Wikia\Search\Config, \Wikia\Search\MediaWikiService, \Solarium_Client;
/**
 * This class is responsible for instantiating the appropriate QueryService based on values in the config.
 * It is also responsible for generating the appropriate instance of Solarium_Client, based on global settings.
 * @author relwell
 * @package Search
 * @subpackage QueryService
 */
class Factory
{
	/**
	 * Inspects dependency container and returns appropriate QueryService\Select instance.
	 * @param DependencyContainer $container
	 * @return \Wikia\Search\QueryService\Select\AbstractSelect
	 */
	public function get( DependencyContainer $container ) {
		$this->validateClient( $container );
		$class = $container->getConfig()->getQueryService();
		return new $class( $container );
	}
	
	/**
	 * Skips instantiating dependency container, just using config and allowing default client instance.
	 * @todo return type hinting to this method when we have a more sane way to test things than mock proxy
	 * @param Config $config
	 * @return \Wikia\Search\QueryService\Select\AbstractSelect|\Wikia\Search\QueryService\Select\InterWiki|\Wikia\Search\QueryService\Select\Video|\Wikia\Search\QueryService\Select\Lucene|\Wikia\Search\QueryService\Select\OnWiki
	 */
	public function getFromConfig( $config ) {
		$container = new DependencyContainer( array( 'config' => $config ) );
		return $this->get( $container );
	}

	public function getSolariumClientConfig() {
		$service = (new \Wikia\Search\ProfiledClassFactory)->get( 'Wikia\Search\MediaWikiService' );
		$host = $service->isOnDbCluster() ? $service->getGlobalWithDefault( 'SolrHost', 'localhost' ) : 'staff-search-s1';
		$host = (! empty( $_GET['newsolrhost'] ) ) ? $service->getGlobal( 'AlternateSolrHost' ) : $host;
		$solariumConfig = array(
			'adapter' => 'Solarium_Client_Adapter_Curl',
			'adapteroptions' => array(
				'host'    => $host,
				'port'    => empty( $_GET['newsolrhost'] ) ? $service->getGlobalWithDefault( 'SolrPort', 8180 ) : 8983,
				'path'    => '/solr/',
			)
		);
		if ( $service->isOnDbCluster() && $service->getGlobal( 'WikiaSearchUseProxy' ) && $service->getGlobalWithDefault( 'SolrProxy' ) !== null && empty( $_GET['newsolrhost'] ) ) {
			$solariumConfig['adapteroptions']['proxy'] = $service->getGlobal( 'SolrProxy' );
			$solariumConfig['adapteroptions']['port'] = null;
		}
		return $solariumConfig;
	}
	
	/**
	 * If an instance of Solarium_Client has not been created yet, create it.
	 * @param DependencyContainer $container
	 */
	protected function validateClient( DependencyContainer $container ) {
		$client = $container->getClient();
		if ( empty( $client ) ) {
			$solariumConfig = $this->getSolariumClientConfig();
			$container->setClient( new Solarium_Client( $solariumConfig ) );
		}
	}
}
