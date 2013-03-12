<?php
/**
 * Class definition for \Wikia\Search\Match\Wiki
 */
namespace Wikia\Search\Match;
use \Wikia\Search\Result as Result;
use \Wikia\Search\Utilities;
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
		$fields = array(
				'wid' => $this->id,
				'title' => $this->interface->getGlobalForWiki( 'wgSitename', $this->id ),
				'isWikiMatch' => true,
				'text' => $this->interface->getDescriptionTextForWikiId( $this->id ),
				'url' => $this->interface->getMainPageUrlForWikiId( $this->id ),
				'hub' => $this->interface->getHubForWikiId( $this->id ),
				);
		$fields = array_merge( $fields, $this->interface->getVisualizationInfoForWikiId( $this->id ), $this->interface->getStatsInfoForWikiId( $this->id ) );
		$result = new Result( $fields );
		if ( isset( $result['description'] ) ) {
			$result->setText( $result['description'] );
		}
		return $result;
	}
}