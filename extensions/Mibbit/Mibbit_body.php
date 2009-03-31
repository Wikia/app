<?php

/**
 * Mibbit extension special page class.
 */

class Mibbit extends SpecialPage {

	function __construct() {
		global $wgMibbitAllowAnonymous;

		if( $wgMibbitAllowAnonymous ) {
			SpecialPage::SpecialPage( 'Mibbit' );
		} else {
			SpecialPage::SpecialPage( 'Mibbit', 'mibbit' );
		}
	}

	function execute( $par ) {
		global $wgOut, $wgUser;
		global $wgMibbitServer, $wgMibbitChannel, $wgMibbitExtraParameters;

		wfLoadExtensionMessages( 'Mibbit' );

		$this->setHeaders();

		$wgOut->addHTML( Xml::element( 'p', null, wfMsg( 'mibbit-header' ) ) );

		if( $wgUser->isLoggedIn() ) {
			$nick = $wgUser->getName();
		} else {
			$nick = '';
		}

		$queryAssoc = array(
			'server'       => $wgMibbitServer,
			'channel'      => $wgMibbitChannel,
			'nick'         => $nick,
		);

		if( $wgMibbitExtraParameters ) {
			$queryAssoc = array_merge( $queryAssoc, $wgMibbitExtraParameters );
		}

		foreach( $queryAssoc as $parameter => $value ) {
			$query[] = $parameter . '=' . urlencode( $value );
		}

		$queryString = implode( $query, '&' );

		$wgOut->addHTML(
			Xml::openElement(
				'iframe',
				array(
					'width'     => '600',
					'height'    => '500',
					'scrolling' => 'no',
					'border'    => '0',
					'onLoad'    => 'mibbitExpand(this)',
					'src'       =>
						'http://embed.mibbit.com/index.html?' . $queryString,
				)
			)
			.
			Xml::closeElement( 'iframe' )
		);

		// This bit sucks, maybe improve it a little.
		$wgOut->addHTML(
			Xml::tags(
				'script',
				array(
					'type' => 'text/javascript',
				),
'/* <![CDATA[ */
function mibbitExpand(elem)
{
	height=elem.height;
	elem.height=screen.height-300;
	width=elem.width;
	elem.width=screen.width-250;
}
/* ]]> */'
			)
		);
	}

}
