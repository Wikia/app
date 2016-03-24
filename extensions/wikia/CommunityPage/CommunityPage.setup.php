<?php

$wgAutoloadClasses['CommunityPageSpecialController'] =  __DIR__ . '/CommunityPageSpecialController.class.php';
$wgAutoloadClasses['CommunityPageSpecialModel'] =  __DIR__ . '/CommunityPageSpecialModel.class.php';
$wgAutoloadClasses['CommunityPageHooks'] =  __DIR__ . '/CommunityPageHooks.class.php';

$wgExtensionMessagesFiles['Community'] = __DIR__ . '/CommunityPage.i18n.php';

$wgSpecialPages['Community'] = 'CommunityPageSpecialController';
