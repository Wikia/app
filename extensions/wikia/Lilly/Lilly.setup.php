<?php

// Autoload
$wgAutoloadClasses['Lilly'] = __DIR__ . '/Lilly.class.php';
$wgAutoloadClasses['LillyHooks'] = __DIR__ . '/LillyHooks.class.php';
$wgAutoloadClasses['LillyValidator'] = __DIR__ . '/LillyValidator.class.php';

// Hooks
$wgHooks['LinkerMakeExternalLink'][] = 'LillyHooks::onLinkerMakeExternalLink';
$wgHooks['LinkEnd'][] = 'LillyHooks::onLinkEnd';
