<?php
/**
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 *
 * TopListParser object implementation
 */

class TopListParser {
	static private $mAttributes = array();
	static private $mOutput = null;
	static private $mList = null;

	/**
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 *
	 * Callback implementation for the ParserFirstCallInit hook
	 */
	static public function onParserFirstCallInit( &$parser ) {
		$app = F::app();

		$app->wf->ProfileIn( __METHOD__ );
		$app->wg->Parser->setHook( TOPLIST_TAG, array( __CLASS__, "parseTag" ) );
		$app->wf->ProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 *
	 * Implementation of a parser function
	 */
	static public function parseTag( $input, $args, $parser ) {
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
				$source = new ImageServing(
					null,
					200
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

        if ( !empty( $args[ TOPLIST_ATTRIBUTE_DESCRIPTION ] ) ) {
            self::$mAttributes[ TOPLIST_ATTRIBUTE_DESCRIPTION ] = $args[ TOPLIST_ATTRIBUTE_DESCRIPTION ];
        }

		if( !empty( self::$mList ) ) {
			$list = self::$mList;
			self::$mList = null;
		} else {
			$list = TopList::newFromTitle( $parser->mTitle );
		}

		if ( !empty( $list ) ) {
			$template = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
                        
				if ( $relatedTitle instanceof Title ) {
					$relatedTitleData = array(
						'localURL' => $relatedTitle->getLocalURL(),
						'text'     => $relatedTitle->getText()
					);
				} else {
					$relatedTitleData = null;
				}
                        
			$template->set_vars(
				array(
					'list' => $list,
					'listTitle' => $list->getTitle()->getText(),
					'relatedTitleData' => $relatedTitleData,
					'relatedImage' => $relatedImage,
					'attribs' => self::$mAttributes,
					'relatedUrl' => $relatedUrl
				)
			);

			self::$mOutput = $template->render( 'list' );

			// remove whitespaces to avoid extra <p> tags
			self::$mOutput = preg_replace("#[\n\t]+#", '', self::$mOutput);
		}
		else {
			self::$mOutput = '';
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
		self::$mList = $list;
		$text = F::app()->wg->Out->parse( $list->getArticle()->getContent() );
		$list->invalidateCache();

		return $text;
	}
}
