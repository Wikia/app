<?php

use Wikia\Search\IndexService\Factory;
use Wikia\Search\MediaWikiInterface;
/**
 * This class is responsible for providing responses for atomic updates of documents. 
 * @author relwell
 */
class WikiaSearchIndexerController extends WikiaController
{
	/**
	 * @var WikiaSearchIndexer
	 */
	protected $searchIndexer;
	
	/**
	 * Allows us to avoid direct calls to MediaWiki components
	 * @var Wikia\Search\MediaWikiInterface
	 */
	protected $interface;
	
	/**
	 * Constructor method.
	 * Sets defaults -- no writing to memache, and a default search indexer instance
	 */
	public function __construct()
	{
		parent::__construct();
		$this->interface = MediaWikiInterface::getInstance();
		$this->interface->setGlobal( 'AllowMemcacheWrites', false )
		                ->setGlobal( 'AppStripsHtml', true );
	}
	
	/**
	 * Produces a JSON response based on calls to the provided pages' WikiaSearchIndexer::getPageDefaultValues method. 
	 */
	public function get()
	{
		$this->getResponse()->setFormat('json');

		$serviceName = $this->getVal( 'service', 'DefaultContent' );
		$ids = explode( '|', $this->getVal( 'ids', '' ) );
		$service = Factory::getInstance()->get( $serviceName, $ids );
		
		$ids = $this->getVal( 'ids' );
	    if ( !empty( $ids ) ) {
	        $this->response->setData( $service->getResponseForPageIds( 'getPageDefaultValues' ) );
	    }
	}
	
	/**
	 * Provides a JSON response for services that work on a wiki-wide level
	 * The response includes the wiki ID, the URL of the wiki, and the stubbed-out XML
	 * It is the responsibility of the back-end script to access all page IDs using the appropriate API 
	 * and replace placeholder values with
	 * @throws Exception 
	 */
	public function getForWiki()
	{
		$this->getResponse()->setFormat('json');
		
		// this will throw an exception if you don't set the service. that's a behavior we want.
		$service = Factory::getInstance()->get( $this->getVal( 'service' ) );
		
		$this->response->setData( $service->getStubbedWikiResponse() );
	}
}