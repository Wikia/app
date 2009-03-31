<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

class TranslateToolbox {
	/**
	 * Adds link in toolbox to Special:Prefixindex to show all other
	 * available translations for a message. Only shown when it
	 * actually is a translatable/translated message.
	 */
	static function toolboxAllTranslations( &$skin ) {
		global $wgTitle;

		$inMessageGroup = TranslateUtils::messageKeyToGroup( $wgTitle->getNamespace(), $wgTitle->getBaseText() );

		if ( $inMessageGroup ) {
			wfLoadExtensionMessages( 'Translate' );

			// Add a slash at the end, to not have basename in the result of Special:Prefixindex
			$message = $wgTitle->getNsText() . ":" . $wgTitle->getBaseText();
			$desc = wfMsg( 'translate-sidebar-alltrans' );
			$url = htmlspecialchars( SpecialPage::getTitleFor( 'Translations' )->getLocalURL( 'message=' . $message ) );

			// Add the actual toolbox entry.
			// Add newlines and tabs for nicer HTML output.
			echo( "\n\t\t\t\t<li id=\"t-alltrans\"><a href=\"$url\">$desc</a></li>\n" );
		}
		return true;
	}
}
