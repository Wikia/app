<?php
/**
 * Class definition for \Wikia\Search\IndexService\Redirects
 * @author relwell
 */
namespace Wikia\Search\IndexService;
use Wikia\Search\Utilities;
/**
 * Reports on redirect titles for a given page
 * @author relwell
 * @package Search
 * @subpackage IndexService
 */
class Redirects extends AbstractService
{
	/**
	 * Provided an Article, queries the database for all titles that are redirects to that page.
	 * @see \Wikia\Search\IndexService\AbstractService::execute()
	 * @return array
	 */
	public function execute() {
		$service = $this->getService();
		$key = $service->getGlobal( 'AppStripsHtml' ) ? Utilities::field( 'redirect_titles' ) : 'redirect_titles';
		$titles = $service->getRedirectTitlesForPageId( $this->currentPageId );
		$result = array( $key => $titles, 'redirect_titles_mv_em' => $titles );
		return $result;
	}
}