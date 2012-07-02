<?php

/**
 *
 * @file SWB_Infolink
 * @ingroup SWB
 * @author Anna Kantorovitch and Benedikt Kämpgen
 *
 */
class SWBInfolink extends SMWInfolink {

	public function __construct( $internal, $caption, $target, $style = false, array $params = array() ) {
		parent::__construct( $internal, $caption, $target, $style, $params );
	}

	public static function newBrowsingLink( $caption, $titleText, $style = 'smwbrowse' ) {
		global $wgContLang;

		return new SWBInfolink(
			true,
			$caption,
			$wgContLang->getNsText( NS_SPECIAL ) . ':BrowseWiki',
			$style,
			array( $titleText )
		);
	}


}


