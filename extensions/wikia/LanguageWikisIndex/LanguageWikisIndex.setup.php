<?php
/*
 * Special page included on domain root when language path wikis exist without the English wiki.
 */

$wgAutoloadClasses['LanguageWikisIndexHooks'] = __DIR__ . '/LanguageWikisIndexHooks.class.php';

// include only on empty or closed wikis
if ( LanguageWikisIndexHooks::isEmptyDomainWithLanguageWikis() || !WikiFactory::isPublic( $wgCityId ) ) {

	$wgAutoloadClasses['LanguageWikisIndexController'] = __DIR__ . '/LanguageWikisIndexController.class.php';

	$wgSpecialPages['LanguageWikisIndex'] = 'LanguageWikisIndexController';

	$wgExtensionMessagesFiles['LanguageWikisIndex'] = __DIR__ . '/LanguageWikisIndex.i18n.php';

	$wgExtensionFunctions[] = 'LanguageWikisIndexHooks::onExtensionFunctions';
	$wgHooks['GenerateRobotsRules'][] = 'LanguageWikisIndexHooks::onGenerateRobotsRules';

	$wgHooks['ClosedWikiHandler'][] = 'LanguageWikisIndexHooks::onClosedWikiPage';
	$wgHooks['GetHTMLBeforeWikiaPage'][] = 'LanguageWikisIndexHooks::onGetHTMLBeforeWikiaPage';
	$wgHooks['WikiaCanonicalHref'][] = 'LanguageWikisIndexHooks::onWikiaCanonicalHref';
}
