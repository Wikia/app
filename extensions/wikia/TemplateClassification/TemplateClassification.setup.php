<?php
$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['TemplateClassificationHooks'] = $dir . 'TemplateClassificationHooks.class.php';

$wgHooks['BeforePageDisplay'][] = 'TemplateClassificationHooks::onBeforePageDisplay';
