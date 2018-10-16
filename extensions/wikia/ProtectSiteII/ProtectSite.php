<?php

$wgAutoloadClasses['ProtectSiteHooks'] = __DIR__ . '/ProtectSiteHooks.php';
$wgAutoloadClasses['ProtectSiteModel'] = __DIR__ . '/ProtectSiteModel.php';
$wgAutoloadClasses['ProtectSiteSpecialController'] = __DIR__ . '/ProtectSiteSpecialController.php';

$wgSpecialPages['ProtectSite'] = 'ProtectSiteSpecialController';
$wgSpecialPageGroups['ProtectSite'] = 'wikia';
