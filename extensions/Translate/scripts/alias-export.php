<?php
/**
 * Script to export translations of one message group to file(s).
 *
 * @author Niklas Laxstrom
 *
 * @copyright Copyright © 2008, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

$optionsWithArgs = array( 'lang', 'target', 'group' );
require( dirname(__FILE__) . '/cli.inc' );

function showUsage() {
	STDERR( <<<EOT
Alias exporter.

Usage: php aliasexport.php [options...]

Options:
  --target      Target directory for exported files
  --lang        Comma separated list of language codes
  --group       Group id
EOT
);
	exit( 1 );
}

if ( isset($options['help']) || $args === 1 ) {
	showUsage();
}

if ( !isset($options['target']) ) {
	STDERR( "You need to specify target directory" );
	exit(1);
}
if ( !isset($options['lang']) ) {
	STDERR( "You need to specify languages to export" );
	exit(1);
}

if ( !is_writable( $options['target'] ) ) {
	STDERR( "Target directory is not writable" );
	exit(1);
}

$langs = array_map( 'trim', explode( ',', $options['lang'] ) );


if ( !file_exists(TRANSLATE_ALIASFILE) || !is_readable(TRANSLATE_ALIASFILE) ) {
	STDERR( "Alias file not defined" );
	exit(1);
}

$defines = file_get_contents( TRANSLATE_ALIASFILE );
$sections = preg_split( "/\n\n/", $defines, -1, PREG_SPLIT_NO_EMPTY );

foreach ( $sections as $section ) {
	$lines = array_map( 'trim', preg_split( "/\n/", $section ) );
	$name = '';
	foreach ( $lines as $line ) {
		if ( $line === '' ) continue;
		if ( strpos( $line, '=' ) === false ) {
			if ( $name === '' ) {
				$name = $line;
			} else {
				throw new MWException( "Trying to define name twice: " . $line );
			}
		} else {
			list( $key, $value ) = array_map( 'trim', explode( '=', $line, 2 ) );
			if ( $key === 'file' ) $file = $value;
		}
	}

	if ( $name !== '' ) {
		// Fake a group
		$group = new AliasMessageGroup( $name );
		$group->setMessageFile( $file );
		$group->setVariableName( 'aliases' );
		$writer = $group->getWriter();
		$writer->fileExport( $langs, $options['target'] );
	}
}
