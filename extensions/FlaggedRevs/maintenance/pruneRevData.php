<?php

if ( getenv( 'MW_INSTALL_PATH' ) ) {
    $IP = getenv( 'MW_INSTALL_PATH' );
} else {
    $IP = dirname(__FILE__).'/../../..';
}

$options = array( 'prune', 'help', 'start' );
require "$IP/maintenance/commandLine.inc";
require dirname(__FILE__) . '/pruneRevData.inc';

if( isset($options['help']) ) {
	echo <<<TEXT
Purpose:
	This script clears template/image data for reviewed versions
	that are 1+ month old and have 50+ newer versions in page. By
	default, it will just output how many rows can be deleted. Use
	the 'prune' option to actually delete them.
Usage:
    php pruneData.php --help
    php pruneData.php [--prune --start <ID> ]

    --help             : This help message
    --prune            : Actually do a live run
    --<ID>             : The ID of the starting rev

TEXT;
	exit(0);
}

error_reporting( E_ALL );

$start = isset($options['start']) ? $options['start'] : null;
$prune = isset($options['prune']) ? true : null;

prune_flaggedrevs($start,$prune);
