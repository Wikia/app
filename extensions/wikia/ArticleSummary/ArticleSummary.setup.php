<?php
/**
 * An extension to serve article summary information
 *
 * @author Garth Webb
 */

$app = F::app();
$dir = dirname( __FILE__ );
$wgAutoloadClasses['ArticleSummaryController'] =  $dir . '/ArticleSummaryController.class.php';

//i18n
$wgExtensionMessagesFiles['ArticleSummary'] = $dir . '/ArticleSummary.i18n.php';

