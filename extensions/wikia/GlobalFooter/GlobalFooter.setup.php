<?php

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'GlobalFooter',
	'author' => 'Bogna "bognix" Knychala',
	'descriptionmsg' => 'global-footer-desc',
	'version' => 1.0,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/GlobalFooter'
);

$wgAutoloadClasses['GlobalFooterController'] =  __DIR__ . '/GlobalFooterController.class.php';
$wgAutoloadClasses['GlobalFooterHooks'] =  __DIR__ . '/hooks/GlobalFooterHooks.class.php';

$wgHooks['SkinCopyrightFooter'][] = 'GlobalFooterHooks::onSkinCopyrightFooter';

$wgExtensionMessagesFiles['GlobalFooter'] = __DIR__ . '/GlobalFooter.i18n.php';
// for "Global Sitemap" label:
$wgExtensionMessagesFiles['SitemapPage'] = __DIR__ . '/../SitemapPage/SitemapPage.i18n.php';
