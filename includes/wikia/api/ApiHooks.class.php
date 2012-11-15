<?php
/**
 *
 * Api needs hooks as well
 * this is great place for them
 *
 * @author: jolek
 */

class ApiHooks {

	/**
	 * Check if given title refers to wiki nav messages
	 */
	private static function isWikiNavMessage(Title $title) {
		return ($title->getNamespace() == NS_MEDIAWIKI) && ($title->getText() == NavigationModel::WIKI_LOCAL_MESSAGE);
	}

	public static function onWikiFactoryChanged( $cv_name , $city_id, $value ) {
		if ( $cv_name == NavigationModel::WIKIA_GLOBAL_VARIABLE ) {
			SquidUpdate::purge(
				array(
					NavigationApiController::getUrlToAjaxMethod( 'getData' )
				)
			);
		}

		return true;
	}

	public static function onMessageCacheReplace( $title, $text ) {
		if ( self::isWikiNavMessage( Title::newFromText( $title, NS_MEDIAWIKI ) ) ) {
			SquidUpdate::purge(
				array(
					NavigationApiController::getUrlToAjaxMethod( 'getData' )
				)
			);
		}

		return true;
	}
}