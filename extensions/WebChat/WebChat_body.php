<?php

/**
 * WebChat extension special page class.
 */

class WebChat extends SpecialPage {

	function __construct() {
		SpecialPage::SpecialPage( 'WebChat', 'webchat' );
	}

	function execute( $par ) {
		global $wgOut, $wgUser, $wgWebChatServer, $wgWebChatChannel,
			$wgWebChatClient, $wgWebChatClients;
		wfLoadExtensionMessages( 'WebChat' );
		$this->setHeaders();
		$wgOut->addWikiMsg( 'webchat-header' );

		if ( !array_key_exists( $wgWebChatClient, $wgWebChatClients ) ) {
			throw new MwException( 'Unknown web chat client specified.' );
		}

		foreach ( $wgWebChatClients[$wgWebChatClient]['parameters'] as $parameter => $value ) {
			switch ( $value ) {
				case '$$$nick$$$':
					if ( $wgUser->isLoggedIn() ) $value = str_replace( ' ', '_', $wgUser->getName() );
					break;
				case '$$$channel$$$':
					$value = $wgWebChatChannel;
					break;
				case '$$$server$$$':
					$value = $wgWebChatServer;
					break;
			}
			$query[] = $parameter . '=' . urlencode( $value );
		}
		$query = implode( $query, '&' );

		$wgOut->addHTML( Xml::openElement( 'iframe', array(
			'width'     => '600',
			'height'    => '500',
			'scrolling' => 'no',
			'border'    => '0',
			'onLoad'    => 'webChatExpand( this )',
			'src'       => $wgWebChatClients[$wgWebChatClient]['url'] . '?' . $query
		) ) . Xml::closeElement( 'iframe' ) );

		// Hack to make the chat area a reasonable size.
		$wgOut->addHTML( Xml::tags( 'script',
			array( 'type' => 'text/javascript' ),
'/* <![CDATA[ */
function webChatExpand( elem ) {
	height = elem.height;
	width  = elem.width;
	elem.height = screen.height - 500;
	elem.width  = screen.width  - 250;
}
/* ]]> */'
			) );

	}

}
