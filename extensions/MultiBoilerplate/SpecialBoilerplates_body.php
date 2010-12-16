<?php
/**
 * Special:boilerplates, provides a list of MediaWiki:Multiboilerplate or $wgMultiBoilerplateOptions.
 * This add-on use three new messages.
 * For more info see http://mediawiki.org/wiki/Extension:Multiboilerplate
 *
 * @subpackage Extensions
 * @author Al Maghi
 */

class SpecialBoilerplates extends IncludableSpecialPage {

	function __construct() {
		parent::SpecialPage( 'Boilerplates' );
		$this->mIncludable = true;
	}

	function execute( $par ) {
		global $wgOut, $wgMultiBoilerplateOptions;
		if ( !isset($wgMultiBoilerplateOptions)) return true; // No options found in either configuration file, abort.
		wfLoadExtensionMessages( 'MultiBoilerplate' );
		if( !$this->mIncluding ) {
			$this->setHeaders();
			$wgOut->addWikiMsg( "multiboilerplate-special-pagetext" );
		}
		if( is_array( $wgMultiBoilerplateOptions ) ) {
			if( !$this->mIncluding ) $wgOut->addWikiMsg( "multiboilerplate-special-define-in-localsettings" );
			foreach( $wgMultiBoilerplateOptions as $name => $template ) {
				$wgOut->addWikiText( "* [[$template]]\n" );
			}
		} else {
			if( !$this->mIncluding ) $wgOut->addWikiMsg( "multiboilerplate-special-define-in-interface" ) ;
			$things = explode( "\n", str_replace( "\r", "\n", str_replace( "\r\n", "\n", wfMsg( 'multiboilerplate' ) ) ) ); // Ensure line-endings are \n
			foreach( $things as $row ) {
				if ( substr( ltrim( $row ), 0, 1 ) === '*' ) {			
					$row = ltrim( $row, '* ' ); // Remove the asterix (and a space if found) from the start of the line.
					$row = explode( '|', $row );
					if( !isset( $row[ 1 ] ) ) return true; // Invalid syntax, abort.
					$wgOut->addWikiText( "* [[$row[1]|$row[0]]]\n" );
				}
			}
		}
	}
}

