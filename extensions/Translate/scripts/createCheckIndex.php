<?php
/**
 * Creates serialised database of messages that need checking for problems.
 *
 * @author Niklas Laxstrom
 *
 * @copyright Copyright © 2008, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

$optionsWithArgs = array( 'groups' );
require( dirname( __FILE__ ) . '/cli.inc' );

$codes = Language::getLanguageNames( false );

// Exclude this special language
if ( $wgTranslateDocumentationLanguageCode )
	unset( $codes[$wgTranslateDocumentationLanguageCode] );

// Skip source
unset( $codes['en'] );

$codes = array_keys( $codes );
sort( $codes );

if ( isset( $options['groups'] ) ) {
	$reqGroups = array_map( 'trim', explode( ',', $options['groups'] ) );
} else {
	$reqGroups = false;
}

$verbose = isset( $options['verbose'] );

$groups = MessageGroups::singleton()->getGroups();

foreach ( $groups as $g ) {
	
	$id = $g->getId();

	// Skip groups that are not requested
	if ( $reqGroups && !in_array( $id, $reqGroups ) ) {
		unset( $g );
		continue;
	}

	$checker = $g->getChecker();
	if ( !$checker ) {
		unset( $g );
		continue;
	}

	// Initialise messages, using unique definitions if appropriate
	$collection = $g->initCollection( 'en', true );
	if ( !count( $collection ) ) continue;

	STDOUT( "Working with $id: ", $id );

	foreach ( $codes as $code ) {
		STDOUT( "$code ", $id );

		$problematic = array();

		$collection->resetForNewLanguage( $code );
		$collection->loadTranslations();

		foreach ( $collection as $key => $message ) {
			$prob = $checker->checkMessageFast( $message,  $code );
			if ( $prob ) {

				if ( $verbose ) {
					// Print it
					$nsText = $wgContLang->getNsText( $g->namespaces[0] );
					STDOUT( "# [[$nsText:$key/$code]]" );
				}

				// Add it to the array
				$problematic[] = array( $g->namespaces[0], "$key/$code" );
			}
		}

		tagFuzzy( $problematic );
	}
}

function tagFuzzy( $problematic ) {
	if ( !count( $problematic ) ) {
		return;
	}

	$db = wfGetDB( DB_MASTER );
	$id = $db->selectField( 'revtag_type', 'rtt_id', array( 'rtt_name' => 'fuzzy' ), __METHOD__ );
	foreach ( $problematic as $p ) {
		$title = Title::makeTitleSafe( $p[0], $p[1] );
		$titleText = $title->getDBKey();
		$res = $db->select( 'page', array( 'page_id', 'page_latest' ),
			array( 'page_namespace' => $p[0], 'page_title' => $titleText ), __METHOD__ );
		
		$inserts = array();
		foreach ( $res as $r ) {
			$inserts = array(
				'rt_page' => $r->page_id,
				'rt_revision' => $r->page_latest,
				'rt_type' => $id
			);
		}
		$db->replace( 'revtag', 'rt_type_page_revision', $inserts, __METHOD__ );
	}
}

