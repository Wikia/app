<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 8/26/14
 * Time: 3:07 PM
 */

class ApiOutboundingLinksService {

	public function getOutboundingLinksSet( $articleId ) {
		$db = wfGetDB( DB_SLAVE );

		$linksHashSet = ( new \WikiaSQL() )
			->SELECT( 'pl_title' )
			->FROM( 'pagelinks' )
			->WHERE( 'pl_from' )->EQUAL_TO( $articleId )
			->AND_( 'pl_namespace' )->EQUAL_TO( NS_MAIN )
			->runLoop(
				$db,
				function( &$dataCollector, $row ){
					$title = Title::newFromText( $row->pl_title );
					$link = $title->getLinkURL();
					$dataCollector[ $link ] = true;
				}
			);

		return $linksHashSet;
	}

} 