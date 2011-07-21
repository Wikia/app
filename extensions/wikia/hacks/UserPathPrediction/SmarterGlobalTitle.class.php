<?php

class SmarterGlobalTitle extends GlobalTitle {

	/**
	 *  Create new Title from title of page
	 */
	//TODO: Make it compatabile with existing GlobalTitle
	public static function smarterNewFromText( &$data ) {
		global $wgMemc;
		$title = null;
		$text = $data[ 'r' ];
		$city_id = $data[ 'c' ];
		$dbname = $data[ 'x' ];
		
		$memkey = sprintf( "GlobalTitle:%s:%d", $text, $city_id );
		$res = $wgMemc->get( $memkey );
			
		if ( empty($res) && WikiFactory::isPublic($city_id) ) {
			$dbr = wfGetDB( DB_SLAVE, array(), ( $dbname ) ? $dbname : WikiFactory::IDtoDB($city_id) );
			$row = $dbr->selectRow( 'page',
				array( 'page_id', 'page_namespace' ),
				array( 'page_title' => $text ),
				__METHOD__
			);

			if( empty( $row ) ) {
				return false;
			}
			
			$res = array( 'id' => $row->page_id, 'namespace' => $row->page_namespace );
			$wgMemc->set($memkey, $res, 60 * 60);
		}

		if ( isset( $res['id'] ) && isset($res['namespace']) ) {
			$title = GlobalTitle::newFromText( $data[ 'r' ], $res['namespace'], $city_id );
		} else {
			$title = NULL;
		}

			$title->mArticleID = $res['id'];
			$title->mDbkeyform = str_replace( ' ', '_', $text );
			
		return $title;
	}
}
