<?php

$dir = dirname(__FILE__) . '/';
$app = F::app();

$wgAutoloadClasses['WikiDescriptionService'] =  $dir . 'WikiDescriptionService.class.php';

$wgExtensionMessagesFiles['WikiDescriptionService'] = $dir . 'WikiDescription.i18n.php';
$wgEditInterfaceWhitelist[] = 'wiki-description-site-meta';
