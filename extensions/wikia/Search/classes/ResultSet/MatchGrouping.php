<?php
/**
 * Class definition for Wikia\Search\ResultSet\MatchGrouping
 * @author relwell
 *
 */
namespace Wikia\Search\ResultSet;
use DataMartService;
/**
 * This class is used to create a "grouping" based on a wiki match.
 * @author relwell
 * @package Search
 * @subpackage ResultSet
 */
class MatchGrouping extends Grouping {
	
	/**
	 * Stores top pages.
	 * @var array
	 */
	protected $topPages = [];
	
	/**
	 * Uses DependencyContainer to pre-populate attributes, and then configures stuff.
	 * Note that we're skipping adding headers or ingesting results from result groupings.
	 * @param DependencyContainer $container
	 */
	protected function configure( DependencyContainer $container ) {
		$this->searchResultObject = $container->getResult();
		$this->searchConfig       = $container->getConfig();
		$this->service          = $container->getService();
		$this->parent             = $container->getParent();
		$this->metaposition       = $container->getMetaposition();
		$result                   = $container->getWikiMatch()->getResult();
		$this->results            = new \ArrayIterator( array( $result ) );
		
		$this->addHeaders( $result->getFields() );
	}
	
	/**
	 * Returns the top four articles for this wiki
	 * @return array of Articles
	 */
	public function getTopPages() {
		if ( empty( $this->topPages ) ) {
			$wikiId = $this->getHeader( 'wid' );
			$articles = (new DataMartService)->getTopArticlesByPageview(
					$wikiId,
					null,
					null,
					false,
					5 //compensation for Main Page
					);
			$mainId = $this->service->getMainPageIdForWikiId( $wikiId );
			$counter = 0;
			unset( $articles[$mainId] );
			$this->topPages = array_slice( array_keys( $articles ), 0, 4 );
		}
		return $this->topPages;
	}
	
}