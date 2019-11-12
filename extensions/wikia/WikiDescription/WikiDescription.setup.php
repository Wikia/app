<?php

$wgAutoloadClasses['WikiDescription\WikiDescriptionService'] =  __DIR__ . '/WikiDescriptionService.class.php';

$wgExtensionMessagesFiles['WikiDescriptionService'] = __DIR__ . '/WikiDescription.i18n.php';
$wgEditInterfaceWhitelist[] = 'Wiki-description-site-meta';
