<?php
/**
 * Special:Gadgets, provides a preview of MediaWiki:Gadgets.
 *
 * @addtogroup SpecialPage
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @license GNU General Public License 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "not a valid entry point.\n" );
	die( 1 );
}

/**
 *
 */
class SpecialGadgets extends SpecialPage {

	/**
	 * Constructor
	 */
	function __construct() {
		SpecialPage::SpecialPage( 'Gadgets', '', true );
	}

	/**
	 * Main execution function
	 * @param $par Parameters passed to the page
	 */
	function execute( $par ) {
		global $wgOut, $wgUser;

		wfLoadExtensionMessages( 'Gadgets' );
		$skin = $wgUser->getSkin();

		$this->setHeaders();
		$wgOut->setPagetitle( wfMsg( "gadgets-title" ) );
		$wgOut->addWikiText( wfMsg( "gadgets-pagetext" ) );

		$gadgets = wfLoadGadgetsStructured();
		if ( !$gadgets ) return;

		$listOpen = false;

		$msgOpt = array( 'parseinline', 'parsemag' );

		foreach ( $gadgets as $section => $entries ) {
			if ( $section !== false && $section !== '' ) {
				$t = Title::makeTitleSafe( NS_MEDIAWIKI, "Gadget-section-$section" );
				$lnk = $t ? $skin->makeLinkObj( $t, wfMsgHTML("edit"), 'action=edit' ) : htmlspecialchars($section);
				$ttext = wfMsgExt( "gadget-section-$section", $msgOpt );

				if( $listOpen ) {
					$wgOut->addHTML( '</ul>' );
					$listOpen = false;
				}
				$wgOut->addHTML( "\n<h2>$ttext &nbsp; &nbsp; [$lnk]</h2>\n" );
			}

			foreach ( $entries as $gname => $code ) {
				$t = Title::makeTitleSafe( NS_MEDIAWIKI, "Gadget-$gname" );
				if ( !$t ) continue;

				$lnk = $skin->makeLinkObj( $t, wfMsgHTML("edit"), 'action=edit' );
				$ttext = wfMsgExt( "gadget-$gname", $msgOpt );

				if( !$listOpen ) {
					$listOpen = true;
					$wgOut->addHTML( '<ul>' );
				}
				$wgOut->addHTML( "<li>" );
				$wgOut->addHTML( "$ttext &nbsp; &nbsp; [$lnk]<br />" );

				$wgOut->addHTML( wfMsgHTML("gadgets-uses") . ": " );

				$first = true;
				foreach ( $code as $codePage ) {
					$t = Title::makeTitleSafe( NS_MEDIAWIKI, "Gadget-$codePage" );
					if ( !$t ) continue;

					if ( $first ) $first = false;
					else $wgOut->addHTML(", ");

					$lnk = $skin->makeLinkObj( $t, htmlspecialchars( $t->getText() ) );
					$wgOut->addHTML($lnk);
				}

				$wgOut->addHtml( "</li>" );
			}
		}

		if( $listOpen ) {
			$wgOut->addHTML( '</ul>' );
		}
	}
}
