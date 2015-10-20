<?php

$wgExtensionCredits[ 'other' ][ ] = array(
	'name' => 'TemplateListProvider',
	'author' => 'Wikia',
	'descriptionmsg' => 'templatelistprovider-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/TemplateListProvider',
);

$dir = dirname( __FILE__ );

$wgAutoloadClasses['TemplateListProviderController'] =  $dir . '/TemplateListProviderController.class.php';
