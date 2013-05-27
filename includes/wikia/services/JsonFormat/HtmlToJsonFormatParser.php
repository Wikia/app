<?php
/**
 * User: artur
 * Date: 21.05.13
 * Time: 14:36
 */

class HtmlToJsonFormatParser {
	/**
	 * @param string $html
	 * @return JsonFormatNode
	 */
	public function parse( $html ) {
		$doc = new DOMDocument();
		libxml_use_internal_errors(true);
		$doc->loadHTML("<?xml encoding=\"UTF-8\">\n<html><body>" . $html . "</body></html>");
		libxml_clear_errors();
		$visitor = new HtmlToJsonFormatParserVisitorStateful( $doc->getElementsByTagName('body')->item(0) );
		return $visitor->run();
	}
}
