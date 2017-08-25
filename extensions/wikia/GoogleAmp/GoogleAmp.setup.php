<?php
/**
 * Google AMP
 */

$dir = dirname(__FILE__) . '/';

// classes
$wgAutoloadClasses['GoogleAmpHelper'] =  $dir . 'GoogleAmpHelper.class.php';

// hooks
$wgHooks['BeforePageDisplay'][] = 'GoogleAmpHelper::onBeforePageDisplay';
$wgHooks['MercuryPageData'][] = 'GoogleAmpHelper::onMercuryPageData';
