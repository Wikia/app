<?php

/**
* Freenode Chat extension special page class.
*/

class FreenodeChat extends SpecialPage {

	function __construct() {
		SpecialPage::SpecialPage( 'FreenodeChat', 'freenodechat' );
	}

	function execute( $par ) {
		global $wgOut, $wgUser;
		global $wgFreenodeChatChannel, $wgFreenodeChatExtraParameters;

		// Preperation.
		wfLoadExtensionMessages( 'FreenodeChat' );
		$this->setHeaders();

		// Introduction message, explaining to users what this is etc.
		$wgOut->addWikiMsg( 'freenodechat-header' );

		// Prepare query string to pass to widget.
		$queryAssoc = array( 'channels' => $wgFreenodeChatChannel );
		if ( $wgUser->IsLoggedIn() ) $queryAssoc[ 'nick' ] = str_replace( ' ', '_', $wgUser->getName() );
		if ( $wgFreenodeChatExtraParameters ) {
			$queryAssoc = array_merge( $queryAssoc, $wgFreenodeChatExtraParameters );
		}
		foreach ( $queryAssoc as $parameter => $value ) {
			$query[] = $parameter . '=' . urlencode( $value );
		}
		$queryString = implode( '&', $query );

		// Output widget.
		$wgOut->addHTML( Xml::openElement( 'iframe', array(
			'width'     => '1000',
			'height'    => '500',
			'scrolling' => 'no',
			'border'    => '0',
			'onLoad'    => 'freenodeChatExpand( this )',
			'src'       => 'http://webchat.freenode.net/?' . $queryString
		) ) . Xml::closeElement( 'iframe' ) );

		// Hack to make the chat area a reasonable size.
		$wgOut->addHTML( Xml::tags( 'script',
			array( 'type' => 'text/javascript' ),
'/* <![CDATA[ */
function freenodeChatExpand( elem ) {
	height = elem.height;
	width  = elem.width;
	elem.height = screen.height - 500;
	elem.width  = screen.width  - 250;
}
/* ]]> */'
			) );

	}
}
