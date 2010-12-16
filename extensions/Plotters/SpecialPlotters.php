<?php
/**
 * Special:Plotters, provides a preview of MediaWiki:Plotters. Based on the Gadgets extension.
 *
 * @addtogroup Extensions
 * @author Ryan Lane, rlane32+mwext@gmail.com
 * @copyright © 2009 Ryan Lane
 * @license GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "not a valid entry point.\n" );
	die( 1 );
}

/**
 *
 */
class SpecialPlotters extends SpecialPage {

	/**
	 * Constructor
	 */
	function __construct() {
		SpecialPage::SpecialPage( 'Plotters', '', true );
	}

	/**
	 * Main execution function
	 * @param $par Parameters passed to the page
	 */
	function execute( $par ) {
		global $wgOut, $wgUser;

		wfLoadExtensionMessages( 'Plotters' );
		$skin = $wgUser->getSkin();

		$this->setHeaders();
		$wgOut->setPagetitle( wfMsg( "plotters-title" ) );
		$wgOut->addWikiText( wfMsg( "plotters-pagetext" ) );

		$plotters = wfLoadPlottersStructured();
		if ( !$plotters ) return;

		$listOpen = false;

		$msgOpt = array( 'parseinline', 'parsemag' );

		foreach ( $plotters as $section => $entries ) {
			if ( $section !== false && $section !== '' ) {
				$t = Title::makeTitleSafe( NS_MEDIAWIKI, "Plotter-section-$section" );
				$lnk = $t ? $skin->makeLinkObj( $t, wfMsgHTML( "edit" ), 'action=edit' ) : htmlspecialchars( $section );
				$ttext = wfMsgExt( "plotter-section-$section", $msgOpt );

				if ( $listOpen ) {
					$wgOut->addHTML( '</ul>' );
					$listOpen = false;
				}
				$wgOut->addHTML( "\n<h2>$ttext &nbsp; &nbsp; [$lnk]</h2>\n" );
			}

			foreach ( $entries as $pname => $code ) {
				$t = Title::makeTitleSafe( NS_MEDIAWIKI, "Plotter-$pname" );
				if ( !$t ) continue;

				$lnk = $skin->makeLinkObj( $t, wfMsgHTML( "edit" ), 'action=edit' );
				$ttext = wfMsgExt( "plotter-$pname", $msgOpt );

				if ( !$listOpen ) {
					$listOpen = true;
					$wgOut->addHTML( '<ul>' );
				}
				$wgOut->addHTML( "<li>" );
				$wgOut->addHTML( "$ttext &nbsp; &nbsp; [$lnk]<br />" );

				$wgOut->addHTML( wfMsgHTML( "plotters-uses" ) . ": " );

				$first = true;
				foreach ( $code as $codePage ) {
					$t = Title::makeTitleSafe( NS_MEDIAWIKI, "Plotters-$codePage" );
					if ( !$t ) continue;

					if ( $first ) $first = false;
					else $wgOut->addHTML( ", " );

					$lnk = $skin->makeLinkObj( $t, htmlspecialchars( $t->getText() ) );
					$wgOut->addHTML( $lnk );
				}

				$wgOut->addHtml( "</li>" );
			}
		}

		if ( $listOpen ) {
			$wgOut->addHTML( '</ul>' );
		}
	}
}
