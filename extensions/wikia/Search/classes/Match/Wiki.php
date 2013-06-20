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
		$title = $this->service->getGlobalForWiki( 'wgSitename', $this->id );
		$fields = array(
				'wid' => $this->id,
				'title' => $title,
				'isWikiMatch' => true,
				'url' => $this->service->getMainPageUrlForWikiId( $this->id ),
				'hub' => $this->service->getHubForWikiId( $this->id ),
				'lang' => $this->service->getGlobalForWiki( 'wgLanguageCode', $this->id ),
				);
		$fields = array_merge( $fields, $this->service->getVisualizationInfoForWikiId( $this->id ), $this->service->getStatsInfoForWikiId( $this->id ) );
		if ( empty($fields['desc']) ) {
			$fields['desc'] = $this->service->getSimpleMessage( 'wikiasearch2-crosswiki-description', array( $title ) );
		}
		$result = new Result( $fields );
		if ( isset( $result['description'] ) ) {
			$result->setText( $result['description'] );
		}
		return $result;
	}
}