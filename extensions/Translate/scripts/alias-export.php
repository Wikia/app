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

$optionsWithArgs = array( 'lang', 'target' );
require( dirname( __FILE__ ) . '/cli.inc' );

function showUsage() {
	STDERR( <<<EOT
Alias exporter.

Usage: php alias-export.php [options...]

Options:
  --target      Target directory for exported files
  --lang        Comma separated list of language codes or *
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

if ( !is_writable( $options['target'] ) ) {
	STDERR( "Target directory is not writable" );
	exit( 1 );
}

$langs = Cli::parseLanguageCodes( $options['lang'] );

$groups = MessageGroups::singleton()->getGroups();

foreach ( $groups as $group ) {
	if ( !$group instanceof ExtensionMessageGroup ) continue;
	$file = $group->getAliasFile();

	$groupId = $group->getId();

	if ( $file !== null ) {
		// Fake a group
		$group = new AliasMessageGroup( $group->getId() );
		$group->setMessageFile( $file );
		// FIXME: getVariableNameAlias() is not read from mediawiki-defines.txt here apparently.
		// Hacked this one exception in for now
		if ( $groupId == 'ext-wikilog' ) {
			$group->setVariableNameAlias( 'specialPageAliases' );
		} else {
			$group->setVariableName( $group->getVariableNameAlias() );
		}
		$writer = $group->getWriter();
		$writer->fileExport( $langs, $options['target'] );
	}
}
