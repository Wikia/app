<?php
/**
 * Class definition for WikiaSearchIndexerController
 */
use Wikia\Search\MediaWikiService;
/**
 * This class is responsible for providing responses for atomic updates of documents. 
 * @author relwell
 * @package Search
 * @subpackage Controller
 */
class WikiaSearchIndexerController extends WikiaController
{
	/**
	 * Allows us to avoid direct calls to MediaWiki components
	 * @var Wikia\Search\MediaWikiService
	 */
	protected $service;
	
	/**
	 * Constructor method.
	 * Sets defaults -- no writing to memache, and a default search indexer instance
	 */
	public function __construct()
	{
		parent::__construct();
		$this->service = new MediaWikiService;
		$this->service->setGlobal( 'AllowMemcacheWrites', false )
		                ->setGlobal( 'AppStripsHtml', true );

		if ( function_exists( 'newrelic_disable_autorum') ) {
			newrelic_disable_autorum();
		}
		if( function_exists( 'newrelic_background_job' ) ) {
			newrelic_background_job(true);
		}

	}
	
	/**
	 * Produces a JSON response based on calls to the provided pages' WikiaSearchIndexer::getPageDefaultValues method. 
	 */
	public function get()
	{
		$this->getResponse()->setFormat('json');

		$serviceName = 'Wikia\Search\IndexService\\' . $this->getVal( 'service', 'DefaultContent' );
		$ids = explode( '|', $this->getVal( 'ids', '' ) );
		$service = new $serviceName( $ids );
		
		$ids = $this->getVal( 'ids' );
	    if ( !empty( $ids ) ) {
	        $this->response->setData( $service->getResponseForPageIds() );
	    }
	}
	
	/**
	 * Provides a JSON response for services that work on a wiki-wide level
	 * The response includes the wiki ID, the URL of the wiki, and the stubbed-out XML
	 * It is the responsibility of the back-end script to access all page IDs using the appropriate API 
	 * and replace placeholder values with
	 */
	public function getForWiki()
	{
		$this->getResponse()->setFormat('json');
		
		$serviceName = 'Wikia\Search\IndexService\\' . $this->getVal( 'service' );
		$service = new $serviceName();
		
		$this->response->setData( $service->getStubbedWikiResponse() );
	}
}