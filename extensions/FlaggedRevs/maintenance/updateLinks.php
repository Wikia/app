<?php

if ( getenv( 'MW_INSTALL_PATH' ) ) {
    $IP = getenv( 'MW_INSTALL_PATH' );
} else {
    $IP = dirname(__FILE__).'/../../..';
}

$options = array( 'updateonly', 'help', 'start' );
require "$IP/maintenance/commandLine.inc";
require dirname(__FILE__) . '/updateLinks.inc';

if( isset($options['help']) ) {
	echo <<<TEXT
Usage:
    php updateLinks.php --help
    php updateLinks.php [--start <ID> | --updateonly <CALL> ]

    --help             : This help message
    --<ID>             : The ID of the starting rev
	--<CALL>           : One of revs,pages,templates, or images

TEXT;
	exit(0);
}

error_reporting( E_ALL );

$start = isset($options['start']) ? $options['start'] : NULL;
$updateonly = isset($options['updateonly']) ? $options['updateonly'] : NULL;

$actions = array( 'revs', 'pages', 'templates', 'images' );
if( $updateonly && in_array($updateonly,$actions) ) {
	$do = "update_flagged{$updateonly}";
	$do($start);
	exit(0);
}

update_flaggedrevs($start);

update_flaggedpages();

update_flaggedtemplates($start);

update_flaggedimages($start);
