<?php
/**
 * User: artur
 * Date: 21.05.13
 * Time: 14:17
 */

class WikitextToHtmlParser {
	/**
	 * @var MessageCache
	 */
	private $mc;

	/**
	 * @param null $mc
	 */
	function __construct( $mc = null ) {
		$this->mc = $mc;
	}

	/**
	 * @param $wikiText
	 * @return string
	 */
	public function parse( $wikiText ) {
		$result = $this->mc->parse( $wikiText );
		return $result->getText();
	}
}
