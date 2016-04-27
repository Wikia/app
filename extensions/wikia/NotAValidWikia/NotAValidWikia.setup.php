<?php

// autoload
$wgAutoloadClasses['NotAValidWikiaArticle'] =  __DIR__ . '/NotAValidWikiaArticle.class.php';

// i18n mapping
$wgExtensionMessagesFiles['NotAValidWikia'] = __DIR__ . '/NotAValidWikia.i18n.php';

// hooks
$wgHooks['ArticleFromTitle'][] = 'NotAValidWikiaArticle::onArticleFromTitle';
