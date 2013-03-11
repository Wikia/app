<?php
/**
 * Class definition for Wikia\Search\QueryService\Factory
 * @author relwell
 */
namespace Wikia\Search\QueryService;
use \Wikia\Search\Config, \Wikia\Search\MediaWikiInterface, \Solarium_Client;

class Factory
{
	/**
	 * Inspects dependency container and returns appropriate QueryService\Select instance.
	 * @param DependencyContainer $container
	 * @return \Wikia\Search\QueryService\Select\AbstractSelect
	 */
	public function get( DependencyContainer $container ) {
		$config = $container->getConfig();
		$this->validateClient( $container );
		
		if ( $config->isInterWiki() ) {
			return new Select\InterWiki( $container );
		}
		if ( $config->getVideoSearch() ) {
			return new Select\Video( $container );
		}
		if ( $config->getDirectLuceneQuery() ) {
			return new Select\Lucene( $container );
		}
		return new Select\OnWiki( $container );
	}
	
	/**
	 * Skips instantiating dependency container, just using config and allowing default client instance.
	 * @todo return type hinting to this method when we have a more sane way to test things than mock proxy
	 * @param Config $config
	 * @return Ambigous <\Wikia\Search\QueryService\Select\AbstractSelect, \Wikia\Search\QueryService\Select\InterWiki, \Wikia\Search\QueryService\Select\Video, \Wikia\Search\QueryService\Select\Lucene, \Wikia\Search\QueryService\Select\OnWiki>
	 */
	public function getFromConfig( $config ) {
		$container = new DependencyContainer( array( 'config' => $config ) );
		return $this->get( $container );
	}
	
	/**
	 * If an instance of Solarium_Client has not been created yet, create it.
	 * @param DependencyContainer $container
	 */
	protected function validateClient( DependencyContainer $container ) {
		$interface = MediaWikiInterface::getInstance();
		$client = $container->getClient();
		if ( empty( $client ) ) {
			$host = $interface->isOnDbCluster() ? $interface->getGlobalWithDefault( 'SolrHost', 'localhost' ) : 'staff-search-s1';  
			$solariumConfig = array(
					'adapter' => 'Solarium_Client_Adapter_Curl',
					'adapteroptions' => array(
							'host'    => $host,
							'port'    => $interface->getGlobalWithDefault( 'SolrPort', 8180 ),
							'path'    => '/solr/',
							)
					);
			if ( $interface->isOnDbCluster() && $interface->getGlobal( 'WikiaSearchUseProxy' ) && $interface->getGlobalWithDefault( 'SolrProxy' ) !== null ) {
				$solariumConfig['adapteroptions']['proxy'] = $interface->getGlobal( 'SolrProxy' );
				$solariumConfig['adapteroptions']['port'] = null;
			}
			$container->setClient( new Solarium_Client( $solariumConfig ) );
		}
	}
}