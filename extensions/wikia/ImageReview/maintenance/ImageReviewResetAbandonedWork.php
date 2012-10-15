<?php

require(  dirname(__FILE__ ) . '/../../../../maintenance/commandLine.inc'  );

$irh = new ImageReviewHelper();
$irh->resetAbandonedWork();
