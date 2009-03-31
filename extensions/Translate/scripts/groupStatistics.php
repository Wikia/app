<?php
/**
 * Statistics about message groups.
 *
 * @author Niklas Laxstrom
 *
 * @copyright Copyright © 2007-2008, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

$optionsWithArgs = array( 'groups', 'output', 'skiplanguages', );
require( dirname( __FILE__ ) . '/cli.inc' );

class TranslateStatsOutput extends WikiStatsOutput {
	function heading() {
		echo '{| class="sortable wikitable" border="2" cellpadding="4" cellspacing="0" style="background-color: #F9F9F9; border: 1px #AAAAAA solid; border-collapse: collapse; clear:both;" width="100%"' . "\n";
	}
}

if ( isset( $options['help'] ) ) showUsage();
if ( !isset( $options['groups'] ) ) showUsage();
if ( !isset( $options['output'] ) ) $options['output'] = 'default';

/** Print a usage message*/
function showUsage() {
	$msg = <<<END
	--help : this help message
	--groups LIST: comma separated list of groups
	--skiplanguages LIST: comma separated list of languages that should be skipped
	--skipzero : skip languages that do not have any localisation at all
	--fuzzy : add column for fuzzy counts
	--output TYPE: select an another output engine
		* 'csv'      : Comma Separated Values.
		* 'wiki'     : MediaWiki syntax.
		* 'metawiki' : MediaWiki syntax used for Meta-Wiki.
		* 'text'     : Text with tabs.

END;
	STDERR( $msg );
	exit( 1 );
}

# Select an output engine
switch ( $options['output'] ) {
	case 'wiki':
		$out = new wikiStatsOutput();
		break;
	case 'metawiki':
		$out = new metawikiStatsOutput();
		break;
	case 'text':
		$out = new textStatsOutput();
		break;
	case 'csv':
		$out = new csvStatsOutput();
		break;
	case 'default':
		$out = new TranslateStatsOutput();
		break;
	default:
		showUsage();
}

$skipLanguages = array();
if ( isset( $options['skiplanguages'] ) ) {
	$skipLanguages = array_map( 'trim', explode( ',', $options['skiplanguages'] ) );
}

// Get groups from input
$groups = array();
$reqGroups = array_map( 'trim', explode( ',', $options['groups'] ) );

// List of all groups
$allGroups = MessageGroups::singleton()->getGroups();

// Get list of valid groups
foreach ( $reqGroups as $id ) {
	if ( isset( $allGroups[$id] ) ) {
		$groups[$id] = $allGroups[$id];
	} else {
		STDERR( "Unknown group: $id" );
	}
}

if ( !count( $groups ) ) showUsage();

// List of all languages.
$languages = Language::getLanguageNames( false );
// Default sorting order by language code, users can sort wiki output by any
// column, if it is supported.
ksort( $languages );

// Output headers
$out->heading();
$out->blockstart();
$out->element( 'Code', true );
$out->element( 'Language', true );
foreach ( $groups as $g ) {
	// Add unprocessed description of group as heading
	$out->element( $g->getLabel(), true );
	if ( isset( $options['fuzzy'] ) ) {
		$out->element( 'Fuzzy', true );
	}
}
$out->blockend();

// Perform the statistic calculations on every language
foreach ( $languages as $code => $name ) {
	// Skip list
	if ( in_array( $code, $skipLanguages ) ) continue;

	// Tracker for skipping languages with no localisation
	$allZero = true;
	$columns = array();

	foreach ( $groups as $g ) {
		// Initialise messages
		$collection = $g->initCollection( $code );
		$collection->filter( 'optional' );
		// Store the count of real messages for later calculation.
		$total = count( $collection );

		// Fill translations in for counting
		$g->fillCollection( $collection );

		// Count fuzzy first
		$collection->filter( 'fuzzy' );
		$fuzzy = $total - count( $collection );

		// Count the completion percent
		$collection->filter( 'translated', false );
		$translated = count( $collection );
		if ( $translated ) $allZero = false;

		$columns[] = $out->formatPercent( $translated, $total,
			/* Inverted color */ false, /* Decimals */ 2 );

		if ( isset( $options['fuzzy'] ) ) {
			$columns[] = $out->formatPercent( $fuzzy, $total,
				/* Inverted color */ true, /* Decimals */ 2 );
		}
	}

	// Skip dummy languages if requested
	if ( $allZero && isset( $options['skipzero'] ) ) continue;

	// Output the the row
	$out->blockstart();
	$out->element( $code );
	$out->element( $name );
	foreach ( $columns as $c ) $out->element( $c );
	$out->blockend();
}

# Finally output footer
$out->footer();
