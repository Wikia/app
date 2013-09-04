<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'ApiDocs',
	'author' => 'Artur Dwornik',
//	'descriptionmsg' => 'imageserving-desc',
	'version' => '0.1',
);

$dir = __DIR__ . '/';

$app = F::app();

$wgAutoloadClasses['ApiDocsController'] = "{$dir}ApiDocsController.class.php";

$wgSpecialPages['ApiDocs'] = 'ApiDocsController';

$wgAutoloadClasses['ApiDocsController'] = "{$IP}/lib/vendor/swagger-php/library/ApiDocsController.class.php";
