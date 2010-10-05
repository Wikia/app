<?php
# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/AdSS/AdSS.php" );
EOT;
        exit( 1 );
}

$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'AdSS',
	'version' => '0.1',
	'author' => 'Emil Podlaszewski',
	'descriptionmsg' => 'adss-extension-description',
);
$wgExtensionMessagesFiles['AdSS'] = $dir . 'AdSS.i18n.php';
$wgExtensionAliasesFiles['AdSS'] = $dir . 'AdSS.alias.php';

$wgAdSS_templatesDir = $dir . 'templates';

$wgAutoloadClasses['AdSS_Controller'] = $dir . 'AdSS_Controller.php';
$wgAutoloadClasses['AdSS_Publisher'] = $dir . 'AdSS_Publisher.php';
$wgAutoloadClasses['AdSS_Util'] = $dir . 'AdSS_Util.php';
$wgAutoloadClasses['AdSS_Ad'] = $dir . 'model/AdSS_Ad.php';
$wgAutoloadClasses['AdSS_AdForm'] = $dir . 'forms/AdSS_AdForm.php';
$wgAutoloadClasses['PaymentProcessor'] = $dir . 'paypal/PaymentProcessor.php';
$wgAutoloadClasses['PayflowAPI'] = $dir . 'paypal/PayflowAPI.php';

$wgSpecialPages['AdSS'] = 'AdSS_Controller';

$wgHooks['AjaxAddScript'][] = 'AdSS_Publisher::onAjaxAddScript';
$wgHooks['MakeGlobalVariablesScript'][] = 'AdSS_Publisher::onMakeGlobalVariablesScript';
//$wgHooks['OutputPageBeforeHTML'][] = 'AdSS_Publisher::onOutputPageBeforeHTML';

$wgAjaxExportList[] = 'AdSS_Publisher::getSiteAdsAjax';
$wgAjaxExportList[] = 'AdSS_AdForm::formatPriceAjax';

$wgAdSS_DBname = 'adss';

// override in your LocalSettings.php
$wgPayPalUrl = 'http://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
$wgPayflowProAPIUrl = 'https://pilot-payflowpro.paypal.com';
$wgPayflowProCredentials = array(); 
$wgAdSS_pricingConf = array();
