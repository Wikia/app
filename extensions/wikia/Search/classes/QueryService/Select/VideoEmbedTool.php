<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\VideoEmbedTool
 */
namespace Wikia\Search\QueryService\Select;
use Wikia\Search\Utilities;
/**
 * This class is responsible for handling Video Embed Tool search logic.
 */
class VideoEmbedTool extends Video
{
	/**
	 * Boosts results that match the the current hub category and wiki title 
	 * @see \Wikia\Search\QueryService\Select\Video::getBoostQueryString()
	 * @return string
	 */
	public function getBoostQueryString() {
		return sprintf( '%s^50 (%s)^150',
				Utilities::valueForField( 'categories', $this->service->getHubForWikiId( $this->service->getWikiId() ) ),
				$this->getConfig()->getQuery()->getSolrQuery()
				);
	}
	
	/**
	 * Here, we overwrite the normal behavior of getFormulatedQuery to search for wiki TOPIC instead of the query
	 * @return string
	 */
	protected function getFormulatedQuery() {
		return sprintf( '+(%s) AND ( (%s)^100 OR (%s)^1000 )', $this->getQueryClausesString(), $this->getTopicsAsQuery(), $this->getConfig()->getQuery()->getSolrQuery() );
	}
	
	/**
	 * Takes whatever global topics are set and returns them disjunctively
	 * The backoff of this is to just return the query, since asking for the same query twice isn't really a big deal.
	 * @return string
	 */
	protected function getTopicsAsQuery() {
		$topics = [];
		foreach ( $this->getService()->getGlobalWithDefault( 'WikiVideoSearchTopics', [] ) as $topic ) {
			$topics[] = sprintf( '(%s)', $topic );
		}
		return empty( $topics ) ? $this->getConfig()->getQuery()->getSolrQuery() : implode( ' OR ', $topics );
	}
	
	/**
	 * Require the wiki ID we're on (or video wiki), and that everything is a video
	 * @return string
	 */
	protected function getQueryClausesString() {
		$queryClauses = array(
				Utilities::valueForField( 'wid', $this->config->getCityId() ),
				Utilities::valueForField( 'is_video', 'true' ),
				Utilities::valueForField( 'ns', \NS_FILE )
				);
		return sprintf( '(%s)', implode( ' AND ', $queryClauses ) );
	}
}