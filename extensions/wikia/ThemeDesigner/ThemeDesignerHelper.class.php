<?php

class ThemeDesignerHelper {

	public static function parseText($text = "") {
		global $wgTitle;
		$tmpParser = new Parser();
		$tmpParser->setOutputType(OT_HTML);
		$tmpParserOptions = new ParserOptions();
		return $tmpParser->parse( $text, $wgTitle, $tmpParserOptions)->getText();
	}
}