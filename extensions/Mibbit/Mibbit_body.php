<?php

/**
 * Mibbit extension special page class.
 */

class Mibbit extends SpecialPage {

	function __construct() {
		SpecialPage::SpecialPage( 'Mibbit', 'mibbit' );
	}

	function execute( $par ) {
		global $wgOut, $wgUser;
		global $wgMibbitServer, $wgMibbitChannel, $wgMibbitExtraParameters;

		// Preperation.
		wfLoadExtensionMessages( 'Mibbit' );
		$this->setHeaders();

		// Introduction message, explaining to users what this is etc.
		$wgOut->addWikiMsg( 'mibbit-header' );

		// Prepare query string to pass to widget.
		$queryAssoc = array(
			'server'  => $wgMibbitServer,
			'channel' => $wgMibbitChannel
		);
		if ( $wgUser->isLoggedIn() ) $queryAssoc[ 'nick' ] = str_replace( ' ', '_', $wgUser->getName() );
		if ( $wgMibbitExtraParameters ) {
			$queryAssoc = array_merge( $queryAssoc, $wgMibbitExtraParameters );
		}
		foreach ( $queryAssoc as $parameter => $value ) {
			$query[] = $parameter . '=' . urlencode( $value );
		}
		$queryString = implode( $query, '&' );

		// Output widget.
		$wgOut->addHTML( Xml::openElement( 'iframe', array(
			'width'     => '600',
			'height'    => '500',
			'scrolling' => 'no',
			'border'    => '0',
			'onLoad'    => 'mibbitExpand( this )',
			'src'       => 'http://embed.mibbit.com/index.html?' . $queryString
		) ) . Xml::closeElement( 'iframe' ) );

		// Hack to make the chat area a reasonable size.
		$wgOut->addHTML( Xml::tags( 'script',
			array( 'type' => 'text/javascript' ),
'/* <![CDATA[ */
function mibbitExpand( elem ) {
	height = elem.height;
	width  = elem.width;
	elem.height = screen.height - 500;
	elem.width  = screen.width  - 250;
}
/* ]]> */'
			) );
	}

}
