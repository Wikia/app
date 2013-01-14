<?php
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
	
	public function __construct()
	{
		parent::__construct();
		$this->wg->AllowMemcacheWrites = false;
		$this->searchIndexer = F::build('WikiaSearchIndexer');
	}
	
	public function getPageDefaults()
	{
		$ids = $this->getVal( 'ids' );
	    if ( !empty( $ids ) ) {
	        $this->response->setData( $this->callForPages( 'getPageDefaultValues', explode( '|', $ids ) ) );
	    }
		$this->getResponse()->setFormat('json');
	}
	
	/**
	 * Allows us to reuse the same basic JSON structure for any number of service calls
	 * @param string $fname
	 * @param array $pageIds
	 * @return Ambigous <multitype:multitype: , unknown>
	 */
	protected function callForPages( $fname, array $pageIds )
	{
		wfProfileIn(__METHOD__);
		
		$result = array( 'contents' => '', 'errors' => array() );
		$documents = array();
		
		foreach ( $pageIds as $pageId ) {
			try {
				
				$responseArray = $this->searchIndexer->{$fname}( $pageId );
				
				$document = new Solarium_Document_AtomicUpdate( $responseArray );
				$pageIdKey = $document->pageid ?: sprintf( '%s_%s', $this->wg->CityId, $pageId );
				$document->setKey( 'pageid', $pageIdKey );
				
				$documents[] = $document;

			} catch (WikiaException $e) {
				$result['errors'][] = $pageId;
			}
		}
		
		$result['contents'] = $this->searchIndexer->getUpdateXmlForDocuments( $documents );
		
		wfProfileOut(__METHOD__);
		return $result;
	}
}