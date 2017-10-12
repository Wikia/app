<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'ApiDocs',
	'author' => 'Artur Dwornik',
	'descriptionmsg' => 'apidocs-desc',
	'version' => '0.1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/ApiDocs',
);

$dir = __DIR__ . '/';

$app = F::app();

//i18n
$wgExtensionMessagesFiles['ApiDocs'] = $dir . 'i18n/ApiDocs.i18n.php';

$wgAutoloadClasses['ApiDocsController'] = "{$dir}ApiDocsController.class.php";
$wgAutoloadClasses['DocsApiController'] = "{$dir}DocsApiController.class.php";
$wgAutoloadClasses['Wikia\ApiDocs\Services\IApiDocsService'] = "{$dir}services/IApiDocsService.php";
$wgAutoloadClasses['Wikia\ApiDocs\Services\ApiDocsServiceFactory'] = "{$dir}services/ApiDocsServiceFactory.php";
$wgAutoloadClasses['Wikia\ApiDocs\Services\CachingApiDocsService'] = "{$dir}services/CachingApiDocsService.php";
$wgAutoloadClasses['Wikia\ApiDocs\Services\ApiDocsService'] = "{$dir}services/ApiDocsService.php";
