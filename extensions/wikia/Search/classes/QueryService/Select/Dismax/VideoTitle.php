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
	 * Minimum duration in seconds
	 * @var int
	 */
	protected $minDuration;
	
	/**
	 * Maximum duration in seconds
	 * @var int
	 */
	protected $maxDuration;
	
	/**
	 * Totally short-circuits how we do select queries
	 * @return \Solarium_Query_Select
	 */
	protected function getSelectQuery() {
		$query = $this->client->createSelect();
		$query->setDocumentClass( '\Wikia\Search\Result' );
		$dismax = $query->getDismax();
		$dismax->setQueryParser( 'edismax' )
		       ->setMinimumMatch( $this->getConfig()->getMinimumMatch() )
		       ->setQueryFields( 'title_en' )
		       ->setPhraseFields( 'title_en' )
		       ->setPhraseSlop( 4 );
		$queryString = "+(wid:%1% AND is_video:true AND categories_mv_en:%2%) AND +(%3%)";
		$params = [
					Video::VIDEO_WIKI_ID,
					$this->service->getHubForWikiId( $this->service->getWikiId() ),
					$this->config->getQuery()->getSanitizedQuery(),
				];
		if ( $this->getMinDuration() && $this->getMaxDuration() ) {
			$queryString .= " AND video_duration_i:[%4% TO %5%]";
			$params = array_merge( $params, [ $this->getMinDuration(), $this->getMaxDuration() ] );
		}
		$query->setQuery( $queryString, $params );
		return $query;
	}
	
	/**
	 * @return int $minDuration
	 */
	public function getMinDuration() {
		return $this->minDuration;
	}

	/**
	 * @param int $minDuration
	 * @return Wikia\Search\QueryService\Select\VideoTitle
	 */
	public function setMinDuration($minDuration) {
		$this->minDuration = $minDuration;
		return $this;
	}

	/**
	 * Returns max duration as set by client code
	 * @return int $maxDuration
	 */
	public function getMaxDuration() {
		return $this->maxDuration;
	}

	/**
	 * @param int $maxDuration
	 * @return Wikia\Search\QueryService\Select\VideoTitle
	 */
	public function setMaxDuration($maxDuration) {
		$this->maxDuration = $maxDuration;
		return $this;
	}

	/**
	 * To heck with it, we need to get rid of this anyway.
	 * (non-PHPdoc)
	 * @see \Wikia\Search\QueryService\Select\AbstractSelect::getFormulatedQuery()
	 */
	public function getFormulatedQuery() {
		return '';
	}
	
	protected function getQueryFieldsString() {
		return '';
	}
	
	/**
	 * We're not using this beacuse we're trying Solarium's native prepared statement stuff in this queryservice
	 * Probably suggests we're eventually due for a refactor
	 * @see \Wikia\Search\QueryService\Select\Dismax\AbstractDismax::getQueryClausesString()
	 */
	protected function getQueryClausesString() {
		return '';
	}
}
