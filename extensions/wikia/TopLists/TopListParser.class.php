<?php
/**
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 *
 * TopListParser object implementation
 */

class TopListParser {
	static private $mAttributes = array();
	static private $mOutput = null;

	/**
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 *
	 * Callback implementation for the ParserFirstCallInit hook
	 */
	static public function onParserFirstCallInit( &$parser ) {
		wfProfileIn( __METHOD__ );
		$parser->setHook( TOPLIST_TAG, array( __CLASS__, "parseTag" ) );
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 *
	 * Implementation of a parser function
	 */
	static public function parseTag( $input, $args, &$parser ) {
		global $wgOut, $wgJsMimeType, $wgExtensionsPath, $wgStyleVersion;

		if( empty( self::$mOutput ) ) {
			if ( !empty( $args[ TOPLIST_ATTRIBUTE_RELATED ] ) ) {
				self::$mAttributes[ TOPLIST_ATTRIBUTE_RELATED ] = $args[ TOPLIST_ATTRIBUTE_RELATED ];
				//$output .= '<li>' . TOPLIST_ATTRIBUTE_RELATED . " = {$args[ TOPLIST_ATTRIBUTE_RELATED ]}</li>";
			}

			if ( !empty( $args[ TOPLIST_ATTRIBUTE_PICTURE ] ) ) {
				self::$mAttributes[ TOPLIST_ATTRIBUTE_PICTURE ] = $args[ TOPLIST_ATTRIBUTE_PICTURE ];
				//$output .= '<li>' . TOPLIST_ATTRIBUTE_PICTURE . " = {$args[ TOPLIST_ATTRIBUTE_PICTURE ]}</li>";
			}

			$list = TopList::newFromTitle( $parser->mTitle );

			if ( !empty( $list ) ) {
				$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/TopLists/js/list.js?{$wgStyleVersion}\"></script>\n" );

				$template = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
				$template->set_vars( array( 'list' => $list, 'attribs' => self::$mAttributes ) );

				self::$mOutput = $template->execute( 'list' );
			}
			else {
				self::$mOutput = '';
			}
		}
		return self::$mOutput;
	}

	/**
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 *
	 * Returns the value of the requested attribute for the parsed TOPLIST_TAG tag
	 */
	static public function getAttribute( $attributeName ) {
		return ( !empty( self::$mAttributes[ $attributeName ] ) ) ? self::$mAttributes[ $attributeName ] : null;
	}

	/**
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 *
	 * Helper method to trigger parsing of a list article comment manually
	 *
	 * @param TopList $list the list object representing the article to parse
	 */
	static public function parse( TopList $list ) {
		global $wgParser;
		$parserOptions = new ParserOptions();

		return $wgParser->parse($list->getArticle()->getContent(), $list->getTitle(), $parserOptions)->getText();
	}
}
