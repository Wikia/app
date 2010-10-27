<?php

include( '/usr/wikia/source/wiki/maintenance/commandLine.inc' );
include( 'TranStatsEngine.php' );

$stats = new TransStatsEngine;

$stats->buildMsgs();
$stats->calculateState();

