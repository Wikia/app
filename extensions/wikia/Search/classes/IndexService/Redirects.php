<?php
/**
 * Class definition for \Wikia\Search\IndexService\Redirects
 * @author relwell
 *
 */
namespace Wikia\Search\IndexService;
/**
 * Reports on redirect titles for a given page
 * @author relwell
 */
class Redirects extends AbstractService
{
	/**
	 * Provided an Article, queries the database for all titles that are redirects to that page.
	 * @see \Wikia\Search\IndexService\AbstractService::execute()
	 * @return array
	 */
	public function execute() {
		wfProfileIn(__METHOD__);
		
		$page = $this->getPageFromPageId( $this->currentPageId );
	
		$dbr = $this->wf->GetDB(DB_SLAVE);
	
		$result = array( 'redirect_titles' => array() );
		$query = $dbr->select(
				array( 'redirect', 'page' ),
				array( 'page_title' ),
				array(),
				__METHOD__,
				array( 'GROUP'=>'rd_title' ),
				array( 'page' => array( 'INNER JOIN', array('rd_title'=>$page->getTitle()->getDbKey(), 'page_id = rd_from' ) ) )
		);
		// look how ugly this is without assignment in condition!
		while ( $row = $dbr->fetchObject( $query ) ) { 
				$result['redirect_titles'][] = str_replace( '_', '_', $row->page_title );
		}
		
		wfProfileOut(__METHOD__);
		return $result;
	}
}