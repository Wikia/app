<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\VideoTitle
 */
namespace Wikia\Search\QueryService\Select;
use Solarium_Query_Select;
/**
 * This class is designed to provide search results based on the title of a video.
 * @see WikiaSearchController::searchVideosByTitle for example usage.
 * @author relwell
 */
class VideoTitle extends AbstractSelect
{
	/**
	 * Minimum duration in seconds
	 * @var int
	 */
	protected $minDuration;
	
	/**
	 * Maximum duration in seconds
	 * @var unknown_type
	 */
	protected $maxDuration;
	
	/**
	 * Totally short-circuits how we do select queries
	 * @return \Solarium_Query_Select
	 */
	protected function getSelectQuery() {
		$query = $this->client->createSelect();
		$query->setDocumentClass( '\Wikia\Search\Result' );
		$queryString = "(wid:%1% AND is_video:true AND categories_mv_en:%2%) AND title_en:\"%3%\"~2";
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
	 * @return the $minDuration
	 */
	public function getMinDuration() {
		return $this->minDuration;
	}

	/**
	 * @param number $minDuration
	 * @return Wikia\Search\QueryService\Select\VideoTitle
	 */
	public function setMinDuration($minDuration) {
		$this->minDuration = $minDuration;
		return $this;
	}

	/**
	 * @return the $maxDuration
	 */
	public function getMaxDuration() {
		return $this->maxDuration;
	}

	/**
	 * @param \Wikia\Search\QueryService\Select\unknown_type $maxDuration
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
}