<?php
/**
 * Class definition for \Wikia\Search\Match\Wiki
 */
namespace Wikia\Search\Match;
use \Wikia\Search\Result as Result;
use \Wikia\Search\Utilities;

class Wiki extends AbstractMatch
{
	/**
	 * Creates result from  main page. Prepopulates some values using stats and visualization info. Wiki description is used as a backoff.
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