<?php
/**
 * Class definition for \Wikia\Search\IndexService\Factory
 * @author relwell
 */
namespace Wikia\Search\IndexService;
/**
 * A singleton instance for instantiating services
 * This lets us make something else reponsible for dependency injection
 * @author relwell
 */
class Factory
{
	/**
	 * Singleton instance
	 * @var 
	 */
	private static $instance;
	
	private function __construct() {
		global $wgSolrMaster;
		
		$solariumConfig = array(
				'adapteroptions'	=> array(
						'host' => $wgSolrMaster,
						'port' => 8983,
						'path' => '/solr/',
						)
				);
		
		$this->client = new \Solarium_Client( $solariumConfig );
	}
	
	public function getInstance() {
		if (! isset( self::$instance ) ) {
			self::$instance = new Factory();
		}
		return self::$instance;
	}
	
	public function get( $terminalClassName, array $pageIds = array() ) {
		$className = 'Wikia\\Search\\IndexService\\' . $terminalClassName;
		if ( class_exists( $className ) ) {
			return new $className( $this->client, $pageIds );
		} else {
			throw new \Exception( "No class by name of {$className}" );
		}
	}
}