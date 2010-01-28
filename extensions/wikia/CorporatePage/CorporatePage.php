<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'CorporatePage',
	'author' => 'Tomasz Odrobny',
	'url' => '',
	'description' => 'global page for wikia.com',
	'descriptionmsg' => 'myextension-desc',
	'version' => '1.0.0',
);

function wfCorporatePage(&$parser) {
	wfLoadExtensionMessages( 'CorporatePage' );
	return true;
}

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['CorporatePageHelper']  = $dir . 'CorporatePageHelper.class.php';
$wgExtensionMessagesFiles['CorporatePage'] = $dir . 'CorporatePage.i18n.php'; 
$wgHooks['MakeGlobalVariablesScript'][] = 'CorporatePageHelper::jsVars';
#$wgHooks['ArticleFromTitle'][] = 'CorporatePageHelper::ArticleFromTitle';
$wgAjaxExportList[] = 'CorporatePageHelper::blockArticle';

if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks['ParserFirstCallInit'][] = 'wfCorporatePage';
} else {
	$wgExtensionFunctions[] = 'wfCorporatePage';
}
