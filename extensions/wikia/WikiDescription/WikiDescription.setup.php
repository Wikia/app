<?php

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['WikiDescriptionService'] =  $dir . 'WikiDescriptionService.class.php';

$wgExtensionMessagesFiles['WikiDescriptionService'] = $dir . 'WikiDescriptionService.i18n.php';
$wgEditInterfaceWhitelist[] = 'wiki-description-site-meta';
