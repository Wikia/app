<?php

class PageLayoutBuilderHelper {
	/*
	 * @author Tomasz Odrobny
	 * @params Title
	 * @return Parser
	 */
	
	public static function rteIsCustom($name, $params, $frame, $wikitextIdx) {
		global $wgPLBwidgets;
		if (isset($wgPLBwidgets[$name])) {
			return false;
		}
		return true;
	}
	
	
	static public function wikiFactoryChanged( $cv_name, $city_id, $value ) {
		global $IP;
		Wikia::log( __METHOD__, $city_id, "{$cv_name} = {$value}" );

		if( $cv_name != 'wgEnablePageLayoutBuilder' ){
			return true;
		}
		
		$dbr = wfGetDB( DB_MASTER, array(), WikiFactory::IDtoDB($city_id) );
	
		if( !$dbr->tableExists( "plb_field" ) ){
			$dbr->sourceFile( "$IP/extensions/wikia/PageLayoutBuilder/sql/plb_field.sql" );
		}
		
		if( !$dbr->tableExists( "plb_page" ) ){
			$dbr->sourceFile( "$IP/extensions/wikia/PageLayoutBuilder/sql/plb_page.sql" );
		}
		return true;
	}
}