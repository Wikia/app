<?php
/**
 * Script to export special core features of %MediaWiki.
 *
 * @author Niklas Laxstrom
 * @copyright Copyright © 2009-2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

/// @cond

$optionsWithArgs = array( 'lang', 'target', 'type' );
require( dirname( __FILE__ ) . '/cli.inc' );

function showUsage() {
	STDERR( <<<EOT
Core special features exporter.

Usage: php mwcore-export.php [options...]

Options:
  --target      Target directory for exported files
  --lang        Comma separated list of language codes or *
  --type        namespace, special or magic
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

if ( !isset( $options['lang'] ) ) {
	STDERR( "You need to specify languages to export" );
	exit( 1 );
}

if ( !isset( $options['type'] ) ) {
	STDERR( "Type must be one of the following: special magic namespace" );
	exit( 1 );
}

if ( !is_writable( $options['target'] ) ) {
	STDERR( "Target directory is not writable" );
	exit( 1 );
}

$langs = Cli::parseLanguageCodes( $options['lang'] );

$group = MessageGroups::getGroup( 'core' );

foreach ( $langs as $l ) {
	$o = null;

	switch ( $options['type'] ) {
		case 'special':
			$o = new SpecialPageAliasesCM( $l );
			break;
		case 'magic':
			$o = new MagicWordsCM( $l );
			break;
		case 'namespace':
			$o = new NamespaceCM( $l );
			break;
		default:
			STDERR( "Invalid type: must be one of special, magic, namespace" );
			exit( 1 );
	}

	$export = $o->export( 'core' );
	if ( $export === '' ) {
		continue;
	}

	$matches = array();
	preg_match( '~^(\$[a-zA-Z]+)\s*=~m', $export, $matches );

	if ( !isset( $matches[1] ) ) {
		continue;
	}

	# remove useles comment
	$export = preg_replace( "~^# .*$\n~m", '', $export );

	if ( strpos( $export, '#!!' ) !== false ) {
		STDERR( "There is warnings with $l" );
	}

	$variable = preg_quote( $matches[1], '~' );

	$file = $group->getMessageFileWithPath( $l );

	if ( !file_exists( $file ) ) {
		STDERR( "File $file does not exists!" );
		continue;
	}

	$data = file_get_contents( $file );

	$export = trim( $export ) . "\n";
	$escExport = addcslashes( $export, '\\$' ); # Darn backreferences

	$outFile = $options['target'] . '/' . $group->getMessageFile( $l );

	$count = 0;
	$data = preg_replace( "~$variable\s*=.*?\n\);\n~s", $escExport, $data, 1, $count );
	if ( $count ) {
		file_put_contents( $outFile, $data );
	} else {
		STDERR( "Adding new entry to $outFile, please double check location", $l );
		$pos = strpos( $data, "*/" );
		if ( $pos === false ) {
			STDERR( ". FAILED! Totally new file? No header?", $l );
		} else {
			$pos += 3;
		}

		$data = substr( $data, 0, $pos ) . "\n" . $export . substr( $data, $pos );

		file_put_contents( $outFile, $data );
	}
}

/// @endcond