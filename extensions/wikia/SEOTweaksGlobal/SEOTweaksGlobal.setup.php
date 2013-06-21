<?php
/**
 * SEOTweaks setup
 *
 * @author Jacek Jursza <jacek at wikia-inc.com>
 *
 */
$dir = dirname(__FILE__) . '/';

//classes
$wgAutoloadClasses['SEOTweaksGlobalHooksHelper'] =  $dir . 'SEOTweaksGlobalHooksHelper.class.php';

//hooks
$wgHooks['OpenGraphMetaHeaders'][] = 'SEOTweaksGlobalHooksHelper::onOpenGraphMetaHeaders';
$wgHooks['ArticleRobotPolicy'][] = 'SEOTweaksGlobalHooksHelper::onArticleRobotPolicy';