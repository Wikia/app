<?php
/**
 * Improved version of GlobalTitle
 * 
 * @author Jakub Olek <jakubolek(at)wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class BetterGlobalTitle extends GlobalTitle {

	/**
	 *  static constructor, Create new Title from name of page
	 */
	public static function newFromText( &$text, &$city_id, &$dbname = "" ) {
		$app = WF::app();
		$app->wf->profileIn( __METHOD__ );

		$title = null;
		$dbname = $dbname ? $dbname : WikiFactory::IDtoDB( $city_id );
		
		$memkey = sprintf( "BetterGlobalTitle:%s:%d", $text, $city_id );
		$row = $app->wg->Memc->get( $memkey );
			
		if ( empty( $row ) && WikiFactory::isPublic( $city_id ) ) {
			$dbr = $app->wf->GetDB( DB_SLAVE, array(), $dbname );
			$row = $dbr->selectRow( 'page',
				array( 'page_id', 'page_namespace' ),
				array( 'page_title' => $text ),
				__METHOD__
			);

			if ( empty( $row ) ) {
				$app->wf->profileOut( __METHOD__ );
				return $title;
			}
			
			$app->wg->Memc->set( $memkey, $row, 3600  );
		}

		if ( !empty( $row->page_id ) && isset( $row->page_namespace ) ) {
			$title = GlobalTitle::newFromText( $text, $row->page_namespace, $city_id );
			$title->mArticleID = $row->page_id;
			$title->mDbkeyform = str_replace( ' ', '_', $text );
		}
		
		$app->wf->profileOut( __METHOD__ );
		return $title;
	}
}
