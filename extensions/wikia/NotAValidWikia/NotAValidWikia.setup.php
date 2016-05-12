<?php

// autoload
$wgAutoloadClasses['NotAValidWikiaArticle'] =  __DIR__ . '/NotAValidWikiaArticle.class.php';
$wgAutoloadClasses['NotAValidWikiaHooks'] =  __DIR__ . '/NotAValidWikiaHooks.class.php';

// i18n mapping
$wgExtensionMessagesFiles['NotAValidWikia'] = __DIR__ . '/NotAValidWikia.i18n.php';

// hooks
$wgHooks['ArticleFromTitle'][] = 'NotAValidWikiaHooks::onArticleFromTitle';
