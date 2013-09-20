<?php  

require( "../../../maintenance/commandLine.inc" );

$helper = (new ImageReviewHelper);
$helper->resetAbandonedWork();
