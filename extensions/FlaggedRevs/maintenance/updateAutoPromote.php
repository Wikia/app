<?php

if ( getenv( 'MW_INSTALL_PATH' ) ) {
	$IP = getenv( 'MW_INSTALL_PATH' );
} else {
	$IP = dirname(__FILE__).'/../../..';
}
require "$IP/maintenance/commandLine.inc";
require dirname(__FILE__) . '/updateAutoPromote.inc';

update_autopromote();

