<?php
/**
 * A script to generate export commands for changes for last X hours.
 *
 * @author Niklas Laxstrom
 *
 * @copyright Copyright © 2008, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

$optionsWithArgs = array( 'skip', 'hours', 'format', 'target' );
require( dirname(__FILE__) . '/cli.inc' );

function showUsage() {
	STDERR( <<<EOT
Export helper, generates list of export commands for changes in some period.

Usage: php autoexport.php [options...]

Options:
  --target    Target directory for exported files
  --format    Format string, variables \$GROUP, \$LANG and \$TARGET
  --skip      Languages to skip, comma separated list
  --hours     Consider changes from last N hours
  --summarize Group languages by group prefix

EOT
);
	exit( 1 );
}

if ( isset($options['format']) ) {
	$format = $options['format'];
} else {
	$format = 'php export.php --group $GROUP --lang $LANG --target $TARGET';
}

if ( isset($options['hours']) ) {
	$hours = $options['hours'];
} else {
	showUsage();
}

if ( isset($options['target']) ) {
	$target = $options['target'];
} else {
	$target = '/tmp';
}

if ( isset($options['summarize']) ) {
	$summarize = true;
} else {
	$summarize = false;
}

if ( isset($options['skip']) ) {
	$skip = array_map( 'trim', explode( ',', $options['skip'] ) );
} else {
	$skip = array();
}


$rows = TranslateUtils::translationChanges( $hours );
$index = TranslateUtils::messageIndex();
$exports = array();
foreach ( $rows as $row ) {
	$group = false;
	$code = false;

	list( $pieces, ) = explode('/', $wgContLang->lcfirst($row->rc_title), 2);

	$key = strtolower( $row->rc_namespace . ':' . $pieces );

	$mg = @$index[$key];
	if ( !is_null($mg) ) $group = $mg;

	if ( strpos( $row->rc_title, '/' ) !== false ) {
		$code = $row->lang;
	}

	if ( $group && $code && !in_array( $code, $skip ) ) {
		$exports[$group][$code] = true;
	}
}

ksort($exports);
$notice = array();
foreach ( $exports as $group => $languages ) {
	$languages = array_keys( $languages );
	sort($languages);
	$languagelist = implode(', ', $languages );
	STDOUT( str_replace(
		array( '$GROUP', '$LANG', '$TARGET' ),
		array( $group, "'$languagelist'", "'$target'" ),
		$format ) );

	if ( $summarize ) {
		list( $group, ) = explode( '-', $group, 2 );
	}
	if ( isset($notice[$group]) ) {
		$notice[$group] = array_merge( $notice[$group], $languages );
	} else {
		$notice[$group] = $languages;
	}
}

foreach ( $notice as $group => $languages ) {
	$languages = array_unique( $languages );
	sort($languages);
	$languagelist = implode(', ', $languages );
	STDOUT( "# Committed $group: $languagelist" );
}
