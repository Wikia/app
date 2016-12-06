<?php
/**
 * Class definition for \Wikia\Search\Indexservice\BacklinkCount
 *
 * @author relwell
 */
namespace Wikia\Search\IndexService;
/**
 * This class provides backlink info for a page
 *
 * @author relwell
 * @package Search
 * @subpackage IndexService
 */
class BacklinkCount extends AbstractService {
	/**
	 * Returns an array keyed for a solr schema field for backlinks
	 *
	 * @see \Wikia\Search\IndexService\AbstractService::execute()
	 * @return array
	 */
	public function execute() {

		$response = [ 'backlinks' => $this->getService()->getBacklinksCountFromPageId( $this->currentPageId ) ];

		return $response;
	}
}
