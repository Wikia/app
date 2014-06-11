<?php
class WikiaInteractiveMapsHooks {

	/**
	 * @brief Adds the JS asset to the bottom scripts
	 *
	 * @param $skin
	 * @param String $text
	 *
	 * @return bool
	 */
	public static function onSkinAfterBottomScripts( $skin, &$text ) {
		global $wgEnableWikiaInteractiveMaps, $wgExtensionsPath;

		if( !empty( $wgEnableWikiaInteractiveMaps ) ) {
			// add the asset to every page
			$text .= Html::linkedScript( $wgExtensionsPath . '/wikia/WikiaInteractiveMaps/js/WikiaInteractiveMapsParserTag.js' );
		}

		if( self::isSpecialInteractiveMapsPage() ) {
			// add the asset only on Special:InteractiveMaps page
			$text .= Html::linkedScript( $wgExtensionsPath . '/wikia/WikiaInteractiveMaps/js/WikiaInteractiveMaps.js' );
		}

		return true;
	}

	/**
	 * @brief Returns true if interactive maps are enabled and the current page is Special:InteractiveMaps
	 *
	 * @return bool
	 */
	private static function isSpecialInteractiveMapsPage() {
		global $wgEnableWikiaInteractiveMaps, $wgTitle;

		return !empty( $wgEnableWikiaInteractiveMaps ) && $wgTitle->isSpecial( 'InteractiveMaps' );
	}

	public static function formatLogEntry( $type, $action, $title, $forUI, $params, $filterWikilinks ) {
		global $wgLang;

		if(empty($params[0])){
			return "";
		}

		$endon = "";
		if(!empty($params[3])) {
			$endon = $wgLang->timeanddate( wfTimestamp( TS_MW, $params[3] ), true );
		}

		$skin = RequestContext::getMain()->getSkin();
		$id =  $params[1];
		$revert = "(" . "<a class='chat-change-ban' data-user-id='{$params[1]}' href='#'>" . wfMsg( 'chat-ban-log-change-ban-link') . "</a>" . ")";
		if ( !$filterWikilinks ) { // Plaintext? Used for IRC messages (BugID: 44249)
			$targetUser = User::newFromId( $id );
			$link = "[[User:{$targetUser->getName()}]]";
		} else {
			$link = $skin->userLink( $id, $title->getText() )
				.$skin->userToolLinks( $id, $title->getText(), false );
		}

		$time = "";
		if(!empty($params[2])) {
			$time = $params[2];
		}

		return wfMsg('chat-'.$action.'-log-entry', $link, $time, $endon );
	}

}
