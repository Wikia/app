<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\Dismax\CombinedMedia
 */
namespace Wikia\Search\QueryService\Select\Dismax;
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
		$queryClauses[] = sprintf( '+(wid:%d OR wid:%d)', Video::VIDEO_WIKI_ID, $config->getWikiId() );
		$queryClauses[] = Utilities::valueForField( 'ns', \NS_FILE );
		if ( $config->getCombinedMediaSearchIsVideoOnly() ) {
			$queryClauses[] = Utilities::valueForField( 'is_video', 'true' );
		}
		return sprintf( '(%s)', implode( ' AND ', $queryClauses ) );
	}
	
	
}