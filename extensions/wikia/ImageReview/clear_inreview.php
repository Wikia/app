<?php  

require( "../../../maintenance/commandLine.inc" );

( new AbandonedWorkResetter() )->resetAbandonedWork();
