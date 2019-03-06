<?php

$dir = dirname(__FILE__) . '/';

/**
 * Classes
 */
$wgAutoloadClasses['ArticleTagEventsProducer'] = $dir . 'ArticleTagEventsProducer.class.php';

/**
 * Hooks
 */
$wgHooks['SpecialMovepageAfterMove'][] = 'ArticleTagEventsProducer::onSpecialMovepageAfterMove';
