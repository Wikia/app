<?php
/**
 * Script to export special page aliases of extensions.
 *
 * @author Niklas Laxstrom
 *
 * @copyright Copyright © 2008-2009, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

$optionsWithArgs = array( 'target', 'type' );
require( dirname( __FILE__ ) . '/cli.inc' );

function showUsage() {
	STDERR( <<<EOT
Magic exporter.

Usage: php magic-export.php [options...]

Options:
  --target      Target directory for exported files
  --type        magic or special
EOT
);
	exit( 1 );
}

if ( isset( $options['help'] ) || $args === 1 ) {
	showUsage();
}

if ( !isset( $options['target'] ) ) {
	STDERR( "You need to specify target directory" );
	exit( 1 );
}

if ( !is_writable( $options['target'] ) ) {
	STDERR( "Target directory is not writable" );
	exit( 1 );
}

if ( !isset( $options['type'] ) ) {
	STDERR( "Type must be one of the following: special magic" );
	exit( 1 );
}


$langs = Cli::parseLanguageCodes( '*' );
$groups = MessageGroups::singleton()->getGroups();

$type = $options['type'] ;

foreach ( $groups as $group ) {
	if ( !$group instanceof ExtensionMessageGroup ) continue;

	if ( $type === 'special' ) {
		$filename = $group->getAliasFile();
	} else {
		$filename = $group->getMagicFile();
	}

	if ( $filename === null ) continue;

	$file = "$wgTranslateExtensionDirectory/$filename";
	if ( !file_exists( $file ) ) continue;
	STDOUT( "Processing {$group->getLabel()}... ", $group->getId() );

	$input = file_get_contents( $file ) . "\n";

	$headerEnd = strpos( $input, "\n);\n" );

	$output = substr( $input, 0, $headerEnd + 3 )  . "\n\n";

	foreach ( $langs as $l ) {
		switch ( $options['type'] ) {
		case 'special':
			$o = new SpecialPageAliasesCM( $l );
			break;
		case 'magic':
			$o = new MagicWordsCM( $l );
			break;
		default:
			STDERR( "Invalid type: must be one of: special, magic" );
			exit( 1 );
		}

		$export = $o->export( $group->getId() );
		if ( $export === '' ) continue;

		# remove useles comment
		$export = preg_replace( "~^# .*$\n~m", '', $export );

		$output .= $export;

		STDOUT( "$l ", $group->getId() );
	}

	wfMkdirParents( dirname( $options['target'] . "/$filename" ) );
	file_put_contents( $options['target'] . "/$filename", trim( $output ) . "\n" );
}
