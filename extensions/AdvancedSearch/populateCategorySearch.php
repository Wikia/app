<?php
/**
 * @addtogroup Maintenance
 * @author Roan Kattouw
 */

$optionsWithArgs = array( 'begin', 'max-slave-lag', 'throttle' );

$commandLineInc = dirname(__FILE__) . "/../../maintenance/commandLine.inc";
if(!file_exists($commandLineInc))
	die("Can't find commandLine.inc\nPlease copy it to " .
	realpath(dirname(__FILE__) . "/../../") . "maintenance or make a symlink.");
require_once $commandLineInc;
require_once "populateCategorySearch.inc";

if( isset( $options['help'] ) ) {
	echo <<<TEXT
This script will populate the categorysearch table, added by the
CategorySearch extension. It will print out progress indicators every
1000 pages it adds to the table.  The script is perfectly safe to run on large,
live wikis, and running it multiple times is harmless.  You may want to use the
throttling options if it's causing too much load; they will not affect
correctness.

If the script is stopped and later resumed, you can use the --begin option with
the last printed progress indicator to pick up where you left off.  This is
safe, because any newly-added intersections before this cutoff will have been
added after the software update and so will be populated anyway.

When the script has finished, it will make a note of this in the database, and
will not run again without the --force option.

Usage:
    php populateCategorySearch.php [--max-slave-lag <seconds>]
[--begin <pageID>] [--throttle <seconds>] [--force]

    --begin: Only do pages with page IDs higher than this value.
Default: empty (start from beginning).
    --max-slave-lag: If slave lag exceeds this many seconds, wait until it
drops before continuing.  Default: 10.
    --throttle: Wait this many milliseconds after each page.  Default: 0.
    --force: Run regardless of whether the database says it's been run already.
TEXT;
	exit( 0 );
}

$defaults = array(
	'begin' => '',
	'max-slave-lag' => 10,
	'throttle' => 0,
	'force' => false
);
$options = array_merge( $defaults, $options );

populateCategorySearch( $options['begin'], $options['max-slave-lag'],
	$options['throttle'], $options['force'] );
