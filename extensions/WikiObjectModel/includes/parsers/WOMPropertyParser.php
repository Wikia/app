<?php
/**
 * @author Ning
 *
 * @file
 * @ingroup WikiObjectModels
 */

// little tricky here, just inherit from link parser
class WOMPropertyParser extends WOMLinkParser {

	public function __construct() {
		parent::__construct();
		$this->m_parserId = WOM_PARSER_ID_PROPERTY;
	}

	public function parseNext( $text, WikiObjectModelCollection $parentObj, $offset = 0 ) {
		if ( !defined( 'SMW_VERSION' ) ) {
			return null;
		}

		$text = substr( $text, $offset );

		// copied from SemanticMediaWiki, includes/SMW_ParserExtensions.php
		// not deal with <nowiki>, could be bug here. SMW has the same bug
		// E.g., [[text::this <nowiki> is ]] </nowiki> not good]]
//		global $smwgLinksInValues;
//		if ( $smwgLinksInValues ) { // More complex regexp -- lib PCRE may cause segfaults if text is long :-(
			$semanticLinkPattern = '/^\[\[                 # Beginning of the link
			                        (?:([^:][^]]*):[=:])+ # Property name (or a list of those)
			                        (                     # After that:
			                          (?:[^|\[\]]         #   either normal text (without |, [ or ])
			                          |\[\[[^]]*\]\]      #   or a [[link]]
			                          |\[[^]]*\]          #   or an [external link]
			                        )*)                   # all this zero or more times
			                        (?:\|([^]]*))?        # Display text (like "text" in [[link|text]]), optional
			                        \]\]                  # End of link
			                        /xu';
//		} else { // Simpler regexps -- no segfaults found for those, but no links in values.
//			$semanticLinkPattern = '/\[\[                 # Beginning of the link
//			                        (?:([^:][^]]*):[=:])+ # Property name (or a list of those)
//			                        ([^\[\]]*)            # content: anything but [, |, ]
//			                        \]\]                  # End of link
//			                        /xu';
//		}
		$r = preg_match( $semanticLinkPattern, $text, $m );
		if ( $r ) {
			$inQuerystring = false;
			$o = $parentObj;
			do {
				if ( $o instanceof WOMQuerystringModel ) {
					$inQuerystring = true;
					break;
				}
				$o = $o->getParent();
			} while ( $o != null );

			if ( $inQuerystring ) {
				$semanticPropPattern = '/\[\[                 # Beginning of the link
				                        (?:([^:][^][]*):[=:])+ # Property name (or a list of those)
				                        /xu';
				preg_match( $semanticPropPattern, $text, $m );
				return array( 'len' => strlen( $m[0] ), 'obj' => new WOMNestPropertyModel( $m[1] ) );
			}

			return array( 'len' => strlen( $m[0] ), 'obj' => new WOMPropertyModel( $m[1], $m[2], isset( $m[3] ) ? $m[3] : '' ) );
		}
		return null;
	}

	public function getSubParserID( $obj ) {
		return WOM_PARSER_ID_PROPERTY_VALUE;
	}

	public function isObjectClosed( $obj, $text, $offset ) {
		if ( !$obj instanceof WOMNestPropertyModel ) return false;

		if ( ( strlen( $text ) >= $offset + 2 )
			&& $text { $offset } == ']'
			&& $text { $offset + 1 } == ']' ) {
				return 2;
		}

		return false;
	}
}
