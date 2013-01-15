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
	
		$pageId = $this->currentPageId;
		if ( $pageId === null ) {
			throw new \WikiaException( 'A pageId-dependent indexer service was executed without a page ID queued' );
		}
		
		$apiService = new \ApiService();
		if (! empty( $this->wg->ExternalSharedDB ) ) {
			$data = $apiService->call( array(
					'pageids'  => $pageId,
					'action'   => 'query',
					'prop'     => 'info',
					'inprop'   => 'url|created|views|revcount',
					'meta'     => 'siteinfo',
					'siprop'   => 'statistics|wikidesc|variables|namespaces|category'
			));
			if( isset( $data['query']['pages'][$pageId] ) ) {
				$pageData = $data['query']['pages'][$pageId];
				$result['views'] = $pageData['views'];
				$result['revcount'] = $pageData['revcount'];
				$result['created'] = $pageData['created'];
				$result['touched'] = $pageData['touched'];
			}
			
			$result['hub'] = isset($data['query']['category']['catname']) ? $data['query']['category']['catname'] : '';
		}
	
		wfProfileOut(__METHOD__);
		return $result;
	}
	
}