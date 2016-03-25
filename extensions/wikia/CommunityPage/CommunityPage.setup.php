<?php

$wgAutoloadClasses['CommunityPageSpecialUsersModel'] =  __DIR__ . '/models/CommunityPageSpecialUsersModel.class.php';
$wgAutoloadClasses['CommunityPageSpecialWikiModel'] =  __DIR__ . '/models/CommunityPageSpecialWikiModel.class.php';
$wgAutoloadClasses['CommunityPageSpecialHelper'] =  __DIR__ . '/CommunityPageSpecialHelper.class.php';
$wgAutoloadClasses['CommunityPageSpecialController'] =  __DIR__ . '/CommunityPageSpecialController.class.php';

$wgExtensionMessagesFiles['Community'] = __DIR__ . '/CommunityPage.i18n.php';

$wgSpecialPages['Community'] = 'CommunityPageSpecialController';
