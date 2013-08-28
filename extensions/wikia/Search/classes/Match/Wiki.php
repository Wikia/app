<?php
/**
 * Class definition for \Wikia\Search\Match\Wiki
 */
namespace Wikia\Search\Match;
use \Wikia\Search\Result as Result;
use \Wikia\Search\Utilities, SolrDocumentService;
/**
 * This class correlates a Wiki ID to a search result, using global data to 
 * instantiate a result we can use as a base or grouped result.
 * @author relwell
 * @package Search
 * @subpackage Match
 */
class Wiki extends AbstractMatch
{
	/**
	 * Creates a result using description text for the wiki. Prepopulates some values using stats and visualization info.
	 * @see \Wikia\Search\Match\AbstractMatch::createResult()
	 * @return \Wikia\Search\Result;
	 */
	public function createResult()
	{
		$service = new SolrDocumentService();
		$service->setCrossWiki( true );
		$service->setWikiId( $this->getId() );
		$result = $service->getResult();
		if (! empty( $result ) ) {
			$result['exactWikiMatch'] = true;
		}
		return $result;
	}
}