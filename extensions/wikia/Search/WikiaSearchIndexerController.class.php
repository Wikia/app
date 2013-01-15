<?php

use Wikia\Search\IndexService\Factory;
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
	 * Constructor method.
	 * Sets defaults -- no writing to memache, and a default search indexer instance
	 */
	public function __construct()
	{
		parent::__construct();
		$this->wg->AllowMemcacheWrites = false;
		$this->wg->AppStripsHtml = true;
		$this->searchIndexer = F::build( 'WikiaSearchIndexer' );
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
}