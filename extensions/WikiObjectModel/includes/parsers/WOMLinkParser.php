<?php
/**
 * @author Ning
 *
 * @file
 * @ingroup WikiObjectModels
 */

class WOMLinkParser extends WikiObjectModelParser {

	public function __construct() {
		parent::__construct();
		$this->m_parserId = WOM_PARSER_ID_LINK;
	}

	public function parseNext( $text, WikiObjectModelCollection $parentObj, $offset = 0 ) {
		$text = substr( $text, $offset );

		$r = preg_match( '/^\[\[([^\|\]]+)(\|([^\]]+))?\]\]/', $text, $m );
		if ( $r && !preg_match( '/^(?:' . wfUrlProtocols() . ')/', $m[1] ) ) {
			return array( 'len' => strlen( $m[0] ), 'obj' => new WOMLinkModel( $m[1], isset( $m[3] ) ? $m[3] : '' ) );
		}
		$r = preg_match( '/^\[((?:' . wfUrlProtocols() . ')[^ \]]+)(\s+([^\]]+))?\]/', $text, $m );
		if ( $r ) {
			return array( 'len' => strlen( $m[0] ), 'obj' => new WOMLinkModel( $m[1], isset( $m[3] ) ? $m[3] : '' ) );
		}
		// includes/Parser.php Parser->doMagicLinks
		$r = preg_match( '/^(?:' . wfUrlProtocols() . ')[^][<>"|}{\\x00-\\x20\\x7F]+/', $text, $m );
		if ( $r ) {
			return array( 'len' => strlen( $m[0] ), 'obj' => new WOMLinkModel( $m[0] ) );
		}

		return null;
	}
}
