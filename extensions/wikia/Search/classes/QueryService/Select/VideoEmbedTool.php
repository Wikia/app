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
		return sprintf( '%s (%s)',
				Utilities::valueForField( 'categories', $this->service->getHubForWikiId( $this->service->getWikiId() ) ),
				preg_replace( '/\bwiki\b/i', '', $this->service->getGlobal( 'Sitename' ) )
				);
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