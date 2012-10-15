<?php  

require( "../../../maintenance/commandLine.inc" );

$helper = F::build( 'ImageReviewHelper' );
$helper->resetAbandonedWork();
