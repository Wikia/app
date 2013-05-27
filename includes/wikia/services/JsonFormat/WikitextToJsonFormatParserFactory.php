<?php
/**
 * User: artur
 * Date: 21.05.13
 * Time: 16:09
 */

class WikitextToJsonFormatParserFactory {
	/**
	 * @return WikitextToJsonFormatParser
	 */
	public function  create() {
		return new WikitextToJsonFormatParser(
			new WikitextToHtmlParser( MessageCache::singleton() ),
			new HtmlToJsonFormatParser()
		);
	}
}
