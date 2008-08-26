<?php

/**
 * Click Extension
 *
 * Adds a parser function to display an image with a link that leads to a page other than the image description page.
 *
 * @addtogroup Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:Click
 *
 * @author MinuteElectron <minuteelectron@googlemail.com>
 * @copyright Copyright © 2008 MinuteElectron and Danny B.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

// If this is run directly from the web die as this is not a valid entry point.
if( !defined( 'MEDIAWIKI' ) ) die;

// Extension credits.
$wgExtensionCredits[ 'parserhook' ][] = array(
	'name'        => 'Click',
	'description' => 'Adds a parser function to display an image with a link that leads to a page other than the image description page.',
	'author'      => array( 'MinuteElectron', 'Danny B.' ),
	'url'         => 'http://www.mediawiki.org/wiki/Extension:Click',
	'version'     => '1.4',
);

// Setup function.
$wgExtensionFunctions[] = 'efClickParserFunction_Setup';

// Register hook.
$wgHooks[ 'LanguageGetMagic' ][] = 'efClickParserFunction_Magic';

function efClickParserFunction_Setup() {
	global $wgParser;
	// Register parser function hook.
	$wgParser->setFunctionHook( 'click', 'efClickParserFunction_Render' );
	// Return true so things don't break.
	return true;
}

function efClickParserFunction_Magic( &$magicWords, $langCode ) {
	// Register parser function magic word.
	$magicWords[ 'click' ] = array( 0, 'click' );
	// Return true so things don't break.
	return true;
}

function efClickParserFunction_Render( &$parser, $target = '', $image = '', $widthalt = '', $altwidth = '' ) {

	// Width and alt-text are interchangable.
	// No need to escape here, automatically done by Xml class functions.
	if( preg_match( '#^[0-9]+px$#', $widthalt ) ) {
		// First value width, second alt.
		$width = $widthalt;
		$alt = $altwidth;
	} elseif( preg_match( '#^[0-9]+px$#', $altwidth ) ) {
		// First value alt, second width.
		$alt = $widthalt;
		$width = $altwidth;
	} else {
		// First value alt, no width.
		$alt = $widthalt;
		$width = false;
	}

	// Open hyperlink, default to a on-wiki page, but if it doesn't exist and
	// is a valid external URL then use it.
	$targettitle = Title::newFromText( $target );
	// Link title attribute (full page name).
	if( $targettitle->getNamespace() !== 0 ) {
		$title = $targettitle->getNsText() . ':' . $targettitle->getText();
	} else {
		$title = $targettitle->getText();
	}
	if( is_object( $targettitle ) && $targettitle->exists() ) {
		// Internal link, open hyperlink and register internal link.
		$r = Xml::openElement( 'a', array( 'href' => $targettitle->getLocalUrl(), 'title' => $title ) );
		$parser->mOutput->addLink( $targettitle );
	} else {
		// Internal page doesn't exist, test if external.
		global $wgUrlProtocols;
		$ext = false;
		foreach( $wgUrlProtocols as $protocol ) {
			if( strpos( $target, $protocol ) === 0 ) {
				$ext = true;
				break;
			}
		}
		if( $ext ) {
			// External link, open hyperlink with escaped href and register external link.
			$r = Xml::openElement( 'a', array( 'href' => $target, 'title' => $target ) );
			$parser->mOutput->addExternalLink( $target );
		} elseif( is_object( $targettitle ) ) {
				// Valid internal link after all (but to non-existant page), open hyperlink and register internal link.
				$r = Xml::openElement( 'a', array( 'class' => 'new', 'href' => $targettitle->getLocalUrl( 'action=edit&redlink=1' ), 'title' => wfMsg( 'red-link-title', $title ) ) );
				$parser->mOutput->addLink( $targettitle );
		}
	}

	// Add image element, or use alt text on it's own if image doesn't exist.
	$imagetitle = Title::newFromText( $image );
	if( is_object( $imagetitle ) ) $imageimage = Image::newFromTitle( $imagetitle );
	if( isset( $imageimage ) && is_object( $imagetitle ) && is_object( $imageimage ) && $imageimage->exists() ) {
		// Display image.
		if( !$width ) $width = $imageimage->getWidth();
		$thumbnail = $imageimage->transform( array( 'width' => $width ) );
		$r .= $thumbnail->toHtml( array( 'alt' => $alt, 'file-link' => false, 'valign' => 'bottom' ) );
	} else {
		// Display alt text.
		$r .= $alt;
	}
	// Register image usage if it is a valid name, even if it doesn't exist (so it appears as a "wanted image").
	if( isset( $imageimage ) && is_object( $imagetitle ) && is_object( $imageimage ) ) {
			$parser->mOutput->addImage( $imagetitle->getDBkey() );
	}

	// Close hyperlink.
	if( is_object( $targettitle ) ) $r .= Xml::closeElement( 'a' );

	// Can't just output as HTML, need to do this to make a new paragraph.
	return $parser->insertStripItem( $r, $parser->mStripState );

}
