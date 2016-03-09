<?php

$wgExtensionCredits['specialpage'][] = [
	'name' => 'Theme designer',
	'author' => [ 'Christian Williams', 'Inez Korczyński', 'Maciej Brencz' ],
	'descriptionmsg' => 'themedesigner-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/ThemeDesigner'
];

$dir = __DIR__;

// autoloads
$wgAutoloadClasses[ 'UploadBackgroundFromFile' ] = "{$dir}/UploadBackgroundFromFile.class.php";
$wgAutoloadClasses[ 'UploadFaviconFromFile' ] = "{$dir}/UploadFaviconFromFile.class.php";
$wgAutoloadClasses[ 'UploadWordmarkFromFile' ] = "{$dir}/UploadWordmarkFromFile.class.php";
$wgAutoloadClasses['ThemeDesignerController'] = "$dir/ThemeDesignerController.class.php";
$wgAutoloadClasses['SpecialThemeDesigner'] = "$dir/SpecialThemeDesigner.class.php";
$wgAutoloadClasses['SpecialThemeDesignerPreview'] = "$dir/SpecialThemeDesignerPreview.class.php";
$wgAutoloadClasses['ThemeDesignerHooks'] = "$dir/ThemeDesignerHooks.class.php";

// special pages
$wgSpecialPages['ThemeDesigner'] = 'SpecialThemeDesigner';
$wgSpecialPages['ThemeDesignerPreview'] = 'SpecialThemeDesignerPreview';

// i18n
$wgExtensionMessagesFiles['ThemeDesigner'] = "$dir/ThemeDesigner.i18n.php";
$wgExtensionMessagesFiles['ThemeDesignerAliases'] = "$dir/ThemeDesigner.alias.php";

JSMessages::registerPackage('ThemeDesigner', [
	'themedesigner-wordmark-preview-error'
]);

// hooks
$wgHooks['ArticleDeleteComplete'][] = 'ThemeDesignerHooks::onArticleDeleteComplete';
$wgHooks['RevisionInsertComplete'][] = 'ThemeDesignerHooks::onRevisionInsertComplete';
$wgHooks['UploadComplete'][] = 'ThemeDesignerHooks::onUploadComplete';
$wgHooks['UploadVerification'][] = 'ThemeDesignerHooks::onUploadVerification';
