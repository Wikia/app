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
		$doc->loadHTML($html);
		$visitor = new HtmlToJsonFormatParserVisitor( $doc->getElementsByTagName('body')->item(0) );
		return $visitor->run();
	}
}
