<?php
/**
 * @author Ning
 *
 * @file
 * @ingroup WikiObjectModels
 */

class WOMCategoryParser extends WOMLinkParser {

	public function __construct() {
		parent::__construct();
		$this->m_parserId = WOM_PARSER_ID_CATEGORY;
	}

	public function parseNext( $text, WikiObjectModelCollection $parentObj, $offset = 0 ) {
		$text = substr( $text, $offset );
		global $wgContLang;
		$namespace = $wgContLang->getNsText( NS_CATEGORY );
		$r = preg_match( '/^\[\[' . $namespace . ':([^\]]+)\]\]/i', $text, $m );
		if ( $r ) {
			return array( 'len' => strlen( $m[0] ), 'obj' => new WOMCategoryModel( trim( $m[1] ) ) );
		}
		return null;
	}
}
