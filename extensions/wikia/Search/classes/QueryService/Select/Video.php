<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\VideoSearch
 */
namespace Wikia\Search\QueryService\Select;
use Wikia\Search\Utilities;
/**
 * Class responsible for video search. Not totally sure we're using this for video search presently.
 * @author relwell
 * @package Search
 * @subpackage QueryService
 */
class Video extends OnWiki
{
	/**
	 * This is the cityId value for the video wiki, used in video searches.
	 * @var int
	 */
	const VIDEO_WIKI_ID = 298117;
	
	/**
	 * Video wiki requires english field search
	 * @see \Wikia\Search\QueryService\Select\OnWiki::configureQueryFields()
	 */
	protected function configureQueryFields() {
		if ( $this->service->getLanguageCode() !== 'en' ) {
			$this->config->addQueryFields( array(
					Utilities::field( 'title', 'en' )           => 5, 
					Utilities::field( 'html', 'en' )            => 1.5, 
					Utilities::field( 'redirect_titles', 'en' ) => 4
					));
		}
		return $this;
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