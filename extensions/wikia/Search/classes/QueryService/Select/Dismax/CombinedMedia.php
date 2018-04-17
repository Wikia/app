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
 *
 * @author relwell
 *
 */
class CombinedMedia extends AbstractDismax {

	/**
	 * We want all files (and maybe just videos) from the current wiki
	 *
	 * @see \Wikia\Search\QueryService\Select\Dismax\AbstractDismax::getQueryClausesString()
	 * @return string
	 */
	protected function getQueryClausesString() {
		$config = $this->getConfig();
		$queryClauses = [];

		$queryClauses[] = "+(wid:{$config->getWikiId()})";

		$queryClauses[] = Utilities::valueForField( 'ns', \NS_FILE );
		if ( $config->getCombinedMediaSearchIsVideoOnly() ) {
			$queryClauses[] = Utilities::valueForField( 'is_video', 'true' );
		}
		if ( $config->getCombinedMediaSearchIsImageOnly() ) {
			$queryClauses[] = Utilities::valueForField( 'is_image', 'true' );
		}

		return sprintf( '(%s)', implode( ' AND ', $queryClauses ) );
	}

	protected function registerQueryParams( Solarium_Query_Select $query ) {
		parent::registerQueryParams( $query );
		$config = $this->getConfig();
		$query->setRows(
			$config->getLimit() * 2
		); // fetch more results because we will filter them out later. FIXME: we shuld have more elegant way of handling this
		return $this;
	}


}
