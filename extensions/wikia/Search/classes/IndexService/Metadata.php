<?php
/**
 * Class definition for \Wikia\Search\IndexService\Metadata
 * @author relwell
 */
namespace Wikia\Search\IndexService;
/**
 * Allows us to access mediawiki-dependent metadata
 * @author relwell
 */
class Metadata extends AbstractService
{
	/**
	 * Queries the API for article metadata
	 * @see \Wikia\Search\IndexService\AbstractService::execute()
	 * @return array
	 */
	public function execute() {
		wfProfileIn(__METHOD__);
		$result = array();
	
		$sharedDb = $this->interface->getGlobal( 'ExternalSharedDB' );
		if (! empty( $sharedDb ) ) {
			return array();
		}
		
		$pageId = $this->currentPageId;
		if ( $pageId === null ) {
			throw new \WikiaException( 'A pageId-dependent indexer service was executed without a page ID queued' );
		}

		$data = $this->interface->getApiStatsForPageId( $pageId );
		if( isset( $data['query']['pages'][$pageId] ) ) {
			$pageData = $data['query']['pages'][$pageId];
			$result['views'] = $pageData['views'];
			$result['revcount'] = $pageData['revcount'];
			$result['created'] = $pageData['created'];
			$result['touched'] = $pageData['touched'];
		}
			
		$result['hub'] = isset($data['query']['category']['catname']) ? $data['query']['category']['catname'] : '';
	
		wfProfileOut(__METHOD__);
		return $result;
	}
	
}