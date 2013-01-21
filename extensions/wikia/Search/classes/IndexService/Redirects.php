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
		$key = $this->interface->getGlobal( 'AppStripsHtml' ) ? \WikiaSearch::field( 'redirect_titles' ) : 'redirect_titles';
		$result = array( $key => $this->interface->getRedirectTitlesForPageId( $this->currentPageId ) );
		wfProfileOut(__METHOD__);
		return $result;
	}
}