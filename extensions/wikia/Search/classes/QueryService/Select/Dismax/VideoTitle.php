<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\Dismax\VideoTitle
 */
namespace Wikia\Search\QueryService\Select\Dismax;
use Solarium_Query_Select;
/**
 * This class is designed to provide search results based on the title of a video.
 * @see WikiaSearchController::searchVideosByTitle for example usage.
 * @author relwell
 */
class VideoTitle extends AbstractDismax
{
	/**
	 * Totally short-circuits how we do select queries
	 * @return \Solarium_Query_Select
	 */
	protected function getSelectQuery() {
		$query = $this->client->createSelect();
		$query->setDocumentClass( '\Wikia\Search\Result' );
		
		$dismax = $query->getDisMax();
		$dismax->setQueryParser( 'edismax' )
		       ->setQueryFields( $this->getQueryFieldsString() )
		       ->setMinimumMatch( $this->config->getMinimumMatch() )
		;
		$query->setQuery( "(wid:%1% AND ns:6 AND categories_mv_en:%2%) AND (%3%)", 
				[
						Video::VIDEO_WIKI_ID,
						$this->service->getHubForWikiId( $this->service->getWikiId() ),
						$this->config->getQuery()->getSanitizedQuery()
				] );
		
		return $query;
	}
	
	protected function getQueryFieldsString() {
		return 'title_en^5 nolang_txt';
	}
}