<?php

include( '/usr/wikia/source/wiki/maintenance/commandLine.inc' );

$stats = new TransStatsEngine;

$stats->buildMsgs();
$stats->calculateState();

