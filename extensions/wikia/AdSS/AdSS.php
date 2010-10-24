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
	'descriptionmsg' => 'adss-desc',
);
$wgExtensionMessagesFiles['AdSS'] = $dir . 'AdSS.i18n.php';
$wgExtensionAliasesFiles['AdSS'] = $dir . 'AdSS.alias.php';

$wgAdSS_templatesDir = $dir . 'templates';

$wgAutoloadClasses['AdSS_Controller'] = $dir . 'AdSS_Controller.php';
$wgAutoloadClasses['AdSS_AdminController'] = $dir . 'admin/AdSS_AdminController.php';
$wgAutoloadClasses['AdSS_AdminPager'] = $dir . 'admin/AdSS_AdminPager.php';
$wgAutoloadClasses['AdSS_Ad'] = $dir . 'model/AdSS_Ad.php';
$wgAutoloadClasses['AdSS_Billing'] = $dir . 'model/AdSS_Billing.php';
$wgAutoloadClasses['AdSS_User'] = $dir . 'model/AdSS_User.php';
$wgAutoloadClasses['AdSS_AdForm'] = $dir . 'forms/AdSS_AdForm.php';
$wgAutoloadClasses['AdSS_Publisher'] = $dir . 'AdSS_Publisher.php';
$wgAutoloadClasses['AdSS_Util'] = $dir . 'AdSS_Util.php';
$wgAutoloadClasses['PaymentProcessor'] = $dir . 'paypal/PaymentProcessor.php';
$wgAutoloadClasses['PayflowAPI'] = $dir . 'paypal/PayflowAPI.php';

$wgSpecialPages['AdSS'] = 'AdSS_Controller';
$wgSpecialPages['Sponsor'] = 'AdSS_Controller';

$wgAvailableRights[] = 'adss-admin';
$wgGroupPermissions['*']['adss-admin'] = false;
$wgGroupPermissions['staff']['adss-admin'] = true;

$wgHooks['AjaxAddScript'][] = 'AdSS_Publisher::onAjaxAddScript';
$wgHooks['MakeGlobalVariablesScript'][] = 'AdSS_Publisher::onMakeGlobalVariablesScript';
//$wgHooks['OutputPageBeforeHTML'][] = 'AdSS_Publisher::onOutputPageBeforeHTML';
$wgHooks['OutputPageCheckLastModified'][] = 'AdSS_Publisher::onOutputPageCheckLastModified';
$wgHooks['ArticlePurge'][] = 'AdSS_Publisher::onArticlePurge';

$wgAjaxExportList[] = 'AdSS_Publisher::getSiteAdsAjax';
$wgAjaxExportList[] = 'AdSS_Util::formatPriceAjax';
$wgAjaxExportList[] = 'AdSS_AdminController::acceptAdAjax';
$wgAjaxExportList[] = 'AdSS_AdminController::closeAdAjax';

$wgAdSS_DBname = 'adss';

// override in your LocalSettings.php
$wgPayPalUrl = 'http://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
$wgPayflowProAPIUrl = 'https://pilot-payflowpro.paypal.com';
$wgPayflowProCredentials = array(); 
$wgAdSS_pricingConf = array(
		'site' => array(
			'price'     => '5.00',
			'period'    => 'd', //daily
			'max-share' => '0.25',
			),
		'page' => array(
			'#default#' => array(
				'price'   => '5.00',
				'period'  => 'm', //monthly
				),
			),
		);

