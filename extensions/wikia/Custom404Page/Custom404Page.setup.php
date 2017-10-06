<?php

// Autoload
$wgAutoloadClasses['Custom404PageBestMatchingPageFinder'] =  __DIR__ . '/Custom404PageBestMatchingPageFinder.class.php';
$wgAutoloadClasses['Custom404PageHooks'] =  __DIR__ . '/Custom404PageHooks.class.php';

// Hooks
$wgHooks['BeforeDisplayNoArticleText'][] = 'Custom404PageHooks::onBeforeDisplayNoArticleText';

// Messages
