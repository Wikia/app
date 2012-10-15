<?php

class APCUtils {
	public static function tableRow( $class, $first, $second = null ) {
		$class = $class !== null ? array( 'class' => 'mw-apc-tr-' . $class ) : null;

		return Xml::tags( 'tr', $class,
			Xml::tags( 'td', array( 'class' => 'mw-apc-td-0' ), $first ) .
			Xml::tags( 'td', null, $second ) );
	}

	public static function tableHeader( $header, $class = '' ) {
		return
			Xml::openElement( 'div', array( 'class' => "mw-apc-stats $class" ) ) .
			Xml::element( 'h2', null, $header ) .
			Xml::openElement( 'table' ) .
			Xml::openElement( 'tbody' );
	}

	public static function tableFooter() {
		return "</tbody></table></div>";
	}

	public static function formatReqPerS( $number ) {
		global $wgLang;
		return wfMsgExt( 'viewapc-rps', 'parsemag',
			$wgLang->formatNum( sprintf( "%.2f", $number ) ) );
	}
}
