<?php
/**
 * WikiPaymentBot execute script - part of WikiPayment extension
 *
 * @addto maintenance
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 *
 */
require_once( dirname(__FILE__) . '/../../../../maintenance/commandLine.inc');

$wgAutoloadClasses['WikiPaymentBot'] = dirname(__FILE__) . '/../WikiPaymentBot.class.php';

$debugMode = (isset($options['d']) || isset($options['debug'])) ? true : false;
$dryRunMode = isset($options['dryrun']) ? true : false;

$paymentBot = new WikiPaymentBot( $debugMode, $dryRunMode );
$paymentBot->run();
