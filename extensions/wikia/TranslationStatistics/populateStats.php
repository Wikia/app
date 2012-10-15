<?php

include( '../../../maintenance/commandLine.inc' );
include( $IP . '/extensions/Translate/MessageGroups.php' );

$gs = new MessageGroupStatistics();

$gs->populateStats();
