<?php
/**
 * An extension to serve article summary information
 *
 * @author Garth Webb
 */

$app = F::app();
$dir = dirname( __FILE__ );
$wgAutoloadClasses['ArticleSummaryController'] =  $dir.'/ArticleSummaryController.class.php';
$wgAutoloadClasses['ArticleSummary'] =  $dir.'/ArticleSummary.class.php';
