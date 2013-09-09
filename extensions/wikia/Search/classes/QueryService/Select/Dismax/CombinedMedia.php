<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\Dismax\CombinedMedia
 */
namespace Wikia\Search\QueryService\Select\Dismax;
use Solarium_Query_Select;
use Wikia\Search\Utilities;
/**
 * This class is responsible for providing videos and (optionally) images 
 * from both the current wiki and the premium video wiki.
 * @author relwell
 *
 */
class CombinedMedia extends AbstractDismax
{
	
	/**
	 * We want all files (and maybe just videos) from video wiki and the current wiki
	 * @see \Wikia\Search\QueryService\Select\Dismax\AbstractDismax::getQueryClausesString()
	 * @return string
	 */
	protected function getQueryClausesString() {
		$config = $this->getConfig();
		$queryClauses = [];
		$queryClauses[] = sprintf( '+((wid:%d AND (%s)) OR wid:%d)', Video::VIDEO_WIKI_ID, $this->getTopicsAsQuery(), $config->getWikiId() );
		$queryClauses[] = Utilities::valueForField( 'ns', \NS_FILE );
		if ( $config->getCombinedMediaSearchIsVideoOnly() ) {
			$queryClauses[] = Utilities::valueForField( 'is_video', 'true' );
		}
		return sprintf( '(%s)', implode( ' AND ', $queryClauses ) );
	}
	
	/**
	 * Takes whatever global topics are set and returns them disjunctively
	 * The backoff for this is to return the wiki name with "wiki" stripped off
	 * Taken from VideoEmbedTool, so if this shows up again we should make a parent class or trait or something
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

	protected function registerQueryParams(Solarium_Query_Select $query) {
		parent::registerQueryParams($query);
		$config = $this->getConfig();
		$query->setRows ( $config->getLimit() * 2 );
		return $this;
	}


}
