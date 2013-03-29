<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\VideoTitle
 */
namespace Wikia\Search\QueryService\Select;
/**
 * This class is designed to provide search results based on the title of a video.
 * @see WikiaSearchController::searchVideosByTitle for example usage.
 * @author relwell
 */
class VideoTitle extends Lucene
{
	/**
	 * Given a search query (which is the title of a video), the video wiki for videos 
	 * (non-PHPdoc)
	 * @see \Wikia\Search\QueryService\Select\AbstractSelect::getQueryClausesString()
	 * @return string
	 */
	protected function getFormulatedQuery() {
		$query = $this->config->getQuery();
		return sprintf( 'wid:%s AND ns:6 AND ( title_en:(%s) OR nolang_txt:(%s) )', Video::VIDEO_WIKI_ID, $query, $query );
	}
}