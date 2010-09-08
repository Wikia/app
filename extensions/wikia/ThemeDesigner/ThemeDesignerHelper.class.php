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

	/**
	 * Handle AJAX request for saving current settings
	 */
	public static function saveSettings() {
		global $wgRequest;
		wfProfileIn( __METHOD__ );

		$themeSettings = new ThemeSettings();
		$data = $wgRequest->getArray( 'settings' );

		foreach ( $data as $name => $value ) {
			$themeSettings->set( $name, $value );
		}

		$result = $themeSettings->save();
		$ret = array( 'result' => $result );

		$response = new AjaxResponse( Wikia::json_encode( $ret ) );
		$response->setContentType( 'application/json; charset=utf-8' );

		wfProfileOut( __METHOD__ );
		return $response;
	}
	
	public static function parseText($text = "") {
		global $wgTitle;
		$tmpParser = new Parser();
		$tmpParser->setOutputType(OT_HTML);
		$tmpParserOptions = new ParserOptions();
		return $tmpParser->parse( $text, $wgTitle, $tmpParserOptions)->getText();
	}
}