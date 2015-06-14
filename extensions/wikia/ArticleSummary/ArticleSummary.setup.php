<?php
/**
 * An extension to serve article summary information
 *
 * @author Garth Webb
 */
 
 $wgExtensionCredits[ 'other' ][ ] = array(
	'name' => 'ArticleSummary',
	'author' => 'Garth Webb',
	'descriptionmsg' => 'articlesummary-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/ArticleSummary',
	
);

$app = F::app();
$dir = dirname( __FILE__ );

$wgAutoloadClasses['ArticleSummaryController'] =  $dir.'/ArticleSummaryController.class.php';

//i18n
$wgExtensionMessagesFiles['ArticleSummary'] = __DIR__  . '/ArticleSummary.i18n.php';

