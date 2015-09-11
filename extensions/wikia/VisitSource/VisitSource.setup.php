<?php
$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['VisitSourceHooks'] = $dir . 'VisitSourceHooks.class.php';

$wgHooks['BeforePageDisplay'][] = 'VisitSourceHooks::onBeforePageDisplay';
