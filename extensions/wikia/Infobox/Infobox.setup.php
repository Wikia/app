<?php

$dir = dirname( __FILE__ );

$wgAutoloadClasses[ 'InfoboxHooks' ] = $dir . '/InfoboxHooks.class.php';

$wgHooks[ 'ParserFirstCallInit' ][ ] = 'InfoboxHooks::onParserFirstCallInit';