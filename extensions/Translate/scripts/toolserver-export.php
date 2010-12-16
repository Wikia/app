<?php
/**
 * Script to export messages for toolserver projects
 *
 * @author Niklas Laxstrom
 *
 * @copyright Copyright © 2009, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

$optionsWithArgs = array( 'target' );
require( dirname( __FILE__ ) . '/cli.inc' );

if ( isset( $options['target'] ) ) {
	$targetf = $options['target'];
} else {
	$targetf = 'toolserver-export.tsv';
}

$index = unserialize( file_get_contents( TRANSLATE_INDEXFILE ) );

# This obviously doesn't work with external storage etc
$dbr = wfGetDB( DB_SLAVE );
$tables = array( 'page', 'revision', 'text' );
$vars = array( 'page_namespace', 'page_title', 'old_text', 'old_flags' );
$conds = array(
	'page_latest = rev_id',
	'rev_text_id = old_id',
	'page_namespace' => NS_MEDIAWIKI
);

STDOUT( "Running query... ", 1 );
$res = $dbr->select( $tables, $vars, $conds, __FILE__ );

$target = fopen( $targetf, 'w+b' );

STDOUT( "Processing...", 1 );
foreach ( $res as $r ) {
	if ( $r->old_flags !== 'utf-8' ) {
		STDERR( "Oops, no text for {$r->page_title} in {$r->page_namespace}" );
		continue;
	}

	list( $key, $code ) = TranslateUtils::figureMessage( $r->page_title );
	if ( $key === '' ) continue;
	if ( $code === '' ) continue;

	$group = @$index[strtolower( "{$r->page_namespace}:$key" )];
	if ( $group === null ) continue;

	$from = array( "\\",   "\n",   "\t"   );
	$to =   array( "\\\\", "\\\n", "\\\t" );

	fwrite( $target,
		str_replace( $from, $to, $key         ) . "\t" . // Name
		str_replace( $from, $to, $r->old_text ) . "\t" . // Contents
		str_replace( $from, $to, $code        ) . "\t" . // Code
		str_replace( $from, $to, $group       ) . "\n" . // Component
	'' );
}

fclose( $target );
