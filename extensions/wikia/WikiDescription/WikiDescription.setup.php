<?php

$dir = dirname(__FILE__) . '/';
$app = F::app();

$wgAutoloadClasses['WikiDescription\WikiDescriptionService'] =  $dir . 'WikiDescriptionService.class.php';

$wgExtensionMessagesFiles['WikiDescriptionService'] = $dir . 'WikiDescription.i18n.php';
$wgEditInterfaceWhitelist[] = 'Wiki-description-site-meta';
