<?php

class ThemeDesignerHelper {

	/**
	 * Add Special:ThemeDesigner to MyTools menu
	 */
	public static function addToMyTools( &$tools ) {
		global $wgUser;

		if ( $wgUser->isAllowed( 'themedesigner' ) ) {
			wfLoadExtensionMessages( 'ThemeDesigner' );
			$tools[] = 'ThemeDesigner';
		}

		return true;
	}

	public static function parseText($text = "") {
		global $wgTitle;
		$tmpParser = new Parser();
		$tmpParser->setOutputType(OT_HTML);
		$tmpParserOptions = new ParserOptions();
		return $tmpParser->parse( $text, $wgTitle, $tmpParserOptions)->getText();
	}
}