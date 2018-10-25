<?php
/*
 * Special page included on domain root when language wikis exist without the English wiki.
 */
$wgAutoloadClasses['LanguageWikisIndexController'] = __DIR__ . '/LanguageWikisIndexController.class.php';
$wgAutoloadClasses['LanguageWikisIndexHooks'] = __DIR__ . '/LanguageWikisIndexHooks.class.php';
$wgSpecialPages['LanguageWikisIndex'] = 'LanguageWikisIndexController';

if ( LanguageWikisIndexHooks::isEmptyDomainWithLanguageWikis() ) {
	$wgExtensionFunctions[] = 'LanguageWikisIndexHooks::onExtensionFunctions';
	$wgHooks['GenerateRobotsRules'][] = 'LanguageWikisIndexHooks::onGenerateRobotsRules';
}

$wgHooks['ClosedWikiHandler'][] = 'LanguageWikisIndexHooks::onClosedWikiPage';
