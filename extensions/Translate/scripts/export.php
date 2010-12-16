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

$optionsWithArgs = array( 'lang', 'target', 'group', 'threshold' );
require( dirname( __FILE__ ) . '/cli.inc' );

function showUsage() {
	STDERR( <<<EOT
Message exporter.

Usage: php export.php [options...]

Options:
  --target      Target directory for exported files
  --lang        Comma separated list of language codes or *
  --group       Group ID
  --threshold   Do not export under this percentage translated
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

if ( !isset( $options['group'] ) ) {
	STDERR( "You need to specify group" );
	exit( 1 );
}

if ( !is_writable( $options['target'] ) ) {
	STDERR( "Target directory is not writable" );
	exit( 1 );
}
if ( isset( $options['threshold'] ) && intval( $options['threshold'] ) ) {
	$threshold = $options['threshold'];
} else {
	$threshold = false;
}

$langs = Cli::parseLanguageCodes( $options['lang'] );

$group = MessageGroups::getGroup( $options['group'] );

if ( !$group instanceof MessageGroup ) {
	STDERR( "Invalid group" );
	exit( 1 );
}

if ( $threshold ) {
	$langs = TranslationStats::getPercentageTranslated(
		$options['group'],
		$langs,
		$threshold,
		true
	);
}

if ( $group instanceof FileBasedMessageGroup ) {
	$ffs = $group->getFFS();
	$ffs->setWritePath( $options['target'] );
	$collection = $group->initCollection( 'en' );

	foreach ( $langs as $lang ) {
		$collection->resetForNewLanguage( $lang );
		$ffs->write( $collection );
	}
} else {
	$writer = $group->getWriter();
	$writer->fileExport( $langs, $options['target'] );
}
