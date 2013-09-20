<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\Dismax\VideoEmbedTool
 */
namespace Wikia\Search\QueryService\Select\Dismax;
use Wikia\Search\Utilities;
/**
 * This class is responsible for handling Video Embed Tool search logic.
 */
class VideoEmbedTool extends Video
{
	/**
	 * Here, we overwrite the normal behavior of getFormulatedQuery to search for wiki TOPIC instead of the query
	 * @return string
	 */
	protected function getQuery() {
	  return sprintf( '+(%s) AND ( +(%s)^1000 AND +(%s)^2000 )', $this->getQueryClausesString(), $this->getTopicsAsQuery(), $this->getTransformedQuery() );
	}
	
	/**
	 * I've noticed that first names or characters are more common in videos, and last names much less common
	 * This boosts the first token in a query, which often corresponds to a first name. We will probably want to tweak this.
	 */
	protected function getTransformedQuery() {
		$query = $this->getConfig()->getQuery()->getSolrQuery();
		$ploded = explode( " ", $query );
		$first = array_shift( $ploded );
		if (! empty( $ploded ) ) {
			return "{$first}^5 " . implode( " ", $ploded );
		} else {
			return $first; // that's all we got. why boost it?
		}
	}
	
	/**
	 * Takes whatever global topics are set and returns them disjunctively
	 * The backoff for this is to return the wiki name with "wiki" stripped off
	 * @return string
	 */
	protected function getTopicsAsQuery() {
		$topics = [];
		$service = $this->getService();
		foreach ( $service->getGlobalWithDefault( 'WikiVideoSearchTopics', [] ) as $topic ) {
			$topics[] = sprintf( '"%s"', $topic );
		}
		return empty( $topics ) ? sprintf( '"%s"', trim( preg_replace( '/\bwiki\b/', '', strtolower( $service->getGlobal( 'Sitename' ) ) ) ) ) : implode( ' OR ', $topics );
	}
	
	/**
	 * Require the wiki ID we're on (or video wiki), and that everything is a video
	 * @return string
	 */
	protected function getQueryClausesString() {
		$queryClauses = array(
				Utilities::valueForField( 'wid', $this->getConfig()->getWikiId() ),
				Utilities::valueForField( 'is_video', 'true' ),
				Utilities::valueForField( 'ns', \NS_FILE )
				);
		return sprintf( '(%s)', implode( ' AND ', $queryClauses ) );
	}
	
	/**
	 * Boosts results that match the the current hub category and wiki title 
	 * @see \Wikia\Search\QueryService\Select\Video::getBoostQueryString()
	 * @return string
	 */
	public function getBoostQueryString() {
		$service = $this->getService();
		return sprintf( '%s^150 AND (%s)^250 AND (html_media_extras_txt:(%s))^300',
				Utilities::valueForField( 'categories', $service->getHubForWikiId( $service->getWikiId() ) ),
				$this->getConfig()->getQuery()->getSolrQuery(),
				$this->getTopicsAsQuery()
				);
	}
}