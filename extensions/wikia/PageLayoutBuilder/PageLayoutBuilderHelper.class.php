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

	/**
	 * create table with update.php
	 */
	static public function schemaUpdate() {
		global $wgExtNewTables;
		$wgExtNewTables[] = array( "plb_field", dirname(__FILE__) . "/sql/plb_field.sql" );
		$wgExtNewTables[] = array( "plb_page", dirname(__FILE__) . "/sql/plb_page.sql" );
		return true;
	}

	/**
	 * Redirects user to page layout builder special page
	 * if the supplied argument is valid layout id
	 *
	 * @param string $text
	 * @author wladek
	 */
	static public function onCreatePageSubpage( $text ) {
		if (is_numeric($text)) {
			$id = intval($text);
			$title = Title::newFromID($id);
			if ( $title && $title->getNamespace() == NS_PLB_LAYOUT ) {
				global $wgOut;
				$wgOut->redirect( SpecialPage::getTitleFor('PageLayoutBuilderForm')->getFullUrl("plbId={$id}") );
				return false;
			}
		}

		return true;
	}
	
	/*
	 * copyLayout - use by task to copy layouts from commuinty
	 * 
	 * @author Tomasz Odrobny
	 * @params Title
	 * @return Parser
	 */
	
	public static function copyLayout() {
		global $wgCityId;
		$list = PageLayoutBuilderModel::getLayoutsToCopy();
		foreach( $list as $layout => $cats ) {
			$cat = WikiFactory::getCategory( $wgCityId );
			if(in_array($cat->cat_id, $cats)) {
				PageLayoutBuilderModel::setLayoutCopy( $layout, $wgCityId );
				$layoutInfo = PageLayoutBuilderModel::getLayoutCopyInfo( $layout );
				
				if($layoutInfo !== false) {
					$newTitle = Title::newFromText( $layoutInfo['title'], NS_PLB_LAYOUT );
					if(!$newTitle->exists()){
						$article = new Article( $newTitle );
						$article->doEdit( $layoutInfo['text'], '', EDIT_NEW | EDIT_DEFER_UPDATES | EDIT_AUTOSUMMARY );
						PageLayoutBuilderModel::setProp($article->getId(), array('desc' => $layoutInfo['desc'] ) );
						
					}
				}
				
			}		
		}
		
		return true;
	}

}
