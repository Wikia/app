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
		global $wgOut, $wgUser, $wgLang, $wgContLang;

		wfLoadExtensionMessages( 'Gadgets' );
		$skin = $wgUser->getSkin();

		$this->setHeaders();
		$wgOut->setPagetitle( wfMsg( "gadgets-title" ) );
		$wgOut->addWikiText( wfMsg( "gadgets-pagetext" ) );

		$gadgets = wfLoadGadgetsStructured();
		if ( !$gadgets ) return;

		$lang = "";
		if ( $wgLang->getCode() != $wgContLang->getCode() ) {
			$lang = "/" . $wgLang->getCode();
		}

		$listOpen = false;

		$msgOpt = array( 'parseinline', 'parsemag' );
		$editInterfaceAllowed = $wgUser->isAllowed( 'editinterface' ) ? true : false ;
			
		foreach ( $gadgets as $section => $entries ) {
			if ( $section !== false && $section !== '' ) {
				$t = Title::makeTitleSafe( NS_MEDIAWIKI, "Gadget-section-$section$lang" );
				if ( $editInterfaceAllowed ) {
					$lnkTarget = $t
						? $skin->link( $t, wfMsgHTML( 'edit' ), array(), array( 'action' => 'edit' ) ) 
						: htmlspecialchars( $section );
					$lnk =  "&nbsp; &nbsp; [$lnkTarget]";
				} else {
					$lnk = '';
				}
				$ttext = wfMsgExt( "gadget-section-$section", $msgOpt );

				if( $listOpen ) {
					$wgOut->addHTML( Xml::closeElement( 'ul' ) . "\n" );
					$listOpen = false;
				}
				$wgOut->addHTML( Html::rawElement( 'h2', array(), $ttext . $lnk ) . "\n" );
			}

			foreach ( $entries as $gname => $code ) {
				$t = Title::makeTitleSafe( NS_MEDIAWIKI, "Gadget-$gname$lang" );
				if ( !$t ) continue;

				if ( $editInterfaceAllowed ) {
					$lnkTarget = $skin->link( $t, wfMsgHTML( 'edit' ), array(), array( 'action' => 'edit' ) );
					$lnk =  "&nbsp; &nbsp; [$lnkTarget]";
				} else {
					$lnk = '';
				}
				$ttext = wfMsgExt( "gadget-$gname", $msgOpt );

				if( !$listOpen ) {
					$listOpen = true;
					$wgOut->addHTML( Xml::openElement( 'ul' ) );
				}
				$wgOut->addHTML( Xml::openElement( 'li' ) .
						$ttext . $lnk . "<br />" .
						wfMsgHTML( 'gadgets-uses' ) . wfMsg( 'colon-separator' )
				);

				$lnk = array();
				foreach ( $code as $codePage ) {
					$t = Title::makeTitleSafe( NS_MEDIAWIKI, "Gadget-$codePage" );
					if ( !$t ) continue;

					$lnk[] = $skin->link( $t, htmlspecialchars( $t->getText() ) );
				}
				$wgOut->addHTML( $wgLang->commaList( $lnk ) );
				$wgOut->addHTML( Xml::closeElement( 'li' ) . "\n" );
			}
		}

		if( $listOpen ) {
			$wgOut->addHTML( Xml::closeElement( 'ul' ) . "\n" );
		}
	}
}
