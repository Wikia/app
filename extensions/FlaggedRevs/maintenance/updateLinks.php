<?php

if ( getenv( 'MW_INSTALL_PATH' ) ) {
    $IP = getenv( 'MW_INSTALL_PATH' );
} else {
    $IP = dirname(__FILE__).'/../../..';
}
require "$IP/maintenance/commandLine.inc";
require dirname(__FILE__) . '/updateLinks.inc';

error_reporting( E_ALL );

$start = isset($args[0]) ? $args[0] : NULL;

update_flaggedrevs($start);

update_flaggedpages($start);

update_flaggedtemplates($start);

update_flaggedimages($start);
