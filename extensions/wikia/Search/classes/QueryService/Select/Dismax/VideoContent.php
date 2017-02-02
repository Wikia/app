<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\Dismax\VideoContent
 */
namespace Wikia\Search\QueryService\Select\Dismax;

use Solarium_Query_Select;

/**
 * This class is designed to provide search results based on the content of a video.
 *
 * @see WikiaSearchController::searchVideosByTopics for example usage.
 */
class VideoContent extends AbstractDismax {
	/**
	 * Minimum duration in seconds
	 *
	 * @var int
	 */
	protected $minDuration;

	/**
	 * Maximum duration in seconds
	 *
	 * @var int
	 */
	protected $maxDuration;

	/**
	 * Totally short-circuits how we do select queries
	 *
	 * @return \Solarium_Query_Select
	 */
	protected function getSelectQuery() {
		$query = $this->client->createSelect();
		$query->setDocumentClass( '\Wikia\Search\Result' );
		$dismax = $query->getDisMax();
		$dismax->setQueryParser( 'edismax' )->setMinimumMatch( $this->getConfig()->getMinimumMatch() )->setQueryFields(
				'title_en^100 html_en^5 redirect_titles_mv_en^50 categories_mv_en^25 nolang_txt^10 backlinks_txt^25 video_actors_txt^100 video_genres_txt^50 html_media_extras_txt^20 video_description_txt^100 video_keywords_txt^60 video_tags_txt^40'
			)->setPhraseFields( 'title_en' )->setPhraseSlop( 4 );
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
		$query->setRows( $this->config->getLimit() );

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
	 *
	 * @return VideoContent
	 */
	public function setMinDuration( $minDuration ) {
		$this->minDuration = $minDuration;

		return $this;
	}

	/**
	 * Returns max duration as set by client code
	 *
	 * @return int $maxDuration
	 */
	public function getMaxDuration() {
		return $this->maxDuration;
	}

	/**
	 * @param int $maxDuration
	 *
	 * @return VideoContent
	 */
	public function setMaxDuration( $maxDuration ) {
		$this->maxDuration = $maxDuration;

		return $this;
	}

	/**
	 * To heck with it, we need to get rid of this anyway.
	 * (non-PHPdoc)
	 *
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
	 *
	 * @see \Wikia\Search\QueryService\Select\Dismax\AbstractDismax::getQueryClausesString()
	 */
	protected function getQueryClausesString() {
		return '';
	}
}
