<?php
/**
 * Class definition for \Wikia\Search\Indexservice\BacklinkCount
 * @author relwell
 */
namespace Wikia\Search\IndexService;
/**
 * This class provides backlink info for a page  
 * @author relwell
 */
class BacklinkCount extends AbstractService
{
	/**
	 * Returns an array keyed for a solr schema field for backlinks
	 * @see \Wikia\Search\IndexService\AbstractService::execute()
	 * @return array
	 */
	public function execute() {
		wfProfileIn(__METHOD__);
		$page = $this->getPageFromPageId( $this->currentPageId );
		$title = $page->getTitle();
		$apiService = new \ApiService();
		$data = $apiService->call( array(
				'titles'	=> $title,
				'bltitle'	=> $title,
				'action'	=> 'query',
				'list'		=> 'backlinks',
				'blcount'	=> 1
		));
		wfProfileOut(__METHOD__);
		return array(
				'backlinks' => isset($data['query']['backlinks_count'] ) ? $data['query']['backlinks_count'] : 0
		);
	}
}