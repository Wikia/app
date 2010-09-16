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
			$relatedTitle = null;
			$relatedImage = null;
			$relatedUrl = null;

			if ( !empty( $args[ TOPLIST_ATTRIBUTE_RELATED ] ) ) {
				self::$mAttributes[ TOPLIST_ATTRIBUTE_RELATED ] = $args[ TOPLIST_ATTRIBUTE_RELATED ];
				$relatedTitle = Title::newFromText( $args[ TOPLIST_ATTRIBUTE_RELATED ] );
				$relatedUrl = $relatedTitle->getLocalUrl();
			}

			if ( !empty( $args[ TOPLIST_ATTRIBUTE_PICTURE ] ) ) {
				self::$mAttributes[ TOPLIST_ATTRIBUTE_PICTURE ] = $args[ TOPLIST_ATTRIBUTE_PICTURE ];
				
				if( !empty( self::$mAttributes[ TOPLIST_ATTRIBUTE_PICTURE ] ) ) {
					$source = new imageServing(
						null,
						120,
						array(
							"w" => 3,
							"h" => 2
						)
					);

					$result = $source->getThumbnails( array( self::$mAttributes[ TOPLIST_ATTRIBUTE_PICTURE ] ) );

					if( !empty( $result[ self::$mAttributes[ TOPLIST_ATTRIBUTE_PICTURE ] ] ) ) {
						$relatedImage = $result[ self::$mAttributes[ TOPLIST_ATTRIBUTE_PICTURE ] ];
						
						if( empty( $relatedUrl ) ) {
							$title = Title::newFromText( $relatedImage[ 'name' ], NS_FILE );
							$relatedUrl = $title->getLocalURL();
						}
					}
				}
			}

			$list = TopList::newFromTitle( $parser->mTitle );

			if ( !empty( $list ) ) {
				$wgOut->addStyle( wfGetSassUrl( "$wgExtensionsPath/wikia/TopLists/css/list.scss" ) );
				$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/TopLists/js/list.js?{$wgStyleVersion}\"></script>\n" );

				$template = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
				$template->set_vars( array( 'list' => $list, 'attribs' => self::$mAttributes, 'relatedTitle' => $relatedTitle, 'relatedImage' => $relatedImage, 'relatedUrl' => $relatedUrl ) );

				self::$mOutput = $template->execute( 'list' );

				// remove whitespaces to avoid extra <p> tags
				self::$mOutput = preg_replace("#[\n\t]+#", '', self::$mOutput);
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
