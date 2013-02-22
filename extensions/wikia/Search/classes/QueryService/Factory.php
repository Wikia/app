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
	 * Singleton instance
	 * @var Factory 
	 */
	private static $instance;
	
	/**
	 * Return a singleton instance
	 * @return \Wikia\Search\QueryService\Factory
	 */
	public static function getInstance() {
		if (! isset( self::$instance ) ) {
			self::$instance = new Factory();
		}
		return self::$instance;
	}
	
	public function get( DependencyContainer $container ) {
		$config = $container->getConfig();
		$this->validateClient( $container );
		
		if ( $config->isInterWiki() ) {
			return new Select\InterWiki( $container );
		}
		if ( $config->getVideoSearch() ) {
			return new Select\Video( $container );
		}
		return new Select\OnWiki( $container );
	}
	
	protected function validateClient( DependencyContainer $container ) {
		$interface = MediaWikiInterface::getInstance();
		$client = $container->getClient();
		if ( empty( $client ) ) {
			$solariumConfig = array(
					'adapter' => 'Solarium_Client_Adapter_Curl',
					'adapteroptions' => array(
							'host'    => ( $this->wg->SolrHost ?: 'localhost'),
							'port'    => ( $this->wg->SolrPort ?: 8180 ),'path'    => '/solr/',
							)
					);
			if ( $interface->getGlobal( 'WikiaSearchUseProxy' ) && $interface->getGlobalWithDefault( 'SolrProxy' ) !== null ) {
				$solariumConfig['adapteroptions']['proxy'] = $this->interface->getGlobal( 'SolrProxy' );
				$solariumConfig['adapteroptions']['port'] = null;
			}
			$container->setClient( new Solarium_Client( $solariumConfig ) );
		}
	}
}