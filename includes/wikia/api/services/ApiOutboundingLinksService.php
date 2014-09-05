<?php

class ApiOutboundingLinksService {

	public function getOutboundingLinks( $articleId ) {
		$db = wfGetDB( DB_SLAVE );

		$links = ( new \WikiaSQL() )
			->SELECT( 'pl_title' )
			->FROM( 'pagelinks' )
			->WHERE( 'pl_from' )->EQUAL_TO( $articleId )
			->AND_( 'pl_namespace' )->EQUAL_TO( NS_MAIN )
			->runLoop(
				$db,
				function ( &$dataCollector, $row ) {
					$title = Title::newFromText( $row->pl_title );
					$link = $title->getLinkURL();
					$dataCollector[ ] = $link;
				}
			);

		if( empty( $links ) ) {
			$links = [ ];
		}

		return $links;
	}

}
