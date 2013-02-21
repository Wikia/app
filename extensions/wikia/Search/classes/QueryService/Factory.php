<?php
/**
 * Class definition for Wikia\Search\QueryService\Factory
 * @author relwell
 */
namespace Wikia\Search\QueryService;
use \Wikia\Search\Config;

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
		
		if ( $config->isInterWiki() ) {
			return new Select\InterWiki( $container );
		}
		if ( $config->getVideoSearch() ) {
			return new Select\Video( $container );
		}
		return new Select\OnWiki( $container );
	}
}