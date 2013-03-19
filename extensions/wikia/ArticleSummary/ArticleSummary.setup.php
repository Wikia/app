<?php
/**
 * An extension to serve article summary information
 *
 * @author Garth Webb
 */

$app = F::app();
$dir = dirname( __FILE__ );
$app->registerClass('ArticleSummaryController', $dir.'/ArticleSummaryController.class.php');
$app->registerClass('ArticleSummary', $dir.'/ArticleSummary.class.php');
